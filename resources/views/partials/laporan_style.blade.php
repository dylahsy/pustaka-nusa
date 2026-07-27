<style>
  body {
    background:
      linear-gradient(135deg, rgba(111, 66, 193, 0.18), rgba(13, 202, 240, 0.12)),
      url('{{ asset('templateperpus/img/BAG.png') }}') no-repeat center center fixed;
    background-size: cover;
  }

  .report-shell {
    max-width: 1120px;
    margin: 28px auto;
    padding: 0 18px;
  }

  .report-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-bottom: 16px;
  }

  .report-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 0;
    border-radius: 7px;
    padding: 7px 12px;
    min-height: 34px;
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    text-decoration: none;
    box-shadow: 0 7px 16px rgba(39, 24, 76, 0.16);
  }

  .report-btn.print {
    background: linear-gradient(135deg, #6f42c1, #4969d8);
  }

  .report-btn.back {
    background: linear-gradient(135deg, #475569, #64748b);
  }

  .report-paper {
    background: rgba(255, 255, 255, 0.96);
    border-radius: 10px;
    padding: 30px 34px;
    box-shadow: 0 24px 60px rgba(44, 34, 84, 0.22);
    color: #111827;
    font-family: Arial, Helvetica, sans-serif;
  }

  .report-kop {
    display: grid;
    grid-template-columns: 90px 1fr 90px;
    align-items: center;
    gap: 16px;
    padding-bottom: 16px;
    border-bottom: 4px double #4c1d95;
  }

  .report-logo {
    width: 80px;
    height: 80px: contain;
    justify-self: center;
    filter: drop-shadow(0 1px 1px rgba(17, 24, 39, 0.14));
  }

  .report-school {
    text-align: center;
  }

  .report-school h1 {
    margin: 0 0 4px;
    font-size: 22px;
    font-weight: 900;
    letter-spacing: 0;
    text-transform: uppercase;
    color: #111827;
    font-family: Arial, Helvetica, sans-serif;
  }

  .report-school-subtitle {
    margin: 0 0 5px;
    color: #4c1d95;
    font-size: 15px;
    line-height: 1.2;
    font-weight: 900;
    text-transform: uppercase;
    font-family: Arial, Helvetica, sans-serif;
  }

  .report-school-address,
  .report-school-contact {
    margin: 1px 0 0;
    font-size: 12.5px;
    line-height: 1.35;
    font-weight: 700;
    color: #1f2937;
    font-family: Arial, Helvetica, sans-serif;
  }

  .report-title {
    text-align: center;
    margin: 24px 0 18px;
  }

  .report-title h2 {
    margin: 0 0 6px;
    font-size: 15px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0;
    color: #111827;
    font-family: Arial, Helvetica, sans-serif;
  }

  .report-title p {
    margin: 0;
    font-size: 14px;
    font-weight: 900;
    text-transform: uppercase;
    color: #4c1d95;
    font-family: Arial, Helvetica, sans-serif;
  }

  .report-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    font-size: 13px;
    font-weight: 700;
    color: #111827;
    font-family: Arial, Helvetica, sans-serif;
  }

  .report-table th,
  .report-table td {
    border: 1px solid #cbd5e1;
    padding: 8px 9px;
    vertical-align: middle;
  }

  .report-table thead th {
    background: linear-gradient(135deg, #ede9fe, #e0f2fe);
    color: #1f2937;
    text-align: center;
    font-weight: 900;
  }

  .report-table tbody tr:nth-child(even) {
    background: #f8fafc;
  }

  .report-signatures {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    margin-top: 42px;
    text-align: center;
    font-size: 14px;
    font-weight: 700;
    font-family: Arial, Helvetica, sans-serif;
  }

  .report-signature-space {
    height: 70px;
  }

  .report-signatures strong {
    display: inline-block;
    min-width: 180px;
    border-bottom: 1px solid #111827;
    padding-bottom: 3px;
    font-weight: 900;
  }

  @media print {
    body {
      background: #fff !important;
    }

    #header,
    .header,
    .scroll-top,
    #preloader,
    .report-actions {
      display: none !important;
    }

    .main {
      margin: 0 !important;
      padding: 0 !important;
    }

    .report-shell {
      max-width: none;
      margin: 0;
      padding: 0;
    }

    .report-paper {
      box-shadow: none;
      border-radius: 0;
      padding: 0;
    }

    .report-table thead th {
      background: #e9d5ff !important;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
  }
</style>
