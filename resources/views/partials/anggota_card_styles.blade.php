<style>
.anggota-card-shell {
    width: 100%;
    display: flex;
    justify-content: center;
}

.library-card-wrap {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 24px;
    justify-items: center;
}

.card-side {
    width: 85.6mm;
    height: 54mm;
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
}

.library-card::before {
    content: "";
    position: absolute;
    inset: 0 auto 0 0;
    width: 9px;
    background: linear-gradient(180deg, #4c1d95, #7c3aed 48%, #a78bfa);
}

.card-head {
    display: grid;
    grid-template-columns: 38px 1fr 38px;
    align-items: center;
    gap: 7px;
    position: relative;
    z-index: 1;
}

.card-head img {
    width: 35px;
    height: 35px;
    object-fit: contain;
    filter: drop-shadow(0 1px 1px rgba(49, 46, 129, 0.16));
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
    display: grid;
    grid-template-columns: minmax(0, 1fr) 58px;
    gap: 9px;
    margin-top: 20px;
    position: relative;
    z-index: 1;
}

.card-photo-slot {
    display: contents;
}

.card-data {
    display: grid;
    gap: 2.5px;
    align-content: start;
    font-size: 8.4px;
    line-height: 1.2;
}

.card-row {
    display: grid;
    grid-template-columns: 78px 7px minmax(0, 1fr);
    align-items: start;
}

.card-label {
    white-space: nowrap;
    font-weight: 800;
    color: #4c1d95;
}

.card-colon {
    text-align: center;
    font-weight: 800;
    color: #4c1d95;
}

.card-value {
    min-width: 0;
    padding-left: 4px;
    font-weight: 900;
    color: #1f2937;
    overflow-wrap: anywhere;
}

.address-value {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
    overflow: hidden;
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
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
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

.anggota-card-preview-wrap {
    width: 100%;
    overflow-x: auto;
}

.anggota-card-preview-wrap .library-card {
    width: 85.6mm;
    height: 54mm;
}

@media (max-width: 768px) {
    .library-card-wrap {
        grid-template-columns: 1fr;
        gap: 18px;
    }

    .anggota-card-preview-wrap .library-card {
        width: 100%;
    }
}

@media print {
    .card-actions,
    .anggota-card-preview-wrap {
        overflow: visible;
    }

    .library-card-wrap {
        grid-template-columns: 1fr;
        gap: 0;
    }

    .card-side {
        width: 85.6mm;
        height: 54mm;
        margin: 12mm auto;
        break-after: page;
        page-break-after: always;
    }

    .card-side:last-child {
        break-after: auto;
        page-break-after: auto;
    }

    .library-card {
        box-shadow: none;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}
</style>
