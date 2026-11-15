<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #162945; text-align: center; padding: 48px; border: 8px double #39D9C1; }
        h1 { font-size: 34px; margin: 20px 0; }
        .name { font-size: 28px; font-weight: bold; margin: 24px 0; }
        .event { font-size: 20px; font-weight: bold; }
        .muted { color: #64748b; font-size: 12px; }
    </style>
</head>
<body>
    <p class="muted">UNIVents · SERTIFIKAT PARTISIPASI</p>
    <h1>SERTIFIKAT</h1>
    <p>Diberikan kepada</p>
    <p class="name">{{ $user->name }}</p>
    <p>atas partisipasi dan kehadiran dalam acara</p>
    <p class="event">{{ $event->title }}</p>
    <p>{{ $event->start_date->translatedFormat('d F Y') }} · {{ $event->location }}</p>
    <p class="muted">Nomor sertifikat: {{ $certificate->certificate_number }}</p>
    <p class="muted">{{ $event->organization->name ?? 'Penyelenggara Acara' }}</p>
</body>
</html>
