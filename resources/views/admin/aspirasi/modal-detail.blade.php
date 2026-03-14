<div class="modal-overlay" id="modalDetail">
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
                <label>NIS Siswa<span>*</span></label>
                <input type="text" id="detailNis" readonly>
            </div>

            <div class="form-group">
                <label>Nama Siswa<span>*</span></label>
                <input type="text" id="detailNama" readonly>
            </div>

            <div class="form-group">
                <label>Kategori<span>*</span></label>
                <input type="text" id="detailKategori" readonly>
            </div>

            <div class="form-group">
                <label>Tempat<span>*</span></label>
                <input type="text" id="detailLokasi" readonly>
            </div>

            <div class="form-group keterangan">
                <label>Keterangan<span>*</span></label>
                <textarea id="detailKeterangan" readonly></textarea>
            </div>

            <div class="bukti-wrapper">
                <label>Lampiran<span>*</span></label>

                <div class="bukti-box">
                    <img id="detailBukti" src="">
                </div>

                 <div class="status-wrapper">
    <label>Status<span>*</span></label>
    <span id="detailStatus" class="status-pill {{ strtolower($item->status) }}">
        {{ $item->status }}
    </span>
</div>
            </div>

        </div>

        {{-- FOOTER --}}
        <div class="modal-footer">
            <a class="btn-outline" id="btnPdf">Simpan Bukti</a>
            <button class="btn-primary" id="closeModal">Kembali</button>
        </div>

    </div>
</div>
