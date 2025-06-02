function toggleDropdown(button) {
  // Find the matching dropdown based on button class
  const isInventory = button.classList.contains("Dropdown-Btn");
  const isAccount = button.classList.contains("Account-Btn");

  const dropdownId = isInventory ? "Inventory_Dropdown" : isAccount ? "Account_Dropdown" : null;
  const dropdown = document.getElementById(dropdownId);

  const contentClass = isInventory ? "Dropdown-content" : "Account-content";
  const buttonClass = isInventory ? "Dropdown-Btn" : "Account-Btn";

  // Hide other dropdowns and deactivate other buttons
  document.querySelectorAll("." + contentClass).forEach(menu => {
    if (menu !== dropdown) menu.classList.remove("show");
  });

  document.querySelectorAll("." + buttonClass).forEach(btn => {
    if (btn !== button) btn.classList.remove("active");
  });

  // Toggle selected dropdown
  dropdown.classList.toggle("show");
  button.classList.toggle("active");
}




      // Helper function to show elements safely
        function showElement(id) {
          const el = document.getElementById(id);
          if (el) el.style.display = 'block';
        }

      function showForms(option) {
        // Hide all sections first
        const sections = ['WelcomePageText', 'AddProductForms', 'EditProduct', 'Prebuilds', 'form-wrapper', 'UpdateformsContainer', 'result', 'edit-title-container'];
        sections.forEach(id => {
          const el = document.getElementById(id);
          if (el) el.style.display = 'none';
        });

        // Show only the selected section and its children
        switch (option) {
          case 'Products':
            showElement('AddProductForms');
            break;

           case 'Edit_Product_Information':
            showElement('EditProduct');
            showElement('edit-title-container');
            showElement('search');
            showElement('search-btn');
            break;

          case 'Prebuilds_section':
            showElement('Prebuilds');
            break;

          default:
            showElement('WelcomePageText'); // Fallback view
        }
      }

          function goBack() {
        // Hide the update form
        document.getElementById('form-wrapper').style.display = 'none';

        // Show the search results
        document.getElementById('result').style.display = 'block';

        // Show the title and search UI again
        document.getElementById('edit-title-container').style.display = 'block';
        document.getElementById('search').style.display = 'inline-block';
        document.getElementById('search-btn').style.display = 'inline-block';

        // Scroll back to top of EditProduct section
        const editProductSection = document.getElementById('EditProduct');
        if (editProductSection) {
          editProductSection.scrollIntoView({ behavior: 'smooth' });
        }
      }


// PROMPT MODAL CONTROL
function showPrompt_newproduct() {
  document.getElementById("customPrompt").style.display = "flex";
}

function closePrompt() {
  document.getElementById("customPrompt").style.display = "none";
}

// ANIMATION FOR CLICKED BUTTONS
function animateClick(element) {
  element.classList.add('clicked-animate');
  setTimeout(() => element.classList.remove('clicked-animate'), 400);
}

// SEARCH BAR FUNCTIONALITY (Live search with AJAX)
$(document).ready(function () {
  let debounceTimer;

  $('#search').on('keyup', function () {
    clearTimeout(debounceTimer);

    const query = $(this).val().trim();

    if (query === '') {
      // If input is empty, clear results and stop
      $('#result').html('').hide();
      return; // no AJAX request sent here
    }

    debounceTimer = setTimeout(() => {
      $.ajax({
        url: 'search.php',
        method: 'POST',
        data: { query: query },
        success: function (data) {
          $('#result').html(data).show();
        },
        error: function () {
          $('#result').html('<p>Error fetching results</p>').show();
        }
      });
    }, 300); // wait 300ms after user stops typing before sending request
  });
});




// SEARCH BUTTON CLICK HANDLER 
document.addEventListener("DOMContentLoaded", () => {
  const searchBtn = document.getElementById('search-btn');
  const searchInput = document.getElementById('search');
  if (searchBtn && searchInput) {
    searchBtn.addEventListener('click', () => {
      const query = searchInput.value.trim();
      if (query !== "") {
        fetch('search.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: 'query=' + encodeURIComponent(query)
        })
          .then(res => res.text())
          .then(html => {
            document.getElementById('result').innerHTML = html;
            document.getElementById('result').style.display = 'block';
            document.getElementById('form-wrapper').style.display = 'none';
          })
          .catch(err => alert('Search error: ' + err));
      }
    });
  }
});

