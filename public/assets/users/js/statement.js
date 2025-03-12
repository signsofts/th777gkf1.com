const userStatements = new DataTable('#table-userStatements', {
    ordering: false
});



try {
    
    document.getElementById("id-FormUpMoney").addEventListener("submit", async e => {
        e.preventDefault();
        const ev = e.target;
        const POST = await fetch("/api/v1/resource/payment", {
            method: "POST",
            body: new FormData(ev),
        });

        let response = await POST.json();
        // console.log(response);
        if (response.success) {

            $("#showModalTM1").hide()
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
        const POST = await fetch("/api/v1/resource/payment", {
            method: "POST",
            body: new FormData(ev),
        });

        let response = await POST.json();

        // return ;
        if (response.success) {
            $("#showModalT6").hide()
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