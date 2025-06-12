function initProductFormValidation() {
  console.log('Initializing product form validation...');

  // === DYNAMIC FIELD VISIBILITY SETUP ===
  function setupDynamicFields() {
    const categorySelect = document.getElementById('category');
    if (!categorySelect) return;

    // Get elements with null checks
    const formFactorContainer = document.getElementById('Form_factor')?.closest('.input-field');
    const formFactorSelect = document.getElementById('Form_factor');
    const cpuSocketContainer = document.getElementById('Socket_type')?.closest('.input-field');
    const cpuSocketSelect = document.getElementById('Socket_type');
    const ramSocketContainer = document.getElementById('Ram_socket_type')?.closest('.input-field');
    const ramSocketSelect = document.getElementById('Ram_socket_type');

    function updateFieldsVisibility() {
      const selected = categorySelect.value;
      
      // Helper function to handle field state
      const setFieldState = (container, select, shouldShow) => {
        if (!container || !select) return;
        container.style.display = shouldShow ? 'block' : 'none';
        select.required = shouldShow;
        if (!shouldShow) select.value = 'Not_Applicable';
      };

      // Mobo selected: show form factor + cpu socket, ram socket
      if (selected === 'Mobo') {
        setFieldState(formFactorContainer, formFactorSelect, true);
        setFieldState(cpuSocketContainer, cpuSocketSelect, true);
        setFieldState(ramSocketContainer, ramSocketSelect, true);
      }
      // CPU selected: show only cpu socket
      else if (selected === 'CPU') {
        setFieldState(formFactorContainer, formFactorSelect, false);
        setFieldState(cpuSocketContainer, cpuSocketSelect, true);
        setFieldState(ramSocketContainer, ramSocketSelect, false);
      }
      // RAM selected: show only ram socket
      else if (selected === 'RAM') {
        setFieldState(formFactorContainer, formFactorSelect, false);
        setFieldState(cpuSocketContainer, cpuSocketSelect, false);
        setFieldState(ramSocketContainer, ramSocketSelect, true);
      }
      // For all other categories, hide all three fields
      else {
        setFieldState(formFactorContainer, formFactorSelect, false);
        setFieldState(cpuSocketContainer, cpuSocketSelect, false);
        setFieldState(ramSocketContainer, ramSocketSelect, false);
      }
    }

    // Initialize visibility
    updateFieldsVisibility();

    // Listen to category changes
    categorySelect.addEventListener('change', updateFieldsVisibility);
  }

  // Initialize dynamic fields (with polling for dynamic loading)
  const checkCategorySelect = setInterval(() => {
    if (document.getElementById('category')) {
      clearInterval(checkCategorySelect);
      setupDynamicFields();
    }
  }, 100);

  // === IMAGE PREVIEW & VALIDATION ===
  const imageInput = document.getElementById('immage');
  const preview = document.getElementById('preview');
  const errorMsg = document.getElementById('immage-error');

  if (imageInput) {
    imageInput.addEventListener('change', function(event) {
      const file = event.target.files[0];
      errorMsg.textContent = '';
      imageInput.classList.remove('is-invalid');

      if (file && file.type.startsWith('image/')) {
        if (file.size <= 20 * 1024 * 1024) {
          const reader = new FileReader();
          reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
          };
          reader.readAsDataURL(file);
        } else {
          preview.style.display = 'none';
          errorMsg.textContent = "File is too large. Max 5MB.";
          imageInput.classList.add('is-invalid');
        }
      } else {
        preview.style.display = 'none';
        errorMsg.textContent = "Unsupported file type.";
        imageInput.classList.add('is-invalid');
      }
    });
  }

  // === SAVE BUTTON CLICK HANDLER ===/////////////////////////////////////////////////////////////////////////////////////
  document.addEventListener('click', function(e) {
    if (e.target && e.target.id === 'saveNewProductBtn') {
      e.preventDefault();
      if (validateProductForm()) {
        showSuccessModal();
        insertData();
        clearAllErrors();
        clearProductForm();
      }
    }
  });

  // === CLOSE MODAL HANDLER ===
  document.addEventListener('click', function(e) {
    if (e.target && e.target.id === 'closeModal') {
      document.getElementById('popupModal').style.display = 'none';
    }
  });

  // === VALIDATION LOGIC ===
  function validateProductForm() {
    clearAllErrors();
    let isValid = true;

    // Validate Product Display Name
    const displayName = document.getElementById('product_display_name');
    if (!displayName.value.trim()) {
      showError('product_display_name', 'This field is required');
      isValid = false;
    } else if (displayName.value.length > 160) {
      showError('product_display_name', 'Maximum 160 characters allowed');
      isValid = false;
    } else if (!/^[A-Za-z0-9\-_][A-Za-z0-9 \-_]*[A-Za-z0-9\-_]$/.test(displayName.value)) {
      showError('product_display_name', 'Only A-Z, 0-9, -, _ and single spaces allowed');
      isValid = false;
    } else if (/\s{3,}/.test(displayName.value)) {
      showError('product_display_name', 'Maximum 2 consecutive spaces allowed');
      isValid = false;
    }

    // Validate Price
    const price = document.getElementById('price');
    if (!price.value.trim()) {
      showError('price', 'This field is required');
      isValid = false;
    } else if (!/^\d+(\.\d{1,2})?$/.test(price.value)) {
      showError('price', 'Only numbers (0-9) allowed');
      isValid = false;
    } else if (parseFloat(price.value) < 300 || parseFloat(price.value) > 300000) {
      showError('price', 'Must be between ₱300 and ₱300,000');
      isValid = false;
    }

    // Validate Category
    const category = document.getElementById('category');
    if (!category.value) {
      showError('category', 'This field is required');
      isValid = false;
    }

    // Validate Manufacturer
    const manufacturer = document.getElementById('manufacturer');
    if (!manufacturer.value.trim()) {
      showError('manufacturer', 'This field is required');
      isValid = false;
    }

    // Validate Form Factor (only if visible)
    const formFactor = document.getElementById('Form_factor');
    if (formFactor && formFactor.closest('.input-field').style.display !== 'none') {
      if (!formFactor.value || formFactor.value === 'Not_Applicable') {
        showError('Form_factor', 'Please select a valid Form Factor');
        isValid = false;
      }
    }

    // Validate Socket Type (only if visible)
    const socketType = document.getElementById('Socket_type');
    if (socketType && socketType.closest('.input-field').style.display !== 'none') {
      if (!socketType.value || socketType.value === 'Not_Applicable') {
        showError('Socket_type', 'Please select a valid Socket Type');
        isValid = false;
      }
    }

    // Validate RAM Socket Type (only if visible)
    const ramSocketType = document.getElementById('Ram_socket_type');
    if (ramSocketType && ramSocketType.closest('.input-field').style.display !== 'none') {
      if (!ramSocketType.value || ramSocketType.value === 'Not_Applicable') {
        showError('Ram_socket_type', 'Please select a valid RAM Socket Type');
        isValid = false;
      }
    }

    // Validate Product Specifications
    const specs = document.getElementById('product_specifications');
    if (!specs.value.trim()) {
      showError('product_specifications', 'This field is required');
      isValid = false;
    }

    // Validate Product Description
    const description = document.getElementById('product_description');
    if (!description.value.trim()) {
      showError('product_description', 'This field is required');
      isValid = false;
    }

    // Validate UID
    const uid = document.getElementById('UID');
    if (!uid.value.trim()) {
      showError('UID', 'This field is required');
      isValid = false;
    } else if (!/^\d+$/.test(uid.value)) {
      showError('UID', 'Only numbers (0-9) allowed');
      isValid = false;
    } else if (uid.value.length < 6 || uid.value.length > 15) {
      showError('UID', 'Must be 6-15 numbers');
      isValid = false;
    }

    // Validate Quantity
    const quantity = document.getElementById('quantity');
    if (!quantity.value.trim()) {
      showError('quantity', 'This field is required');
      isValid = false;
    } else if (!/^\d+$/.test(quantity.value)) {
      showError('quantity', 'Only numbers (0-9) allowed');
      isValid = false;
    } else if (parseInt(quantity.value) < 10 || parseInt(quantity.value) > 100) {
      showError('quantity', 'Must be 10-100 pieces only');
      isValid = false;
    }

    // Validate Warranty Duration
    const warranty = document.getElementById('warranty_duration');
    if (!warranty.value) {
      showError('Warrantyduration', 'This field is required');
      isValid = false;
    }

    // Validate Image
    const image = document.getElementById('immage');
    if (!image.value) {
      showError('immage', 'This field is required');
      isValid = false;
    } else {
      const validExtensions = ['.png', '.jpg', '.jpeg'];
      const fileExtension = image.value.substring(image.value.lastIndexOf('.')).toLowerCase();
      if (!validExtensions.includes(fileExtension)) {
        showError('immage', 'Only .png, .jpg, or .jpeg files allowed');
        isValid = false;
      }

      if (image.files[0] && image.files[0].size > 5 * 1024 * 1024) {
        showError('immage', 'File size exceeds 5MB limit');
        isValid = false;
      }
    }

    return isValid;
  }

  // === HELPER FUNCTIONS ===
  function showError(fieldId, message) {
    const errorElement = document.getElementById(`${fieldId}-error`);
    if (errorElement) {
      errorElement.textContent = message;
      errorElement.style.display = 'block';
      const input = document.getElementById(fieldId);
      if (input) input.classList.add('is-invalid');
    }
  }

  function clearAllErrors() {
    document.querySelectorAll('.error-message').forEach(el => {
      el.textContent = '';
      el.style.display = 'none';
    });
    document.querySelectorAll('.is-invalid').forEach(el => {
      el.classList.remove('is-invalid');
    });
  }

  function showSuccessModal() {
    const modal = document.getElementById('popupModal');
    if (modal) {
      modal.style.display = 'block';
      document.getElementById('modalMessage').textContent = 'Product saved successfully!';
    }
  }

  // === REAL-TIME VALIDATION FOR NUMBER FIELDS ===
  document.getElementById('price')?.addEventListener('input', function() {
    this.value = this.value.replace(/[^\d.]/g, '');
  });

  document.getElementById('UID')?.addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, '');
  });

  document.getElementById('quantity')?.addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, '');
  });
}

