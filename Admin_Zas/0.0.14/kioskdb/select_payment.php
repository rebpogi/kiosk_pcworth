<?php
session_start();
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    header("Location: viewcart.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Select Payment Method</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 font-sans flex flex-col items-center justify-center min-h-screen">

  <!-- Logo -->
  <div class="mb-4">
    <img src="resource/logo.png" alt="Kiosk Logo" class="w-40 h-auto">
  </div>

  <!-- Payment Selection Card -->
  <div class="bg-white shadow rounded-lg max-w-2xl w-full p-6">
    <h2 class="text-2xl font-bold mb-6 text-center">Choose Payment Method</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
      
      <!-- Cash -->
      <form id="cashForm">
        <input type="hidden" name="payment_method" value="Cash">
        <div class="border border-blue-600 rounded-lg p-5 hover:shadow-lg transition cursor-pointer bg-blue-50">
          <div class="text-center">
            <img src="resource/cash.png" alt="Cash Payment" class="mx-auto mb-4 w-16 h-16">
            <h3 class="text-xl font-semibold text-blue-800">Cash</h3>
            <p class="text-sm text-gray-600 mt-2">Pay with cash upon delivery or kiosk.</p>
            <button type="submit" class="mt-4 bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800">Select</button>
          </div>
        </div>
      </form>

      <!-- E-Pay -->
      <div id="epayCard" class="border border-green-600 rounded-lg p-5 hover:shadow-lg transition cursor-pointer bg-green-50">
        <div class="text-center">
          <img src="resource/epay.png" alt="E-Pay" class="mx-auto mb-4 w-16 h-16">
          <h3 class="text-xl font-semibold text-green-800">E-Pay</h3>
          <p class="text-sm text-gray-600 mt-2">Pay using QR code or online wallet.</p>
          <button id="epaySelectBtn" type="button" class="mt-4 bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">Select</button>
        </div>
      </div>
    </div>

    <!-- Cancel Button -->
    <div class="mt-6 text-center">
      <a href="viewcart.php" class="inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Cancel</a>
    </div>
  </div>

    <!-- Modal: Bank Selection -->
    <div id="bankModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-[500px] text-center max-h-[80vh] overflow-y-auto">
        <h3 class="text-lg font-semibold mb-4">Select Your E-Payment Bank</h3>
        <div class="grid grid-cols-3 gap-4">
        <img src="resource/bank1.png" class="cursor-pointer border rounded-lg hover:ring-2" onclick="selectBank('Bank1')" alt="Bank 1">
        <img src="resource/bank2.png" class="cursor-pointer border rounded-lg hover:ring-2" onclick="selectBank('Bank2')" alt="Bank 2">
        <img src="resource/bank3.png" class="cursor-pointer border rounded-lg hover:ring-2" onclick="selectBank('Bank3')" alt="Bank 3">
        <img src="resource/bank4.png" class="cursor-pointer border rounded-lg hover:ring-2" onclick="selectBank('Bank4')" alt="Bank 4">
        <img src="resource/bank5.png" class="cursor-pointer border rounded-lg hover:ring-2" onclick="selectBank('Bank5')" alt="Bank 5">
        <img src="resource/bank6.png" class="cursor-pointer border rounded-lg hover:ring-2" onclick="selectBank('Bank6')" alt="Bank 6">
        <img src="resource/bank7.png" class="cursor-pointer border rounded-lg hover:ring-2" onclick="selectBank('Bank7')" alt="Bank 7">
        <img src="resource/bank8.png" class="cursor-pointer border rounded-lg hover:ring-2" onclick="selectBank('Bank8')" alt="Bank 8">
        <img src="resource/bank9.png" class="cursor-pointer border rounded-lg hover:ring-2" onclick="selectBank('Bank9')" alt="Bank 9">
        <img src="resource/bank10.png" class="cursor-pointer border rounded-lg hover:ring-2" onclick="selectBank('Bank10')" alt="Bank 10">
        <img src="resource/bank11.png" class="cursor-pointer border rounded-lg hover:ring-2" onclick="selectBank('Bank11')" alt="Bank 11">
        <img src="resource/bank12.png" class="cursor-pointer border rounded-lg hover:ring-2" onclick="selectBank('Bank12')" alt="Bank 12">
        <img src="resource/bank13.png" class="cursor-pointer border rounded-lg hover:ring-2" onclick="selectBank('Bank13')" alt="Bank 13">
        <img src="resource/bank14.png" class="cursor-pointer border rounded-lg hover:ring-2" onclick="selectBank('Bank14')" alt="Bank 14">
        </div>
        <div class="mt-6 text-center">
      <a href="viewcart.php" class="inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Cancel</a>
    </div>
  </div>
    </div>
    </div>

  <!-- Modal: QR Code -->
  <div id="qrModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-[400px] text-center">
      <p class="text-lg font-medium text-gray-700 mb-4">Scan the QR code below to pay</p>
      <img src="resource/QRCODE.png" class="w-40 h-40 mx-auto mb-4" alt="QR Code">
      <p class="text-sm text-gray-600">Third party E-Payment transaction by Paymongo</p>
    </div>
  </div>

  <!-- Modal: Processing -->
  <div id="processingModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-96 h-96 rounded-lg shadow-lg p-6 flex flex-col justify-center items-center text-center">
      <div id="processingSection" class="flex flex-col items-center">
        <p class="text-lg font-semibold text-blue-700 mb-4">Processing Order<span class="dots">.</span></p>
      </div>
      <div id="successSection" class="hidden flex flex-col items-center text-center">
        <img src="resource/greencheckcircle.png" alt="Success Checkmark" class="w-20 h-20 mb-4" />
        <p id="receiptNumber" class="text-md font-medium text-gray-700 mb-2">
          Receipt No: <span class="font-bold">#123456</span>
        </p>
        <p class="text-sm text-gray-600">Proceed to the cashier to complete the transaction</p>
      </div>
    </div>
  </div>

  <script>
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

    // Simulate receipt number
    const receiptNo = '#' + Math.floor(100000 + Math.random() * 900000);
    receiptNumberEl.textContent = receiptNo;

    // Show success after 3 seconds
    setTimeout(() => {
      processingSection.classList.add('hidden');
      successSection.classList.remove('hidden');
    }, 3000);

    // Submit stock update + redirect
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
  </script>

</body>
</html>
