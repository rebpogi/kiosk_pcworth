/**
 * Enhanced Product Update Form Handler
 * - Validation
 * - Dynamic field handling
 * - AJAX submission
 * - Modal feedback
 */
function initUpdateProductFormValidation() {
  console.log("Initializing product update form validation");

  const form = document.getElementById('UpdateProductForm');
  if (!form) return;

  // Initialize dynamic fields
  setupDynamicFields();

  // Image preview handler
  initImagePreview();

  // Form submission handler
  form.addEventListener('submit', handleFormSubmit);

  // Helper Functions
  function showError(fieldId, message) {
    const errorElement = document.getElementById(`${fieldId}-error`);
    if (errorElement) {
      errorElement.textContent = message;
      errorElement.style.display = 'block';
      document.getElementById(fieldId)?.classList.add('is-invalid');
    }
  }

  function clearError(fieldId) {
    const errorElement = document.getElementById(`${fieldId}-error`);
    if (errorElement) {
      errorElement.textContent = '';
      errorElement.style.display = 'none';
      document.getElementById(fieldId)?.classList.remove('is-invalid');
    }
  }

  function scrollToFirstError() {
    const firstError = form.querySelector('.is-invalid');
    if (firstError) {
      firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
  }

  async function validateForm() {
    let isValid = true;
    const productId = form.querySelector('[name="ID"]')?.value || 0;

    // Required field validation
    const requiredFields = {
      'product_display_name': 'Product name',
      'price': 'Price',
      'category': 'Category',
      'manufacturer': 'Manufacturer',
      'product_specifications': 'Specifications',
      'product_description': 'Description',
      'warranty_duration': 'Warranty',
      'UID': 'UID',
      'quantity': 'Quantity'
    };

    for (const [field, name] of Object.entries(requiredFields)) {
      if (!form.elements[field]?.value.trim()) {
        showError(field, `${name} is required`);
        isValid = false;
      }
    }

    // Special validations
    if (form.elements.price?.value) {
      const price = parseFloat(form.elements.price.value);
      if (isNaN(price) || price < 300 || price > 300000) {
        showError('price', 'Must be between ₱300 and ₱300,000');
        isValid = false;
      }
    }

    if (form.elements.UID?.value) {
      if (!/^\d{6,15}$/.test(form.elements.UID.value)) {
        showError('UID', 'Must be 6-15 digits');
        isValid = false;
      }
    }

    if (form.elements.quantity?.value) {
      const qty = parseInt(form.elements.quantity.value);
      if (isNaN(qty) || qty < 10 || qty > 100) {
        showError('quantity', 'Must be 10-100 units');
        isValid = false;
      }
    }

    // Image validation (only if new file selected)
    if (form.elements.immage?.files[0]) {
      const file = form.elements.immage.files[0];
      if (!['image/jpeg', 'image/png'].includes(file.type)) {
        showError('immage', 'Only JPEG/PNG images allowed');
        isValid = false;
      }
      if (file.size > 20 * 1024 * 1024) {
        showError('immage', 'Max file size is 5MB');
        isValid = false;
      }
    }

    return isValid;
  }

  async function handleFormSubmit(event) {
    event.preventDefault();
    
    if (!await validateForm()) {
      scrollToFirstError();
      return;
    }

    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    
    try {
      // Show loading state
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Updating...';

      const formData = new FormData(form);
      const response = await fetch(form.action, {
        method: 'POST',
        body: formData
      });

      const result = await response.json();
      
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalBtnText;

      if (result.success) {
        showSuccessModal();
        updateFormFields(result.product);
        clearAllErrors();
      } else {
        handleErrors(result);
      }
    } catch (error) {
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalBtnText;
      showError('form', 'Network error. Please try again.');
      console.error('Update error:', error);
    }
  }

  function showSuccessModal() {
    const modal = document.getElementById('popupModal');
    if (modal) {
      modal.style.display = 'block';
      document.getElementById('modalMessage').textContent = 'Product UPDATED successfully!';
    }
  }

  function updateFormFields(product) {
    // Update form fields with new data if needed
    if (product.image_url) {
      const preview = document.getElementById('imagePreview');
      if (preview) {
        preview.src = product.image_url;
      }
    }
  }

  function handleErrors(result) {
    if (result.errors) {
      for (const [field, message] of Object.entries(result.errors)) {
        showError(field, message);
      }
    } else {
      showError('form', result.message || 'Update failed');
    }
    scrollToFirstError();
  }

  function setupDynamicFields() {
    const categorySelect = form.elements.category;
    if (!categorySelect) return;

    const toggleField = (field, show) => {
      const container = field.closest('.input-field') || field.closest('.form-group');
      if (container) {
        container.style.display = show ? 'block' : 'none';
        field.required = show;
        if (!show) field.value = 'Not_Applicable';
      }
    };

    const updateVisibility = () => {
      const category = categorySelect.value;
      const formFactor = form.elements.Form_factor;
      const socketType = form.elements.Socket_type;
      const ramSocket = form.elements.Ram_socket_type;

      toggleField(formFactor, category === 'Mobo');
      toggleField(socketType, ['Mobo', 'CPU'].includes(category));
      toggleField(ramSocket, ['Mobo', 'RAM'].includes(category));
    };

    categorySelect.addEventListener('change', updateVisibility);
    updateVisibility(); // Initialize
  }

  function initImagePreview() {
    const imageInput = form.elements.immage;
    const preview = document.getElementById('preview');
    
    if (imageInput && preview) {
      imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file && file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = (e) => {
            preview.src = e.target.result;
            preview.style.display = 'block';
          };
          reader.readAsDataURL(file);
        } else {
          preview.style.display = 'none';
        }
      });
    }
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

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
  initUpdateProductFormValidation();
  
  // Back button functionality
  const backButton = document.querySelector('button[onclick="goBack()"]');
  if (backButton) {
    backButton.addEventListener('click', function() {
      window.history.back();
    });
  }
});

// Make function available globally
window.initUpdateProductFormValidation = initUpdateProductFormValidation;