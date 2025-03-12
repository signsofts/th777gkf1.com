const tableBank = new DataTable('#table-bankStatements', {
    order: [[0, 'desc']]
});
// tableBank.fnSort( [ [0,'asc'] ] );

const onCheangeType = (e) => {

    let val = e.value;
    switch (val) {
        case 'member':
            $("#div-user_id").show();
            $('#id-FormUpMoney select[name="user_id"]').prop('required', true);
            break;
        case 'other':
            $('#id-FormUpMoney select[name="user_id"]').prop('required', false);
            $("#div-user_id").hide();
            break;
    }
}
const onCheangeTypeWith = (e) => {

    let val = e.value;
    switch (val) {
        case 'member':
            $("#div-with-user_id").show();
            $('#id-FormWithDraw select[name="user_id"]').prop('required', true);
            break;
        case 'other':
            $("#div-with-user_id").hide();
            $('#id-FormWithDraw select[name="user_id"]').prop('required', false);
            break;
    }
}


try {
    document.getElementById("id-FormUpMoney").addEventListener("submit", async e => {
        e.preventDefault();
        const ev = e.target;
        const POST = await fetch("/api/v1/resource/statements", {
            method: "POST",
            body: new FormData(ev),
        });

        let response = await POST.json();
        if (response.success) {

            $("#upMoneyShowModal").hide()
            // toastMixin.fire({
            //     animation: true,
            //     title: response.success,
            //     timer: 600,
            // });

            showToast(response.success ?? 'success', 'alert', 'success')

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

    })
} catch (error) {
    console.error(error);
}

try {
    document.getElementById("id-FormWithDraw").addEventListener("submit", async e => {
        e.preventDefault();
        const ev = e.target;
        const POST = await fetch("/api/v1/resource/statements", {
            method: "POST",
            body: new FormData(ev),
        });

        let response = await POST.json();

        if (response.success) {

            $("#withDrawShowModal").hide()
            // toastMixin.fire({
            //     animation: true,
            //     title: response.success,
            //     timer: 600,
            // });

            showToast(response.success ?? 'success', 'alert', 'success')

            setTimeout(() => {
                location.reload();
            }, 600);
            return;
        }
        showToast(response.error ?? 'error', 'alert', 'danger')


        // if (response.success) {

        //     $("#withDrawShowModal").hide()

        //     toastMixin.fire({
        //         animation: true,
        //         title: response.success,
        //         timer: 600,
        //     });
        //     setTimeout(() => {
        //         location.reload();
        //     }, 600);
        //     return;
        // }

        // toastMixin.fire({
        //     icon: "error",
        //     animation: true,
        //     title: response.error,
        //     timer: 600,
        // });

    })
} catch (error) {
    console.error(error);
}

const BankDelete = async (blit_id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: "/api/v1/resource/bank/" + blit_id,
                data: "data",
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        // toastMixin.fire({
                        //     animation: true,
                        //     title: response.msg,
                        //     timer: 600,
                        // });
                        showToast(response.msg ?? 'success', 'alert', 'success')

                        setTimeout(() => {
                            window.history.back(-1);
                        }, 600);
                        return;
                    } else {

                        showToast(response.msg ?? 'error', 'alert', 'danger')

                        // toastMixin.fire({
                        //     animation: true,
                        //     title: response.msg,
                        //     timer: 600,
                        //     icon: "error"
                        // });
                    }
                }
            });

        }
    });

}
$(document).ready(function () {
    $('#id-FormWithDraw select[name="user_id"]').select2({
        placeholder: 'Select Options',
        dropdownParent: $("#withDrawShowModal"),
        ajax: {
            url: '/api/v1/resource/member',  // Replace with your CodeIgniter route
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.user_id,
                            text: item.displayName
                        };
                    })
                };
            },
            cache: true
        }
    });

    $('#id-FormUpMoney select[name="user_id"]').select2({
        placeholder: 'Select Options',
        dropdownParent: $("#upMoneyShowModal"),
        ajax: {
            url: '/api/v1/resource/member',  // Replace with your CodeIgniter route
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.user_id,
                            text: item.displayName
                        };
                    })
                };
            },
            cache: true
        }
    });
});