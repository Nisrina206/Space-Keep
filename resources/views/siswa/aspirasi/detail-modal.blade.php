<!-- Modal Success -->
<div class="modal-overlay" id="successModal">
    <div class="success-modal">
        <h3>Berhasil! 🎉</h3>
        <p>Aspirasi Anda telah tersimpan dengan status <b>menunggu</b></p>
        <button onclick="closeModal()">OK</button>
    </div>
</div>

{{-- @endif --}}

<script>
function closeModal() {
    document.getElementById('successModal').style.display = 'none';
}
</script>