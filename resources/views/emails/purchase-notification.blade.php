<!DOCTYPE html>
<html>

<head>
    <title>Pembelian Baru - Notifikasi</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(to right, #0369a1, #0c4a6e);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .content {
            padding: 30px 20px;
            background-color: #f9fafb;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .info-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-table tr:last-child td {
            border-bottom: none;
        }

        .info-table td:first-child {
            width: 35%;
            font-weight: bold;
            color: #374151;
            background-color: #f9fafb;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.875em;
            font-weight: 600;
        }

        .badge-pending {
            background-color: #fef3c7;
            color: #d97706;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-size: 0.9em;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(to right, #0369a1, #0c4a6e);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Pembelian Baru</h1>
        <p>Ada user yang melakukan pembelian course</p>
    </div>

    <div class="content">
        <p>Halo Admin,</p>

        <p>Pembelian baru telah dilakukan. Berikut detail pembeliannya:</p>

        <table class="info-table">
            <tr>
                <td>ID Pembelian:</td>
                <td>#{{ $purchase->id }}</td>
            </tr>
            <tr>
                <td>Nama User:</td>
                <td>{{ $purchase->user->name }}</td>
            </tr>
            <tr>
                <td>Email User:</td>
                <td>{{ $purchase->user->email }}</td>
            </tr>
            <tr>
                <td>Course:</td>
                <td>
                    <strong>{{ $purchase->course->title }}</strong><br>
                    @if($purchase->course->description)
                        <small style="color: #6b7280;">{{ \Illuminate\Support\Str::limit($purchase->course->description, 100) }}</small>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Jumlah:</td>
                <td><strong style="color: #0369a1;">Rp {{ number_format($purchase->amount, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td>Status:</td>
                <td><span class="badge badge-pending">{{ ucfirst($purchase->status) }}</span></td>
            </tr>
            <tr>
                <td>Tanggal Pembelian:</td>
                <td>{{ $purchase->created_at->format('d M Y H:i') }}</td>
            </tr>
            <tr>
                <td>Batas Pembayaran:</td>
                <td>{{ $purchase->expired_at ? $purchase->expired_at->format('d M Y H:i') : '-' }}</td>
            </tr>

            @if($purchase->sender_name)
            <tr>
                <td>Nama Pengirim:</td>
                <td>{{ $purchase->sender_name }}</td>
            </tr>
            @endif

            @if($purchase->sender_bank)
            <tr>
                <td>Bank Pengirim:</td>
                <td>{{ $purchase->sender_bank }}</td>
            </tr>
            @endif

            @if($purchase->transfer_date)
            <tr>
                <td>Tanggal Transfer:</td>
                <td>{{ $purchase->transfer_date }}</td>
            </tr>
            @endif
        </table>

        @if($purchase->proof_image)
        <p><strong>Bukti Transfer:</strong><br>
        <a href="{{ asset('storage/' . $purchase->proof_image) }}" target="_blank" style="color: #0369a1;">Lihat Bukti Transfer</a>
        </p>
        @endif

        @if($purchase->whatsapp_number)
        <p><strong>Nomor WhatsApp:</strong> {{ $purchase->whatsapp_number }}</p>
        @endif

        @if($purchase->notes)
        <p><strong>Catatan:</strong><br>{{ $purchase->notes }}</p>
        @endif

        <p style="margin-top: 30px;">Silakan review pembelian ini dan lakukan konfirmasi jika pembayaran sudah valid.</p>

        <a href="{{ url('/admin/purchases/' . $purchase->id) }}" class="button">
            Review Pembelian
        </a>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>

</html>
