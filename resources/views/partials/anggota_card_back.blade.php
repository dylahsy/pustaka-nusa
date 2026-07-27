@php
    $anggotaCard = $anggotaCard ?? [];
    $backTitleTop = $anggotaCard['back_title_top'] ?? 'Peraturan Perpustakaan';
    $backTitleBottom = $anggotaCard['back_title_bottom'] ?? 'SMA Negeri 9 Kota Jambi';
    $rules = $anggotaCard['rules'] ?? [
        'Kartu wajib dibawa saat peminjaman buku.',
        'Jaga ketertiban dan kebersihan perpustakaan.',
        'Buku harus dikembalikan sesuai batas waktu.',
        'Dilarang merusak atau menghilangkan buku.',
        'Kehilangan buku menjadi tanggung jawab peminjam.',
        'Kartu tidak boleh dipindahtangankan.',
    ];
@endphp

<div class="library-card card-back">
    <h3 class="card-back-title">
        <span>{{ $backTitleTop }}</span>
        <span>{{ $backTitleBottom }}</span>
    </h3>

    <div class="card-rule"></div>

    <ol class="library-rules">
        @foreach($rules as $rule)
            <li>{{ $rule }}</li>
        @endforeach
    </ol>
</div>