// MAIN AJAX FUNCTION TO LOAD UPDATE FORM
function loadUpdateForm(productId) {
  fetch('update_product_forms.php?id=' + productId)
    .then(response => {
      if (!response.ok) throw new Error('Network error while loading the form.');
      return response.text();
    })
    .then(html => {
      // Hide the search result area
      document.getElementById('result').style.display = 'none';

      // ✅ Hide the search bar and search button
      const searchInput = document.getElementById('search');
      const searchBtn = document.getElementById('search-btn');
      if (searchInput) searchInput.style.display = 'none';
      if (searchBtn) searchBtn.style.display = 'none';

      // ✅ Hide the heading above the search bar
      const title = document.getElementById('edit-title-container');
      if (title) title.style.display = 'none';

      // Show and fill the update form
      const formWrapper = document.getElementById('form-wrapper');
      formWrapper.innerHTML = html;
      formWrapper.style.display = 'block';
      formWrapper.scrollIntoView({ behavior: "smooth" });

      // Attach image preview listener
      attachImagePreviewListener();
    })
    .catch(error => alert('Error loading product form: ' + error.message));
}





// HANDLE FORM SUBMISSION (for update form)
function handleFormSubmit(e) {
  const form = e.target;
  if (form && form.id === "Update_product_form") {
    const submitter = e.submitter;
    if (!submitter || submitter.name !== "submit_update") return;

    e.preventDefault();
    e.stopImmediatePropagation();

    const formData = new FormData(form);
    submitter.disabled = true;

    fetch("update_product.php", {
      method: "POST",
      body: formData
    })
      .then(response => response.text())
      .then(result => {
        alert("Product updated successfully!");

        // Clear and hide the update form
        document.getElementById('form-wrapper').innerHTML = "";
        document.getElementById('form-wrapper').style.display = "none";

        // Show the search result area
        document.getElementById('result').style.display = "block";

        // Show the search bar and search button again
        const searchInput = document.getElementById('search');
        const searchBtn = document.getElementById('search-btn');
        if (searchInput) searchInput.style.display = 'inline-block';
        if (searchBtn) searchBtn.style.display = 'inline-block';

        // Show the title above the search bar
        const title = document.getElementById('edit-title-container');
        if (title) title.style.display = 'block';
      })
      .catch(error => alert("Update failed: " + error.message))
      .finally(() => submitter.disabled = false);
  }
}


// // ATTACH UPDATE FORM SUBMISSION
// document.addEventListener("submit", handleFormSubmit, { once: true });
document.body.addEventListener("submit", function (e) {
  if (e.target.id === "Update_product_form") {
    handleFormSubmit(e);
  }
});


// NEW PRODUCT FORM SUBMIT WITH MODAL
document.getElementById('productForm').addEventListener('submit', async function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  try {
    const response = await fetch('test_insert.php', {
      method: 'POST',
      body: formData
    });

    const result = await response.text();
    document.getElementById('modalMessage').textContent = result;
    document.getElementById('popupModal').style.display = 'block';

    // Close modal
    document.getElementById('closeModal').addEventListener('click', function () {
      document.getElementById('popupModal').style.display = 'none';
    });

    // Reset on success
    if (result.toLowerCase().includes('success')) {
      this.reset();
      document.getElementById('imagePreview').src = '';
    }
  } catch (error) {
    document.getElementById('modalMessage').textContent = 'Something went wrong!';
    document.getElementById('popupModal').style.display = 'block';
  }
});


// IMAGE PREVIEW FOR NEW PRODUCT
document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('immage').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const preview = document.getElementById('imagePreview');
        preview.src = e.target.result;
        preview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    }
  });
});

// ✅ FUNCTION TO ATTACH IMAGE PREVIEW FOR UPDATE IMAGE 
function attachImagePreviewListener() {
  const newImageInput = document.getElementById('new_immage');
  const previewImage = document.getElementById('UpdateimagePreview');

  if (newImageInput && previewImage) {
    newImageInput.addEventListener('change', function (event) {
      const file = event.target.files[0];
      if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function (e) {
          previewImage.src = e.target.result;
          previewImage.style.display = 'block';
        };
        reader.readAsDataURL(file);
      }
    });
  }
}



// BUNDLES
function LoadBundlePartSelector() {
  document.getElementById('BundlePartSelectorContainer').style.display = 'block';
  document.getElementById('bundleForm').style.display = 'none';  // hide form when selector is open
  fetch('Bundles_search_select.php')
    .then(response => response.text())
    .then(html => {
      document.getElementById('BundlePartSelectorContainer').innerHTML = html;
    })
    .catch(error => {
      document.getElementById('BundlePartSelectorContainer').innerHTML = '<p style="color:red;">Failed to load selector.</p>';
      console.error(error);
    });
}

//Bundles
