<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twibbon Webinar KWU 2026 - IMP</title>
    <link rel="icon" href="{{ asset('images/logonocap.png') }}" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- html2canvas is needed for download -->
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
            background: #1e293b;
            /* slate-800 */
            border: 2px solid #334155;
            /* slate-700 */
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
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Custom Range Slider for Dark Mode */
        input[type="range"] {
            -webkit-appearance: none;
            background: transparent;
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            background: #3b82f6;
            /* blue-500 */
            cursor: pointer;
            border-radius: 50%;
            margin-top: -8px;
        }

        input[type="range"]::-webkit-slider-runnable-track {
            width: 100%;
            height: 4px;
            cursor: pointer;
            background: #475569;
            /* slate-600 */
            border-radius: 2px;
        }

        input[type="range"]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background: #3b82f6;
            cursor: pointer;
            border-radius: 50%;
            border: none;
        }

        input[type="range"]::-moz-range-track {
            width: 100%;
            height: 4px;
            cursor: pointer;
            background: #475569;
            border-radius: 2px;
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .twibbon-container {
                touch-action: none;
            }
        }
    </style>
</head>

<body class="bg-slate-900 text-white font-sans selection:bg-blue-500 selection:text-white">

    @include('partials.header')

    <section class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 mt-16 md:mt-0 relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute -top-[10%] -right-[10%] w-[50%] h-[50%] bg-blue-600/20 rounded-full blur-3xl"></div>
            <div class="absolute top-[20%] -left-[10%] w-[40%] h-[40%] bg-indigo-600/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-[10%] right-[20%] w-[30%] h-[30%] bg-cyan-600/20 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12 mt-12">
                <div
                    class="inline-block px-4 py-1.5 bg-blue-900/50 border border-blue-500/30 text-blue-300 rounded-full text-xs font-bold uppercase tracking-wide mb-4 backdrop-blur-sm">
                    ✨ Official Twibbon
                </div>
                <h1
                    class="text-3xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-200 via-white to-blue-200 tracking-tight mb-2 drop-shadow-sm">
                    Webinar Kewirausahaan 2026</h1>
                <p class="mt-4 text-lg md:text-xl text-slate-300 font-medium max-w-2xl mx-auto">Small Start, Big Dream:
                    Dari Ide Sederhana Jadi Peluang Usaha</p>
            </div>

            <div class="bg-slate-800/80 backdrop-blur-md p-6 md:p-10 rounded-3xl shadow-2xl border border-slate-700/50">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

                    <!-- Upload & Preview Section -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 mb-2">
                            <div
                                class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-600/30">
                                <i class="fas fa-camera"></i>
                            </div>
                            <h2 class="text-xl md:text-2xl font-bold text-white">
                                Foto & Preview
                            </h2>
                        </div>

                        <!-- Upload Input -->
                        <div>
                            <label for="photoInput"
                                class="group relative block w-full border-2 border-dashed border-slate-600 rounded-2xl p-8 text-center cursor-pointer hover:border-blue-500 hover:bg-slate-700/50 transition duration-300 ease-in-out">
                                <input type="file" id="photoInput" accept="image/*" class="hidden">

                                <div class="mb-4 transform group-hover:scale-110 transition duration-300">
                                    <div
                                        class="w-16 h-16 mx-auto bg-slate-700 rounded-full flex items-center justify-center text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                        <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold text-white mb-1">Upload Foto Kamu</h3>
                                <p class="text-slate-400 text-sm mb-2">Drag & drop atau klik untuk memilih</p>
                                <span class="text-xs text-slate-500 bg-slate-900/50 px-3 py-1 rounded-full">JPG, PNG
                                    (Max 5MB)</span>
                            </label>
                        </div>

                        <!-- Preview Container -->
                        <div id="previewContainer" class="bg-slate-900/50 rounded-2xl p-4 border border-slate-700">
                            <div class="mb-4">
                                <div class="flex justify-between items-center mb-2">
                                    <p class="text-xs md:text-sm text-slate-400 font-medium tracking-wide uppercase">
                                        Live Preview</p>
                                </div>

                                <div id="twibbonPreview" class="twibbon-container shadow-2xl shadow-blue-900/20">
                                    <div class="twibbon-canvas">
                                        <img id="previewImage" class="photo-upload hidden" src="" alt="Preview">
                                        <img id="templatePreview" class="template-preview opacity-80"
                                            src="{{ asset('images/webinarkwu.png') }}" alt="Template Twibbon KWU IMP">
                                        <div class="twibbon-overlay">
                                            <img class="twibbon-frame" src="{{ asset('images/webinarkwu.png') }}"
                                                alt="Twibbon Frame KWU IMP">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Photo Controls (Hidden by default) -->
                            <div id="photoControls" class="hidden animate-fade-in-up">
                                <div class="bg-slate-800 rounded-xl p-4 mb-4 border border-slate-700">
                                    <label class="flex justify-between text-sm font-semibold text-slate-300 mb-3">
                                        <span><i class="fas fa-search-plus text-blue-400 mr-2"></i>Zoom</span>
                                        <span id="zoomValue" class="text-blue-400">100%</span>
                                    </label>
                                    <input type="range" id="zoomSlider" min="10" max="200" value="100" class="w-full">
                                    <div class="flex justify-between text-xs text-slate-500 mt-2 font-mono">
                                        <span>10%</span>
                                        <span>200%</span>
                                    </div>
                                </div>

                                <div
                                    class="bg-blue-900/20 border border-blue-500/20 rounded-xl p-3 mb-4 flex gap-3 items-start">
                                    <i class="fas fa-info-circle text-blue-400 mt-0.5"></i>
                                    <p class="text-blue-200 text-xs leading-relaxed">
                                        Geser (drag) foto pada preview untuk mengatur posisi. Gunakan slider di atas
                                        untuk memperbesar/memperkecil.
                                    </p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3">
                                <button id="downloadBtn"
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-blue-600/30 transition transform hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-2 group">
                                    <i class="fas fa-download group-hover:animate-bounce"></i>
                                    <span>Download Twibbon</span>
                                </button>
                                <button id="resetBtn"
                                    class="sm:w-auto w-full bg-slate-700 hover:bg-slate-600 text-slate-200 font-medium py-3.5 px-6 rounded-xl transition border border-slate-600 hover:border-slate-500 flex items-center justify-center gap-2">
                                    <i class="fas fa-redo"></i>
                                    <span>Reset</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Caption Section -->
                    <div class="flex flex-col h-full">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-600/30">
                                <i class="fas fa-quote-right"></i>
                            </div>
                            <h2 class="text-xl md:text-2xl font-bold text-white">
                                Caption Instagram
                            </h2>
                        </div>

                        <div class="flex-1 bg-slate-900/50 rounded-2xl p-6 border border-slate-700 flex flex-col">
                            <p class="text-slate-400 text-sm mb-4">Salin caption di bawah ini untuk postingan kamu:</p>

                            <div
                                class="flex-1 bg-slate-800 rounded-xl p-4 border border-slate-700 mb-4 overflow-y-auto max-h-[400px] shadow-inner custom-scrollbar relative group">
                                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                                    <span class="text-[10px] text-slate-500 px-2 py-1 bg-slate-900 rounded">Scroll for
                                        more</span>
                                </div>
                                <p class="text-slate-300 text-sm leading-relaxed whitespace-pre-wrap font-mono"
                                    id="caption-1">🌟OFFICIAL TWIBBON WEBINAR KEWIRAUSAHAAN IMP 2026 🌟
