let selectedUserId = null;

function openConfirm(id) {
    selectedUserId = id;
    document.getElementById('confirmResetModal').classList.add('show');
}

function closeConfirm() {
    document.getElementById('confirmResetModal').classList.remove('show');
}

function closeSuccess() {
    document.getElementById('successResetModal').classList.remove('show');
}

function confirmReset() {
    if (!selectedUserId) {
        alert('ID siswa tidak ditemukan');
        return;
    }

    fetch(`/admin/siswa/${selectedUserId}/reset-sandi`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            closeConfirm();
            document.getElementById('newPasswordText').innerText = data.password;
            document.getElementById('successResetModal').classList.add('show');
        } else {
            alert('Reset gagal');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan');
    });
}

const searchInput = document.getElementById('searchInput');
const siswaTable  = document.getElementById('siswaTable');

if (searchInput) {
    searchInput.addEventListener('keyup', function () {
        const keyword = this.value;

        fetch(`/admin/siswa/search?search=${keyword}`)
            .then(res => res.json())
            .then(data => {
                let html = '';

                if (data.length === 0) {
                    html = `
                        <tr>
                            <td colspan="5" class="empty-text">
                                Data tidak ditemukan
                            </td>
                        </tr>
                    `;
                } else {
                    data.forEach((item, index) => {
                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.nis}</td>
                                <td>${item.nama_lengkap}</td>
                                <td>${item.kelas}</td>
                                <td class="aksi-cell">
                                    <button
                                        class="btn-reset-sandi"
                                        onclick="openConfirm(${item.id})">
                                        <img src="/img/kunci.png">
                                        <span>Reset Sandi</span>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                }

                siswaTable.innerHTML = html;
            });
    });
}
