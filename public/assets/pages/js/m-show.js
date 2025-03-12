const userStatements = new DataTable('#table-userStatements', {
    ordering: false
});
// const userGroups = new DataTable('#table-userGroups');


try {
    document.getElementById("id-FormUpMoney").addEventListener("submit", async e => {
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
    console.error(error);
}

try {
    document.getElementById("id-FormWithDraw").addEventListener("submit", async e => {
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
    console.error(error);
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