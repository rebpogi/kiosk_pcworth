<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PC Worth Admin Dashboard</title>
  <link rel="stylesheet" href="InsertNewProduct/NewProductForm.css">

  <!-- <link rel="stylesheet" href="admin.css"> -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="UpdateProducts/Update_Table.js"></script>
  <script src="UpdateProducts/productFormValidationTest.js"></script>
  <script src="AccountsManagement/account.js"></script>
  <style>
    /* --- Your existing styles --- */
    body, html { margin: 0; padding: 0; height: 100%; font-family: Arial, sans-serif; }

    .navbar {
      position: fixed;
      top: 0; left: 0; right: 0;
      height: 48px;
      background: #0C304A; color: white;
      display: flex; align-items: center;
      padding: 0 1rem;
      font-size: 20px;
      z-index: 1050;
      box-shadow: 0 2px 4px rgba(0,0,0,0.15);
    }

    .sidebar {
      position: fixed;
      top: 48px; bottom: 0; left: 0;
      width: 250px;
      background-color: #074a7f;
      color: white;
      overflow-y: auto;
      padding-top: 1rem;
      box-shadow: inset -1px 0 0 rgba(0, 0, 0, .2);
      z-index: 1000;
    }

    .sidebar ul { list-style: none; padding: 0; margin: 0; }
    .sidebar li { margin-bottom: 0.3rem; }

    .Dropdown-Btn, .Account-Btn {
      background-color: #0a3b68;
      border: none;
      color: white;
      padding: 10px 20px;
      font-size: 18px;
      width: 100%;
      text-align: left;
      cursor: pointer;
      border-radius: 6px;
      transition: background-color 0.3s ease;
      user-select: none;
    }

    .Dropdown-Btn:hover, .Account-Btn:hover { background-color: #0d4c8a; }
    .Dropdown-Btn.active, .Account-Btn.active { background-color: #1a73e8; }

    .Dropdown-content, .Account-content {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
      background-color: #145da0;
      border-radius: 0 0 6px 6px;
      margin-top: 0.3rem;
      padding-left: 1rem;
    }

    .Dropdown-content.show, .Account-content.show {
      max-height: 300px;
      padding-top: 0.5rem;
      padding-bottom: 0.5rem;
    }

    .Dropdown-content a, .Account-content a {
      color: #cde6ff;
      padding: 8px 12px;
      display: block;
      text-decoration: none;
      border-radius: 4px;
      font-size: 16px;
      transition: background-color 0.2s;
    }

    .Dropdown-content a:hover, .Account-content a:hover {
      background-color: #1a73e8;
      color: white;
    }

    main {
      margin-left: 250px;
      margin-top: 48px;
      padding: 1rem;
      min-height: calc(100vh - 48px);
      background: #f4f7fa;
      color: #333;
    }

    .clicked-animate {
      animation: clickPulse 0.4s ease;
      border-radius: 5px;
    }

    @keyframes clickPulse {
      0% { background-color: #1a73e8; color: white; transform: scale(1); }
      50% { background-color: #145da0; transform: scale(1.05); }
      100% { background-color: #1a73e8; transform: scale(1); }
    }

    .section-content {
      display: none;
    }

    #contentContainer {
      display: none;
    }

    .active-section {
      display: block;
    }
  </style>
</head>

<body>
  <nav class="navbar">
    <span>PC WORTH ADMIN DASHBOARD</span>
  </nav>

  <nav class="sidebar" id="sidebarMenu">
    <ul>
      <li>
        <button class="Dropdown-Btn" onclick="toggleDropdown(this)">Inventory</button>
        <div class="Dropdown-content" id="Inventory_Dropdown">
          <a href="#" data-section="Products" data-file="InsertNewProduct/Forms.php">★ Products</a>
          <a href="#" data-section="Edit_Product_Information" data-file="UpdateProducts/Existing_Product_Table.php">Edit Product Information</a>
          <a href="#" data-section="Prebuilds_section">Prebuilds</a>
          <a href="#" data-section="Sales_section">Sales</a>
        </div>
      </li>
      <li>
        <button class="Account-Btn" onclick="toggleDropdown(this)">Account Manager</button>
        <div class="Account-content" id="Account_Dropdown">
          <a href="#" data-section="Manage_Account" data-file="AccountsManagement/account.php">Account setting</a>
          <a href="#" data-section="AccountCreation">AccountCreation</a>
          <a href="#" data-section="ViewAccounts" data-file="GroupAccountManagement/SuperAdmin-accounts.php">ViewAccounts</a>
        </div>
      </li>
    </ul>
  </nav>

  <main>
    <div id="contentContainer"></div>

    <div id="welcome-message">
      <h1>Welcome to PC Worth Admin Dashboard</h1>
      <p>This is the main content area.</p>
    </div>

    <!-- Dynamic Content Sections -->
    <div id="Products" class="section-content"></div>
    <div id="Edit_Product_Information" class="section-content"></div>
    <div id="Prebuilds_section" class="section-content"></div>
    <div id="Sales_section" class="section-content"></div>
    <div id="Manage_Account" class="section-content"></div>
    <div id="AccountCreation" class="section-content">WORK IN PROGRESS DITO DAPAT GAGAWA ACCOUNT USER</div>
    <div id="ViewAccounts" class="section-content"></div>
  </main>

  <script src="InsertNewProduct/productFormValidation.js"></script>
  <script src="UpdateProducts/productFormValidationTest.js"></script>
    <!-- <script src="AccountsManagement/account.js"></script> -->

  <script>
    // Global functions
    function toggleDropdown(button) {
      let dropdownId;
      if (button.classList.contains('Dropdown-Btn')) {
        dropdownId = 'Inventory_Dropdown';
      } else if (button.classList.contains('Account-Btn')) {
        dropdownId = 'Account_Dropdown';
      }

      const dropdown = document.getElementById(dropdownId);
      if (!dropdown) return;

      dropdown.classList.toggle('show');
      button.classList.toggle('active');
    }

    function animateClick(element) {
      element.classList.add('clicked-animate');
      setTimeout(() => element.classList.remove('clicked-animate'), 400);
    }

    function goBack() {
      // Hide the form container
      document.getElementById('contentContainer').style.display = 'none';
      
      // Show the product table again
      showForms('Edit_Product_Information', 'UpdateProducts/Existing_Product_Table.php');
      
      // Highlight the sidebar link
      const editLink = document.querySelector('[data-section="Edit_Product_Information"]');
      if (editLink) {
        animateClick(editLink);
      }
    }

function showForms(sectionId, fileToLoad = null) {
    // Hide all section divs and content container
    document.querySelectorAll('.section-content').forEach(div => {
        div.style.display = 'none';
    });
    document.getElementById('contentContainer').style.display = 'none';

    const target = document.getElementById(sectionId);
    if (target) {
        // Load content from file if specified
        if (fileToLoad) {
            target.innerHTML = '<p>Loading...</p>';
            target.style.display = 'block';
            fetch(fileToLoad)
                .then(res => res.text())
                .then(data => {
                    target.innerHTML = data;
                    
                    // Initialize specific functionality based on section
                     if (sectionId === 'Manage_Account' && typeof initializeAccountInfoHandlers === 'function') {
                        initializeAccountInfoHandlers();
                    }
                    if (sectionId === 'Products' && typeof initProductFormValidation === 'function') {
                        initProductFormValidation();
                    }
                })
                .catch(() => {
                    target.innerHTML = '<p style="color: red;">Failed to load content.</p>';
                });
        } else {
            target.style.display = 'block';
        }
        
        // Hide welcome message
        const welcome = document.getElementById('welcome-message');
        if (welcome) welcome.style.display = 'none';
    }
}


    // Event listeners
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('[data-section]').forEach(link => {
        link.addEventListener('click', e => {
          e.preventDefault();

          const sectionId = e.target.dataset.section;
          const file = e.target.dataset.file || null;

          animateClick(e.target);
          showForms(sectionId, file);
        });
      });
      
      // Initialize with welcome message
      document.getElementById('welcome-message').style.display = 'block';
    });
  </script>
</body>
</html>