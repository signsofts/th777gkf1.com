

const tableLive = new DataTable('#table-live-index');

try {
    document.getElementById("id-form-add").addEventListener("submit", async (e) => {

        e.preventDefault();
        const ev = e.target;
        const POST = await fetch("/api/v1/resource/live", {
            method: "POST",
            body: new FormData(ev),
        });

        let response = await POST.json();
        if (response.status ?? false) {
            $("#AddShowModal").hide()
            showToast(response.success ?? 'success', 'alert', 'success')
            setTimeout(() => {
                // location.assign('/g/l/' + response.id);
                location.reload();
            }, 600);
            return;
        }
        showToast(response.error ?? 'error', 'alert', 'error')
    })
} catch (error) {
    console.error(error);
}

const closeOpenLive = async (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, it!"
    }).then(async (result) => {
        if (result.isConfirmed) {
            const POST = await fetch("/api/v1/resource/live/" + id, {
                method: "DELETE",
                body: JSON.stringify({}),
            });
            let response = await POST.json();
            if (response.status ?? false) {
                showToast(response.success ?? 'success', 'alert', 'success')
                setTimeout(() => {
                    location.reload();
                }, 600);
                return;
            }
            showToast(response.error ?? 'error', 'alert', 'error')
        }
    });
}


try {
    document.getElementById("id-form-edit").addEventListener("submit", async (e) => {

        e.preventDefault();
        const ev = e.target;
        const Form = new FormData(ev);
        const data = formDataToJson(Form);
        const PATCH = await fetch("/api/v1/resource/group/" + Form.get('groupId'), {
            method: "PATCH",
            body: data,
        });

        let response = await PATCH.json();

        // return ; 
        if (response.status ?? false) {
            $("#EditRoomShowModal").hide()
            showToast(response.success ?? 'success', 'alert', 'success')
            setTimeout(() => {
                // location.assign('/g/l/' + response.id);
                location.reload();
            }, 600);
            return;
        }
        showToast(response.error ?? 'error', 'alert', 'error')
    })
} catch (error) {
    console.error(error);
}



$(document).ready(function () {
    // console.log(base_url()
    $('#id-form-edit select').select2({
        dropdownParent: $("#EditRoomShowModal")
    });
});