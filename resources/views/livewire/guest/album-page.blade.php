<div>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-serif-italic {
            font-family: 'Playfair Display', serif;
            font-style: italic;
        }
        
        /* Shimmer Effect for Coming Soon Text */
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        
        .shimmer-text {
            background: linear-gradient(90deg, #b45309 0%, #fbbf24 50%, #b45309 100%);
            background-size: 200% auto;
            color: transparent;
            -webkit-background-clip: text;
            background-clip: text;
            animation: shimmer 3s linear infinite;
        }

        .album-hero {
            background-color: #fffbeb; /* Amber 50 */
            position: relative;
            overflow: hidden;
        }

        /* Polaroid Animation */
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        .floating-card {
            animation: float 6s ease-in-out infinite;
        }

        .delay-1000 { animation-delay: 1s; }
        .delay-2000 { animation-delay: 2s; }
        ";
    </style>

    <main class="flex-grow flex items-center justify-center relative album-hero min-h-screen pt-16">
        
        <!-- Background Elements -->
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#d97706 1px, transparent 1px); background-size: 32px 32px;"></div>

        <!-- Floating Polaroid Placeholders (Decorative) -->
        <div class="absolute top-20 left-[10%] w-40 h-48 bg-white p-3 shadow-lg transform -rotate-12 rounded-sm border border-gray-200 hidden md:block floating-card">
            <div class="bg-gray-200 w-full h-32 mb-3 overflow-hidden flex items-center justify-center">
                <i class="fas fa-user-friends text-gray-400 text-2xl"></i>
            </div>
            <div class="h-2 w-20 bg-gray-200 rounded"></div>
        </div>

        <div class="absolute bottom-32 right-[15%] w-48 h-56 bg-white p-4 shadow-xl transform rotate-6 rounded-sm border border-gray-200 hidden md:block floating-card delay-2000">
            <div class="bg-gray-200 w-full h-40 mb-4 overflow-hidden flex items-center justify-center">
                <i class="fas fa-camera text-gray-400 text-3xl"></i>
            </div>
            <div class="h-2 w-24 bg-gray-200 rounded"></div>
        </div>

        <div class="absolute top-1/3 right-[5%] w-32 h-32 bg-yellow-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-1/4 left-[5%] w-40 h-40 bg-orange-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse delay-1000"></div>


        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto">
            
            <span class="inline-block py-1 px-3 rounded-full bg-orange-100 text-orange-700 text-xs font-bold tracking-widest uppercase mb-6 border border-orange-200">
                Presented by Kominfo IMP
            </span>

            <h1 class="text-5xl md:text-7xl font-serif-italic font-bold mb-2 text-gray-900 leading-tight">
                Our Journey
            </h1>
            <h2 class="text-2xl md:text-3xl font-light text-gray-600 mb-8">
                In One Book
            </h2>

            <div class="h-px w-24 bg-orange-300 mx-auto mb-10"></div>

            <p class="text-4xl md:text-6xl font-black italic tracking-wider mb-8 uppercase shimmer-text">
                COMING SOON
            </p>

            <p class="text-lg md:text-xl text-gray-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                A visual tribute to the functionaries of this period. 
                Get ready to rewind our best moments, achievements, and the stories behind every smile.
            </p>

            <div class="flex justify-center gap-6">
                 <!-- Icon indicators -->
                 <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-white shadow flex items-center justify-center text-orange-500 mb-2">
                        <i class="fas fa-images"></i>
                    </div>
                    <span class="text-xs text-gray-500 font-medium">Galleries</span>
                 </div>
                 <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-white shadow flex items-center justify-center text-orange-500 mb-2">
                        <i class="fas fa-video"></i>
                    </div>
                    <span class="text-xs text-gray-500 font-medium">Recaps</span>
                 </div>
                 <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-white shadow flex items-center justify-center text-orange-500 mb-2">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    <span class="text-xs text-gray-500 font-medium">Stories</span>
                 </div>
            </div>

            <div class="mt-12 text-sm text-gray-400 italic">
                "Every picture has a story to tell."
            </div>
            
        </div>
    </main>

</div>
