// bundle-management.js

document.addEventListener('DOMContentLoaded', function() {
  initBundleManagement();
});

function initBundleManagement() {
  const createBundleBtn = document.getElementById('createBundleBtn');
  const cancelFormBtn = document.getElementById('cancelFormBtn');
  const bundlesTable = document.getElementById('bundlesTable');
  const bundleFormContainer = document.getElementById('bundleFormContainer');
  const bundleForm = document.getElementById('bundleForm');
  const formTitle = document.getElementById('formTitle');
  const imageInput = document.getElementById('bundle_image');
  const imagePreview = document.getElementById('imagePreview');
  const imageError = document.getElementById('imageError');

  // Show form for creating new bundle
  if (createBundleBtn) {
    createBundleBtn.addEventListener('click', showBundleForm);
  }

  // Cancel form and go back to table
  if (cancelFormBtn) {
    cancelFormBtn.addEventListener('click', hideBundleForm);
  }

  // Image preview functionality
  if (imageInput) {
    imageInput.addEventListener('change', handleImagePreview);
  }

  // Form validation
  if (bundleForm) {
    bundleForm.addEventListener('submit', validateBundleForm);
  }
}

function showBundleForm() {
  // Reset form
  document.getElementById('bundleForm').reset();
  document.getElementById('bundle_id').value = '';
  document.getElementById('formTitle').textContent = 'Create New Bundle';
  
  // Reset image preview
  document.getElementById('imagePreview').innerHTML = '';
  
  // Reset parts selection
  document.querySelectorAll('[id^="part_"]').forEach(el => {
    if (el.id.endsWith('_uid')) {
      el.value = '';
    } else if (el.id.endsWith('_qty')) {
      el.value = '0';
    } else if (el.id.endsWith('_price')) {
      el.textContent = '₱0.00';
    }
  });
  
  // Hide all remove buttons
  document.querySelectorAll('[onclick^="removePart"]').forEach(btn => {
    btn.style.display = 'none';
  });
  
  // Show form and hide table
  document.getElementById('bundleFormContainer').style.display = 'block';
  document.getElementById('bundlesTable').style.display = 'none';
}

function hideBundleForm() {
  document.getElementById('bundleFormContainer').style.display = 'none';
  document.getElementById('bundlesTable').style.display = 'block';
}

function handleImagePreview() {
  const file = this.files[0];
  const imagePreview = document.getElementById('imagePreview');
  const imageError = document.getElementById('imageError');

  if (file) {
    // Validate file type and size
    const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    const maxSize = 20 * 1024 * 1024; // 20MB

    if (!validTypes.includes(file.type)) {
      imageError.textContent = 'Only JPG, JPEG, and PNG files are allowed.';
      this.value = '';
      imagePreview.innerHTML = '';
      return;
    }

    if (file.size > maxSize) {
      imageError.textContent = 'Image must be 20MB or smaller.';
      this.value = '';
      imagePreview.innerHTML = '';
      return;
    }

    imageError.textContent = '';

    const img = document.createElement('img');
    img.style.maxWidth = '200px';
    img.style.maxHeight = '150px';

    const reader = new FileReader();
    reader.onload = function(e) {
      img.src = e.target.result;
      imagePreview.innerHTML = '';
      imagePreview.appendChild(img);
    };
    reader.readAsDataURL(file);
  }
}

function validateBundleForm(e) {
  let isValid = true;
  let errors = [];
  const imageError = document.getElementById('imageError');
  imageError.textContent = '';

  // Validate UID
  const uid = document.getElementById('bundle_uid').value;
  if (!/^\d{6}$/.test(uid)) {
    isValid = false;
    errors.push("Bundle UID must be exactly 6 digits.");
  }

  // Validate price
  const price = parseFloat(document.getElementById('bundle_price').value);
  if (isNaN(price) || price < 2000 || price > 500000) {
    isValid = false;
    errors.push("Bundle price must be between ₱2000 and ₱500000.");
  }

  // Validate quantity
  const qty = parseInt(document.getElementById('bundle_quantity').value, 10);
  if (isNaN(qty) || qty < 0 || qty > 10) {
    isValid = false;
    errors.push("Bundle quantity must be between 0 and 10.");
  }

  // Validate display name
  const name = document.getElementById('bundle_display_name').value;
  if (/\${1,}/.test(name) || /\s{3,}/.test(name)) {
    isValid = false;
    errors.push("Display name cannot contain dollar signs or more than two consecutive spaces.");
  }

  // For new bundles, require an image
  const imageInput = document.getElementById('bundle_image');
  if (!document.getElementById('bundle_id').value && !imageInput.files[0]) {
    isValid = false;
    errors.push("Bundle image is required for new bundles.");
  }

  if (!isValid) {
    e.preventDefault();
    alert("Please fix the following errors:\n\n" + errors.join("\n"));
  }
}

function editBundle(bundleId) {
  fetch('ActionButtons/get_bundle.php?id=' + bundleId)
    .then(response => response.json())
    .then(data => {
      // Populate form fields
      document.getElementById('bundle_id').value = data.id;
      document.getElementById('bundle_display_name').value = data.bundle_display_name;
      document.getElementById('bundle_quantity').value = data.bundle_quantity;
      document.getElementById('bundle_uid').value = data.bundle_uid;
      document.getElementById('bundle_price').value = data.bundle_price;
      document.getElementById('status').value = data.status;
      document.getElementById('bundle_description').value = data.bundle_description;
      
      // Set image preview
      const imagePreview = document.getElementById('imagePreview');
      if (data.bundle_image) {
        const img = document.createElement('img');
        img.src = data.bundle_image;
        img.style.maxWidth = '200px';
        img.style.maxHeight = '150px';
        imagePreview.innerHTML = '';
        imagePreview.appendChild(img);
      }
      
      // Set form title
      document.getElementById('formTitle').textContent = 'Edit Bundle';
      
      // Show form and hide table
      document.getElementById('bundleFormContainer').style.display = 'block';
      document.getElementById('bundlesTable').style.display = 'none';
      
      // TODO: Populate parts data if available
      // This would require additional AJAX call to get bundle parts
    })
    .catch(error => {
      console.error('Error fetching bundle data:', error);
      alert('Error loading bundle data');
    });
}

function toggleBundleStatus(bundleId, currentStatus) {
  if (confirm(`Are you sure you want to ${currentStatus ? 'hide' : 'show'} this bundle?`)) {
    fetch('ActionButtons/toggle_status_bundle.php?id=' + bundleId, {
      method: 'POST'
    })
    .then(response => {
      if (response.ok) {
        location.reload(); // Refresh the page to see changes
      } else {
        alert('Error updating bundle status');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Error updating bundle status');
    });
  }
}

function deleteBundle(bundleId) {
  if (confirm('Are you sure you want to delete this bundle? This action cannot be undone.')) {
    fetch('ActionButtons/delete_bundle.php?id=' + bundleId, {
      method: 'POST'
    })
    .then(response => {
      if (response.ok) {
        location.reload(); // Refresh the page to see changes
      } else {
        alert('Error deleting bundle');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Error deleting bundle');
    });
  }
}

function selectPart(category) {
  alert('Implement part selection for ' + category);
  // This would open a modal or another interface to select parts
  // Then update the corresponding fields in the form
}

function removePart(category) {
  document.getElementById('part_' + category + '_uid').value = '';
  document.getElementById('part_' + category + '_qty').value = '0';
  document.getElementById('part_' + category + '_price').textContent = '₱0.00';
  document.querySelector(`button[onclick="removePart('${category}')"]`).style.display = 'none';
}