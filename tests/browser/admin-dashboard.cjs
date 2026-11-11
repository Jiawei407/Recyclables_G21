'use strict';

const assert = require('node:assert/strict');

function onePagePdf() {
    let pdf = '%PDF-1.4\n';
    const objects = [
        '<< /Type /Catalog /Pages 2 0 R >>',
        '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
        '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 72 72] /Resources << >> >>',
    ];
    const offsets = objects.map((object, index) => {
        const offset = pdf.length;
        pdf += (index + 1) + ' 0 obj\n' + object + '\nendobj\n';
        return offset;
    });
    const xref = pdf.length;
    pdf += 'xref\n0 4\n0000000000 65535 f \n';
    for (const offset of offsets) pdf += String(offset).padStart(10, '0') + ' 00000 n \n';
    pdf += 'trailer\n<< /Size 4 /Root 1 0 R >>\nstartxref\n' + xref + '\n%%EOF\n';
    return Buffer.from(pdf);
}

module.exports = async function checkAdminDashboard({admin, faculty, base, catalog, pass = console.log}) {
    const route = logical => base + '/' + catalog.routes.find(screen => screen.logical === logical).route;
    const adminHome = route('admin/home.php');
    const participantPanel = admin.locator('section.panel').filter({has: admin.getByRole('heading', {name: 'Participant activity', exact: true})});
    await admin.goto(adminHome);
    assert.ok(await participantPanel.locator('svg.line-chart rect').count() > 0);
    assert.equal(await participantPanel.locator('table').isVisible(), false);
    const chartToggle = participantPanel.locator('summary');
    await chartToggle.focus();
    await admin.keyboard.press('Enter');
    assert.equal(await participantPanel.getByText('Hide chart data', {exact: true}).isVisible(), true);
    const chartValues = await participantPanel.locator('tbody tr td:nth-child(2) .cell-value').allTextContents();
    assert.equal(chartValues.length, 6);
    assert.ok(chartValues.some(value => Number(value) > 0));
    await admin.keyboard.press('Enter');
    assert.equal(await participantPanel.locator('table').isVisible(), false);
    pass('Admin participant chart and six-month disclosure use saved counts');

    await admin.goto(route('admin/impact-analytics.php'));
    for (const name of ['Approved activities', 'Participants', 'Recyclable items recorded']) {
        const value = await admin.locator('.metric').filter({has: admin.getByText(name, {exact: true})}).locator('.metric-value').innerText();
        assert.ok(Number(value) > 0, name + ' should have recorded data');
    }
    assert.ok(await admin.locator('main .data-table tbody tr').count() > 0);
    pass('Admin impact analytics show recorded activity, participants, and recyclable item counts');

    await admin.goto(route('admin/reports-faculty-report.php'));
    const report = admin.locator('main article[data-record]');
    assert.equal(await report.getByText('No attachment supplied.', {exact: true}).isVisible(), true);
    assert.equal(await report.getByText('Hide report details', {exact: true}).isVisible(), true);
    await report.locator('summary').click();
    assert.equal(await report.getByText('Show report details', {exact: true}).isVisible(), true);
    assert.equal(await report.locator('dl').isVisible(), false);
    await report.locator('summary').click();
    assert.deepEqual(await report.locator('dt').allTextContents(), ['Faculty', 'Period', 'Participants', 'Outcome']);
    if (faculty) {
        const attachment = onePagePdf();
        const title = 'Report attachment workflow';
        await faculty.goto(route('faculty/submit-report-submit-report.php'));
        await faculty.locator('#report-activity').fill(title);
        await faculty.locator('#report-participants').fill('2');
        await faculty.locator('#report-outcome').fill('Two participants submitted outcomes.');
        await faculty.locator('#report-attachment').setInputFiles({name: 'report.pdf', mimeType: 'application/pdf', buffer: attachment});
        await faculty.getByRole('button', {name: 'Submit report', exact: true}).click();
        await faculty.waitForURL(url => url.searchParams.get('view') === 'submit-report-reports');
        await admin.goto(route('admin/reports-faculty-reports.php'));
        await admin.locator('article[data-record]').filter({has: admin.getByRole('heading', {name: title, exact: true})})
            .getByRole('link', {name: 'View report details', exact: true}).click();
        await report.getByText('View attachment', {exact: true}).click();
        const download = report.getByRole('link', {name: 'Open report attachment', exact: true});
        assert.equal(await download.isVisible(), true);
        const response = await admin.request.get(new URL(await download.getAttribute('href'), base).href);
        assert.equal(response.status(), 200);
        assert.match(response.headers()['content-type'], /^application\/pdf/);
        assert.deepEqual(await response.body(), attachment);
        await report.getByText('Hide attachment', {exact: true}).click();
        assert.equal(await download.isVisible(), false);
    }
    pass('Admin report details toggle and handle saved attachment state');

    const auditDetail = route('admin/audit-log-audit-details.php');
    await admin.goto(auditDetail);
    const auditEntry = admin.locator('main article.panel');
    const fieldLabels = ['User', 'Role', 'Action taken', 'Date'];
    assert.deepEqual(await auditEntry.locator('dt').allTextContents(), fieldLabels);
    const actor = await auditEntry.locator('dd').first().innerText();
    const date = (await auditEntry.locator('time').getAttribute('datetime')).slice(0, 10);
    const actionText = (await auditEntry.locator('dd').nth(2).innerText()).trim();
    assert.match(actionText, /^Saved challenge #1/);
    await admin.goto(route('admin/audit-log.php'));
    const select = async (label, option) => {
        await admin.getByRole('combobox', {name: label, exact: true}).click();
        await admin.getByRole('option', {name: option, exact: true}).click();
    };
    await admin.locator('#audit-from').fill(date);
    await admin.locator('#audit-to').fill(date);
    await select('User', actor);
    await select('Role', 'Administrator');
    await select('Action type', 'Challenge saved');
    await admin.locator('#audit-search').fill('Plastic Bottles');
    await admin.getByRole('button', {name: 'Apply filters', exact: true}).click();
    assert.equal(await admin.locator('main article[data-record]').count(), 1);
    assert.deepEqual(await admin.locator('main article[data-record] dt').allTextContents(), fieldLabels);
    await admin.getByRole('link', {name: actionText, exact: true}).click();
    assert.equal(new URL(admin.url()).searchParams.get('id'), new URL(auditDetail).searchParams.get('id'));
    await admin.getByRole('link', {name: 'All audit records', exact: true}).click();
    assert.equal(await admin.locator('#audit-from').inputValue(), date);
    assert.equal(await admin.locator('#audit-to').inputValue(), date);
    await admin.getByRole('link', {name: 'Clear filters', exact: true}).click();
    assert.equal(await admin.locator('#audit-from').inputValue(), '');
    pass('Admin audit filters intersect and the exact four fields survive detail navigation');
};
