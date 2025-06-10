function updateQty(change) {
  const qtyInput = document.getElementById('qty');
  const formQty = document.getElementById('form_qty');
  const maxQty = parseInt(qtyInput.getAttribute('data-max')) || 99;

  let currentQty = parseInt(qtyInput.value);
  let newQty = Math.max(1, Math.min(currentQty + change, maxQty));
  qtyInput.value = newQty;
  if (formQty) formQty.value = newQty;
}

function validateQty() {
  const qty = parseInt(document.getElementById('qty').value);
  return qty >= 1;
}

function goBack() {
  history.back();
}

// Handles form submission via AJAX
document.addEventListener("DOMContentLoaded", () => {
  const addToCartForm = document.getElementById("addToCartForm");

  if (addToCartForm) {
    addToCartForm.addEventListener("submit", function (e) {
      e.preventDefault();

      const form = e.target;
      const formData = new FormData(form);
      const qty = parseInt(formData.get("quantity"));

      if (isNaN(qty) || qty <= 0) {
        alert("Please select at least 1 item.");
        return;
      }

      fetch("addtocart.php", {
        method: "POST",
        body: formData,
        headers: {
          "X-Requested-With": "XMLHttpRequest"
        }
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            showModal();
          } else {
            alert(data.message || "An error occurred.");
          }
        })
        .catch(() => {
          alert("An error occurred while adding to cart.");
        });
    });
  }
});

function showModal() {
  const modal = document.getElementById("addedModal");
  if (!modal) return;

  modal.classList.remove("hidden");

  // Auto-close after 2.5 seconds
  setTimeout(() => {
    modal.classList.add("hidden");
  }, 2500);
}
