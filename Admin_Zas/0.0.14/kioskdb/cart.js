function updateCartQty(productId, newQty) {
  if (newQty < 1) newQty = 1;

  fetch('viewcart.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({
      action: 'update_qty',
      product_id: productId,
      quantity: newQty
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.error) {
      alert(data.error);
      return;
    }

    const qtyInput = document.querySelector(`input.qty-input[data-product-id="${productId}"]`);
    qtyInput.value = data.newQty;

const subtotalElem = document.querySelector(`.subtotal[data-product-id="${productId}"]`);
if (subtotalElem) subtotalElem.innerText = `₱${data.subtotal}`;

const totalElem = document.getElementById('total');
if (totalElem) totalElem.innerText = `₱${data.total}`;
  })
  .catch(err => {
    console.error('Error updating quantity:', err);
  });
}

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.qty-btn-minus').forEach(btn => {
    btn.addEventListener('click', () => {
      const productId = btn.getAttribute('data-product-id');
      const qtyInput = document.querySelector(`input.qty-input[data-product-id="${productId}"]`);
      let currentQty = parseInt(qtyInput.value);
      if (isNaN(currentQty)) currentQty = 1;
      if (currentQty > 1) {
        updateCartQty(productId, currentQty - 1);
      }
    });
  });

document.querySelectorAll('.qty-btn-plus').forEach(btn => {
  btn.addEventListener('click', () => {
    const productId = btn.getAttribute('data-product-id');
    const qtyInput = document.querySelector(`input.qty-input[data-product-id="${productId}"]`);
    let currentQty = parseInt(qtyInput.value) || 1;
    let stock = parseInt(qtyInput.getAttribute('data-stock')) || 1;

    if (currentQty < stock) {
      updateCartQty(productId, currentQty + 1);
    } else {
      alert("Reached max stock available.");
    }
  });
});
});