
const tableAdmin = new DataTable('#table-admin');
const showEditModal = async (ac_id) => {

    const GET = await fetch("/api/v1/resource/admin/" + ac_id, {
        method: "GET",
        // body: new FormData(),
    });

    let response = await GET.json();
}





const formSubmitEdit = async (id, ac_id) => {
    const e = document.getElementById(id);

    const formData = new FormData(e);
    const json = formDataToJson(formData);
    // console.log(json);
    // console.log(getTokenFromStore())
    // e.preventDefault();
    const POST = await fetch("/api/v1/resource/admin/" + ac_id, {
        method: "PATCH",
        // headers: {
        //     'Authorization': getTokenFromStore(),
        // },
        body: json,
    });

    let response = await POST.json();
    if (response.status) {
        $("#AdminEditShowModal-" + ac_id).hide()
        showToast(response.message ?? 'success', 'alert', 'success')

        // toastMixin.fire({
        //     animation: true,
        //     title: response.message,
        //     timer: 600,
        // });

        setTimeout(() => {
            location.reload();
        }, 600);
        return;
    }


    showToast(response.error ?? 'error', 'alert', 'danger')

    // toastMixin.fire({
    //     icon: "error",
    //     animation: true,
    //     title: response.error,
    //     timer: 600,
    // });
};

const BtnDelete = async (ac_id) => {
    $("#AdminEditShowModal-" + ac_id).hide()

    $(".modal-backdrop").hide();
    // const myModalEl = document.getElementById("AdminEditShowModal-" + ac_id)
    // myModalEl.addEventListener('hidden.bs.modal', event => {
    //     // do something...
    // })
    Swal.fire({
        title: "Confirm!",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                type: "DELETE",
                url: "/api/v1/resource/admin/" + ac_id,
                data: "data",
                dataType: "json",
                success: function (response) {
                    if (response.status) {
                        showToast(response.success ?? 'success', 'alert', 'success')
                        setTimeout(() => {
                            location.reload();
                        }, 600);
                        return;
                    } else {
                        showToast(response.error ?? 'error', 'alert', 'danger')
                    }
                }
            });

        } else {
            $(".modal-backdrop").show();
            $("#AdminEditShowModal-" + ac_id).show()
        }
    });

}


try {
    document.getElementById("id-AdminAdd").addEventListener("submit", async e => {
        e.preventDefault();
        const ev = e.target;
        const POST = await fetch("/api/v1/resource/admin", {
            method: "POST",
            body: new FormData(ev),
        });

        let response = await POST.json();

        if (response.status === true) {
            $("#AdminAddShowModal").hide()
            showToast(response.success ?? 'success', 'alert', 'success')
            setTimeout(() => {
                location.reload();
            }, 600);
            return;
        }

        showToast(response.messages.message ?? 'error', 'alert', 'danger')

    })
} catch (error) {
    console.error(error);
}



$(document).ready(function () {
    $('#id-AdminAdd select[name="RoleID"]').select2({
        placeholder: 'Select Options',
        dropdownParent: $("#AdminAddShowModal"),
    });

});