'use strict';

const test = require('node:test');
const assert = require('node:assert/strict');
const { Element, environment } = require('./support/dom.cjs');

function filtering(records) {
  const toolbar = new Element(), search = new Element(), select = new Element();
  toolbar.selectors.set('input[type="search"]', search);
  toolbar.selectors.set('select', select);
  const world = environment({multiples: {'.toolbar': [toolbar], '[data-record]': records}});
  world.run();
  return {toolbar, search, select};
}

test('mobile labels are ignored while stored record text and extended search metadata remain searchable', () => {
  const row = new Element({textContent: 'Participant Alice Status Active', dataset: {filterText: 'Alice Active', search: 'TP900001 School of Computing'}});
  const {toolbar, search} = filtering([row]);
  for (const [query, hidden] of [['participant', true], ['status', true], ['ALICE', false], ['tp900001', false], ['COMPUTING', false], ['unknown', true], ['', false]]) {
    search.value = query; toolbar.dispatch('input');
    assert.equal(row.hidden, hidden, query);
    assert.equal(row.style.display, hidden ? 'none' : '', query);
  }
});

test('an empty stored record value does not accidentally search its presentation labels', () => {
  const row = new Element({textContent: 'Status Participant', dataset: {filterText: '', search: 'faculty fixture'}});
  const {toolbar, search} = filtering([row]);
  search.value = 'status'; toolbar.dispatch('input'); assert.equal(row.hidden, true);
  search.value = 'fixture'; toolbar.dispatch('input'); assert.equal(row.hidden, false);
});

test('unwrapped records keep the original text search fallback and extended metadata', () => {
  const row = new Element({textContent: 'Campus cleanup', dataset: {search: 'School of Media'}});
  const {toolbar, search} = filtering([row]);
  search.value = 'cleanup'; toolbar.dispatch('input'); assert.equal(row.hidden, false);
  search.value = 'media'; toolbar.dispatch('input'); assert.equal(row.hidden, false);
  search.value = 'computing'; toolbar.dispatch('input'); assert.equal(row.hidden, true);
});

for (const [label, status] of Object.entries({
  'Pending review': 'pending', 'Needs revision': 'needs-revision', 'Registered user': 'user',
  'Faculty representative': 'faculty', 'Sustainability coordinator': 'coordinator', 'Administrator': 'admin',
})) {
  test('original status filter remains active for ' + label, () => {
    const matching = new Element({textContent: 'Status Label', dataset: {filterText: 'Saved record', search: 'TP900001', status}});
    const other = new Element({textContent: 'Other', dataset: {filterText: 'Other', search: 'TP900001', status: 'unrelated'}});
    const {toolbar, search, select} = filtering([matching, other]);
    search.value = 'tp900001'; select.value = label; toolbar.dispatch('change');
    assert.equal(matching.hidden, false); assert.equal(other.hidden, true);
    search.value = 'no matching record'; toolbar.dispatch('input'); assert.equal(matching.hidden, true);
    search.value = ''; select.value = 'All statuses'; toolbar.dispatch('change');
    assert.equal(matching.hidden, false); assert.equal(other.hidden, false);
  });
}

function modal() {
  const dialog = new Element(), first = new Element({type: 'button', tabIndex: 0}), middle = new Element({type: 'text', tabIndex: 0}), last = new Element({type: 'button', tabIndex: 0});
  const excluded = [
    new Element({type: 'hidden', tabIndex: 0}), // The real backend CSRF field.
    new Element({disabled: true, tabIndex: 0}),
    new Element({hidden: true, tabIndex: 0}),
    new Element({tabIndex: -1}), // Enhanced native select replaced by a themed button.
    new Element({tabIndex: 0, closest: () => ({inert: true})}),
    new Element({tabIndex: 0, getClientRects: () => []}),
    new Element({tabIndex: 0, matches: selector => selector === ':disabled'}), // Disabled by an enclosing fieldset.
  ];
  const close = new Element();
  const world = environment({singles: {'[role="dialog"]': dialog}});
  for (const control of [first, middle, last, ...excluded]) control.ownerDocument = world.document;
  dialog.selectors.set('a[href],button,input,select,textarea', [excluded[0], first, ...excluded.slice(1), middle, last]);
  dialog.selectors.set('.close-button', close);
  world.run();
  return {dialog, first, middle, last, excluded, close, world};
}

test('modal initially focuses the first visible enabled control, never the CSRF field', () => {
  const {first, world} = modal(); assert.equal(world.document.activeElement, first);
});

test('Tab wraps past hidden, disabled, inherited-disabled and inert controls', () => {
  const {dialog, first, last, excluded, world} = modal();
  // Excluded controls appear at both ends and cannot become a focus boundary.
  dialog.selectors.set('a[href],button,input,select,textarea', [...excluded, first, last, ...excluded]);
  last.focus(); const event = dialog.dispatch('keydown', {key: 'Tab', shiftKey: false});
  assert.equal(event.defaultPrevented, true); assert.equal(world.document.activeElement, first);
  first.focus(); dialog.dispatch('keydown', {key: 'Tab', shiftKey: true});
  assert.equal(world.document.activeElement, last);
});

test('modal boundaries include a newly created themed control without rerunning the script', () => {
  const {dialog, first, middle, last, world} = modal();
  const added = new Element({type: 'button', tabIndex: 0, ownerDocument: world.document});
  dialog.selectors.set('a[href],button,input,select,textarea', [first, middle, last, added]);
  added.focus(); dialog.dispatch('keydown', {key: 'Tab', shiftKey: false}); assert.equal(world.document.activeElement, first);
  first.focus(); dialog.dispatch('keydown', {key: 'Tab', shiftKey: true}); assert.equal(world.document.activeElement, added);
});

test('modal boundaries adjust when fields become disabled after page load', () => {
  const {dialog, first, middle, last, world} = modal();
  first.disabled = true;
  last.focus(); dialog.dispatch('keydown', {key: 'Tab', shiftKey: false}); assert.equal(world.document.activeElement, middle);
  middle.focus(); dialog.dispatch('keydown', {key: 'Tab', shiftKey: true}); assert.equal(world.document.activeElement, last);
});

test('normal Tab inside a modal is left to the browser', () => {
  const {dialog, middle} = modal(); middle.focus();
  assert.equal(dialog.dispatch('keydown', {key: 'Tab', shiftKey: false}).defaultPrevented, false);
  assert.equal(dialog.dispatch('keydown', {key: 'Tab', shiftKey: true}).defaultPrevented, false);
});

test('Escape still activates the original close action', () => {
  const {dialog, close} = modal(); dialog.dispatch('keydown', {key: 'Escape'}); assert.equal(close.clicked, true);
});

test('an empty modal and a page without enhancements remain safe', () => {
  const dialog = new Element();
  environment({singles: {'[role="dialog"]': dialog}}).run();
  assert.equal(dialog.dispatch('keydown', {key: 'Tab'}).defaultPrevented, false);
  assert.doesNotThrow(() => dialog.dispatch('keydown', {key: 'Escape'}));
  assert.doesNotThrow(() => environment().run());
});
