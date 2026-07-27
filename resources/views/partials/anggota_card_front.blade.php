@php
    $anggotaCard = $anggotaCard ?? [];
    $rows = $anggotaCard['rows'] ?? [];
    $photo = $anggotaCard['photo'] ?? null;
    $photoAlt = $anggotaCard['photo_alt'] ?? 'Foto anggota';
    $initial = $anggotaCard['initial'] ?? 'A';
    $titleTop = $anggotaCard['title_top'] ?? 'Kartu Tanda Anggota Perpustakaan';
    $titleBottom = $anggotaCard['title_bottom'] ?? 'SMA Negeri 9 Kota Jambi';
    $logoLeft = $anggotaCard['logo_left'] ?? asset('templateperpus/img/logo_sepucuk_jambi_transparent.png');
    $logoRight = $anggotaCard['logo_right'] ?? asset('templateperpus/img/logo_ungu_smanes_transparent.png');
    $note = $anggotaCard['note'] ?? 'Kartu ini dapat digunakan untuk administrasi perpustakaan.';
    $photoSlotId = $anggotaCard['photo_slot_id'] ?? null;
@endphp

<div class="library-card">
    <div class="card-head">
        <img src="{{ $logoLeft }}" alt="Logo Sepucuk Jambi">
        <h2 class="card-title">
            <span>{{ $titleTop }}</span>
            <span>{{ $titleBottom }}</span>
        </h2>
        <img src="{{ $logoRight }}" alt="Logo SMA Negeri 9 Kota Jambi">
    </div>

    <div class="card-rule"></div>

    <div class="card-body-area">
        <div class="card-data">
            @foreach($rows as $row)
                <div class="card-row">
                    <span class="card-label">{{ $row['label'] ?? '' }}</span>
                    <span class="card-colon">:</span>
                    <strong class="card-value {{ $row['class'] ?? '' }}">{{ $row['value'] ?? '-' }}</strong>
                </div>
            @endforeach
        </div>

        <div class="card-photo-slot" @if($photoSlotId) id="{{ $photoSlotId }}" @endif>
            @if($photo)
                <img src="{{ $photo }}" alt="{{ $photoAlt }}" class="anggota-photo">
            @else
                <div class="anggota-photo-placeholder">{{ $initial }}</div>
            @endif
        </div>
    </div>

    <div class="card-note-rule"></div>
    <p class="card-note">{{ $note }}</p>
</div>
