const tableIndex = new DataTable('#table-group-index');


const clipboardMakeLink = async (groupId) => {
    // navigator.clipboard.writeText();
    const formData = new FormData();
    formData.append("groupId", groupId);
    const POST = await fetch("/api/v1/resource/lnvitelink", {
        method: "POST",
        body: formData,
    });

    let response = await POST.json();

    if (response.status === true) {
        $("#AdminAddShowModal").hide()
        showToast(response.message ?? 'success', 'alert', 'success')
        modalShow(null,"Copy Link Url",response.message);
        return true;
    }

    showToast(response.messages.message ?? 'error', 'alert', 'danger')
}

$(document).ready(function () {
    // modalShow();
});