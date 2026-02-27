<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Ditolak</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #fee2e2; color: #991b1b; padding: 30px 20px; text-align: center; border-radius: 8px 8px 0 0;">
        <h1 style="margin: 0; font-size: 24px;">Pembayaran Ditolak</h1>
    </div>

    <div style="padding: 30px; background-color: #ffffff; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 8px 8px;">
        <p>Halo <strong>{{ $purchase->user->name }}</strong>,</p>

        <p>Maaf, bukti pembayaran Anda untuk Pembelian #{{ $purchase->id }} telah ditinjau dan ditolak.</p>

        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Course:</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">
                    <strong>{{ $purchase->course->title }}</strong>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Jumlah:</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">Rp {{ number_format($purchase->amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Alasan Penolakan:</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; color: #dc2626;">{{ $reason ?? 'Tidak ada alasan spesifik' }}</td>
            </tr>
        </table>

        <p><strong>Yang dapat Anda lakukan:</strong></p>
        <ul style="margin: 15px 0; padding-left: 20px;">
            <li>Review alasan penolakan di atas</li>
            <li>Hubungi tim support kami jika Anda yakin ini adalah kesalahan</li>
            <li>Upload ulang bukti pembayaran dengan informasi yang lebih jelas</li>
        </ul>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('purchases.index') }}"
               style="display: inline-block; padding: 12px 24px; background: linear-gradient(to right, #0369a1, #0c4a6e); color: white; text-decoration: none; border-radius: 6px; font-weight: bold;">
                Lihat Pembelian Saya
            </a>
        </div>

        <p>Jika Anda memiliki pertanyaan atau membutuhkan bantuan, jangan ragu untuk menghubungi tim support kami.</p>

        <p style="margin-top: 30px;">Salam,<br>Tim {{ config('app.name') }}</p>
    </div>

    <div style="text-align: center; padding: 20px; color: #6b7280; font-size: 12px;">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
    </div>
</body>

</html>
