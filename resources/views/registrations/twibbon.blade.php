<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twibbon AMPERA 2026 - IMP</title>
    <link rel="icon" href="{{ asset('images/logonocap.png') }}" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .twibbon-container {
            position: relative;
            width: 100%;
            max-width: 400px;
            aspect-ratio: 1/1;
            margin: 0 auto;
            background: #ffffff;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            cursor: move;
        }

        @media (max-width: 640px) {
            .twibbon-container {
                max-width: 320px;
            }
        }

        .twibbon-canvas {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .photo-upload {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: none;
            cursor: move;
            user-select: none;
            -webkit-user-drag: none;
        }

        .twibbon-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 10;
        }

        .twibbon-frame {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .template-preview {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .spinner {
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        input[type="range"]::-webkit-slider-thumb {
            appearance: none;
            width: 20px;
            height: 20px;
            background: #10b981;
            cursor: pointer;
            border-radius: 50%;
        }

        input[type="range"]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background: #10b981;
            cursor: pointer;
            border-radius: 50%;
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .twibbon-container {
                touch-action: none;
            }
        }
    </style>
</head>

<body class="bg-emerald-50 text-gray-800 font-sans">

    @include('partials.header')

    <section class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 mt-16 md:mt-0">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12 mt-12">
                <div class="inline-block px-4 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold uppercase tracking-wide mb-4">
                    Twibbon
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-emerald-900 tracking-tight">AMPERA 2026</h1>
                <p class="mt-4 text-lg text-emerald-700 font-semibold">Abadikan Momen, Bagikan Semangat!</p>
                <p class="text-sm text-gray-600 mt-2">Buat twibbon cantik dan share ke Instagram Anda</p>
            </div>

            <div class="bg-white p-8 md:p-10 rounded-2xl shadow-xl border-t-4 border-emerald-600">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                    <!-- Upload & Preview Section -->
                    <div>
                        <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4 md:mb-6">
                            <i class="fas fa-image text-emerald-500 mr-2"></i> Upload Foto Anda
                        </h2>

                        <!-- Upload Input -->
                        <div class="mb-4 md:mb-6">
                            <label for="photoInput"
                                class="block border-2 border-dashed border-emerald-300 rounded-lg p-6 md:p-8 text-center cursor-pointer hover:border-emerald-500 transition">
                                <input type="file" id="photoInput" accept="image/*" class="hidden">
                                <i class="fas fa-cloud-upload-alt text-3xl md:text-4xl text-emerald-500 mb-2"></i>
                                <p class="text-gray-700 font-semibold text-sm md:text-base">Klik untuk Upload Foto</p>
                                <p class="text-gray-500 text-xs md:text-sm">atau drag & drop gambar di sini</p>
                                <p class="text-gray-400 text-xs mt-2">(JPG, PNG, maksimal 5MB)</p>
                            </label>
                        </div>

                        <!-- Preview Section -->
                        <div id="previewContainer">
                            <div class="mb-4">
                                <p class="text-xs md:text-sm text-gray-600 mb-2">Preview:</p>
                                <div id="twibbonPreview" class="twibbon-container">
                                    <div class="twibbon-canvas">
                                        <img id="previewImage" class="photo-upload hidden" src="" alt="Preview">
                                        <img id="templatePreview" class="template-preview" src="{{ asset('images/twibbon.png') }}" alt="Template Twibbon">
                                        <div class="twibbon-overlay">
                                            <img class="twibbon-frame" src="{{ asset('images/twibbon.png') }}" alt="Twibbon Frame">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Photo Controls -->
                            <div id="photoControls" class="hidden mb-4 space-y-2 md:space-y-3">
                                <div class="bg-emerald-50 p-3 md:p-4 rounded-lg">
                                    <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-search-plus mr-1"></i> Zoom Foto
                                    </label>
                                    <input type="range" id="zoomSlider" min="10" max="200" value="100" 
                                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                                        <span>10%</span>
                                        <span id="zoomValue">100%</span>
                                        <span>200%</span>
                                    </div>
                                </div>
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-2 md:p-3">
                                    <p class="text-blue-800 text-xs flex items-start gap-2">
                                        <i class="fas fa-hand-paper mt-0.5 flex-shrink-0"></i>
                                        <span>Drag foto untuk mengatur posisi. Gunakan slider untuk zoom in/out.</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2 md:gap-3">
                                <button id="downloadBtn"
                                    class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 md:py-3 px-4 md:px-6 rounded-lg transition flex items-center justify-center gap-2 text-sm md:text-base">
                                    <i class="fas fa-download"></i> <span class="hidden sm:inline">Download</span><span class="sm:hidden">Download</span>
                                </button>
                                <button id="resetBtn"
                                    class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-2.5 md:py-3 px-4 md:px-6 rounded-lg transition flex items-center justify-center gap-2 text-sm md:text-base">
                                    <i class="fas fa-redo"></i> <span class="hidden sm:inline">Reset</span><span class="sm:hidden">Reset</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Caption Section -->
                    <div>
                        <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4 md:mb-6">
                            <i class="fas fa-quote-left text-emerald-500 mr-2"></i> Caption Instagram
                        </h2>

                        <!-- Caption Cards -->
                        <div class="space-y-3 md:space-y-4 mb-4 md:mb-6 max-h-[400px] md:max-h-[600px] overflow-y-auto">
                            <div class="bg-emerald-50 border-l-4 border-emerald-600 p-3 md:p-4 rounded">
                                <p class="text-gray-800 text-xs leading-relaxed mb-3 whitespace-pre-wrap font-mono" id="caption-1">[🌱 OFFICIAL TWIBBON AMPERA 2026 🌱]

I'm ready for AMPERA NGREMBAKA BUMI IMP 2026🌱

"The best time to plant a tree was 20 years ago. The second best time is now." - Chinese Proverb

Hello Pejuang Bumi!
Saya (Nama) dari (Asal Instansi/Komunitas) siap berpartisipasi dalam kegiatan “AMPERA NGREMBAKA BUMI 2026” — aksi nyata kepedulian lingkungan melalui penanaman pohon demi bumi yang lebih lestari.

Hijaukan Negeri, Bergerak Mengabdi, Bumi Lestari! 🌱

#AMPERAIMP
#AMPERAXPENGMAS2026
@imp_unnes @ampera_imp</p>
                                <button class="copy-caption w-full bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold py-2 px-4 rounded transition"
                                    data-target="caption-1">
                                    <i class="fas fa-copy mr-1"></i> Salin Caption
                                </button>
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 md:p-4">
                            <p class="text-blue-900 text-xs md:text-sm">
                                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                                Klik tombol "Salin Caption" untuk menyalin caption, kemudian paste di Instagram story atau feed Anda!
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- How to Use Section -->
            <div class="mt-8 md:mt-12 bg-white rounded-2xl shadow-xl p-6 md:p-8">
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-6 md:mb-8 text-center">Cara Menggunakan</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                    <div class="text-center">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-emerald-500 text-white rounded-full flex items-center justify-center text-lg md:text-xl font-bold mx-auto mb-2 md:mb-3">1</div>
                        <h3 class="font-bold text-gray-800 mb-1 md:mb-2 text-sm md:text-base">Upload Foto</h3>
                        <p class="text-gray-600 text-xs md:text-sm">Pilih foto pribadi Anda untuk dijadikan twibbon AMPERA</p>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-emerald-500 text-white rounded-full flex items-center justify-center text-lg md:text-xl font-bold mx-auto mb-2 md:mb-3">2</div>
                        <h3 class="font-bold text-gray-800 mb-1 md:mb-2 text-sm md:text-base">Download Twibbon</h3>
                        <p class="text-gray-600 text-xs md:text-sm">Klik tombol download untuk menyimpan gambar twibbon Anda</p>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-emerald-500 text-white rounded-full flex items-center justify-center text-lg md:text-xl font-bold mx-auto mb-2 md:mb-3">3</div>
                        <h3 class="font-bold text-gray-800 mb-1 md:mb-2 text-sm md:text-base">Bagikan di Instagram</h3>
                        <p class="text-gray-600 text-xs md:text-sm">Posting twibbon dengan caption pilihan Anda!</p>
                    </div>
                </div>
            </div>

            <p class="mt-6 md:mt-8 text-center text-xs text-gray-500">
                &copy; 2025 Ikatan Mahasiswa Pati. All rights reserved.
            </p>
        </div>
    </section>

    {{-- @include('partials.footer') --}}

    <!-- Notification -->
    <div id="copyNotif" class="hidden fixed bottom-4 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center gap-2 fade-in z-50">
        <i class="fas fa-check-circle"></i> <span>Caption disalin ke clipboard!</span>
    </div>

    <script>
        const photoInput = document.getElementById('photoInput');
        const previewImage = document.getElementById('previewImage');
        const templatePreview = document.getElementById('templatePreview');
        const photoControls = document.getElementById('photoControls');
        const downloadBtn = document.getElementById('downloadBtn');
        const resetBtn = document.getElementById('resetBtn');
        const zoomSlider = document.getElementById('zoomSlider');
        const zoomValue = document.getElementById('zoomValue');
        const copyButtons = document.querySelectorAll('.copy-caption');
        const copyNotif = document.getElementById('copyNotif');
        const twibbonPreview = document.getElementById('twibbonPreview');
        const twibbonCanvas = document.querySelector('.twibbon-canvas');

        // Photo position and zoom state
        let photoScale = 1;
        let photoX = 0;
        let photoY = 0;
        let isDragging = false;
        let startX, startY;

        // Handle file input
        photoInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    previewImage.src = event.target.result;
                    previewImage.classList.remove('hidden');
                    templatePreview.classList.add('hidden');
                    photoControls.classList.remove('hidden');
                    
                    // Reset position and scale
                    photoScale = 1;
                    photoX = 0;
                    photoY = 0;
                    zoomSlider.value = 100;
                    updatePhotoTransform();
                };
                reader.readAsDataURL(file);
            }
        });

        // Drag and drop on upload label
        const label = document.querySelector('label[for="photoInput"]');
        label.addEventListener('dragover', (e) => {
            e.preventDefault();
            label.classList.add('border-emerald-500', 'bg-emerald-50');
        });

        label.addEventListener('dragleave', () => {
            label.classList.remove('border-emerald-500', 'bg-emerald-50');
        });

        label.addEventListener('drop', (e) => {
            e.preventDefault();
            label.classList.remove('border-emerald-500', 'bg-emerald-50');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                photoInput.files = files;
                const event = new Event('change', { bubbles: true });
                photoInput.dispatchEvent(event);
            }
        });

        // Zoom functionality
        zoomSlider.addEventListener('input', function() {
            photoScale = this.value / 100;
            zoomValue.textContent = this.value + '%';
            updatePhotoTransform();
        });

        // Drag functionality
        previewImage.addEventListener('mousedown', startDrag);
        previewImage.addEventListener('touchstart', startDrag);

        document.addEventListener('mousemove', drag);
        document.addEventListener('touchmove', drag);

        document.addEventListener('mouseup', stopDrag);
        document.addEventListener('touchend', stopDrag);

        function startDrag(e) {
            if (previewImage.classList.contains('hidden')) return;
            
            isDragging = true;
            twibbonCanvas.style.cursor = 'grabbing';
            
            if (e.type === 'touchstart') {
                startX = e.touches[0].clientX - photoX;
                startY = e.touches[0].clientY - photoY;
            } else {
                startX = e.clientX - photoX;
                startY = e.clientY - photoY;
            }
            e.preventDefault();
        }

        function drag(e) {
            if (!isDragging) return;
            
            if (e.type === 'touchmove') {
                photoX = e.touches[0].clientX - startX;
                photoY = e.touches[0].clientY - startY;
            } else {
                photoX = e.clientX - startX;
                photoY = e.clientY - startY;
            }
            
            updatePhotoTransform();
        }

        function stopDrag() {
            isDragging = false;
            twibbonCanvas.style.cursor = 'move';
        }

        function updatePhotoTransform() {
            previewImage.style.transform = `translate(calc(-50% + ${photoX}px), calc(-50% + ${photoY}px)) scale(${photoScale})`;
        }

        // Download functionality
        downloadBtn.addEventListener('click', async function () {
            downloadBtn.disabled = true;
            downloadBtn.innerHTML = '<i class="fas fa-spinner spinner"></i> Processing...';

            try {
                // Create a temporary canvas with Instagram standard size
                const tempCanvas = document.createElement('canvas');
                const targetSize = 1080; // Instagram standard size (1080x1080)
                tempCanvas.width = targetSize;
                tempCanvas.height = targetSize;
                const ctx = tempCanvas.getContext('2d');

                // Fill white background
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, targetSize, targetSize);

                // Load and draw user photo if exists
                if (!previewImage.classList.contains('hidden') && previewImage.src) {
                    const userImg = new Image();
                    userImg.crossOrigin = 'anonymous';
                    
                    await new Promise((resolve, reject) => {
                        userImg.onload = resolve;
                        userImg.onerror = reject;
                        userImg.src = previewImage.src;
                    });

                    // Get the actual rendered size of the photo in the preview
                    const canvasRect = twibbonCanvas.getBoundingClientRect();
                    const imgRect = previewImage.getBoundingClientRect();
                    
                    // Calculate scale ratio from preview to download size
                    const scaleRatio = targetSize / canvasRect.width;
                    
                    // Get the rendered dimensions of the image in the preview
                    const renderedWidth = imgRect.width;
                    const renderedHeight = imgRect.height;
                    
                    // Scale these dimensions for the high-res output
                    const outputWidth = renderedWidth * scaleRatio;
                    const outputHeight = renderedHeight * scaleRatio;

                    // Calculate position offsets
                    const offsetX = photoX * scaleRatio;
                    const offsetY = photoY * scaleRatio;

                    ctx.save();
                    ctx.translate(targetSize / 2, targetSize / 2);
                    ctx.translate(offsetX, offsetY);
                    ctx.drawImage(userImg, -outputWidth / 2, -outputHeight / 2, outputWidth, outputHeight);
                    ctx.restore();
                }

                // Load and draw twibbon frame
                const frameImg = new Image();
                frameImg.crossOrigin = 'anonymous';
                
                await new Promise((resolve, reject) => {
                    frameImg.onload = resolve;
                    frameImg.onerror = reject;
                    frameImg.src = '{{ asset("images/twibbon.png") }}';
                });

                ctx.drawImage(frameImg, 0, 0, targetSize, targetSize);

                // Download the result
                const link = document.createElement('a');
                link.href = tempCanvas.toDataURL('image/png', 1.0);
                link.download = `AMPERA2026-Twibbon-${new Date().getTime()}.png`;
                link.click();

            } catch (error) {
                console.error('Error generating image:', error);
                alert('Terjadi kesalahan saat download. Silakan coba lagi.');
            } finally {
                downloadBtn.disabled = false;
                downloadBtn.innerHTML = '<i class="fas fa-download"></i> Download';
            }
        });

        // Reset functionality
        resetBtn.addEventListener('click', function () {
            photoInput.value = '';
            previewImage.src = '';
            previewImage.classList.add('hidden');
            templatePreview.classList.remove('hidden');
            photoControls.classList.add('hidden');
            
            // Reset transform
            photoScale = 1;
            photoX = 0;
            photoY = 0;
            zoomSlider.value = 100;
            zoomValue.textContent = '100%';
        });

        // Copy caption functionality
        copyButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const captionElement = document.getElementById(targetId);
                const caption = captionElement.textContent;
                navigator.clipboard.writeText(caption).then(() => {
                    copyNotif.classList.remove('hidden');
                    setTimeout(() => {
                        copyNotif.classList.add('hidden');
                    }, 3000);
                }).catch(err => {
                    alert('Gagal menyalin caption. Silakan coba lagi.');
                });
            });
        });
    </script>

</body>

</html>