<!DOCTYPE html>
<html>

<head>
    <title>E-Ticket SI SEMAR 2026</title>
</head>

<body
    style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f0f9ff; margin: 0; padding: 20px;">
    <div
        style="max-width: 600px; margin: 0 auto; background-color: #fff; border: 1px solid #bae6fd; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">

        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="color: #1e40af; margin-top: 0; font-size: 24px;">Selamat, Pendaftaran Diterima!</h2>
        </div>

        <p>Halo <strong>{{ $sisemar->name }}</strong>,</p>

        <p>Selamat! Pendaftaran Anda untuk acara <strong>SI SEMAR 2026</strong> telah kami setujui. Anda sekarang resmi
            menjadi peserta.</p>

        <div
            style="background-color: #eff6ff; padding: 20px; border-radius: 8px; margin: 25px 0; border-left: 5px solid #2563eb;">
            <p style="margin: 0; font-size: 14px; text-transform: uppercase; color: #64748b; font-weight: bold;">Kode
                E-Ticket Anda:</p>
            <h1 style="margin: 10px 0; letter-spacing: 2px; color: #1e3a8a; font-size: 32px;">
                {{ $sisemar->e_ticket_code }}
            </h1>
            <p style="margin: 0; font-size: 13px; color: #64748b;">Simpan kode ini baik-baik.</p>
        </div>

        <p><strong>Pilihan Jurusan:</strong></p>
        <ul style="background-color: #f8fafc; padding: 15px 30px; border-radius: 8px; margin-top: 5px;">
            <li style="margin-bottom: 5px;"><strong>Pilihan 1:</strong> {{ $sisemar->major_preference_1 }}</li>
            <li><strong>Pilihan 2:</strong> {{ $sisemar->major_preference_2 }}</li>
        </ul>

        <p>Silakan klik tombol di bawah ini untuk melihat detail tiket dan <strong>QR Code</strong> Anda. QR Code ini
            wajib ditunjukkan kepada panitia saat <strong>Penukaran Tiket</strong>.</p>

        <div style="text-align: center; margin: 35px 0;">
            <a href="{{ route('sisemar.ticket.check', ['search' => $sisemar->e_ticket_code]) }}"
                style="background-color: #2563eb; color: white; padding: 14px 28px; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 16px; display: inline-block; box-shadow: 0 4px 6px rgba(37, 99, 235, 0.3);">
                Lihat E-Tiket Saya
            </a>
        </div>

        <p>Sampai jumpa di lokasi acara! Bersiaplah meraih impianmu.</p>

        <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;">

        <div style="text-align: center; color: #94a3b8; font-size: 12px;">
            <p>&copy; 2026 Panitia SI SEMAR - Ikatan Mahasiswa Pati</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>

</html>