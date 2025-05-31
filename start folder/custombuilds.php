<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="customb.css" />
  <title>Custom Build</title>
  <style>
    /* Keep your styles */
  </style>
</head>
<body>
  <div class="popup-tab">
    <h2>Custom Build</h2>

    <!-- CPU Brand -->
    <div class="step active" id="cpu-brand">
      <h3>Select CPU Brand</h3>
      <button class="choice-btn" onclick="chooseCPUBrand('Intel')">Intel</button>
      <button class="choice-btn" onclick="chooseCPUBrand('AMD Ryzen')">AMD Ryzen</button>
    </div>

    <!-- CPU Model (Intel) -->
    <div class="step" id="intel-model">
      <h3>Select Intel Model</h3>
      <button class="choice-btn" onclick="chooseIntelModel('i3')">i3</button>
      <button class="choice-btn" onclick="chooseIntelModel('i5')">i5</button>
      <button class="choice-btn" onclick="chooseIntelModel('i7')">i7</button>
      <button class="choice-btn" onclick="chooseIntelModel('i9')">i9</button>
      <button class="btn back-btn" onclick="goBack('cpu-brand')">Back</button>
    </div>

    <!-- Intel Generation -->
    <div class="step" id="intel-gen">
      <h3>Select Intel Generation</h3>
      <button class="choice-btn" onclick="finalizeIntelGen('12th Gen')">12th Gen</button>
      <button class="choice-btn" onclick="finalizeIntelGen('14th Gen')">14th Gen</button>
      <button class="choice-btn" onclick="finalizeIntelGen('Ultra')">Ultra</button>
      <button class="btn back-btn" onclick="goBack('intel-model')">Back</button>
    </div>

    <!-- CPU Model (AMD) -->
    <div class="step" id="amd-model">
      <h3>Select Ryzen Model</h3>
      <button class="choice-btn" onclick="chooseAMDModel('Ryzen 3')">Ryzen 3</button>
      <button class="choice-btn" onclick="chooseAMDModel('Ryzen 5')">Ryzen 5</button>
      <button class="choice-btn" onclick="chooseAMDModel('Ryzen 7')">Ryzen 7</button>
      <button class="choice-btn" onclick="chooseAMDModel('Ryzen 9')">Ryzen 9</button>
      <button class="btn back-btn" onclick="goBack('cpu-brand')">Back</button>
    </div>

    <!-- AMD Socket -->
    <div class="step" id="amd-socket">
      <h3>Select AMD Socket</h3>
      <button class="choice-btn" onclick="finalizeAMDSocket('AM4')">AM4</button>
      <button class="choice-btn" onclick="finalizeAMDSocket('AM5')">AM5</button>
      <button class="btn back-btn" onclick="goBack('amd-model')">Back</button>
    </div>

    <!-- Motherboard -->
    <div class="step" id="step2">
      <h3>Select Motherboard</h3>
      <button class="choice-btn" onclick="selectPart('Motherboard', 'ASUS B550')">ASUS B550</button>
      <button class="choice-btn" onclick="selectPart('Motherboard', 'Gigabyte Z690')">Gigabyte Z690</button>
      <button class="btn back-btn" onclick="goBackToCPU()">Back</button>
    </div>

    <!-- GPU Brand -->
    <div class="step" id="step3">
      <h3>Select GPU Brand</h3>
      <button class="choice-btn" onclick="chooseGPUBrand('Nvidia')">Nvidia</button>
      <button class="choice-btn" onclick="chooseGPUBrand('AMD')">AMD</button>
      <button class="btn back-btn" onclick="goBack('step2')">Back</button>
    </div>

    <!-- Nvidia GPU Tier -->
    <div class="step" id="nvidia-tier">
      <h3>Select Nvidia Tier</h3>
      <button class="choice-btn" onclick="selectPart('GPU', 'GTX 1650')">Budget (GTX 1650)</button>
      <button class="choice-btn" onclick="selectPart('GPU', 'RTX 3060')">Mid (RTX 3060)</button>
      <button class="choice-btn" onclick="selectPart('GPU', 'RTX 4080')">High (RTX 4080)</button>
      <button class="btn back-btn" onclick="goBack('step3')">Back</button>
    </div>

    <!-- AMD GPU Tier -->
    <div class="step" id="amd-tier">
      <h3>Select AMD Tier</h3>
      <button class="choice-btn" onclick="selectPart('GPU', 'RX 6500 XT')">Budget (RX 6500 XT)</button>
      <button class="choice-btn" onclick="selectPart('GPU', 'RX 6600')">Mid (RX 6600)</button>
      <button class="choice-btn" onclick="selectPart('GPU', 'RX 7900 XTX')">High (RX 7900 XTX)</button>
      <button class="btn back-btn" onclick="goBack('step3')">Back</button>
    </div>

    <!-- RAM -->
    <div class="step" id="step4">
      <h3>Select RAM</h3>
      <button class="choice-btn" onclick="selectPart('RAM', '8GB')">8GB</button>
      <button class="choice-btn" onclick="selectPart('RAM', '16GB')">16GB</button>
      <button class="choice-btn" onclick="selectPart('RAM', '32GB')">32GB</button>
      <button class="choice-btn" onclick="selectPart('RAM', '64GB')">64GB</button>
      <button class="choice-btn" onclick="selectPart('RAM', '128GB')">128GB</button>
      <button class="btn back-btn" onclick="goBack('step3')">Back</button>
    </div>

    <!-- SSD -->
    <div class="step" id="step5">
      <h3>Select SSD</h3>
      <button class="choice-btn" onclick="selectPart('SSD', '256GB')">256GB</button>
      <button class="choice-btn" onclick="selectPart('SSD', '500GB')">500GB</button>
      <button class="choice-btn" onclick="selectPart('SSD', '1TB')">1TB</button>
      <button class="choice-btn" onclick="selectPart('SSD', '2TB')">2TB</button>
      <button class="choice-btn" onclick="selectPart('SSD', '4TB')">4TB</button>
      <button class="btn back-btn" onclick="goBack('step4')">Back</button>
    </div>

    <!-- PSU -->
    <div class="step" id="step6">
      <h3>Select PSU</h3>
      <button class="choice-btn" onclick="selectPart('PSU', 'Corsair 650W')">Corsair 650W</button>
      <button class="choice-btn" onclick="selectPart('PSU', 'Cooler Master 550W')">Cooler Master 550W</button>
      <button class="btn back-btn" onclick="goBack('step5')">Back</button>
    </div>

    <!-- Case -->
    <div class="step" id="step7">
      <h3>Select Case</h3>
      <button class="choice-btn" onclick="selectPart('Case', 'NZXT H510')">NZXT H510</button>
      <button class="choice-btn" onclick="selectPart('Case', 'Lian Li 011')">Lian Li 011</button>
      <button class="btn back-btn" onclick="goBack('step6')">Back</button>
    </div>

    <!-- Cooler -->
    <div class="step" id="step8">
      <h3>Select CPU Cooler</h3>
      <button class="choice-btn" onclick="selectPart('Cooler', 'Cooler Master Hyper 212')">Cooler Master Hyper 212</button>
      <button class="choice-btn" onclick="selectPart('Cooler', 'Noctua NH-U12S')">Noctua NH-U12S</button>
      <button class="btn back-btn" onclick="goBack('step7')">Back</button>
    </div>

    <!-- Summary -->
    <div class="step" id="summary">
      <h3>Build Summary</h3>
      <pre id="summaryText"></pre>
      <button class="btn" onclick="restart()">Start Over</button>
    </div>
  </div>

  <script>
    const build = {};

    function showStep(stepId) {
      document.querySelectorAll('.step').forEach(step => step.classList.remove('active'));
      document.getElementById(stepId).classList.add('active');
    }

    function goBack(stepId) {
      showStep(stepId);
    }

    function goBackToCPU() {
      // Clear motherboard choice
      delete build.Motherboard;
      showStep('cpu-brand');
    }

    // Step 1 - CPU Brand
    function chooseCPUBrand(brand) {
      build.CPUBrand = brand;
      if (brand === 'Intel') {
        showStep('intel-model'); // Model first
      } else {
        showStep('amd-model');
      }
    }

    // Intel path: model then gen
    function chooseIntelModel(model) {
      build.cpuModel = model;
      showStep('intel-gen');
    }

    function finalizeIntelGen(gen) {
      build.IntelGen = gen;
      showStep('step2'); // Proceed to motherboard
    }

    // AMD path: model then socket
    function chooseAMDModel(model) {
      build.cpuModel = model;
      showStep('amd-socket');
    }

    function finalizeAMDSocket(socket) {
      build.AMDSocket = socket;
      showStep('step2'); // Proceed to motherboard
    }

    // Motherboard and onward
    function selectPart(partType, choice) {
      build[partType] = choice;

      switch (partType) {
        case 'Motherboard': showStep('step3'); break;
        case 'GPU': showStep('step4'); break;
        case 'RAM': showStep('step5'); break;
        case 'SSD': showStep('step6'); break;
        case 'PSU': showStep('step7'); break;
        case 'Case': showStep('step8'); break;
        case 'Cooler': showSummary(); break;
      }
    }

    function chooseGPUBrand(brand) {
      build.GPUBrand = brand;
      if (brand === 'Nvidia') {
        showStep('nvidia-tier');
      } else {
        showStep('amd-tier');
      }
    }

    function showSummary() {
      let summary = 'Your build configuration:\n';
      for (const [part, value] of Object.entries(build)) {
        summary += `${part}: ${value}\n`;
      }
      document.getElementById('summaryText').textContent = summary;
      showStep('summary');
    }

    function restart() {
      for (const key in build) {
        delete build[key];
      }
      showStep('cpu-brand');
    }
  </script>
</body>
</html>
