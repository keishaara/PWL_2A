<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Tiket {{ $ticket->ticket_code }}</title>
    @php
        // logo di-embed base64 supaya pasti muncul di PDF
        $logoPath = public_path('images/logo-ticket.png');
        $logo = is_file($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        $isUsed  = $ticket->status === 'used';
        $price   = $event->isPaid() ? 'Rp ' . number_format((float) $event->price, 0, ',', '.') : 'Gratis';
        $sameDay = $event->start_date->isSameDay($event->end_date);
        $title    = \Illuminate\Support\Str::limit($event->title, 100);
        $location = \Illuminate\Support\Str::limit($event->location, 75);
        $holder   = \Illuminate\Support\Str::limit($user->name, 32);
        $titleSize = strlen($event->title) > 70 ? 16 : (strlen($event->title) > 40 ? 21 : 26);
    @endphp
    <style>
        @page { margin: 0; size: 841.89pt 595.28pt; }
        * { margin: 0; padding: 0; }
        body { font-family: DejaVu Sans, sans-serif; color: #162945; background: #F3EFE8; }

        .page { position: relative; width: 841.89pt; height: 595.28pt; background: #F3EFE8; }

        /* tiket */
        .ticket { position: absolute; left: 36pt; top: 40pt; width: 770pt; height: 396pt; }

        .stripe { position: absolute; left: 0; top: 0; width: 770pt; height: 7pt; }
        .stripe div { float: left; height: 7pt; }

        .main { position: absolute; left: 0; top: 0; width: 556pt; height: 396pt; background: #ffffff;
                border-top-left-radius: 16pt; border-bottom-left-radius: 16pt; }
        .stub { position: absolute; left: 556pt; top: 0; width: 214pt; height: 396pt; background: #162945;
                border-top-right-radius: 16pt; border-bottom-right-radius: 16pt; }

        /* lubang sobekan */
        .notch { position: absolute; width: 28pt; height: 28pt; background: #F3EFE8; border-radius: 14pt; }
        .perf { position: absolute; left: 555pt; top: 22pt; height: 352pt; border-left: 2pt dashed #94a3b8; }

        /*main */
        .m-inner { position: absolute; left: 30pt; top: 26pt; width: 496pt; }
        table { border-collapse: collapse; }
        .head td { vertical-align: middle; }
        .logo { height: 30pt; }
        .etix { text-align: right; font-size: 8pt; font-weight: bold; letter-spacing: 3pt; color: #94a3b8; }

        .badges { margin-top: 20pt; }
        .badge { display: inline-block; padding: 3pt 9pt; border-radius: 4pt; font-size: 7.5pt; font-weight: bold; letter-spacing: 0.5pt; text-transform: uppercase; }
        .b-cat  { background: #162945; color: #ffffff; }
        .b-ok   { background: #39D9C1; color: #0e2a2a; margin-left: 4pt; }
        .b-used { background: #F45D69; color: #ffffff; margin-left: 4pt; }
        .b-free { background: #FCCC6B; color: #5b4300; margin-left: 4pt; }

        .title { font-weight: bold; line-height: 1.25; margin-top: 11pt; color: #162945; }

        .grid { width: 496pt; margin-top: 15pt; }
        .grid td { vertical-align: top; padding: 0 12pt 11pt 0; }
        .lbl { font-size: 6.5pt; font-weight: bold; letter-spacing: 1.4pt; text-transform: uppercase; color: #94a3b8; margin-bottom: 3pt; }
        .val { font-size: 10pt; font-weight: bold; line-height: 1.35; color: #162945; }
        .val small { display: block; font-size: 8pt; font-weight: normal; color: #64748b; margin-top: 1pt; }
        .accent { border-left: 3pt solid #FCCC6B; padding-left: 7pt; }

        /* stub */
        .s-inner { position: absolute; top: 0; width: 214pt; text-align: center; }
        .admit { margin-top: 44pt; font-size: 7pt; font-weight: bold; letter-spacing: 4pt; color: #FCCC6B; }
        .admit-sub { font-size: 6.5pt; letter-spacing: 1.5pt; color: #94a3b8; margin-top: 3pt; text-transform: uppercase; }
        .qr-tile { width: 122pt; height: 122pt; margin: 16pt auto 0; background: #ffffff; border-radius: 10pt; padding: 8pt; }
        .qr-tile img { width: 122pt; height: 122pt; }
        .code-lbl { margin-top: 15pt; font-size: 6.5pt; letter-spacing: 2pt; color: #94a3b8; text-transform: uppercase; }
        .code { font-family: DejaVu Sans Mono, monospace; font-size: 15pt; font-weight: bold; letter-spacing: 1.5pt; color: #39D9C1; margin-top: 3pt; }
        .scan { margin-top: 12pt; font-size: 7pt; color: #cbd5e1; line-height: 1.5; }
        .used-stamp { margin: 10pt auto 0; width: 120pt; padding: 3pt 0; border: 1.5pt solid #F45D69; border-radius: 4pt; color: #F45D69; font-size: 8pt; font-weight: bold; letter-spacing: 2pt; }

        /* bawah */
        .info { position: absolute; left: 36pt; top: 460pt; width: 770pt; }
        .info td { vertical-align: top; width: 33.33%; padding-right: 22pt; }
        .info .t { font-size: 8pt; font-weight: bold; color: #162945; margin-bottom: 4pt; }
        .info .t span { color: #F45D69; }
        .info .d { font-size: 7.5pt; color: #64748b; line-height: 1.55; }

        .foot { position: absolute; left: 36pt; top: 552pt; width: 770pt; border-top: 1pt solid #d9d3c7; font-size: 7pt; color: #94a3b8; }
        .foot td { padding-top: 9pt; }
        .foot td.r { text-align: right; }
    </style>
</head>
<body>
<div class="page">

    <div class="ticket">

        <div class="main"></div>
        <div class="stub"></div>

        <!-- strip warna -->
        <div class="stripe">
            <div style="width:556pt; background:#F45D69; border-top-left-radius:16pt;"></div>
            <div style="width:80pt; background:#39D9C1;"></div>
            <div style="width:134pt; background:#FCCC6B; border-top-right-radius:16pt;"></div>
        </div>

        <!-- lubang sobekan + garis putus -->
        <div class="perf"></div>
        <div class="notch" style="left:542pt; top:-14pt;"></div>
        <div class="notch" style="left:542pt; top:382pt;"></div>

        <!-- isi kiri -->
        <div class="m-inner">
            <table class="head" width="496pt">
                <tr>
                    <td>@if($logo)<img class="logo" src="{{ $logo }}" alt="Univents">@else<b>Univents</b>@endif</td>
                    <td class="etix">E-TICKET</td>
                </tr>
            </table>

            <div class="badges">
                <span class="badge b-cat">{{ $event->category->name ?? 'Acara' }}</span>
                @if($isUsed)
                    <span class="badge b-used">Sudah Digunakan</span>
                @else
                    <span class="badge b-ok">Aktif &bull; Terverifikasi</span>
                @endif
                <span class="badge b-free">{{ $price }}</span>
            </div>

            <div class="title" style="font-size: {{ $titleSize }}pt;">{{ $title }}</div>

            <table class="grid">
                <tr>
                    <td width="50%">
                        <div class="lbl">Tanggal</div>
                        <div class="val">{{ $event->start_date->translatedFormat('l, d F Y') }}
                            @unless($sameDay)<small>s/d {{ $event->end_date->translatedFormat('d F Y') }}</small>@endunless
                        </div>
                    </td>
                    <td width="50%">
                        <div class="lbl">Waktu</div>
                        <div class="val">{{ $event->start_date->format('H:i') }} &ndash; {{ $event->end_date->format('H:i') }} WIB</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="lbl">Lokasi</div>
                        <div class="val">{{ $location }}</div>
                    </td>
                    <td>
                        <div class="lbl">Penyelenggara</div>
                        <div class="val accent">{{ $event->organization->name ?? '-' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="lbl">Pemegang Tiket</div>
                        <div class="val">{{ $holder }}@if($user->npm)<small>NPM {{ $user->npm }}</small>@endif</div>
                    </td>
                    <td>
                        <div class="lbl">Diterbitkan</div>
                        <div class="val">{{ $ticket->created_at->translatedFormat('d F Y') }}<small>{{ $ticket->created_at->format('H:i') }} WIB</small></div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- isi stub -->
        <div class="s-inner" style="left:556pt;">
            <div class="admit">ADMIT ONE</div>
            <div class="admit-sub">Tiket Masuk &bull; 1 Orang</div>

            <div class="qr-tile"><img src="{{ $qr }}" alt="QR Code"></div>

            <div class="code-lbl">Kode Tiket</div>
            <div class="code">{{ $ticket->ticket_code }}</div>

            @if($isUsed)
                <div class="used-stamp">CHECKED-IN</div>
            @else
                <div class="scan">Scan QR ini di meja<br>registrasi untuk check-in</div>
            @endif
        </div>
    </div>

    <!-- ketentuan -->
    <table class="info" cellspacing="0">
        <tr>
            <td>
                <div class="t"><span>01</span> &nbsp;Check-in</div>
                <div class="d">Tunjukkan QR Code ini (dari layar atau hasil cetak) kepada panitia saat tiba di lokasi. Disarankan hadir 15 menit sebelum acara dimulai.</div>
            </td>
            <td>
                <div class="t"><span>02</span> &nbsp;Sekali pakai</div>
                <div class="d">Satu tiket hanya berlaku untuk satu orang dan satu kali masuk. Tiket yang sudah di-scan tidak dapat digunakan kembali.</div>
            </td>
            <td>
                <div class="t"><span>03</span> &nbsp;Jangan disebarkan</div>
                <div class="d">Tiket bersifat pribadi dan tidak dapat dipindahtangankan. Jaga kerahasiaan QR Code dan kode tiket agar tidak disalahgunakan.</div>
            </td>
        </tr>
    </table>

    <table class="foot" cellspacing="0">
        <tr>
            <td>Dokumen ini dibuat otomatis oleh sistem Univents dan sah tanpa tanda tangan.</td>
            <td class="r">{{ $ticket->ticket_code }} &nbsp;&bull;&nbsp; univents</td>
        </tr>
    </table>
</div>
</body>
</html>
