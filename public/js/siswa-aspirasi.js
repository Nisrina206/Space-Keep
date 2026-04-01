// // // {{-- ================= JS LANGSUNG DI VIEW ================= --}}
// // function openConfirm() {
// //     document.getElementById('confirmModal').style.display = 'flex';
// // }

// // function closeConfirm() {
// //     document.getElementById('confirmModal').style.display = 'none';
// // }

// // function submitForm() {
// //     document.getElementById('formAspirasi').submit();
// // }

// // function closeSuccess() {
// //     document.getElementById('successModal').style.display = 'none';
// // }

// function closeModal() {
//     document.getElementById('successModal').style.display = 'none';
// }

// function showModal() {
//     document.getElementById('successModal').classList.add('show');
// }

// function hideModal() {
//     document.getElementById('successModal').classList.remove('show');
// }

// // Panggil showModal() saat form berhasil disimpan

// Fungsi untuk menampilkan modal
function showSuccessModal() {
    document.getElementById('successModal').style.display = 'flex';
}

// Fungsi untuk menutup modal
function closeSuccessModal() {
    document.getElementById('successModal').style.display = 'none';
}

// Tutup modal jika klik di luar modal
window.onclick = function(event) {
    const modal = document.getElementById('successModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}

// Tutup modal dengan tombol ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('successModal');
        if (modal.style.display === 'flex') {
            modal.style.display = 'none';
        }
    }
});