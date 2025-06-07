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
  if (qty < 1) {
    alert("Please select at least 1 item.");
    return false;
  }
  return true;
}

// Go back to previous page
function goBack() {
  history.back();
}

// Simulate add to cart logic
function addToCart() {
  const qty = parseInt(document.getElementById('qty').value);

  if (isNaN(qty) || qty <= 0) {
    alert("Please select at least 1 item.");
    return;
  }

  if (typeof maxStock !== 'undefined' && qty > maxStock) {
    alert(`Only ${maxStock} item(s) available in stock.`);
    return;
  }

  alert(`Added ${qty} item(s) to cart.`);
  // TODO: Add API or server-side logic to update cart
}