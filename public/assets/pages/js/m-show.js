const userStatements = new DataTable('#table-userStatements', {
    ordering: false
});
// const userGroups = new DataTable('#table-userGroups');

const deleteUser = async (user_id) => {

    if (!confirm("You Delete Users ? ")) {
        return true;
    }

    const Form = new FormData();
    Form.append("user_id", user_id);
    const data = formDataToJson(Form);

    const DELETE = await fetch("/api/v1/resource/member/" + Form.get('user_id'), {
        headers: {
            'Authorization': `Bearer ${getTokenFromStore()}`, // Authorization header with Bearer token
            'Content-Type': 'application/json' // Example of setting another header
        },
        method: "DELETE",
        body: data,
    });

    let response = await DELETE.json();
    // return;
    if (response.status == true) {
        showToast(response.message ?? 'success', 'alert', 'success')
        setTimeout(() => {
            location.assign("/admin/m")
        }, 600);
        return;
    }
    showToast(response.error ?? 'error', 'alert', 'error')
}

let FormUpMoney_COUNT = 0;

try {
    document.getElementById("id-FormUpMoney").addEventListener("submit", async e => {

        if (FormUpMoney_COUNT == 1) {
            return false;
        } else {
            FormUpMoney_COUNT = 1;
        }

        e.preventDefault();
        const ev = e.target;
        const POST = await fetch("/api/v1/resource/mstatements", {
            method: "POST",
            body: new FormData(ev),
        });

        let response = await POST.json();
        // console.log(response);
        if (response.success) {

            $("#upMoneyShowModal").hide()
            showToast(response.success ?? 'success', 'alert', 'success')

            setTimeout(() => {
                location.reload();
            }, 600);
            return;
        }

        showToast(response.error ?? 'error', 'alert', 'danger')

    })
} catch (error) {
    FormUpMoney_COUNT = 0;
    console.error(error);
    showToast('error', 'alert', 'danger')

}

let FormWithDraw_cont = 0;
try {
    document.getElementById("id-FormWithDraw").addEventListener("submit", async e => {

        if (FormWithDraw_cont == 1) {
            return false;
        } else {
            FormWithDraw_cont = 1;
        }


        e.preventDefault();
        const ev = e.target;
        const POST = await fetch("/api/v1/resource/mstatements", {
            method: "POST",
            body: new FormData(ev),
        });

        let response = await POST.json();

        // return ;
        if (response.status) {
            $("#withDrawShowModal").hide()
            showToast(response.success ?? 'success', 'alert', 'success')
            setTimeout(() => {
                location.reload();
            }, 600);
            return;
        }

        showToast(response.error ?? 'error', 'alert', 'error')
    })
} catch (error) {

    FormWithDraw_cont = 0;
    console.error(error);

    showToast('error', 'alert', 'error')

}
try {
    document.getElementById("id-FormAddAgent").addEventListener("submit", async e => {
        e.preventDefault();
        const ev = e.target;
        const POST = await fetch("/m/setagent", {
            method: "POST",
            body: new FormData(ev),
        });

        let response = await POST.json();
        // return ;
        if (response.success) {
            $("#addAgentModal").hide()
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

$(document).ready(function () {
    $('#id-FormWithDraw select[name="blit_id"]').select2({
        placeholder: 'select',
        dropdownParent: $("#withDrawShowModal"),
    });

    $('#id-FormUpMoney select[name="blit_id"]').select2({
        placeholder: 'select',
        dropdownParent: $("#upMoneyShowModal"),
    });

    $('#id-FormAddAgent select[name="user_agent"]').select2({
        placeholder: 'select',
        dropdownParent: $("#addAgentModal"),
    });

});