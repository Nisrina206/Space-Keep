const modal = document.getElementById('modalDetail');

/* ================= OPEN MODAL ================= */
document.addEventListener('click', function (e) {

    const btn = e.target.closest('.btn-detail');
    if (!btn) return;

    modal.classList.add('show');
    document.body.classList.add('modal-open');

    document.getElementById('detailNis').value        = btn.dataset.nis;
    document.getElementById('detailNama').value       = btn.dataset.nama;
    document.getElementById('detailKategori').value   = btn.dataset.kategori;
    document.getElementById('detailLokasi').value     = btn.dataset.lokasi;
    document.getElementById('detailKeterangan').value = btn.dataset.keterangan;

    /* ================= TANGGAL ================= */
    const tanggalEl = document.getElementById('detailTanggal');
    if (tanggalEl) {
        tanggalEl.innerText = btn.dataset.tanggal || '-';
    }

    /* ================= GAMBAR BUKTI ================= */
    const buktiImg = document.getElementById('detailBukti');

    if (btn.dataset.bukti) {
        buktiImg.src = btn.dataset.bukti;
        buktiImg.style.display = 'block';
    } else {
        buktiImg.style.display = 'none';
    }

    /* ================= STATUS + WARNA ================= */
    const statusEl = document.getElementById('detailStatus');

    statusEl.innerText = btn.dataset.status;
    statusEl.className = 'status-pill ' + btn.dataset.status.toLowerCase();
});


/* ================= CLOSE MODAL FUNCTION ================= */
function closeModal() {
    modal.classList.remove('show');
    document.body.classList.remove('modal-open');
}


/* ================= CLOSE VIA BUTTON ================= */
document.addEventListener('click', function (e) {

    const closeBtn = e.target.closest('#closeModal'); // 🔥 FIX ID
    if (closeBtn) {
        closeModal();
    }
});


/* ================= CLOSE VIA OVERLAY ================= */
modal.addEventListener('click', function (e) {
    if (e.target === modal) {
        closeModal();
    }
});


/* ================= CLOSE VIA ESC ================= */
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});


/* ================= DOWNLOAD PDF ================= */
document.addEventListener('click', function (e) {

    const pdfBtn = e.target.closest('#btnPdf');
    if (!pdfBtn) return;

    const nis        = document.getElementById('detailNis').value;
    const nama       = document.getElementById('detailNama').value;
    const kategori   = document.getElementById('detailKategori').value;
    const lokasi     = document.getElementById('detailLokasi').value;
    const keterangan = document.getElementById('detailKeterangan').value;
    const status     = document.getElementById('detailStatus').innerText;
    const tanggal    = document.getElementById('detailTanggal')?.innerText ?? '';

    const buktiSrc = document.getElementById('detailBukti').src;
    const bukti = buktiSrc.includes('/storage/')
        ? buktiSrc.split('/storage/')[1]
        : '';

    const params = new URLSearchParams({
        nis,
        nama,
        kategori,
        lokasi,
        keterangan,
        status,
        tanggal,
        bukti
    });

    window.open('/admin/aspirasi/pdf?' + params.toString(), '_self');
});

document.addEventListener('click', function (e) {

    const btn = e.target.closest('.btn-detail');
    if (!btn) return;

    const id = btn.dataset.id;

    document.getElementById('btnCetakId').href =
        `/admin/cetak/${id}`;
});
