<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <tr>
            <td style="padding: 25px 30px; text-align: center; background-color: #1e40af; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                <!-- Logo with fallback text -->
                <a href="https://pey.my.id" style="text-decoration: none;">
                    <img src="https://pey.my.id/images/LOGO.png" 
                         alt="Smart Power Management Logo" 
                         width="150" 
                         height="50" 
                         style="display: block; margin: 0 auto; max-width: 150px; height: auto; border: 0;">
                </a>
            </td>
        </tr>
        <tr>
            <td style="padding: 30px;">
                <h2 style="color: #1e3a8a; font-size: 20px;">Halo, {{ $user->name ?? 'Pengguna' }} 👋</h2>

                <p style="color: #333; font-size: 16px; line-height: 1.5; margin-bottom: 20px;">
                    Yth. Pengguna <strong>Smart Power Management</strong>,
                </p>

                {{-- <p style="color: #333; font-size: 16px; line-height: 1.5;">
                    {{ $messageContent ?? 'Berikut ini adalah informasi terbaru yang kami kirimkan kepada Anda:' }}
                </p>

                <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;"> --}}

                <div style="color: #444; font-size: 16px; line-height: 1.6;">
                    {!! nl2br(e($dynamicContent ?? 'Belum ada isi.')) !!}
                </div>

                <p style="margin-top: 40px; font-size: 16px; color: #555;">
                    Hormat kami,<br>
                    <strong>Tim Smart Power Management</strong>
                </p>

                <p style="margin-top: 20px; font-size: 14px; color: #555;">
                    Terima kasih telah menggunakan layanan <strong>Smart Power Management</strong>.
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px 30px; background-color: #f1f5f9; text-align: center; font-size: 12px; color: #777; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                © {{ date('Y') }} Smart Power Management. All rights reserved.
            </td>
        </tr>
    </table>
</body>
</html>
