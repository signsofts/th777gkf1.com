

const tableLive = new DataTable('#table-live');

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


$(document).ready(function () {
   
});