let selectedId = null;

function openConfirm(id){
    selectedId = id;
    document.getElementById("confirmResetModal").style.display = "flex";
}

function closeConfirm(){
    document.getElementById("confirmResetModal").style.display = "none";
}

function closeSuccess(){
    document.getElementById("successResetModal").style.display = "none";
}

function confirmReset(){

    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("/admin/siswa/reset/" + selectedId, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrf,
            "Accept": "application/json"
        }
    })

    .then(response => {

        if(!response.ok){
            throw new Error("HTTP status " + response.status);
        }

        return response.json();
    })

    .then(data => {

        console.log("Response:", data);

        if(data.success === true){

            closeConfirm();

            document.getElementById("newPasswordText").innerText = data.password;

            document.getElementById("successResetModal").style.display = "flex";

        }else{

            alert("Reset gagal");

        }

    })

    .catch(error => {

        console.error(error);
        alert("Terjadi kesalahan saat mereset sandi");

    });

}