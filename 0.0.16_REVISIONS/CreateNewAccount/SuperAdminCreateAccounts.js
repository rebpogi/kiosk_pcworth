function setupAccountTableActions() {
  const table = document.getElementById('accountsTable');
  if (!table) return;

  const rows = table.querySelectorAll('tbody tr');
  rows.forEach(row => {
    const editBtn = row.querySelector('.edit-btn');
    const deleteBtn = row.querySelector('.delete-btn');
    const id = row.getAttribute('id').replace('row-', '');

    if (editBtn) {
      editBtn.onclick = function () {
        alert('Edit clicked for ID: ' + id);
        // TODO: Add modal logic or redirection for editing
      };
    }

    if (deleteBtn) {
      deleteBtn.onclick = function () {
        if (confirm(`Delete account ID ${id}?`)) {
          fetch('DeleteAccount.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + encodeURIComponent(id)
          })
          .then(res => res.json())
          .then(data => {
            if (data.status === 'success') {
              row.remove();
              alert('Deleted successfully!');
            } else {
              alert('Delete failed: ' + data.message);
            }
          })
          .catch(() => alert('Network error'));
        }
      };
    }
  });
}