// === FORM CLEARING FUNCTION ===
function clearProductForm() {
  const form = document.getElementById('productForm');
  if (form) {
    form.reset();
    
    // Reset dynamic fields to default state
    const categorySelect = document.getElementById('category');
    if (categorySelect) {
      categorySelect.value = '';
      const event = new Event('change');
      categorySelect.dispatchEvent(event);
    }
    
    // Clear image preview
    const preview = document.getElementById('preview');
    if (preview) {
      preview.src = '';
      preview.style.display = 'none';
    }
    
    // Clear file input
    const imageInput = document.getElementById('immage');
    if (imageInput) {
      imageInput.value = '';
    }
    
    // Remove validation error styling
    clearAllErrors();
  }
}

// === DATA INSERTION FUNCTION ===
function insertData() {
  const form = document.getElementById('productForm');
  const formData = new FormData(form);

  fetch("/phpscripts/0.0.16_REVISIONS/InsertNewProduct/InsertNewProduct.php", {
    method: "POST",
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    const modal = document.getElementById('popupModal');
    const message = document.getElementById('modalMessage');

    if (data.success) {
      message.textContent = data.message || 'Product saved successfully!';
      showSuccessModal();
      clearProductForm();
    } else {
      // Handle specific field errors from server
      if (data.errors) {
        Object.entries(data.errors).forEach(([field, error]) => {
          showError(field, error);
        });
      }
      message.textContent = data.message || 'Failed to save product.';
      modal.style.display = 'block';
    }
  })
}