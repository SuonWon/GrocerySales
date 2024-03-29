import("./dselect.js");

$(document).ready(function () {
    var windowHeight = window.innerHeight;
    var windowWidth = window.innerWidth;

    var tableHeight = 380;

    if (windowWidth <= 766) {
        tableHeight = 320;
    } else {
        tableHeight = 450;
    }

    // Category DataTable

    $("#itemCategoryList").DataTable({
        order: [],
        scrollX: true,
        fixedColumns: {
            right: 1,
        },
        dom: '<"toolbar">frtip',
    });

    // Unit DataTable

    $("#unitList").DataTable({
        scrollX: true,
        fixedColumns: {
            right: 1,
        },
        dom: '<"toolbar">frtip',
    });

    // Unit DataTable

    $("#itemList").DataTable({
        scrollX: true,
        fixedColumns: {
            left: 1,
            right: 1,
        },
        dom: '<"toolbar">frtip',
    });

    // Customer DataTable

    $("#custList").DataTable({
        scrollX: true,
        fixedColumns: {
            left: 1,
            right: 1,
        },
        columnDefs: [
            { width: "120px", targets: 0 },
            { width: "130px", targets: 1 },
            { width: "130px", targets: 2 },
            { width: "130px", targets: 3 },
            { width: "130px", targets: 4 },
            { width: "100px", targets: 5 },
            { width: "100px", targets: 6 },
            { width: "130px", targets: 7 },
            { width: "170px", targets: 8 },
            { width: "100px", targets: 9 },
            { width: "100px", targets: 10 },
            { width: "180px", targets: 11 },
        ],
        dom: '<"toolbar">frtip',
    });

    // Warehouse DataTable

    $("#warehouseList").DataTable({
        scrollX: true,
        fixedColumns: {
            right: 1,
        },
        dom: '<"toolbar">frtip',
    });

    // Supplier DataTable

    $("#supplierList").DataTable({
        scrollX: true,
        fixedColumns: {
            right: 1,
        },
        dom: '<"toolbar">frtip',
    });

    // Company DataTable

    $("#companyList").DataTable({
        scrollX: true,
        fixedColumns: {
            right: 1,
        },
        dom: '<"toolbar">frtip',
    });

    // User DataTable

    $("#userList").DataTable({
        scrollX: true,
        fixedColumns: {
            right: 1,
        },
        dom: '<"toolbar">frtip',
    });

    // System Role DataTable

    $("#systemroleList").DataTable({
        scrollX: true,
        fixedColumns: {
            right: 1,
        },
        dom: '<"toolbar">frtip',
    });

    // Item Arrival DataTable

    $("#itemArrivalList").DataTable({
        scrollX: true,
        order: [],
        fixedColumns: {
            right: 1,
        },
        dom: '<"toolbar">frtip',
    });

    // Purchase DataTable

    $("#purchaseList").DataTable({
        dom: '<"toolbar">frtip',
        "lengthMenu": [20,30,50,75,100],
        scrollX: true,
        order: [],
        fixedColumns: {
            right: 1,
        },
    });

    // Sales DataTable

    $("#salesList").DataTable({
        scrollX: true,
        "lengthMenu": [20,30,50,75,100],
        order: [],
        fixedColumns: {
            right: 1,
        },
        dom: '<"toolbar">frtip',
    });

    // Delete Invoice DataTable

    $("#deleteInvoiceList").DataTable({
        scrollX: true,
        fixedColumns: {
            left: 1,
        },
        dom: '<"toolbar">frtip',
    });

    // Delete Sales DataTable

    $("#deleteSales").DataTable({
        scrollX: true,
        fixedColumns: {
            left: 1,
        },
        dom: '<"toolbar">frtip',
    });

    // Stock Transfer List DataTable

    $("#stockTransferList").DataTable({
        scrollX: true,
        order: [],
        fixedColumns: {
            right: 1,
        },
        dom: '<"toolbar">frtip',
    }); 

    // Stock Damage List DataTable

    $("#stockDamageList").DataTable({
        scrollX: true,
        order: [],
        fixedColumns: {
            right: 1,
        },
        dom: '<"toolbar">frtip',
    });

    // Stock Adjustment List DataTable

    $("#stockAdjustmentList").DataTable({
        scrollX: true,
        order: [],
        fixedColumns: {
            right: 1,
        },
        dom: '<"toolbar">frtip',
    });

});

// Delete Category function

