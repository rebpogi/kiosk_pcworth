/**
 * Account Form Handler with Modal Support - Dynamic Loading Compatible
 */
function initializeAccountInfoHandlers() {
  // DOM Elements
  const accountForm = document.getElementById('accountForm');
  const editAccountForm = document.getElementById('editAccountForm');
  const editInfoBtn = document.getElementById('editInfoBtn');
  
  // If elements don't exist yet, skip initialization
  if (!accountForm || !editAccountForm || !editInfoBtn) {
    console.log('Account form elements not found, skipping initialization');
    return;
  }

  // Password fields
  const togglePassword = document.getElementById('togglePassword');
  const toggleNewPassword = document.getElementById('toggleNewPassword');
  const passwordField = document.getElementById('password');
  const newPasswordField = document.getElementById('newPassword');
  
  // Error messages
  const usernameError = document.getElementById('usernameError');
  const passwordError = document.getElementById('passwordError');
  const confirmPasswordError = document.getElementById('confirmPasswordError');

  /**
   * Initialize all event listeners
   */
  function initEventListeners() {
    // Show edit form when Edit Info button is clicked
    editInfoBtn.addEventListener('click', showEditForm);
    
    // Toggle password visibility
    if (togglePassword) {
      togglePassword.addEventListener('click', () => togglePasswordVisibility(passwordField, togglePassword));
    }
    
    if (toggleNewPassword) {
      toggleNewPassword.addEventListener('click', () => togglePasswordVisibility(newPasswordField, toggleNewPassword));
    }
    
    // Handle form submission
    editAccountForm.addEventListener('submit', handleFormSubmission);
  }

  /**
   * Toggle password field visibility
   */
  function togglePasswordVisibility(field, button) {
    if (field.type === 'password') {
      field.type = 'text';
      button.textContent = 'Hide';
    } else {
      field.type = 'password';
      button.textContent = 'Show';
    }
  }

  /**
   * Show the edit form section
   */
  function showEditForm() {
    const editFormSeparator = document.getElementById('editFormSeparator');
    const editFormTitle = document.getElementById('editFormTitle');
    
    if (editFormSeparator) editFormSeparator.style.display = 'block';
    if (editFormTitle) editFormTitle.style.display = 'block';
    editAccountForm.style.display = 'block';
    
    // Scroll to the edit form
    editAccountForm.scrollIntoView({ behavior: 'smooth' });
  }

  /**
   * Validate form inputs
   */
  function validateForm() {
    const username = document.getElementById('newUsername').value.trim();
    const password = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    let isValid = true;
    
    // Reset error messages
    if (usernameError) usernameError.style.display = 'none';
    if (passwordError) passwordError.style.display = 'none';
    if (confirmPasswordError) confirmPasswordError.style.display = 'none';
    
    // Validate username
    if (username.length < 7) {
      if (usernameError) {
        usernameError.textContent = 'Username must be at least 7 characters long';
        usernameError.style.display = 'block';
      }
      isValid = false;
    }
    
    // Validate password
    if (password.length < 7) {
      if (passwordError) {
        passwordError.textContent = 'Password must be at least 7 characters long';
        passwordError.style.display = 'block';
      }
      isValid = false;
    }
    
    // Validate password confirmation
    if (password !== confirmPassword) {
      if (confirmPasswordError) {
        confirmPasswordError.textContent = 'Passwords do not match';
        confirmPasswordError.style.display = 'block';
      }
      isValid = false;
    }
    
    return isValid;
  }

  /**
   * Handle form submission
   */
  function handleFormSubmission(e) {
    e.preventDefault();
    
    if (!validateForm()) {
      return;
    }
    
    // Get form data
    const formData = new FormData(editAccountForm);
    
    // Show loading state
    const submitBtn = editAccountForm.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.textContent;
    submitBtn.textContent = 'Updating...';
    submitBtn.disabled = true;
    
    // Submit to PHP endpoint
    fetch('AccountsManagement/update_account.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        Swal.fire({
          title: 'Success!',
          text: 'Account updated successfully!',
          icon: 'success',
          confirmButtonText: 'OK'
        });
        
        // Update the displayed username
        document.getElementById('username').value = document.getElementById('newUsername').value.trim();
        
        // Hide edit form
        const editFormSeparator = document.getElementById('editFormSeparator');
        const editFormTitle = document.getElementById('editFormTitle');
        
        if (editFormSeparator) editFormSeparator.style.display = 'none';
        if (editFormTitle) editFormTitle.style.display = 'none';
        editAccountForm.style.display = 'none';
      } else {
        Swal.fire({
          title: 'Error!',
          text: data.message || 'Update failed',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }
    })
    .catch(error => {
      Swal.fire({
        title: 'Network Error!',
        text: error.message,
        icon: 'error',
        confirmButtonText: 'OK'
      });
    })
    .finally(() => {
      submitBtn.textContent = originalBtnText;
      submitBtn.disabled = false;
    });
  }

  // Initialize the form handler
  initEventListeners();
}