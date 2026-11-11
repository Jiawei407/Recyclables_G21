(() => {
  'use strict';

  const form = document.getElementById('badge-editor');
  if (!form) return;

  const mode = form.querySelector('#badge-mode');
  const family = form.querySelector('#badge-family');
  function showTierFields() {
    const tiered = mode.value === 'tiered';
    for (const field of form.querySelectorAll('[data-tier-field]')) {
      field.hidden = !tiered;
      field.querySelector('input, select').disabled = !tiered;
    }
    family.required = tiered;
  }
  mode.addEventListener('change', showTierFields);
  showTierFields();

  const rows = [...form.querySelectorAll('[data-requirement-row]')];
  const add = form.querySelector('#badge-add-requirement button');
  add.parentElement.hidden = false;

  function refreshRequirements() {
    let index = 0;
    for (const row of rows) {
      if (row.hidden) continue;
      row.querySelector('legend').textContent = 'Requirement ' + (++index);
      const measure = row.querySelector('[data-requirement-measure]');
      const challenge = row.querySelector('[data-requirement-challenge]');
      challenge.hidden = measure.value !== 'specific-challenge';
      challenge.querySelector('select').disabled = challenge.hidden;
    }
    add.disabled = index === rows.length;
  }

  function showRequirement(row, show) {
    row.hidden = !show;
    row.disabled = !show;
  }

  const hasValues = row => [...row.querySelectorAll('input, select')].some(field => field.value);
  const anyFilled = rows.some(hasValues);
  for (const [index, row] of rows.entries()) {
    showRequirement(row, hasValues(row) || (!anyFilled && index === 0));
    row.addEventListener('change', refreshRequirements);
    const remove = row.querySelector('[data-remove-requirement]');
    remove.hidden = false;
    remove.querySelector('button').addEventListener('click', () => {
      for (const field of row.querySelectorAll('input, select')) {
        field.value = '';
        field.dispatchEvent(new Event('change', { bubbles: true }));
      }
      showRequirement(row, false);
      refreshRequirements();
      add.focus();
    });
  }
  add.addEventListener('click', () => {
    const next = rows.find(row => row.hidden);
    if (!next) return;
    showRequirement(next, true);
    refreshRequirements();
    next.querySelector('input').focus();
  });
  refreshRequirements();

  const upload = form.querySelector('#badge-image');
  const preview = form.querySelector('#badge-image-preview');
  let previewUrl = '';

  function showImage(source) {
    preview.replaceChildren();
    preview.hidden = !source;
    if (!source) return;
    const thumbnail = document.createElement('img');
    thumbnail.className = 'upload-thumbnail';
    thumbnail.alt = 'Badge preview';
    thumbnail.width = thumbnail.height = 96;
    thumbnail.src = source;
    preview.append(thumbnail);
  }

  upload.addEventListener('change', async () => {
    upload.setCustomValidity('');
    if (previewUrl) URL.revokeObjectURL(previewUrl);
    previewUrl = '';

    showImage(preview.dataset.savedImage);
    const file = upload.files[0];
    if (!file) return;

    const reject = message => {
      upload.setCustomValidity(message);
      upload.reportValidity();
    };
    if (file.size > 5 * 1024 * 1024) {
      reject('Choose a file up to 5 MB.');
      return;
    }

    const image = new Image();
    const url = URL.createObjectURL(file);
    image.src = url;
    try {
      await image.decode();
      if (upload.files[0] !== file) return;
      if (image.naturalWidth < 128 || image.naturalHeight < 128 || image.naturalWidth > 2048 || image.naturalHeight > 2048) {
        reject('Badge width and height must each be between 128 and 2048 pixels.');
        return;
      }
      previewUrl = url;
      showImage(url);
    } catch {
      if (upload.files[0] === file) reject('Choose a valid, complete JPG or PNG badge image.');
    } finally {
      if (previewUrl !== url) URL.revokeObjectURL(url);
    }
  });
})();
