'use strict';

const assert = require('node:assert/strict');

async function badgePng(page, width) {
  const base64 = await page.evaluate(size => {
    const canvas = document.createElement('canvas');
    canvas.width = size;
    canvas.height = 128;
    const context = canvas.getContext('2d');
    context.fillStyle = '#173f2a';
    context.fillRect(0, 0, canvas.width, canvas.height);
    return canvas.toDataURL('image/png').split(',')[1];
  }, width);
  return Buffer.from(base64, 'base64');
}

module.exports = async function achievementRegression({admin, base, catalog, pass}) {
  const create = base + '/admin/achievements.php?view=achievements-create';
  const name = 'Badge validation regression';
  await admin.goto(create);
  const csrf = await admin.locator('#badge-editor input[name="csrf"]').inputValue();
  const valid = await badgePng(admin, 128);
  const undersized = await badgePng(admin, 127);
  const damaged = Buffer.from(valid);
  const idat = damaged.indexOf('IDAT');
  assert.ok(idat > 4);
  const crc = idat + 4 + damaged.readUInt32BE(idat - 4);
  damaged[crc] ^= 1;

  const form = {
    csrf,
    action: 'save-achievement',
    id: '0',
    'achievement-name': name,
    'achievement-status': 'active',
    'badge-mode': 'standalone',
    'requirement-1-count': '10',
    'requirement-1-item': 'Aluminum cans',
    'requirement-1-condition': 'At least',
  };
  for (const [buffer, message] of [
    [undersized, /width and height must each be between 128 and 2048/],
    [damaged, /valid, complete JPG or PNG/],
  ]) {
    const rejected = await admin.request.post(create, {
      multipart: {...form, image: {name: 'badge.png', mimeType: 'image/png', buffer}},
    });
    assert.equal(rejected.status(), 422);
    assert.match(await rejected.text(), message);
  }
  pass('Badge upload rejects undersized and damaged PNGs at the server');

  const mode = admin.locator('#badge-mode');
  const family = admin.locator('#badge-family');
  assert.equal(await mode.inputValue(), 'standalone');
  assert.equal(await family.isVisible(), false);
  await mode.selectOption('tiered', {force: true});
  assert.equal(await family.isVisible(), true);
  await mode.selectOption('standalone', {force: true});
  assert.equal(await family.isDisabled(), true);
  await admin.locator('#achievement-name').fill(name);
  await admin.locator('#requirement-1-item').selectOption('Aluminum cans', {force: true});
  await admin.locator('#requirement-1-condition').selectOption('At least', {force: true});
  await admin.locator('#requirement-1-count').fill('10');
  await admin.getByRole('button', {name: 'Add requirement'}).click();
  await admin.locator('#requirement-2-item').selectOption('specific-challenge', {force: true});
  await admin.locator('#requirement-2-condition').selectOption('Exactly', {force: true});
  await admin.locator('#requirement-2-count').fill('2');
  const challenge = admin.locator('#requirement-2-challenge');
  await challenge.selectOption(String(catalog.challenge), {force: true});
  const title = await challenge.evaluate(select => select.selectedOptions[0].textContent);
  await admin.locator('#badge-image').setInputFiles({name: 'badge.png', mimeType: 'image/png', buffer: valid});
  await admin.waitForFunction(() => document.querySelector('#badge-image-preview img')?.naturalWidth === 128);
  await admin.getByRole('button', {name: 'Save achievement', exact: true}).click();
  await admin.waitForURL(url => url.searchParams.get('view') === 'achievements-achievements');
  const card = admin.locator('article.badge-card').filter({has: admin.getByRole('heading', {name, exact: true})});
  assert.equal(await card.count(), 1);
  assert.equal(await card.locator('.badge-tier').count(), 0);
  assert.match(await card.textContent(), /Aluminum cans · At least 10/);
  assert.ok((await card.textContent()).includes('Approved submissions in ' + title + ' · Exactly 2'));
  const image = await admin.request.get(new URL(await card.locator('img').getAttribute('src'), base).href);
  assert.equal(image.status(), 200);
  assert.deepEqual(await image.body(), valid);

  await card.getByRole('link', {name: 'Edit achievement'}).click();
  assert.equal(await admin.locator('#badge-mode').inputValue(), 'standalone');
  assert.equal(await admin.locator('#requirement-1-item').inputValue(), 'Aluminum cans');
  assert.equal(await admin.locator('#requirement-2-challenge').inputValue(), String(catalog.challenge));
  pass('Standalone badge saves a checked image and both fixed and challenge-specific requirements');
};
