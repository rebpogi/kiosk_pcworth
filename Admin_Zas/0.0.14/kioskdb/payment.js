// Dots animation
let dotCount = 1;
setInterval(() => {
  const dotsEl = document.querySelector('.dots');
  if (dotsEl) dotsEl.textContent = '.'.repeat(dotCount++ % 4);
}, 500);

// Cash flow
document.getElementById('cashForm').addEventListener('submit', function (e) {
  e.preventDefault();
  startProcessing('Cash');
});

// Show bank modal
document.getElementById('epaySelectBtn').addEventListener('click', () => {
  document.getElementById('bankModal').classList.remove('hidden');
});

// After bank selected
function selectBank(bankName) {
  document.getElementById('bankModal').classList.add('hidden');
  document.getElementById('qrModal').classList.remove('hidden');

  setTimeout(() => {
    document.getElementById('qrModal').classList.add('hidden');
    startProcessing(`E-Pay - ${bankName}`);
  }, 5000);
}

// Shared function
function startProcessing(method) {
  const modal = document.getElementById('processingModal');
  const processingSection = document.getElementById('processingSection');
  const successSection = document.getElementById('successSection');
  const receiptNumberEl = document.getElementById('receiptNumber').querySelector('span');

  modal.classList.remove('hidden');
  processingSection.classList.remove('hidden');
  successSection.classList.add('hidden');

  // Generate simulated receipt number
  const receiptNo = '#' + Math.floor(100000 + Math.random() * 900000);
  receiptNumberEl.textContent = receiptNo;

  // Save receipt number to database
  fetch('save_receipt.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 'receipt_no=' + encodeURIComponent(receiptNo) + '&payment_method=' + encodeURIComponent(method)
  })
  .then(response => response.text())
  .then(data => {
    console.log('Receipt saved:', data);
  })
  .catch(error => {
    console.error('Error saving receipt:', error);
  });

  // Show success after 3 seconds
  setTimeout(() => {
    processingSection.classList.add('hidden');
    successSection.classList.remove('hidden');
  }, 3000);

  // Submit stock update + redirect after 6 seconds
  setTimeout(() => {
    fetch('update_stock.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'payment_method=' + encodeURIComponent(method)
    })
    .then(response => {
      if (response.ok) {
        window.location.href = 'startmainkiosk.php';
      } else {
        alert('Failed to update stock. Please contact staff.');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Something went wrong. Please contact staff.');
    });
  }, 6000);
}
