// LOADS THE FORM AND MANAGES THE ACTION BUTTONS
function showForms(sectionId, fileToLoad = null) {
  // Hide all section divs
  document.querySelectorAll('.section-content').forEach(div => {
    div.classList.remove('active');
  });

  const target = document.getElementById(sectionId);
  if (target) {
    if (fileToLoad) {
      target.innerHTML = '<p>Loading...</p>';
      fetch(fileToLoad)
        .then(res => {
          // First check if the response is JSON
          const contentType = res.headers.get('content-type');
          if (contentType && contentType.includes('application/json')) {
            return res.json().then(data => {
              throw new Error(`Expected HTML but got JSON: ${JSON.stringify(data)}`);
            });
          }
          return res.text();
        })
        .then(data => {
          target.innerHTML = data;
          target.classList.add('active');
          
          // Load SweetAlert if not already loaded
          if (!document.querySelector('script[src*="sweetalert2"]')) {
            loadSweetAlert();
          }
        })
        .catch((err) => {
          console.error('Error loading content:', err);
          target.innerHTML = '<p style="color: red;">Failed to load content.</p>';
          target.classList.add('active');
        });
    } else {
      target.classList.add('active');
    }
  }
}

document.addEventListener('DOMContentLoaded', function () {
function filterTableB() {
  const input = document.getElementById('searchBar').value.toLowerCase();
  const rows = document.querySelectorAll('#productTable tbody tr');

  rows.forEach(row => {
    const name = row.cells[0]?.textContent.toLowerCase() || '';
    const category = row.cells[1]?.textContent.toLowerCase() || '';

    if (name.includes(input) || category.includes(input)) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
}
});


function addNewBundle() {
  fetch('Bundles/Bundle_Forms.php') // No ID passed = New bundle form
    .then(response => response.text())
    .then(html => {
      const container = document.getElementById('BundlecontentContainer');
      container.innerHTML = html;
      container.style.display = 'block';

      document.querySelectorAll('.section-content').forEach(div => {
        div.classList.remove('active');
        div.style.display = 'none';
      });

      if (typeof initUpdateProductFormValidation === 'function') {
        initUpdateProductFormValidation();
      }
    })
    .catch(err => {
      console.error('Failed to load form:', err);
      document.getElementById('BundlecontentContainer').innerHTML = '<p>Error loading form.</p>';
    });
}


function editBundle(bundleId) {
  fetch(`Bundles/Bundle_Forms.php?id=${bundleId}`)
    .then(response => response.text())
    .then(html => {
      const container = document.getElementById('BundlecontentContainer');
      container.innerHTML = html;
      container.style.display = 'block';

      // Hide other sections
      document.querySelectorAll('.section-content').forEach(div => {
        div.classList.remove('active');
        div.style.display = 'none';
      });

      // Initialize form validation after content loads
      if (typeof initUpdateProductFormValidation === 'function') {
        initUpdateProductFormValidation();
      }
    })
    .catch(err => {
      console.error('Failed to load update form:', err);
      document.getElementById('BundlecontentContainer').innerHTML = '<p>Error loading form.</p>';
    });
}

function toggleBundleStatus(id) {
  fetch('Bundles/ExistingBundleTable.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=toggle&id=${id}`
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      const statusSpan = document.querySelector(`#row-${id} .status span`);
      const toggleBtn = document.querySelector(`#row-${id} .btn-toggle`);

      // Update text
      statusSpan.textContent = data.statusText;

      // Remove both classes before adding the new one
      statusSpan.classList.remove('shown', 'hidden');
      statusSpan.classList.add(data.newStatus == 1 ? 'shown' : 'hidden');

      // Update button label
      toggleBtn.textContent = data.newStatus == 1 ? 'Hide' : 'Show';
    } else {
      Swal.fire('Error', data.message || 'Toggle failed', 'error');
    }
  })
  .catch(err => {
    console.error('Toggle Error:', err);
    Swal.fire('Error', 'Failed to toggle bundle status', 'error');
  });
}


function deleteBundle(id) {
  Swal.fire({
    title: 'Delete bundle?',
    text: 'This action is irreversible!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it',
    cancelButtonText: 'Cancel'
  }).then(result => {
    if (result.isConfirmed) {
      fetch('Bundles/ExistingBundleTable.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `action=delete&id=${id}`
      })
      .then(res => {
        if (!res.ok) {
          throw new Error(`HTTP error! status: ${res.status}`);
        }
        return res.json();
      })
      .then(data => {
        if (data.success) {
          document.getElementById(`row-${id}`).remove();
          Swal.fire('Deleted!', 'Bundle has been deleted.', 'success');
        } else {
          Swal.fire('Error', data.message || 'Delete failed', 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Failed to delete bundle', 'error');
      });
    }
  });
}

function loadSweetAlert() {
  return new Promise((resolve) => {
    if (document.querySelector('script[src*="sweetalert2"]')) {
      resolve();
      return;
    }

    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
    script.onload = resolve;
    document.head.appendChild(script);
    
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css';
    document.head.appendChild(link);
  });
}

  // Back button functionality
  const backButton = document.querySelector('button[onclick="goBackBundles()"]');
  if (backButton) {
    backButton.addEventListener('click', function() {
      window.history.back();
    });
  }

