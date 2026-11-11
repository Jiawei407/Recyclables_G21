'use strict';
const fs=require('node:fs'),path=require('node:path'),assert=require('node:assert/strict');
const {chromium}=require(process.env.RECYCLABLES_PLAYWRIGHT_MODULE||'playwright');
const root=path.resolve(__dirname,'../..'),base=process.env.RECYCLABLES_BROWSER_URL;
assert.match(base||'',/^http:\/\/127\.0\.0\.1:\d+$/);
const catalog=JSON.parse(fs.readFileSync(path.join(root,'tests/.runtime/catalog.json'),'utf8'));
const out=path.join(root,'tests/.runtime/browser');fs.mkdirSync(out,{recursive:true});
const credentials={user:['tp900001@mail.apu.edu.my','TP900001123@'],faculty:['computing.rep@mail.apu.edu.my','faculty123@'],coordinator:['coordinator@mail.apu.edu.my','coordinator123@'],admin:['admin@mail.apu.edu.my','admin123@']};
const axe=process.env.RECYCLABLES_AXE_PATH?fs.readFileSync(process.env.RECYCLABLES_AXE_PATH,'utf8'):null;
const accessible=new Set(['user/home.php','user/profile-edit-details.php','user/submit-evidence-new-submission.php','faculty/home.php','faculty/announcements-create.php','coordinator/home.php','coordinator/submissions-review-submission.php','coordinator/challenges-create.php','admin/home.php','admin/users-edit-user.php','admin/reports-faculty-report.php']);
const report={routes:[],workflows:[],date:new Date().toISOString(),passed:false};
const pass=name=>{report.workflows.push(name);console.log('PASS '+name)};
function png(){const original=Buffer.from('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+jRZkAAAAASUVORK5CYII=','base64');const data=Buffer.from('Comment\0'+require('node:crypto').randomUUID()),type=Buffer.from('tEXt'),size=Buffer.alloc(4),crc=Buffer.alloc(4);size.writeUInt32BE(data.length);let value=0xffffffff;for(const b of Buffer.concat([type,data])){value^=b;for(let i=0;i<8;i++)value=(value>>>1)^((value&1)?0xedb88320:0)}crc.writeUInt32BE((value^0xffffffff)>>>0);return Buffer.concat([original.subarray(0,-12),size,type,data,crc,original.subarray(-12)])}
(async()=>{
 const health=await(await fetch(base+'/__test_health')).json();assert.equal(health.database,catalog.database);assert.ok(process.env.RECYCLABLES_TEST_SERVER_TOKEN);assert.equal(health.token,process.env.RECYCLABLES_TEST_SERVER_TOKEN);
 const browser=await chromium.launch({headless:true,...(process.env.RECYCLABLES_CHROME?{executablePath:process.env.RECYCLABLES_CHROME}:{})});
 try{
  const pages={},contexts={},errors=[];
  for(const [role,[email,password]] of Object.entries(credentials)){
   const context=contexts[role]=await browser.newContext({viewport:{width:390,height:1000}}),page=pages[role]=await context.newPage();
   page.on('pageerror',error=>errors.push(error.message));page.on('dialog',dialog=>dialog.accept());
   await page.goto(base+'/login.php');await page.locator('#email').fill(email);await page.locator('#password').fill(password);await page.getByRole('button',{name:'Log in',exact:true}).last().click();await page.waitForURL(url=>url.pathname.endsWith('/'+role+'/home.php'));
   for(const screen of catalog.routes.filter(item=>item.role===role)){
    const record={...screen,viewports:[]};
    for(const width of [320,1440]){
     await page.setViewportSize({width,height:1000});const response=await page.goto(base+'/'+screen.route);
     await page.evaluate(async()=>{await document.fonts.ready;await Promise.all([...document.images].map(i=>{i.loading='eager';return i.decode().catch(()=>{})}))});
     const state=await page.evaluate(()=>({width:innerWidth,pageWidth:document.documentElement.scrollWidth,header:!!document.querySelector('.clay-header'),brokenImages:[...document.images].filter(i=>!i.naturalWidth).map(i=>i.src),missingCsrf:[...document.forms].filter(f=>f.method==='post'&&f.querySelectorAll('[name=csrf]').length!==1).map(f=>f.id),prototype:!!document.querySelector('[data-role-switch],[data-prototype-form],.preview-note'),htmlLinks:[...document.querySelectorAll('a[href]')].filter(a=>/\.html(?:[?#]|$)/.test(a.getAttribute('href'))).map(a=>a.href)}));
     state.status=response.status();state.errors=[...errors];
     if(axe&&accessible.has(screen.logical)){await page.addScriptTag({content:axe});state.axe=await page.evaluate(async()=>(await axe.run(document,{runOnly:{type:'tag',values:['wcag2a','wcag2aa','wcag21aa','wcag22aa']}})).violations.map(v=>({id:v.id,nodes:v.nodes.map(n=>({target:n.target,summary:n.failureSummary}))})));await page.screenshot({path:path.join(out,screen.logical.replace(/[/.]/g,'-')+'-'+width+'.png')});}
     record.viewports.push(state);
    }
    report.routes.push(record);fs.writeFileSync(path.join(out,'report.json'),JSON.stringify(report,null,2));console.log(screen.logical+' '+record.viewports.map(s=>s.width+':'+s.status+' overflow='+(s.pageWidth-s.width)+' axe='+(s.axe?.length??'-')).join(' / '));
   }
  }
  const failures=report.routes.flatMap(r=>r.viewports.filter(s=>s.status!==200||s.pageWidth>s.width||!s.header||s.brokenImages.length||s.missingCsrf.length||s.prototype||s.htmlLinks.length||s.errors.length||s.axe?.length).map(state=>({logical:r.logical,...state})));
  report.failures=failures;assert.deepEqual(failures,[]);
  const user=pages.user,coordinator=pages.coordinator,faculty=pages.faculty,admin=pages.admin;
  await faculty.goto(base+'/faculty/home.php?view=insights-overview');
  const rankCard=faculty.locator('main .metric').filter({hasText:'Faculty rank'}).locator('.metric-value');
  const facultyRank=(await rankCard.innerText()).trim();
  await faculty.goto(base+'/faculty/home.php?view=insights-leaderboard');
  const computing=faculty.locator('tr[data-record]').filter({hasText:'School of Computing'});
  assert.equal((await computing.locator('td .cell-value').first().innerText()).trim(),facultyRank);
  assert.match(facultyRank,/^[1-9]\d*$/);
  await faculty.goto(base+'/faculty/home.php?view=participation-challenge-participation');
  const enrollmentRows=faculty.locator('tbody tr[data-record]');
  assert.ok(await enrollmentRows.count()>0);
  const enrollments=await enrollmentRows.evaluateAll(rows=>rows.map(row=>Number(row.cells[2].querySelector('.cell-value').textContent)));
  assert.deepEqual(enrollments,[...enrollments].sort((a,b)=>b-a));
  const topChallenge=await enrollmentRows.first().locator('td .cell-value').nth(1).innerText();
  await enrollmentRows.first().getByRole('link',{name:/View/}).click();
  assert.equal((await faculty.locator('main h1').innerText()).trim(),topChallenge.trim());
  await faculty.goto(base+'/faculty/home.php?view=participation-completion-rates');
  assert.ok(await faculty.locator('tbody tr[data-record]').count()>0);
  await faculty.getByLabel('Search challenges').fill(topChallenge.trim());
  await faculty.locator('#participation-period').selectOption('all');
  await faculty.getByRole('button',{name:'Apply filters'}).click();
  await faculty.waitForURL(url=>url.searchParams.get('q')===topChallenge.trim());
  assert.equal(await faculty.locator('tbody tr[data-record]').count(),1);
  assert.match((await faculty.locator('tbody tr[data-record] td .cell-value').last().innerText()).trim(),/^\d+%$/);
  pass('Faculty rank agrees with the leaderboard and participation shows sorted, filterable saved enrollments');
  await faculty.goto(base+'/faculty/challenges.php?view=faculty-activities-create-activity');
  const limit=faculty.locator('#activity-limit');
  await limit.fill('-1');
  assert.equal(await limit.evaluate(input=>input.validity.rangeUnderflow),true);
  await limit.fill('1');
  await limit.press('ArrowDown');
  assert.equal(await limit.inputValue(),'1');
  await faculty.setViewportSize({width:320,height:900});
  const account=faculty.locator('.workspace-account');
  assert.equal(await account.count(),1);
  await account.locator('summary').click();
  assert.equal(await account.getByRole('button',{name:'Log out'}).isVisible(),true);
  await account.locator('summary').click();
  await faculty.locator('.mobile-menu summary').click();
  assert.equal(await faculty.locator('.mobile-menu nav').getByRole('link',{name:'Participation'}).isVisible(),true);
  await faculty.setViewportSize({width:1440,height:1000});
  pass('Faculty participant limits and mobile account navigation use native controls');
  await require('./achievement-regression.cjs')({admin,base,catalog,pass});
  await require('./admin-dashboard.cjs')({admin,faculty,base,catalog,pass});
  await user.goto(base+'/user/evidence.php?view=submit-evidence-new-submission&challenge_id='+catalog.challenge);
  await user.locator('.selection-challenge').click();await user.locator('input[name="challenge-id"][value="'+catalog.challenge+'"]').check();
  await user.getByRole('button',{name:/Increase Number of items/i}).click();assert.equal(await user.locator('#quantity').inputValue(),'2');
  await user.locator('input[type=file]').setInputFiles({name:'ui-port.png',mimeType:'image/png',buffer:png()});await user.locator('#evidence-description').fill('Disposable UI port browser workflow');
  await user.getByRole('button',{name:'Submit evidence',exact:true}).click();await user.waitForURL(url=>url.searchParams.get('view')==='submit-evidence-submission-status');
  const href=await user.locator('a[href*="view=submit-evidence-submission-details"]').first().getAttribute('href');const submission=new URL(href,base).searchParams.get('id');assert.ok(submission);pass('Grouped evidence route submits themed challenge, quantity and photo with real CSRF');
  await coordinator.goto(base+'/coordinator/submissions.php?view=submissions-review-submission&id='+submission);
  const reason=coordinator.locator('#review-reason');await reason.locator('..').locator('.selection-trigger').click();await coordinator.getByRole('option',{name:'Other',exact:true}).click();assert.equal(await reason.inputValue(),'Other');
  await coordinator.getByRole('button',{name:'Needs revision',exact:true}).click();await coordinator.waitForLoadState('networkidle');assert.match(await coordinator.locator('body').textContent(),/Describe the reason when you choose Other/);pass('Themed review reason preserves required Other explanation');
  for(const name of ['review-matches','review-count','review-duplicate'])await coordinator.locator('[name="'+name+'"]').check();
  await coordinator.getByRole('button',{name:'Approve',exact:true}).click();await coordinator.waitForURL(url=>url.searchParams.get('view')==='submissions-approved');
  await user.goto(base+'/user/evidence.php?view=submit-evidence-submission-details&id='+submission);assert.match(await user.locator('main').textContent(),/approved/i);pass('Coordinator approval stores a decision visible to its participant');
  await coordinator.goto(base+'/coordinator/submissions.php?view=submissions-review-submission&id='+submission);assert.equal(await coordinator.getByRole('button',{name:'Approve',exact:true}).isDisabled(),true);assert.equal(await coordinator.locator('.selection-trigger').last().isDisabled(),true);pass('Final review controls stay disabled after approval');
  await require('./admin-workflow-regression.cjs')({admin,user,base,catalog,submission,pass});
  await faculty.goto(base+'/faculty/announcements.php?view=announcements-create');await faculty.locator('#announcement-title').fill('UI port browser announcement');await faculty.locator('#announcement-message').fill('Disposable workflow fixture.');
  const date=new Date().toISOString().slice(0,10);await faculty.locator('#announcement-date').fill(date);await faculty.locator('#announcement-date').locator('..').locator('.clay-calendar-button').click();await faculty.locator('.selection-calendar:not([hidden]) [data-date="'+date+'"]').click();
  await faculty.getByRole('button',{name:'Publish',exact:true}).click();await faculty.waitForURL(url=>url.searchParams.get('view')==='announcements-announcements');assert.match(await faculty.locator('main').textContent(),/UI port browser announcement/);pass('Faculty calendar publishes through the grouped announcement route');
  await admin.goto(base+'/admin/users.php?view=users-edit-user&id=7');await admin.locator('#designated-role').locator('..').locator('.selection-trigger').click();await admin.getByRole('option',{name:'Faculty Representative',exact:true}).click();assert.equal(await admin.locator('#designated-role').evaluate(e=>new FormData(e.form).get(e.name)),'faculty');pass('Administrator themed role selection retains original form payload');
  const forbidden=await user.goto(base+'/admin/users.php?view=users-users');assert.equal(forbidden.status(),403);pass('Role permissions still block unauthorized grouped pages');
  assert.deepEqual(errors,[]);report.passed=true;
 }catch(error){report.error=error.stack||String(error);throw error}finally{fs.writeFileSync(path.join(out,'report.json'),JSON.stringify(report,null,2));await browser.close()}
})().catch(error=>{console.error(error);process.exitCode=1});
