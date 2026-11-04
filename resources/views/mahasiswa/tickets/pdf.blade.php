<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Tiket {{ $ticket->ticket_code }}</title>
    <style>
        @page { margin: 28px; }
        body { font-family: DejaVu Sans, sans-serif; color: #162945; font-size: 12px; }
        .wrap { border: 2px solid #162945; border-radius: 12px; overflow: hidden; }
        .head { background: #162945; color: #ffffff; padding: 18px 24px; border-bottom: 4px solid #39D9C1; }
        .head .brand { font-size: 20px; font-weight: bold; }
        .head .brand span { color: #39D9C1; }
        .head .sub { font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: #cbd5e1; margin-top: 4px; }
        .body { padding: 22px 24px; }
        .cat { display: inline-block; background: #162945; color: #fff; padding: 3px 10px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .ok { display: inline-block; background: #39D9C1; color: #162945; padding: 3px 10px; border-radius: 4px; font-size: 10px; font-weight: bold; margin-left: 6px; }
        h1 { font-size: 22px; margin: 10px 0 16px; line-height: 1.3; }
        table.info { width: 100%; border-collapse: collapse; }
        table.info td { padding: 7px 0; vertical-align: top; border-bottom: 1px solid #e2e8f0; }
        table.info td.label { width: 28%; color: #64748b; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; }
        table.info td.value { font-weight: bold; }
        .org { border-left: 4px solid #FCCC6B; padding-left: 8px; }
        .qr { text-align: center; padding: 18px 24px 8px; border-top: 2px dashed #94a3b8; }
        .qr img { width: 200px; height: 200px; }
        .code { font-family: DejaVu Sans Mono, monospace; font-size: 18px; font-weight: bold; letter-spacing: 2px; margin-top: 6px; color: #F45D69; }
        .note { text-align: center; color: #64748b; font-size: 10px; padding: 4px 24px 18px; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="head">
            <div class="brand">Uni<span>vents</span></div>
            <div class="sub">E-Tiket Resmi Acara Kampus</div>
        </div>

        <div class="body">
            <span class="cat">{{ $event->category->name }}</span><span class="ok">TERVERIFIKASI</span>
            <h1>{{ $event->title }}</h1>

            <table class="info">
                <tr><td class="label">Pemegang Tiket</td><td class="value">{{ $user->name }}@if($user->npm) ({{ $user->npm }})@endif</td></tr>
                <tr><td class="label">Tanggal</td><td class="value">{{ $event->start_date->translatedFormat('l, d F Y') }}</td></tr>
                <tr><td class="label">Waktu</td><td class="value">{{ $event->start_date->format('H:i') }} - {{ $event->end_date->format('H:i') }} WIB</td></tr>
                <tr><td class="label">Lokasi</td><td class="value">{{ $event->location }}</td></tr>
                <tr><td class="label">Penyelenggara</td><td class="value"><div class="org">{{ $event->organization->name }}</div></td></tr>
                <tr><td class="label">Terbit</td><td class="value">{{ $ticket->created_at->translatedFormat('d F Y, H:i') }} WIB</td></tr>
            </table>
        </div>

        <div class="qr">
            <img src="{{ $qr }}" alt="QR Code">
            <div class="code">{{ $ticket->ticket_code }}</div>
        </div>
        <div class="note">
            Tunjukkan QR Code ini kepada panitia saat check-in. Tiket hanya berlaku satu kali dan tidak dapat dipindahtangankan.
        </div>
    </div>
</body>
</html>