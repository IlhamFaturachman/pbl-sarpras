<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Akun Anda Telah Diaktifkan</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9f9f9; padding: 30px;">
    <div style="max-width: 600px; margin: auto; background-color: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div style="background-color: #4CAF50; color: white; padding: 20px 30px;">
            <h2 style="margin: 0;">🎉 Selamat! Akun Anda Aktif</h2>
        </div>

        <div style="padding: 30px;">
            <p style="font-size: 16px;">Halo <strong>{{ $user->nama_lengkap }}</strong>,</p>

            <p style="font-size: 15px; color: #333;">
                Kami dengan senang hati memberi tahu bahwa akun Anda dengan email 
                <strong>{{ $user->email }}</strong> telah <span style="color: #4CAF50; font-weight: bold;">diaktifkan</span>.
            </p>

            <p style="font-size: 15px;">Anda sekarang dapat login dan mulai menggunakan layanan kami.</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/login') }}" style="background-color: #4CAF50; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-size: 16px;">
                    🔐 Login Sekarang
                </a>
            </div>

            <p style="font-size: 14px; color: #777;">Jika Anda merasa tidak melakukan pendaftaran, abaikan email ini.</p>

            <p style="font-size: 15px; margin-top: 40px;">Terima kasih,<br><strong>Tim Silaprak</strong></p>
        </div>

        <div style="background-color: #f0f0f0; color: #888; text-align: center; padding: 15px; font-size: 12px;">
            &copy; {{ date('Y') }} Silaprak System. All rights reserved.
        </div>
    </div>
</body>
</html>
