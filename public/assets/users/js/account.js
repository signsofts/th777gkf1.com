try {
    document.getElementById("formAccountDeactivation").addEventListener('submit', async e => {
        e.preventDefault();
        const ev = e.target;
        const FDATA = new FormData(ev);

        const DELETE = await fetch("/api/v1/resource/member/" + FDATA.get('user_id'), {
            headers: {
                'Authorization': `Bearer ${getTokenFromStore()}`, // Authorization header with Bearer token
                'Content-Type': 'application/json' // Example of setting another header
            },
            method: "DELETE",
            body: JSON.stringify({}),
        });

        let response = await DELETE.json();
        // console.log(response);
        if (response.status) {
            showToast(response.success ?? 'success', 'alert', 'success')

            setTimeout(() => {
                location.reload();
            }, 600);
            return;
        }

        showToast(response.error ?? 'error', 'alert', 'danger')

    })
} catch (error) {

}
try {
    document.getElementById("formAccountSettings").addEventListener('submit', async e => {
        e.preventDefault();
        const ev = e.target;
        const Form = new FormData(ev);
        const data = formDataToJson(Form);
        const PATCH = await fetch("/api/v1/resource/member/" + Form.get('user_id'), {
            headers: {
                'Authorization': `Bearer ${getTokenFromStore()}`, // Authorization header with Bearer token
                'Content-Type': 'application/json' // Example of setting another header
            },
            method: "PATCH",
            body: data,
        });

        let response = await PATCH.json();
        // return;
        if (response.status == true) {
            showToast(response.message ?? 'success', 'alert', 'success')
            setTimeout(() => {
                location.reload();
            }, 600);
            return;
        }
        showToast(response.error ?? 'error', 'alert', 'error')
    })
} catch (error) {

}


$(document).ready(function () {

});