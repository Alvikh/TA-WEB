<div style="text-align: center; margin-bottom: 20px;">
    <img src="https://pey.my.id/images/LOGO.png" alt="Logo" style="width: 120px;">
</div>

# Reset Password Akun Anda

Kami menerima permintaan untuk mereset password Anda. Klik tombol di bawah ini untuk melanjutkan proses pengubahan password Anda:

@component('mail::button', ['url' => $actionUrl, 'color' => 'primary'])
Reset Password
@endcomponent

Jika Anda tidak pernah meminta reset password, abaikan saja email ini. Password Anda tetap aman.

Terima kasih,<br>
**{{ config('app.name') }} Team**
