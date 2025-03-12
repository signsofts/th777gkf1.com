$.extend(true, $.fn.dataTable.defaults, {
    lengthMenu: [
        [30, 50, -1],
        [30, 50, 'All']
    ],
    pageLength: 30,
    scrollX: true,
    "language": {
        // "sProcessing": " กำลังดำเนินการ... ",
        // "sLengthMenu": " แสดง _MENU_ แถว ",
        // "sZeroRecords": " ไม่พบข้อมูล ",
        // "sInfo": " แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว ",
        // "sInfoEmpty": " แสดง 0 ถึง 0 จาก 0 แถว ",
        // "sInfoFiltered": " ( กรองข้อมูล _MAX_ ทุกแถว ) ",
        // "sInfoPostFix": "",
        // "sSearch": " ค้นหา : ",
        "sUrl": "",
        "oPaginate": {
            "sFirst": " << ",
            "sPrevious": " < ",
            "sNext": " > ",
            "sLast": " >> "
        }
    }
});

$.fn.select2.defaults.set("theme", "bootstrap-5");

const getTokenFromStore = () => {
    return Cookies.get('token');
}

function currency(number) {
    // Format number as currency using Thai Baht (THB)
    const formatter = new Intl.NumberFormat('th-TH', {
        style: 'currency',
        currency: 'THB',
        minimumFractionDigits: 2,
    });

    return formatter.format(number);
}

function formatDate(stringDate) {
    // Assuming stringDate is in a format supported by Date.parse()
    var date = new Date(stringDate);

    // Format the date in the desired format "D, d M Y H:i:s"
    var formattedDate = `${getDayOfWeek(date)}, ${addLeadingZero(date.getDate())} ${getMonthName(date)} ${date.getFullYear()} ${addLeadingZero(date.getHours())}:${addLeadingZero(date.getMinutes())}:${addLeadingZero(date.getSeconds())}`;

    return formattedDate;
}
function formatDateTime(stringDate) {
    // Assuming stringDate is in a format supported by Date.parse()
    var date = new Date(stringDate);

    // Format the date in the desired format "D, d M Y H:i:s"
    // var formattedDate = `${addLeadingZero(date.getHours())}:${addLeadingZero(date.getMinutes())}:${addLeadingZero(date.getSeconds())} `;
    var formattedDate = `${addLeadingZero(date.getDate())} ${getMonthName(date)} ${date.getFullYear()} ${addLeadingZero(date.getHours())}:${addLeadingZero(date.getMinutes())}:${addLeadingZero(date.getSeconds())}`;

    return formattedDate;
}
function getDayOfWeek(date) {
    // Array of weekdays
    var daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    return daysOfWeek[date.getDay()];
}

function getMonthName(date) {
    const lang = getCookie("lang")

    // Array of month names
    var months = lang == "th" ? ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'] : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    return months[date.getMonth()];
}

function addLeadingZero(number) {
    // Add leading zero if number is less than 10
    return (number < 10 ? '0' : '') + number;
}

const showToast = (message = "", title = "Message", type = 'primary') => {


    const toastPlacementExample = document.querySelector('.toast-placement-ex');
    let selectedType, selectedPlacement, toastPlacement;

    switch (type) {
        case 'success':
            selectedType = 'bg-success';
            break;
        case 'primary':
            selectedType = 'bg-primary';
            break;
        case 'secondary':
            selectedType = 'bg-secondary';
            break;
        case 'danger':
            selectedType = 'bg-danger';
            break;
        case 'error':
            selectedType = 'bg-danger';
            break;
        case 'warning':
            selectedType = 'bg-warning';
            break;
        case 'info':
            selectedType = 'bg-info';
            break;
        case 'dark':
            selectedType = 'bg-dark';
            break;
        default:
            selectedType = 'bg-primary';
            break;
    }


    function toastDispose(toast) {
        if (toast && toast._element !== null) {
            if (toastPlacementExample) {
                toastPlacementExample.classList.remove(selectedType);
                DOMTokenList.prototype.remove.apply(toastPlacementExample.classList, selectedPlacement);
            }
            toast.dispose();
        }
    }


    if (toastPlacement) {
        toastDispose(toastPlacement);
    }

    toastPlacementExample.classList.add(selectedType);
    DOMTokenList.prototype.add.apply(toastPlacementExample.classList, ['top-0', 'end-0']);


    document.getElementById('toast-body').innerHTML = message;
    document.getElementById('toast-title').innerHTML = title;


    toastPlacement = new bootstrap.Toast(toastPlacementExample);


    toastPlacement.show();
}

var toastMixin = Swal.mixin({
    toast: true,
    icon: 'success',
    title: 'General Title',
    animation: false,
    position: 'top-right',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

function formDataToJson(formData) {
    const object = {};
    formData.forEach((value, key) => {
        // Check if property already exists
        if (object.hasOwnProperty(key)) {
            // Property does exist and is an array, so push value
            if (Array.isArray(object[key])) {
                object[key].push(value);
            } else {
                // Property is not an array, but since it already exists, make it an array and push value
                object[key] = [object[key], value];
            }
        } else {
            // Property does not exist, so simply assign it
            object[key] = value;
        }
    });
    return JSON.stringify(object);
}

function modalShow(ID = 'modalMain', Title = '', body = '', Footer = '') {

    if (ID == null) {
        ID = 'modalMain'
    }

    let options = {
        delay: 1,
        keyboard: false,
    }
    const modalToggle = document.getElementById(ID);

    const modalTitle = document.getElementById("modalMainTitle");
    const modalMainBody = document.getElementById("modalMainBody");
    const modalMainFooter = document.getElementById("modalMainFooter");
    const myModal = new bootstrap.Modal(modalToggle, options)




    modalTitle.innerHTML = Title;
    modalMainBody.innerHTML = body;
    modalMainFooter.innerHTML = Footer;

    myModal.show(modalToggle);

}
function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function modalHide(ID = 'modalMain') {

    $('#' + ID).modal('hide');
    $('.modal-backdrop').hide();
    // const modalToggle = document.getElementById(ID);
    // const myModal = new bootstrap.Modal(modalToggle)

    // myModal.hide(modalToggle);
}


$(document).ready(function () {
});