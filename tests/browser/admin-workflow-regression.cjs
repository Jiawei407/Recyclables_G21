'use strict';

const assert = require('node:assert/strict');

module.exports = async function adminWorkflowRegression({ admin, user, base, catalog, submission, pass }) {
  const manage = base + '/admin/manage.php?view=';
  const users = base + '/admin/users.php?view=';
  await admin.goto(manage + 'challenge-balancing');
  assert.equal(await admin.locator('#edit-challenge').count(), 0);
  await admin.locator('a[href$="&id=' + catalog.challenge + '#edit-challenge"]').click();
  assert.equal(new URL(admin.url()).hash, '#edit-challenge');
  assert.equal(await admin.locator('#edit-challenge [name=id]').inputValue(), String(catalog.challenge));
  assert.ok(await admin.locator('#challenge-title').inputValue());
  pass('Challenge balancing opens the selected challenge editor');

  await admin.goto(manage + 'leaderboard-review-user-points&id=7');
  const original = admin.getByRole('link', { name: 'View submission #' + submission, exact: true });
  assert.equal(await original.count(), 1);
  const originalPoints = Number(await original.locator('xpath=ancestor::tr').locator('td').nth(2).locator('.cell-value').textContent());
  assert.ok(originalPoints > 0);
  await original.click();
  assert.equal(new URL(admin.url()).hash, '#activity-details');
  const details = admin.locator('#activity-details');
  assert.match(await details.textContent(), /Approved/);
  assert.equal(await details.locator('img').count(), 1);
  const reason = 'The quantity does not match the submitted evidence.';
  const rejection = details.locator('form');
  const csrf = await rejection.locator('[name=csrf]').inputValue();
  const transaction = await rejection.locator('[name=transaction-id]').inputValue();
  const activityUrl = admin.url();
  await details.getByLabel('Rejection reason').fill(reason);
  await details.getByRole('button', { name: 'Reject submission' }).click();
  await admin.waitForLoadState('domcontentloaded');
  assert.match(await details.textContent(), /Rejected/);
  assert.equal(await details.getByRole('button', { name: 'Reject submission' }).count(), 0);
  assert.equal(await original.count(), 1);
  const reversed = admin.getByRole('link', { name: 'View reversal for submission #' + submission, exact: true });
  assert.equal(await reversed.count(), 1);
  const reversedPoints = Number(await reversed.locator('xpath=ancestor::tr').locator('td').nth(2).locator('.cell-value').textContent());
  assert.equal(reversedPoints, -originalPoints);

  const repeated = await admin.request.post(activityUrl, {
    form: { csrf, action: 'reject-approved-submission', id: '7', 'transaction-id': transaction, 'review-reason': reason },
    maxRedirects: 0,
  });
  assert.equal(repeated.status(), 422);
  await admin.reload();
  assert.equal(await original.count(), 1);
  assert.equal(await reversed.count(), 1);
  await user.goto(base + '/user/evidence.php?view=submit-evidence-submission-details&id=' + submission);
  const submissionDetails = await user.locator('main').textContent();
  assert.match(submissionDetails, /Status: rejected · Points: 0/i);
  assert.ok(submissionDetails.includes(reason));
  pass('Rejection reverses only the original award once and is visible to the student');

  await admin.goto(users + 'users-edit-user');
  assert.equal(new URL(admin.url()).searchParams.get('view'), 'users-users');
  assert.equal(await admin.locator('#designated-role').count(), 0);
  const missing = await admin.request.post(users + 'users-edit-user', {
    form: { csrf, action: 'save-user', id: '0' },
    maxRedirects: 0,
  });
  assert.equal(missing.status(), 422);
  pass('An edit request without a selected account cannot create a user');

  await admin.goto(users + 'users-edit-user&id=7');
  const role = admin.locator('#designated-role');
  await role.locator('..').locator('.selection-trigger').click();
  await admin.getByRole('option', { name: 'Faculty Representative', exact: true }).click();
  const permissions = await role.evaluate(field => new FormData(field.form).getAll('permissions[]'));
  assert.deepEqual(permissions, ['create-activities', 'feature-challenges', 'publish-announcements', 'submit-reports']);
  pass('Changing the designated role replaces the visible and submitted permission choices');

  const facultyEdit = users + 'users-edit-user&id=4';
  await admin.goto(facultyEdit);
  const activities = admin.locator('input[type=checkbox][value=create-activities]');
  assert.equal(await activities.isChecked(), true);
  assert.equal(await admin.locator('input[type=checkbox][value=join-challenges]').isVisible(), false);
  const facultyContext = await admin.context().browser().newContext();
  try {
    await activities.uncheck();
    await admin.getByRole('button', { name: 'Save user', exact: true }).click();
    await admin.waitForURL(users + 'users-users');
    await admin.goto(facultyEdit);
    assert.equal(await activities.isChecked(), false);

    const faculty = await facultyContext.newPage();
    await faculty.goto(base + '/login.php');
    await faculty.locator('#email').fill('engineering.rep@mail.apu.edu.my');
    await faculty.locator('#password').fill('faculty123@');
    await faculty.getByRole('button', { name: 'Log in', exact: true }).last().click();
    await faculty.waitForURL(url => url.pathname.endsWith('/faculty/home.php'));
    const createActivity = base + '/faculty/challenges.php?view=faculty-activities-create-activity';
    await faculty.goto(createActivity);
    const facultyCsrf = await faculty.locator('#backend-form [name=csrf]').inputValue();
    const forbidden = await faculty.request.post(createActivity, {
      form: { csrf: facultyCsrf, action: 'save-activity' },
      maxRedirects: 0,
    });
    assert.equal(forbidden.status(), 403);
    pass('Faculty permissions are saved and enforced on the corresponding server action');
  } finally {
    await facultyContext.close();
    await admin.goto(facultyEdit);
    await activities.check();
    await admin.getByRole('button', { name: 'Save user', exact: true }).click();
    await admin.waitForURL(users + 'users-users');
  }
};
