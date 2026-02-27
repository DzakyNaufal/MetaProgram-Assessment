<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran - {{ config('app.name') }}</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9fafb;">
    <!-- Header -->
    <div style="background: linear-gradient(135deg, #0369a1 0%, #0c4a6e 100%); color: white; padding: 30px 20px; text-align: center; border-radius: 12px 12px 0 0;">
        <div style="font-size: 36px; margin-bottom: 10px;">🎉</div>
        <h1 style="margin: 0; font-size: 24px;">Pembayaran Berhasil Dikonfirmasi!</h1>
        <p style="margin: 10px 0 0 0; opacity: 0.9;">Terima kasih telah melakukan pembelian</p>
    </div>

    <!-- Content -->
    <div style="padding: 30px; background-color: #ffffff; border: 1px solid #e5e7eb; border-top: none;">
        <!-- Greeting -->
        <p style="font-size: 16px;">Halo <strong>{{ $purchase->user->name }}</strong>,</p>

        <p style="color: #059669; background-color: #ecfdf5; padding: 15px; border-radius: 8px; border-left: 4px solid #059669; margin: 20px 0;">
            <strong>Kabar baik!</strong> Pembayaran Anda telah berhasil dikonfirmasi. Anda sekarang memiliki akses penuh ke course yang dibeli.
        </p>

        <!-- Purchase Details -->
        <h2 style="color: #0369a1; border-bottom: 2px solid #0369a1; padding-bottom: 10px; margin-top: 30px;">Detail Pembelian</h2>

        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr>
                <td style="padding: 12px 10px; border-bottom: 1px solid #e5e7eb; font-weight: bold; color: #6b7280; width: 40%;">No. Transaksi:</td>
                <td style="padding: 12px 10px; border-bottom: 1px solid #e5e7eb;"><strong>#INV-{{ str_pad($purchase->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 12px 10px; border-bottom: 1px solid #e5e7eb; font-weight: bold; color: #6b7280;">Nama:</td>
                <td style="padding: 12px 10px; border-bottom: 1px solid #e5e7eb;">{{ $purchase->user->name }}</td>
            </tr>
            <tr>
                <td style="padding: 12px 10px; border-bottom: 1px solid #e5e7eb; font-weight: bold; color: #6b7280;">Email:</td>
                <td style="padding: 12px 10px; border-bottom: 1px solid #e5e7eb;">{{ $purchase->user->email }}</td>
            </tr>
            <tr>
                <td style="padding: 12px 10px; border-bottom: 1px solid #e5e7eb; font-weight: bold; color: #6b7280;">Course:</td>
                <td style="padding: 12px 10px; border-bottom: 1px solid #e5e7eb;">
                    <strong>{{ $purchase->course->title }}</strong>
                </td>
            </tr>
            <tr>
                <td style="padding: 12px 10px; border-bottom: 1px solid #e5e7eb; font-weight: bold; color: #6b7280;">Metode Pembayaran:</td>
                <td style="padding: 12px 10px; border-bottom: 1px solid #e5e7eb;">{{ $purchase->payment_method ?? 'Transfer Bank' }}</td>
            </tr>
            <tr>
                <td style="padding: 12px 10px; border-bottom: 1px solid #e5e7eb; font-weight: bold; color: #6b7280;">Total Bayar:</td>
                <td style="padding: 12px 10px; border-bottom: 1px solid #e5e7eb; color: #0369a1; font-size: 18px; font-weight: bold;">Rp {{ number_format($purchase->amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="padding: 12px 10px; border-bottom: 1px solid #e5e7eb; font-weight: bold; color: #6b7280;">Tanggal Pembelian:</td>
                <td style="padding: 12px 10px; border-bottom: 1px solid #e5e7eb;">{{ $purchase->created_at->format('d F Y H:i') }} WIB</td>
            </tr>
            <tr>
                <td style="padding: 12px 10px; font-weight: bold; color: #6b7280;">Tanggal Konfirmasi:</td>
                <td style="padding: 12px 10px; color: #059669; font-weight: bold;">{{ $purchase->updated_at->format('d F Y H:i') }} WIB</td>
            </tr>
        </table>

        <!-- Course Features -->
        @if ($purchase->course->has_whatsapp_consultation || $purchase->course->has_offline_coaching)
        <h2 style="color: #0369a1; border-bottom: 2px solid #0369a1; padding-bottom: 10px; margin-top: 30px;">Fitur Course</h2>
        <ul style="margin: 15px 0; padding-left: 20px; list-style: none;">
            <li style="padding: 8px 0;">✅ Akses seumur hidup ke course</li>
            <li style="padding: 8px 0;">✅ {{ $purchase->course->questions_count ?? 255 }} pertanyaan asesmen</li>
            <li style="padding: 8px 0;">✅ Laporan hasil lengkap</li>
            @if ($purchase->course->has_whatsapp_consultation)
            <li style="padding: 8px 0;">✅ Konsultasi via WhatsApp</li>
            @endif
            @if ($purchase->course->has_offline_coaching)
            <li style="padding: 8px 0;">✅ Sesi Coaching Offline dengan Expert</li>
            @endif
        </ul>
        @endif

        <!-- Next Steps -->
        <h3 style="color: #0369a1; margin-top: 30px;">Langkah Selanjutnya</h3>
        <ol style="margin: 15px 0; padding-left: 20px;">
            <li style="margin-bottom: 10px;">Login ke akun Anda di <a href="{{ url('https://jasaeksekutif.com/login') }}" style="color: #0369a1;">{{ config('app.name') }}</a></li>
            <li style="margin-bottom: 10px;">Buka menu <strong>"Courses"</strong></li>
            <li style="margin-bottom: 10px;">Pilih course <strong>"{{ $purchase->course->title }}"</strong></li>
            <li style="margin-bottom: 10px;">Mulai mengerjakan pertanyaan asesmen</li>
            <li>Lihat hasil lengkap dengan grafik interaktif</li>
        </ol>

        <!-- CTA Button -->
        <div style="text-align: center; margin: 40px 0 30px 0;">
            <a href="{{ route('courses.show', $purchase->course->slug) }}"
               style="display: inline-block; padding: 15px 30px; background: linear-gradient(135deg, #0369a1 0%, #0c4a6e 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                🚀 Mulai Kerjakan Course Sekarang
            </a>
        </div>

        <!-- Support Info -->
        <div style="background-color: #f3f4f6; padding: 20px; border-radius: 8px; margin-top: 30px;">
            <p style="margin: 0 0 10px 0; font-weight: bold;">Butuh Bantuan?</p>
            <p style="margin: 0; font-size: 14px; color: #6b7280;">Jika Anda mengalami kendala atau memiliki pertanyaan, jangan ragu untuk menghubungi tim support kami.</p>
        </div>

        <!-- Closing -->
        <p style="margin-top: 30px;">Salam hangat,</p>
        <p style="margin: 0; font-weight: bold; color: #0369a1;">Tim {{ config('app.name') }}</p>
    </div>

    <!-- Footer -->
    <div style="text-align: center; padding: 20px; color: #6b7280; font-size: 12px; background-color: #f9fafb; border-radius: 0 0 12px 12px;">
        <p style="margin: 5px 0;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        <p style="margin: 5px 0;">Email ini dikirim secara otomatis sebagai bukti pembayaran yang sah.</p>
        <p style="margin: 5px 0;">Silakan simpan email ini sebagai arsip pembelian Anda.</p>
    </div>
</body>

</html>
