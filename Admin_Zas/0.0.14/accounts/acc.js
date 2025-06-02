
    // Toggle the Dropdown-content visibility
    // If cliked lalabas mga drop down ni product
      function toggleDropdown() {
      const dropdown = document.getElementById("Inventory_Dropdown");
      dropdown.classList.toggle("show");
    }



  function toggleDropdown(button) {
   const dropdown = document.getElementById("Inventory_Dropdown");

  // Hide any other dropdowns and remove 'active' from other buttons
  document.querySelectorAll('.Dropdown-content').forEach(menu => {
    if (menu !== dropdown) menu.classList.remove('show');
  });

  document.querySelectorAll('.Dropdown-Btn').forEach(btn => {
    if (btn !== button) btn.classList.remove('active');
  });

  // Toggle dropdown and button highlight
  dropdown.classList.toggle("show");
  button.classList.toggle("active");
}

  // Function to display forms dynamically when an option is clicked
      function showForms(option) {
  document.getElementById('WelcomePageText').style.display = 'block';
     // Hide all by default
  document.getElementById('AddProductForms').style.display = 'none';
  document.getElementById('EditProduct').style.display = 'none';
  document.getElementById('ManageAccount').style.display = 'none';
  document.getElementById('CreateAccount').style.display = 'none';
  document.getElementById('Accounts').style.display = 'none';

  // Show the selected one
  if (option === 'Products') {
    document.getElementById('AddProductForms').style.display = 'block';
    document.getElementById('WelcomePageText').style.display = 'none';
  } else if (option === 'Edit_Product_Information') {
    document.getElementById('EditProduct').style.display = 'block';
    document.getElementById('WelcomePageText').style.display = 'none';
  } else if (option === 'Manage_Account') {
    document.getElementById('ManageAccount').style.display = 'block';
    document.getElementById('WelcomePageText').style.display = 'none';
  } else if (option === 'AccountCreation') {
    document.getElementById('CreateAccount').style.display = 'block';
    document.getElementById('WelcomePageText').style.display = 'none';
  } else if (option === 'ViewAccounts') {
    document.getElementById('Accounts').style.display = 'block';
    document.getElementById('WelcomePageText').style.display = 'none';
  }
}


function showPrompt_newproduct() {
  document.getElementById("customPrompt").style.display = "flex";
}

function closePrompt() {
  document.getElementById("customPrompt").style.display = "none";
}

function showPrompt_save_details() {
  document.getElementById("New_Details_Prompt").style.display = "flex";
}

function close_Details_Prompt() {
  document.getElementById("New_Details_Prompt").style.display = "none";
}

 /*Animation ng mga button under inventory*/
function animateClick(element) {
  element.classList.add('clicked-animate');

  // Remove the class after animation so it can be reapplied on next click
  setTimeout(() => {
    element.classList.remove('clicked-animate');
  }, 400); // match the animation duration
}

document.addEventListener("DOMContentLoaded", function () {
  let eyeicon = document.getElementById("eyeicon");
  let password = document.getElementById("password");

  eyeicon.onclick = function () {
    if (password.type === "password") {
      password.type = "text";
      eyeicon.src = "open_eye.png";
    } else {
      password.type = "password";
      eyeicon.src = "close_eye.png";
    }
  };
});

document.addEventListener('DOMContentLoaded', function () {
  const editPen = document.getElementById('editpen');
  const passwordInput = document.getElementById('password');

  if (editPen && passwordInput) {
    editPen.addEventListener('click', function () {
      const isReadOnly = passwordInput.hasAttribute('readonly');

      if (isReadOnly) {
        passwordInput.removeAttribute('readonly');
        passwordInput.focus();
      } else {
        passwordInput.setAttribute('readonly', true);
      }
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  window.showEditRow = function(id) {
    document.getElementById('view-row-' + id).style.display = 'none';
    document.getElementById('edit-row-' + id).style.display = 'table-row';
  };

  window.hideEditRow = function(id) {
    document.getElementById('edit-row-' + id).style.display = 'none';
    document.getElementById('view-row-' + id).style.display = 'table-row';
  };
});




