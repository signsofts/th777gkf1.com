const tableAdmin = new DataTable('#table-card');
let length = 0;
async function loadData() {
    // const urlObj = new URL(location.href);
    // const pathArray = urlObj.pathname.split('/').filter(segment => segment !== '');

    let glco_ID = document.getElementById('hidden-glco_ID').value;

    let token = getTokenFromStore();
    // console.log(token)
    const POST = await fetch("/api/v1/resource/card/" + glco_ID, {
        method: "GET",
        headers: {
            'Authorization': `Bearer ${token}`, // Authorization header with Bearer token
            'Content-Type': 'application/json' // Example of setting another header
        },
    })


    let resp = await POST.json();

    if (resp.Gambling.length == length) {
        return;
    }
    tableAdmin.clear().draw(false);

    length = resp.Gambling.length;

    let moneySum = 0;

    let i = 0;
    for (const item of resp.Gambling) {

        moneySum += parseFloat(item.glco_quantity);
        tableAdmin.row
            .add([
                ++i,
                moment(item.gambcreated_at).format("lll"),
                // `<img src="${item.memberpictureUrl}" width="50px" height="50px" class=""> `,
                item.displayName,
                item.grName,
                currency(parseFloat(item.glco_quantity)),
                // currency(item.user_remain),
                // "",
                item.glco_success == 1 ? item.grId == resp.grId ? `<span class="text-success" >WIN</span>  ` : ` <span class="text-danger" >LOST</span>  ` : "",
                item.glco_success == 1 ? currency(item.glco_refund) : "",
                // item.glco_success == 1 ? "" :"" ,
            ])
    }
    tableAdmin.draw();



    $("#moneySum").html(currency(moneySum));
}


try {
    document.getElementById("id-form-add").addEventListener("submit", async (e) => {

        e.preventDefault();

        const ev = e.target;
        const Form = new FormData(ev);
        const data = formDataToJson(Form);
        const PATCH = await fetch("/api/v1/resource/card/" + Form.get('glco_ID'), {
            method: "PATCH",
            body: data,
        });

        let response = await PATCH.json();
        // return;
        if (response.status) {
            $("#saveCardShowModal").hide()
            showToast(response.success ?? 'success', 'alert', 'success')
            setTimeout(() => {
                location.reload();
            }, 600);
            return;
        }
        showToast(response.error ?? 'error', 'alert', 'error')
    })

} catch (error) {
    console.error(error);
}


const ClickOpen = async (glco_ID) => {

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "OK",
        // cancelButtonText: "OK"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: `/admin/g/ld/openling/${glco_ID}`,
                data: {},
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

        }
    });
}

const ClickStop = async (glco_ID) => {

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "OK",
        // cancelButtonText: "OK"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: `/admin/g/ld/stoping/${glco_ID}`,
                data: {},
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

        }
    });
}

const closeOpenLive = async (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes"
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



$(document).ready(function () {
    loadData();
    // $('select[name="grId"]').select2({
    //     dropdownParent: $("#saveCardShowModal")
    // });

    // $('select[name="id-grId-win"]').select2({
    //     dropdownParent: $("#saveCardShowModal")
    // });


    setInterval(() => {
        loadData();
    }, 20000);

});