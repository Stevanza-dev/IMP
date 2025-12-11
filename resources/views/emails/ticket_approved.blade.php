<!DOCTYPE html>
<html>
<head>
    <title>Tiket AMPERA 2026</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
        
        <h2 style="color: #16a34a; text-align: center;">Selamat, Pendaftaran Diterima!</h2>
        
        <p>Halo <strong>{{ $registration->name }}</strong>,</p>
        
        <p>Terima kasih telah mendaftar acara <strong>AMPERA 2026</strong>. Pembayaran Anda telah kami verifikasi.</p>
        
        <div style="background-color: #f3f4f6; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p style="margin: 0;"><strong>Kode Tiket:</strong></p>
            <h1 style="margin: 5px 0; letter-spacing: 2px;">{{ $registration->ticket_code }}</h1>
            <p style="margin: 0; font-size: 12px; color: #666;">Tunjukkan kode ini saat registrasi ulang.</p>
        </div>

        <p>Silakan klik tombol di bawah ini untuk melihat detail tiket dan Barcode QR Anda:</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/cek-tiket?search=' . $registration->ticket_code) }}" 
               style="background-color: #16a34a; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
               Lihat E-Tiket Saya
            </a>
        </div>

        <p>Sampai jumpa di lokasi!</p>
        <hr style="border: none; border-top: 1px solid #eee;">
        <p style="font-size: 12px; color: #888;">Panitia AMPERA 2026 - Ikatan Mahasiswa Pati</p>
    </div>
</body>
</html>