Ready to build your dream business? 🚀

Mulai dari ide sederhana,
Berkembang jadi usaha luar biasa🔥

Hello, Future Entrepreneurs! 👋
Saya [Nama] dari [Asal/Instansi] siap mengikuti acara Webinar Kewirausahaan IMP 2026! 💼✨

Di sinilah mindset dibentuk, strategi dipelajari, dan mimpi bisnis mulai disusun.
“Kesempatan tidak datang dua kali, tapi keberanian bisa kamu ciptakan hari ini.”

Yuk, daftar sekarang dan jadilah bagian dari generasi entrepreneur muda yang kreatif, inovatif, dan siap bersaing! 📈

#WebinarKewirausahaanIMP2026
#KWUIMP
#IMPUNNES
#SmallStartBigDream</p>
                            </div>

                            <button
                                class="copy-caption w-full bg-slate-700 hover:bg-slate-600 hover:text-white text-slate-200 font-semibold py-3 px-4 rounded-xl transition border border-slate-600 flex items-center justify-center gap-2 group"
                                data-target="caption-1">
                                <i class="far fa-copy group-hover:scale-110 transition"></i> Salin Caption
                            </button>
                        </div>

                        <!-- Instruction Steps -->
                        <div class="mt-8">
                            <h3 class="text-lg font-bold text-white mb-4">Cara Menggunakan:</h3>
                            <div class="space-y-4">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-900/50 border border-blue-500/50 text-blue-400 flex flex-shrink-0 items-center justify-center font-bold text-sm">
                                        1</div>
                                    <div>
                                        <h4 class="text-white font-medium text-sm">Upload Foto</h4>
                                        <p class="text-slate-400 text-xs mt-0.5">Pilih foto terbaikmu, format JPG atau
                                            PNG.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-900/50 border border-blue-500/50 text-blue-400 flex flex-shrink-0 items-center justify-center font-bold text-sm">
                                        2</div>
                                    <div>
                                        <h4 class="text-white font-medium text-sm">Atur Posisi</h4>
                                        <p class="text-slate-400 text-xs mt-0.5">Geser dan zoom foto agar pas di frame.
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-900/50 border border-blue-500/50 text-blue-400 flex flex-shrink-0 items-center justify-center font-bold text-sm">
                                        3</div>
                                    <div>
                                        <h4 class="text-white font-medium text-sm">Download & Share</h4>
                                        <p class="text-slate-400 text-xs mt-0.5">Unduh hasilnya dan posting dengan
                                            caption!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="mt-8 text-center text-sm text-slate-500">
                &copy; 2026 Ikatan Mahasiswa Pati. All rights reserved.
            </p>
        </div>
    </section>

    <!-- Notification -->
    <div id="copyNotif"
        class="hidden fixed bottom-6 right-6 bg-slate-800 border border-emerald-500/30 text-white px-5 py-3 rounded-lg shadow-2xl flex items-center gap-3 fade-in z-50">
        <div class="w-8 h-8 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center">
            <i class="fas fa-check"></i>
        </div>
        <div>
            <h4 class="font-bold text-sm">Berhasil!</h4>
            <p class="text-xs text-slate-300">Caption telah disalin ke clipboard.</p>
        </div>
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
        const label = document.querySelector('label[for="photoInput"]');

        let photoScale = 1;
        let photoX = 0;
        let photoY = 0;
        let isDragging = false;
        let startX, startY;

        photoInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    previewImage.src = event.target.result;
                    previewImage.classList.remove('hidden');
                    templatePreview.classList.add('hidden');
                    photoControls.classList.remove('hidden');
                    photoScale = 1;
                    photoX = 0;
                    photoY = 0;
                    zoomSlider.value = 100;
                    zoomValue.textContent = '100%';
                    updatePhotoTransform();
                };
                reader.readAsDataURL(file);
            }
        });

        // Drag/Drop Styling updates
        label.addEventListener('dragover', (e) => {
            e.preventDefault();
            label.classList.add('border-blue-500', 'bg-slate-700/50');
            label.classList.remove('border-slate-600');
        });

        label.addEventListener('dragleave', () => {
            label.classList.remove('border-blue-500', 'bg-slate-700/50');
            label.classList.add('border-slate-600');
        });

        label.addEventListener('drop', (e) => {
            e.preventDefault();
            label.classList.remove('border-blue-500', 'bg-slate-700/50');
            label.classList.add('border-slate-600');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                photoInput.files = files;
                const event = new Event('change', { bubbles: true });
                photoInput.dispatchEvent(event);
            }
        });

        zoomSlider.addEventListener('input', function () {
            photoScale = this.value / 100;
            zoomValue.textContent = this.value + '%';
            updatePhotoTransform();
        });

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

        downloadBtn.addEventListener('click', async function () {
            downloadBtn.disabled = true;
            const originalText = downloadBtn.innerHTML;
            downloadBtn.innerHTML = '<i class="fas fa-spinner spinner"></i> <span>Processing...</span>';

            try {
                const tempCanvas = document.createElement('canvas');
                const targetSize = 1080;
                tempCanvas.width = targetSize;
                tempCanvas.height = targetSize;
                const ctx = tempCanvas.getContext('2d');

                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, targetSize, targetSize);

                if (!previewImage.classList.contains('hidden') && previewImage.src) {
                    const userImg = new Image();
                    userImg.crossOrigin = 'anonymous';
                    await new Promise((resolve, reject) => {
                        userImg.onload = resolve;
                        userImg.onerror = reject;
                        userImg.src = previewImage.src;
                    });

                    const canvasRect = twibbonCanvas.getBoundingClientRect();
                    const imgRect = previewImage.getBoundingClientRect();
                    const scaleRatio = targetSize / canvasRect.width;
                    const outputWidth = imgRect.width * scaleRatio;
                    const outputHeight = imgRect.height * scaleRatio;
                    const offsetX = photoX * scaleRatio;
                    const offsetY = photoY * scaleRatio;

                    ctx.save();
                    ctx.translate(targetSize / 2, targetSize / 2);
                    ctx.translate(offsetX, offsetY);
                    ctx.drawImage(userImg, -outputWidth / 2, -outputHeight / 2, outputWidth, outputHeight);
                    ctx.restore();
                }

                const frameImg = new Image();
                frameImg.crossOrigin = 'anonymous';
                await new Promise((resolve, reject) => {
                    frameImg.onload = resolve;
                    frameImg.onerror = reject;
                    frameImg.src = '{{ asset("images/webinarkwu.png") }}';
                });

                ctx.drawImage(frameImg, 0, 0, targetSize, targetSize);

                const link = document.createElement('a');
                link.href = tempCanvas.toDataURL('image/png', 1.0);
                link.download = `WEBINARKWU-Twibbon-${new Date().getTime()}.png`;
                link.click();

            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat download. Silakan coba lagi.');
            } finally {
                downloadBtn.disabled = false;
                downloadBtn.innerHTML = originalText;
            }
        });

        resetBtn.addEventListener('click', function () {
            photoInput.value = '';
            previewImage.src = '';
            previewImage.classList.add('hidden');
            templatePreview.classList.remove('hidden');
            photoControls.classList.add('hidden');
            photoScale = 1;
            photoX = 0;
            photoY = 0;
            zoomSlider.value = 100;
            zoomValue.textContent = '100%';
        });

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
                });
            });
        });
    </script>
</body>

</html>