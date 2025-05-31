// Variables to store the build parts
const build = {};

// Navigate between steps
function showStep(stepId) {
  document.querySelectorAll('.step').forEach(step => {
    step.classList.remove('active');
  });
  document.getElementById(stepId).classList.add('active');
}

// Go back function for buttons
function goBack(stepId) {
  showStep(stepId);
}

// Go back from motherboard step to CPU brand selection
function goBackToCPU() {
  // Reset motherboard and next steps if needed
  delete build.Motherboard;
  showStep('cpu-brand');
}

// Choose CPU brand and go to next step
function chooseCPUBrand(brand) {
  build.CPUBrand = brand;
  if (brand === 'Intel') {
    showStep('intel-gen');
  } else {
    showStep('amd-socket');
  }
}

// Intel generation selection
function chooseIntelGen(gen) {
  build.IntelGen = gen;
  showStep('intel-model');
}

// AMD socket selection
function chooseAMDSocket(socket) {
  build.AMDSocket = socket;
  showStep('amd-model');
}
function finalizeCPU(model) {
  build.cpuModel = model; // Fix: use the 'build' object instead of 'selectedParts'

  let cpuDetails = {
    'i3': { name: 'Intel Core i3-12700K', price: '₱12,500', image: 'i3.jpg' },
    'i5': { name: 'Intel Core i5-13600K', price: '₱17,800', image: 'i5.jpg' },
    'i7': { name: 'Intel Core i7-13700K', price: '₱22,500', image: 'i7.jpg' },
    'i9': { name: 'Intel Core i9-13900K', price: '₱33,900', image: 'i9.jpg' },
    'Ryzen 3': { name: 'Ryzen 3 4100', price: '₱5,999', image: 'r3.jpg' },
    'Ryzen 5': { name: 'Ryzen 5 5600X', price: '₱9,500', image: 'r5.jpg' },
    'Ryzen 7': { name: 'Ryzen 7 5800X', price: '₱14,000', image: 'r7.jpg' },
    'Ryzen 9': { name: 'Ryzen 9 7950X', price: '₱29,999', image: 'r9.jpg' }
  };

  const cpu = cpuDetails[model];

  document.getElementById('productImg').src = `assets/cpu/${cpu.image}`;
  document.getElementById('productName').textContent = cpu.name;
  document.getElementById('productPrice').textContent = cpu.price;
  document.getElementById('productPreview').style.display = 'flex';

  showStep('step2'); // Go to motherboard selection

}

// Select motherboard, then GPU brand step
function selectPart(partType, choice) {
  build[partType] = choice;

  // Decide next step based on what was selected
  switch(partType) {
    case 'Motherboard':
      showStep('step3'); // GPU Brand
      break;
    case 'GPU':
      showStep('step4'); // RAM
      break;
    case 'RAM':
      showStep('step5'); // SSD
      break;
    case 'SSD':
      showStep('step6'); // PSU
      break;
    case 'PSU':
      showStep('step7'); // Case
      break;
    case 'Case':
      showStep('step8'); // Cooler
      break;
    case 'Cooler':
      showStep('summary');
      showSummary();
      break;
  }
}

// GPU brand selection leads to specific tiers
function chooseGPUBrand(brand) {
  build.GPUBrand = brand;
  if (brand === 'Nvidia') {
    showStep('nvidia-tier');
  } else {
    showStep('amd-tier');
  }
}

// Show summary of selected parts
function showSummary() {
  let summary = '';
  for (const [part, choice] of Object.entries(build)) {
    summary += `<strong>${part}:</strong> ${choice}<br/>`;
  }
  document.getElementById('summaryText').innerHTML = summary;
}

// Restart the build
function restart() {
  for (const key in build) {
    delete build[key];
  }
  showStep('cpu-brand');
}


