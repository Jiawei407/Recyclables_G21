(() => {
  const role = document.getElementById('designated-role');
  if (!role) return;
  const groups = document.querySelectorAll('[data-permission-role]');
  const hint = document.querySelector('[data-permission-hint]');
  const updatePermissions = () => {
    groups.forEach(group => {
      const active = group.dataset.permissionRole === role.value;
      group.hidden = !active;
      group.querySelector('fieldset').disabled = !active;
    });
    hint.hidden = Boolean(role.value);
  };
  role.addEventListener('change', updatePermissions);
  updatePermissions();
})();
