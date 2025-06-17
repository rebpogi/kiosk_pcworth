function initializeCreateAccountForm() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        let valid = true;

        // Clear existing errors
        document.querySelectorAll('.error').forEach(el => el.textContent = '');

        // Firstname validation
        const firstname = document.getElementById('firstname').value.trim();
        if (firstname === '') {
            document.getElementById('firstnameError').textContent = 'First name is required.';
            valid = false;
        }

        // Lastname validation
        const lastname = document.getElementById('lastname').value.trim();
        if (lastname === '') {
            document.getElementById('lastnameError').textContent = 'Last name is required.';
            valid = false;
        }

        // Username validation
        const username = document.getElementById('username').value.trim();
        if (username === '') {
            document.getElementById('usernameError').textContent = 'Username is required.';
            valid = false;
        }

        // Password validation
        const password = document.getElementById('password').value.trim();
        if (password.length < 6) {
            document.getElementById('passwordError').textContent = 'Password must be at least 6 characters.';
            valid = false;
        }

        // Role validation
        const role = document.getElementById('role').value;
        if (role === '') {
            alert('Please select a role.');
            valid = false;
        }

        if (!valid) {
            event.preventDefault(); // Prevent form submission if invalid
        }
    });
}

function validateCreateAccountForm() {
    let valid = true;

    // Clear existing errors
    document.querySelectorAll('.error').forEach(el => el.textContent = '');

    // Firstname validation
    const firstname = document.getElementById('firstname').value.trim();
    if (firstname === '') {
        document.getElementById('firstnameError').textContent = 'First name is required.';
        valid = false;
    }

    // Lastname validation
    const lastname = document.getElementById('lastname').value.trim();
    if (lastname === '') {
        document.getElementById('lastnameError').textContent = 'Last name is required.';
        valid = false;
    }

    // Username validation
    const username = document.getElementById('username').value.trim();
    if (username === '') {
        document.getElementById('usernameError').textContent = 'Username is required.';
        valid = false;
    }

    // Password validation
    const password = document.getElementById('password').value.trim();
    if (password.length < 6) {
        document.getElementById('passwordError').textContent = 'Password must be at least 6 characters.';
        valid = false;
    }

    // Role validation
    const role = document.getElementById('role').value;
    if (role === '') {
        alert('Please select a role.');
        valid = false;
    }

    return valid;
}

(function() {
  const form = document.getElementById('createAccountForm');
  if (!form) return;

  form.addEventListener('submit', function(event) {
    event.preventDefault();

    if (!validateCreateAccountForm()) {
      return;
    }

    const formData = new FormData(form);

    fetch('CreateNewAccount/SuperAdminCreateAccounts.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      // Clear previous errors
      document.querySelectorAll('.error').forEach(el => el.textContent = '');

      if (data.success) {
        showAccountModal('Account created successfully!');
        form.reset();
      } else if (data.field === 'username') {
        document.getElementById('usernameError').textContent = data.error;
      } else if (data.field === 'password') {
        document.getElementById('passwordError').textContent = data.error;
      } else if (data.error) {
        showAccountModal(data.error, 'Error');
      }
    })
    .catch(error => {
      showAccountModal('There was an error creating the account.', 'Error');
    });
  });

  // Modal close logic
  const closeBtn = document.getElementById('closeAccountModal');
  if (closeBtn) {
    closeBtn.onclick = hideAccountModal;
  }
  const okBtn = document.getElementById('modalOkBtn');
  if (okBtn) {
    okBtn.onclick = hideAccountModal;
  }
  // Hide modal when clicking outside modal-box
  const modal = document.getElementById('accountModal');
  if (modal) {
    modal.onclick = function(event) {
      if (event.target === modal) {
        hideAccountModal();
      }
    };
  }
})();

function showAccountModal(message) {
  document.getElementById('accountModalTitle').textContent = 'Success';
  document.getElementById('accountModalMessage').textContent = message;
  document.getElementById('accountModal').style.display = 'flex';
}

function hideAccountModal() {
  document.getElementById('accountModal').style.display = 'none';
}
