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