const tableBank = new DataTable('#table-banklist');
// const onsubmitAddBankList = async (e) => {

//     console.log(e)
// }
// try {
//     document.getElementById("id-formAddBankList").addEventListener("submit", async (e) => {
//         e.preventDefault();
//         const target = e.target;
         
//     });
// } catch (error) {

// }
$(document).ready(function () {
    // console.log(base_url() 
    $('select[name="bank_id"]').select2({
        dropdownParent: $("#addShowModal")
    });
});