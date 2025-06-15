

// LOADS THE FORM AND MANGES THE ACTION BUTTONS==========================================================
// ================================================================
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
        .then(res => res.text())
        .then(data => {
          target.innerHTML = data;
          target.classList.add('active');
          
          // Load SweetAlert if not already loaded
          if (!document.querySelector('script[src*="sweetalert2"]')) {
            loadSweetAlert();
          }
        })
        .catch(() => {
          target.innerHTML = '<p style="color: red;">Failed to load content.</p>';
          target.classList.add('active');
        });
    } else {
      target.classList.add('active');
    }
  }
}
function filterTable() {
  const input = document.getElementById('searchBar').value.toLowerCase();
  const rows = document.querySelectorAll('#productTable tbody tr');

  rows.forEach(row => {
    const name = row.cells[0].textContent.toLowerCase();
    const category = row.cells[1].textContent.toLowerCase();
    if (name.includes(input) || category.includes(input)) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
}

function editProduct(productId) {
  fetch(`UpdateProducts/Update_Forms.php?id=${productId}`)
    .then(response => response.text())
    .then(html => {
      const container = document.getElementById('contentContainer');
      container.innerHTML = html;
      container.style.display = 'block';

      // Hide other sections
      document.querySelectorAll('.section-content').forEach(div => {
        div.classList.remove('active');
        div.style.display = 'none';
      });

      // Remove "active" class from Edit Product Information link
      const editLink = document.querySelector('[data-section="Edit_Product_Information"]');
      if (editLink) {
        editLink.classList.remove('active');
      }
      
      // Initialize form validation after content loads
      if (typeof initUpdateProductFormValidation === 'function') {
        initUpdateProductFormValidation();
      }
    })
    .catch(err => {
      console.error('Failed to load update form:', err);
      document.getElementById('contentContainer').innerHTML = '<p>Error loading form.</p>';
    });
}


function toggleStatus(id) {
  fetch('UpdateProducts/Existing_Product_Table.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `action=toggle&id=${id}`
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      const statusCell = document.querySelector(`#row-${id} .status span`);
      if (data.newStatus == 1) {
        statusCell.textContent = 'Shown';
        statusCell.className = 'shown';
      } else {
        statusCell.textContent = 'Hidden';
        statusCell.className = 'hidden';
      }
    } else {
      Swal.fire('Error', data.message, 'error');
    }
  });
}

function deleteProduct(id) {
  Swal.fire({
    title: 'Delete product?',
    text: 'This action is irreversible!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it'
  }).then(result => {
    if (result.isConfirmed) {
      fetch('UpdateProducts/Existing_Product_Table.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `action=delete&id=${id}`
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          document.getElementById(`row-${id}`).remove();
          Swal.fire('Deleted!', data.message, 'success');
        } else {
          Swal.fire('Error', data.message, 'error');
        }
      });
    }
  });
}

function loadSweetAlert() {
  const script = document.createElement('script');
  script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
  document.head.appendChild(script);
  
  const link = document.createElement('link');
  link.rel = 'stylesheet';
  link.href = 'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css';
  document.head.appendChild(link);
}
