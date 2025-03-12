
const tableBank = new DataTable('#table-memberlist');



const clipboardMakeLink = async (user_id) => {
    // navigator.clipboard.writeText();
    const formData = new FormData();
    formData.append("user_id", user_id);
    formData.append("type", 'member');
    const POST = await fetch("/api/v1/resource/lnvitelink", {
        method: "POST",
        body: formData,
    });

    let response = await POST.json();

    if (response.status === true) {
        showToast(response.message ?? 'success', 'alert', 'success')
        modalShow(null, "Copy Link Url", response.message);
        return true;
    }

    showToast(response.messages.message ?? 'error', 'alert', 'danger')
}


$(document).ready(function () {
    // console.log(base_url()
    // $('select[name="bank_id"]').select2({
    //     dropdownParent: $("#addShowModal")
    // });
});