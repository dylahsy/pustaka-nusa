@php
    $anggotaCard = $anggotaCard ?? [];
@endphp

<div class="library-card-wrap">
    <div class="card-side">
        @include('partials.anggota_card_front', ['anggotaCard' => $anggotaCard])
    </div>

    <div class="card-side">
        @include('partials.anggota_card_back', ['anggotaCard' => $anggotaCard])
    </div>
</div>
