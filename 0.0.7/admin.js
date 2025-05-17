
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
  document.getElementById('option3Content').style.display = 'none';

  // Show the selected one
  if (option === 'Products') {
    document.getElementById('AddProductForms').style.display = 'block';
    document.getElementById('WelcomePageText').style.display = 'none';
  } else if (option === 'Edit_Product_Information') {
    document.getElementById('EditProduct').style.display = 'block';
     document.getElementById('WelcomePageText').style.display = 'none';
  } else if (option === 'option3') {
    document.getElementById('option3Content').style.display = 'block';
  }
}


function showPrompt_newproduct() {
  document.getElementById("customPrompt").style.display = "flex";
}

function closePrompt() {
  document.getElementById("customPrompt").style.display = "none";
}

 /*Animation ng mga button under inventory*/
function animateClick(element) {
  element.classList.add('clicked-animate');

  // Remove the class after animation so it can be reapplied on next click
  setTimeout(() => {
    element.classList.remove('clicked-animate');
  }, 400); // match the animation duration
}


