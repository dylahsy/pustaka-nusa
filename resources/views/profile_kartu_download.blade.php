<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kartu Profil</title>

  @include('partials.anggota_card_styles')
  @php
      $anggotaCard = $anggotaCard ?? [];
  @endphp

  <style>
    @page {
      size: A4 landscape;
      margin: 12mm 14mm;
    }

    body {
      margin: 0;
      min-height: 100vh;
      background: #ffffff;
      font-family: Arial, Helvetica, sans-serif;
    }

    .download-page {
      min-height: 100vh;
      padding: 0;
    }

    .download-shell {
      width: 100%;
      max-width: none;
    }

    .anggota-card-shell {
      width: 100%;
    }

    .library-card-wrap {
      display: table;
      width: 100%;
      border-collapse: separate;
      border-spacing: 12mm 0;
    }

    .card-side {
      display: table-cell;
      width: 50%;
      vertical-align: top;
      text-align: center;
    }

    .library-card {
      width: 85.6mm;
      height: 54mm;
      position: relative;
      overflow: hidden;
      border-radius: 8px;
      border: 1.5px solid #6d28d9;
      background:
        radial-gradient(circle at 90% 10%, rgba(216, 180, 254, 0.5) 0 22%, transparent 23%),
        radial-gradient(circle at 8% 92%, rgba(191, 219, 254, 0.55) 0 26%, transparent 27%),
        linear-gradient(135deg, #ffffff 0%, #fbf7ff 42%, #ede9fe 72%, #ddd6fe 100%);
      box-shadow: 0 18px 38px rgba(76, 29, 149, 0.18);
      color: #111827;
      padding: 8px 10px;
      margin: 0 auto;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .card-head {
      display: block;
      position: relative;
      min-height: 38px;
      padding: 0 38px;
      text-align: center;
    }

    .card-head img {
      position: absolute;
      top: 0;
      width: 35px;
      height: 35px;
      object-fit: contain;
      filter: drop-shadow(0 1px 1px rgba(49, 46, 129, 0.16));
    }

    .card-head img:first-child {
      left: 0;
    }

    .card-head img:last-child {
      right: 0;
    }

    .card-title {
      margin: 0;
      text-align: center;
      font-family: "Arial Narrow", Arial, Helvetica, sans-serif;
      font-size: 10.5px;
      line-height: 1.18;
      font-weight: 900;
      text-transform: uppercase;
      color: #2e1065;
      text-shadow: 0 1px 0 rgba(255, 255, 255, 0.85);
    }

    .card-title span {
      display: block;
    }

    .card-rule {
      height: 2px;
      margin: 5px 0 7px;
      background: linear-gradient(90deg, #4c1d95, #8b5cf6 52%, #4c1d95);
      border-radius: 99px;
      position: relative;
      z-index: 1;
    }

    .card-body-area {
      display: table;
      width: 100%;
      table-layout: fixed;
      margin-top: 20px;
      position: relative;
      z-index: 1;
    }

    .card-data {
      display: table-cell;
      vertical-align: top;
      width: auto;
      font-size: 8.4px;
      line-height: 1.2;
      padding-right: 8px;
    }

    .card-row {
      display: table;
      width: 100%;
      table-layout: fixed;
      margin-bottom: 2.5px;
    }

    .card-label {
      display: table-cell;
      width: 78px;
      white-space: nowrap;
      font-weight: 800;
      color: #4c1d95;
    }

    .card-colon {
      display: table-cell;
      width: 7px;
      text-align: center;
      font-weight: 800;
      color: #4c1d95;
    }

    .card-value {
      display: table-cell;
      padding-left: 4px;
      font-weight: 900;
      color: #1f2937;
      overflow-wrap: anywhere;
      vertical-align: top;
    }

    .address-value {
      overflow: hidden;
    }

    .card-photo-slot {
      display: table-cell;
      width: 58px;
      vertical-align: top;
      text-align: right;
    }

    .anggota-photo {
      width: 58px;
      height: 77px;
      object-fit: cover;
      border-radius: 5px;
      border: 1.5px solid #6d28d9;
      background: #fff;
      box-shadow: 0 3px 8px rgba(76, 29, 149, 0.16);
      transform: translateY(-5px);
    }

    .anggota-photo-placeholder {
      width: 58px;
      height: 77px;
      display: grid;
      place-items: center;
      border-radius: 5px;
      border: 1.5px solid #6d28d9;
      background: linear-gradient(135deg, #ffffff, #f5f3ff);
      color: #6d28d9;
      font-size: 12px;
      font-weight: 900;
      letter-spacing: 0;
      box-shadow: 0 3px 8px rgba(76, 29, 149, 0.16);
      transform: translateY(-3px);
    }

    .card-note-rule {
      height: 1px;
      margin: 7px 0 4px;
      background: linear-gradient(90deg, transparent, #7c3aed 12%, #7c3aed 88%, transparent);
      position: relative;
      z-index: 1;
    }

    .card-note {
      margin: 0;
      position: relative;
      z-index: 1;
      text-align: center;
      color: #4c1d95;
      font-size: 7.8px;
      line-height: 1.25;
      font-weight: 800;
    }

    .card-back {
      display: block;
      padding: 12px 14px 10px 18px;
    }

    .card-back-title {
      margin: 0 0 7px;
      text-align: center;
      font-family: "Arial Narrow", Arial, Helvetica, sans-serif;
      font-size: 12px;
      line-height: 1.25;
      font-weight: 900;
      text-transform: uppercase;
      color: #2e1065;
      text-shadow: 0 1px 0 rgba(255, 255, 255, 0.85);
      position: relative;
      z-index: 1;
    }

    .card-back-title span {
      display: block;
    }

    .library-rules {
      margin: 0;
      padding-left: 16px;
      font-size: 9px;
      line-height: 1.42;
      font-weight: 700;
      color: #1f2937;
      position: relative;
      z-index: 1;
    }

    .library-rules li {
      padding-left: 2px;
      margin-bottom: 2px;
    }

    .library-rules li::marker {
      color: #6d28d9;
      font-weight: 900;
    }

    @media (max-width: 768px) {
      .download-page {
        padding: 18px;
      }
    }

    @media print {
      body {
        background: #fff !important;
      }

      .download-page {
        padding: 0;
      }

      .download-shell {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <div class="download-page">
    <div class="download-shell">
      <div class="anggota-card-shell">
        @include('partials.anggota_card_pair', ['anggotaCard' => $anggotaCard])
      </div>
    </div>
  </div>
</body>
</html>
