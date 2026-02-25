<div>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        /* Shimmer Effect for Coming Soon Text */
        @keyframes shimmer {
            0% {
                background-position: -200% center;
            }
            100% {
                background-position: 200% center;
            }
        }
        
        .shimmer-text {
            background: linear-gradient(90deg, #1e3a8a 0%, #60a5fa 50%, #1e3a8a 100%);
            background-size: 200% auto;
            color: transparent;
            -webkit-background-clip: text;
            background-clip: text;
            animation: shimmer 3s linear infinite;
        }

        .impcup-hero {
            background-image: radial-gradient(circle at center, #f0f9ff 0%, #e0f2fe 100%);
            position: relative;
            overflow: hidden;
        }

        .bg-grid-pattern {
            background-image: 
                linear-gradient(to right, rgba(59, 130, 246, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(59, 130, 246, 0.05) 1px, transparent 1px);
            background-size: 24px 24px;
        }
        ";
    </style>

    <main class="flex-grow flex items-center justify-center relative impcup-hero min-h-screen pt-16">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-grid-pattern pointer-events-none"></div>

        <!-- Decorative Blobs -->
        <div class="absolute top-1/4 left-1/4 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-1/3 right-1/4 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-1/4 left-1/3 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>

        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto">
            <!-- Icon / Logo Placeholder -->
            <div class="mb-8 inline-flex items-center justify-center w-24 h-24 rounded-3xl bg-white shadow-xl border border-blue-50 transform rotate-3 hover:rotate-0 transition duration-500">
                <i class="fas fa-trophy text-4xl text-blue-600"></i>
            </div>

            <h1 class="text-5xl md:text-7xl font-extrabold mb-4 tracking-tight text-gray-900">
                IMP CUP <span class="text-blue-600">2026</span>
            </h1>

            <div class="h-1 w-24 bg-blue-600 mx-auto rounded-full mb-8"></div>

            <p class="text-4xl md:text-6xl font-black italic tracking-wider mb-8 uppercase shimmer-text">
                COMING SOON
            </p>

            <p class="text-lg md:text-xl text-gray-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                Bersiaplah untuk kompetisi olahraga terbesar IMP UNNES.
                Nantikan informasi lengkap mengenai tanggal, cabang olahraga, dan pendaftaran segera!
            </p>

            <!-- Notification Form Placeholder -->
            <div class="max-w-md mx-auto bg-white p-2 rounded-full shadow-lg border border-gray-100 flex items-center">
                <div class="flex-grow pl-6 pr-4 py-2 text-gray-400 italic text-sm md:text-base cursor-default select-none">
                    Pantau terus sosial media kami...
                </div>
                <a href="https://instagram.com/impunnes" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full transition transform hover:scale-105 flex-shrink-0">
                    <i class="fab fa-instagram mr-2"></i> Follow
                </a>
            </div>
            
            <div class="mt-12 flex flex-wrap justify-center gap-4 text-sm text-gray-500 font-medium">
                <span class="flex items-center px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100">
                    <i class="fas fa-running text-blue-500 mr-2"></i> Futsal?
                </span>
                <span class="flex items-center px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100">
                    <i class="fas fa-shuttlecock text-blue-500 mr-2"></i> Badminton?
                </span>
                <span class="flex items-center px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100">
                    <i class="fas fa-headset text-blue-500 mr-2"></i> E-Sport?
                </span>
                <span class="flex items-center px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100">
                    <i class="fas fa-question text-blue-500 mr-2"></i> Atau Lainnya?
                </span>
            </div>
        </div>
    </main>

</div>
