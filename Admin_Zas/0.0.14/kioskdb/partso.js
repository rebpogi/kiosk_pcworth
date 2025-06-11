  let activeSection = 'allitem';

  function setActiveSection(sectionId) {
    activeSection = sectionId;
    const items = document.querySelectorAll('.item');

    items.forEach(item => {
      item.style.display = (item.id === sectionId) ? 'block' : 'none';
    });

    if (sectionId === 'allitem') {
      const allitemDiv = document.querySelector('#allitem .product-grid');
      allitemDiv.innerHTML = '';

      items.forEach(item => {
        if (item.id !== 'allitem') {
          const productCards = item.querySelectorAll('.product-card');
          productCards.forEach(card => {
            allitemDiv.appendChild(card.cloneNode(true));
          });
        }
      });
    }

    filterContent();
  }

  function filterContent() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const activeitem = document.getElementById(activeSection);
    if (!activeitem) return;

    const products = activeitem.querySelectorAll('.product-card');
    products.forEach(product => {
      const text = product.textContent.toLowerCase();
      product.style.display = text.includes(input) ? 'block' : 'none';
    });
  }

  window.onload = () => {
    setActiveSection('allitem');
  };

  document.addEventListener('DOMContentLoaded', () => {
  fetch('get_cart_count.php')
    .then(response => response.text())
    .then(count => {
      const badge = document.getElementById('cart-count');
      const parsedCount = parseInt(count);
      if (!isNaN(parsedCount) && parsedCount > 0) {
        badge.textContent = parsedCount;
        badge.style.display = 'inline-block';
      } else {
        badge.style.display = 'none';
      }
    })
    .catch(error => console.error('Cart count fetch failed:', error));
});