function PassId(itemCategoryCode) {
    $("#deleteCategoryBtn").attr(
        "href",
        "/category/delete/" + itemCategoryCode
    );
}

// Delete Unit function

function PassUnitCode(unitCode) {
    $("#deleteUnitBtn").attr("href", "/unit/delete/" + unitCode);
}

// Delete Customer function

function PassCustomerCode(custCode) {
    $("#deleteCustBtn").attr("href", "/customer/delete/" + custCode);
}

// Delete Warehouse function

function PassWarehouseCode(warehouseCode) {
    $("#deleteWarehouseBtn").attr("href", "/warehouse/delete/" + warehouseCode);
}

// Delete Supplier function

function PassSupplierCode(supplierCode) {
    $("#deleteSupplierBtn").attr("href", "/supplier/delete/" + supplierCode);
}

// Delete Item function

function PassItemCode(itemCode) {
    $("#deleteItemBtn").attr("href", "/item/delete/" + itemCode);
}

// Delete Company Function

function PassCompanyCode(companyCode) {
    $("#deleteCompanyBtn").attr(
        "href",
        "/companyinformation/delete/" + companyCode
    );
}

// Delete RoleId

function PassRoleId(RoleId) {
    $("#deleteRoleBtn").attr("href", "/systemrole/delete/" + RoleId);
}

// Delete User

function PassUserId(userId) {
    $("#deleteUserBtn").attr("href", "/user/delete/" + userId);
}

// Delete Item Arrival

function PassItemArrivalCode(arrivalCode) {
    $("#deleteItemArrivalBtn").attr(
        "href",
        "/itemarrival/delete/" + arrivalCode
    );
}

// Delete Purchase Invoice

function PassPurchaseInNo(invoiceNo) {
    $("#deletePurchaseBtn").attr(
        "href",
        "/purchaseinvoices/delete/" + invoiceNo
    );
}

// Delete Sales Invoice

function PassSaleInNo(invoiceNo) {
    $("#deleteSaleBtn").attr("href", "/salesinvoices/delete/" + invoiceNo);
}

// Delete Stock Transfer

function PassTransferNo(transferNo) {
    $("#deleteTransferBtn").attr("href", "/stocktransfer/delete/" + transferNo);
}

// Delete Stock Damage

function PassDamageNo(damageNo) {
    $("#deleteDamageBtn").attr("href", "/stockdamage/delete/" + damageNo);
}

// Delete Adjustment Damage

function PassAdjustmentNo(adjustNo) {
    $("#deleteAdjustBtn").attr("href", "/stockadjustment/delete/" + adjustNo);
}

// Delete Adjustment Damage

function PassTransactionId(id) {
    alert(id);
    $("#deleteTransactionBtn").attr("href", "/walletTransaction/delete/" + id);
}

// Check Number Function

function CheckNumber(event) {

    allowNum = /^[0-9/,]+$/;

    if (event.target.value < 0 || !allowNum.test(event.target.value)) {

        $("#"+event.target.id).val(0);

    }

    let inputValue = Number((event.target.value).replace(/,/g, ""));

    $("#"+event.target.id).val(inputValue);


}

// Auto seclect value function

function AutoSelectValue(event) {
    event.target.select();
}

var dropdownBtn = document.getElementById("dropdownBtn");
var dropdownMenu = document.getElementById("dropdownMenu");

function DropDown(event) {
    console.log(event.target.getAttribute("subMenu"));
    let dropdownMenu = document.getElementById(
        event.target.getAttribute("subMenu")
    );
    dropdownMenu.classList.toggle("close");
}

function DisplayBlock(event) {
    let displayId = event.target.getAttribute("displayId");

    let closeId = event.target.getAttribute("closeId");

    document.getElementById(closeId).style.display = "none";

    document.getElementById(displayId).style.display = "block";
}

const config = { search: true, maxHeight: '150px'};

const forms = document.querySelectorAll(".needs-validation");

// Loop over them and prevent submission
Array.from(forms).forEach((form) => {
    form.addEventListener(
        "submit",
        (event) => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add("was-validated");
        },
        false
    );
});

var loadFile = function (event) {
    console.log('hello');
    var image = document.getElementById("output");
    image.style.zIndex = 1;
    document.querySelector("#file").style.zIndex = 200;
    document.querySelector(".inputImageLabel").style.opacity = "0";
    document.querySelector(".inputImageUpload").style.borderRadius = "10px";
    image.src = URL.createObjectURL(event.target.files[0]);
};
