const tableList = new DataTable('#table-list');
let length = 0;
const loadData = async () => {

    let token = getTokenFromStore();
    // console.log(token)
    const GET = await fetch("/api/v1/resource/payment" + "?q=n", {
        method: "GET",
        headers: {
            'Authorization': `Bearer ${getTokenFromStore()}`, // Authorization header with Bearer token
            'Content-Type': 'application/json' // Example of setting another header
        },
    })


    let resp = await GET.json();

    if (resp.length == length) {
        return;
    }

    tableList.clear().draw(false);


    length = resp.length;

    let i = 0;
    for (const item of resp) {

        tableList.row

        let btnApp = ``;
        if (item.PAY_APPROVE == null) {
            btnApp = `<button class="btn btn-sm btn-outline-primary" onclick="appRove(this)" data-value="${item.PAY_ID}" > อนุมัติ </button>`;
        } else {
            continue;
        }

        let tagSatus = ``;
        let tagCurreyn = ``;

        if (item.status_id == '3') {
            tagSatus = `<span class="text-success" > ${item.status_name ?? '-'}</sapn>`;
            tagCurreyn = `<span class="text-success" > ${currency(parseFloat(item.PAY_MONEY))}</sapn>`;
        } else if (item.status_id == '4') {
            tagSatus = `<span class="text-danger" > ${item.status_name ?? '-'}</sapn>`;
            tagCurreyn = `<span class="text-danger" > ${currency(parseFloat(item.PAY_MONEY))}</sapn>`;
        }

        tableList.row.add([
            ++i,
            moment(item.PAY_created_at).format("lll"),
            item.displayName,
            tagSatus,
            tagCurreyn,
            item.PAY_DATE != null ? moment(item.PAY_DATE + " " + item.PAY_TIME).format("lll") : " - ",
            `${item.blit_name ?? '-'} ${item.bank_name ?? " "}`,
            item.PAY_APPROVE_TEXT,
            btnApp,
        ])
    }
    tableList.draw();
}

const submintFrom = async (type, PAY_ID, PAY) => {
    const lang = getCookie('lang') ?? 'en';
    const Form = new FormData();
    switch (type) {
        case 'yes':
            PAY_APPROVE = 1;
            break;
        case 'no':
            PAY_APPROVE = 0;
            break;
    }

    if (PAY == '0' && PAY_APPROVE !== 0) {
        let blit_id = document.getElementById('id-blit_id-approve').value;
        if (!blit_id || blit_id == '') {
            showToast(lang == "th" ? "กรุณาเลือกบัญชีที่ต้องการถอน" : 'Please select the account you want to withdraw.', 'alert', 'error')
            return;
        }
        Form.append("blit_id", blit_id);
    }
    Form.append("PAY_ID", PAY_ID);
    Form.append("PAY_APPROVE", PAY_APPROVE);

    const data = formDataToJson(Form);
    const PATCH = await fetch("/api/v1/resource/payment/" + PAY_ID, {
        method: "PATCH",
        body: data,
    });

    const resp = await PATCH.json();
    modalHide('modalMain');
    if (resp.status == true) {
        showToast(lang == "th" ? "บันทึกข้อมูลสำเร็จ" : 'Data saved successfully', 'alert', 'success')
        loadData();
        return true;
    }
    showToast(lang == "th" ? resp.message ?? "ไม่สามารถทำรายการได้" : resp.message ?? 'Unable to complete the transaction', 'alert', 'error')
    loadData();
    return false;
}

