<div class="modal-overlay" id="modalDetail" style="display:none;">
    <div class="modal-box">

        <div class="modal-header-top">
            <div class="school-info">
                <img src="{{ asset('img/logo.png') }}" class="logo">
            </div>
            <div class="date-info">
                Tanggal : <span id="detailTanggal">-</span>
            </div>
        </div>

        <hr>

        <h2 class="modal-title">Detail Aspirasi</h2>

        <div class="detail-grid">

            <div class="form-group">
                <label>NIS Siswa</label>
                <input type="text" id="detailNis" readonly>
            </div>

            <div class="form-group">
                <label>Nama Siswa</label>
                <input type="text" id="detailNama" readonly>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <input type="text" id="detailKategori" readonly>
            </div>

            <div class="form-group">
                <label>Tempat</label>
                <input type="text" id="detailLokasi" readonly>
            </div>

            <div class="form-group keterangan">
                <label>Keterangan</label>
                <textarea id="detailKeterangan" readonly></textarea>
            </div>

            <div class="bukti-wrapper">
                <label>Lampiran</label>

                <div class="bukti-box">
                    <img id="detailBukti" src="">
                </div>

                <div class="status-wrapper">
                    <label>Status</label>
                    <span id="detailStatus" class="status-pill">-</span>
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <a class="btn-outline" id="btnPdf">Simpan Bukti</a>
            <button class="btn-primary" id="closeModal">Kembali</button>
        </div>

    </div>
</div>