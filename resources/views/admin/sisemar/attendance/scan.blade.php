<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scan E-Ticket Peserta SI SEMAR') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Alert Info -->
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                            <p class="font-bold">SUCCESS</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
                            <p class="font-bold">ERROR</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif
                    @if (session('warning'))
                        <div class="mb-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
                            <p class="font-bold">ALREADY CHECKED-IN</p>
                            <p>{{ session('warning') }}</p>
                        </div>
                    @endif

                    <div class="text-center mb-6">
                        <div id="reader" width="600px"
                            class="bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 mx-auto max-w-sm">
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Arahkan scanner ke Barcode E-Ticket (dari email).</p>
                    </div>

                    <form id="scan-form" action="{{ route('admin.sisemar.attendance.checkin') }}" method="POST"
                        class="hidden">
                        @csrf
                        <input type="text" name="e_ticket_code" id="e_ticket_code">
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        const beepSound = new Audio('https://www.soundjay.com/button/beep-07.wav');
        let html5QrcodeScanner = null;

        function onScanSuccess(decodedText, decodedResult) {
            // Mainkan suara beep
            beepSound.play();

            // Isi input dan submit
            document.getElementById('e_ticket_code').value = decodedText;

            // Stop scanner agar tidak submit double
            html5QrcodeScanner.clear();

            document.getElementById('scan-form').submit();
        }

        function onScanFailure(error) {
            // handle error
        }

        document.addEventListener('DOMContentLoaded', function () {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader",
                { fps: 10, qrbox: { width: 250, height: 250 } },
                /* verbose= */ false
            );
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        });
    </script>
</x-app-layout>