const appRove = async (ev) => {
    const PAY_ID = ev.dataset.value;

    let token = getTokenFromStore();
    // console.log(token)
    const GET = await fetch("/api/v1/resource/payment/" + PAY_ID, {
        method: "GET",
        headers: {
            'Authorization': `Bearer ${token}`, // Authorization header with Bearer token
            'Content-Type': 'application/json' // Example of setting another header
        },
    })
    let resp = await GET.json();

    const GET_BANK = await fetch("/api/v1/resource/bank", {
        method: "GET",
        headers: {
            'Authorization': `Bearer ${token}`, // Authorization header with Bearer token
            'Content-Type': 'application/json' // Example of setting another header
        },
    })
    let respBank = await GET_BANK.json();

    if (!resp || !respBank) {
        return;
    }

    const lang = getCookie('lang') ?? 'en';

    // console.log(lang)
    let option = '';
    respBank.forEach(item => {
        option += `<option  value="${item.blit_id}"> -- ${item.blit_name} (${item.blit_number}) --  </option>`;
    });
    let html = ``;
    let footer = `
    <button type="submint" onclick="submintFrom('yes','${PAY_ID}','${resp.PAY_IN}')"  class="btn btn-lg btn-outline-primary"  > Yes's </button>
    <button type="submint" onclick="submintFrom('no','${PAY_ID}','${resp.PAY_IN}')"  class="btn btn-lg btn-danger"  > No </button>`;

    const PAY_IN = resp.PAY_IN;
    const PAY_OUT = resp.PAY_OUT;
    if (PAY_IN == '1' && PAY_OUT == '0') {
        html += `
        <form id="id-approve" action="javascript:;" method="post" enctype="multipart/form-data">
            <div class="row ">
                <div class="col-12 mb-4">
                    <h4 class="text-start">Slip</h4>
                    <img src="/image?img=${resp.PAY_SLIP}" alt=" " class="w-100 rounded-3 " height="250px">
                </div>
                <div class="col-4">
                    <h4 class="text-start">Name</h4>
                </div>
                <div class="col-8">
                    <h4 class="text-start text-primary ">${resp.displayName}</h4>
                </div>
                <div class="col-4">
                    <h4 class="text-start">Amount</h4>
                </div>
                <div class="col-8">
                    <h4 class="text-start text-primary"> + ${currency(parseFloat(resp.PAY_MONEY))}</h4>
                </div>
                <div class="col-4">
                    <h4 class="text-start">Time</h4>
                </div>
                <div class="col-8">
                    <h4 class="text-start text-primary"> ${resp.PAY_DATE != null ? moment(resp.PAY_DATE + " " + resp.PAY_TIME).format("lll") : " - "}</h4>
                </div>

                <hr>

                <div class="col-4">
                    <h4 class="text-start">Bank name</h4>
                </div>
                <div class="col-8">
                    <h4 class="text-start text-primary"> ${resp.bank_name}</h4>
                </div>
                <div class="col-4">
                    <h4 class="text-start">Bank number</h4>
                </div>
                <div class="col-8">
                    <h4 class="text-start text-primary"> ${resp.blit_number}</h4>
                </div>
                <div class="col-4">
                    <h4 class="text-start">Account</h4>
                </div>
                <div class="col-8">
                    <h4 class="text-start text-primary"> ${resp.blit_name}</h4>
                </div>
            </div>
        </form>
        `;
    }

    if (PAY_IN == '0' && PAY_OUT == '1') {
        html += `

        <form id="id-approve" action="javascript:;" method="post" enctype="multipart/form-data">
            <div class="row ">
                <div class="mt-2 mb-4">
                    <label class="form-label" for="id-blit_id-approve">Withdraw money from </label>
                    <select name="blit_id" class="form-select w-100" id="id-blit_id-approve" required>
                        <option selected value=""> -- select --  </option>
                        ${option}
                    </select>
                </div>
                <hr>

                <div class="col-4">
                    <h4 class="text-start">Name</h4>
                </div>
                <div class="col-8">
                    <h4 class="text-start text-primary ">${resp.displayName}</h4>
                </div>
                <div class="col-4">
                    <h4 class="text-start">Amount</h4>
                </div>
                <div class="col-8">
                    <h4 class="text-start text-primary"> - ${currency(parseFloat(resp.PAY_MONEY))}</h4>
                </div>
                <hr>

                <div class="col-12 ${resp.user_bank ? "" : "d-none"}">
                    <div class="row">
                        <div class="col-4">
                            <h4 class="text-start">Bank name</h4>
                        </div>
                        <div class="col-8">
                            <h4 class="text-start text-primary"> ${resp.user_bank}</h4>
                        </div>
                        <div class="col-4">
                            <h4 class="text-start">Bank number</h4>
                        </div>
                        <div class="col-8">
                            <h4 class="text-start text-primary"> ${resp.user_bankNumber}</h4>
                        </div>
                        <div class="col-4">
                            <h4 class="text-start">Account</h4>
                        </div>
                        <div class="col-8">
                            <h4 class="text-start text-primary"> ${resp.user_bankFName} ${resp.user_bankLName}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        `;
    }


    modalShow('modalMain', "Confirm!", html, footer)
    $('select[name="blit_id"]').select2({
        dropdownParent: $("#modalMain")
    });
    return;
}
$(document).ready(function () {
    loadData();

    $('select[name="grId"]').select2({
        dropdownParent: $("#saveCardShowModal")
    });


    setInterval(() => {
        loadData();
    }, 20000);

});