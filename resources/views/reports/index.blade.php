<x-layout title="Reports">

    <div class="container-fluid mt-3 content-body">

    {{-- Section Title --}}

        <div class="row justify-content-between">
            {{-- Title --}}
            <div class="col-6 p-0">
                <h3 class="section-title">Reports</h3>
            </div>
        </div>

    {{-- End of Section Title --}}

    <div class="row mt-2 px-0 form-card">
        <div class="col-6 col-xl-8 report-column">
            <div class="row">
                <div class="col-xl-6">
                    <div class="report-title mt-2">
                        <span class="report-text">Setup Reports</span>
                        <a type="button" id="setupDropdown" onclick="DropDown(event)"><i class="fa fa-circle-chevron-down" subMenu="setupMenu"></i></a>
                    </div>
                    <ul id="setupMenu">
                        <li>
                            <a href="/user/reports"><span class="me-2"><i class="bi bi-file-text"></i></span>User Report</a>
                        </li>
                        <li>
                            <a href="/systemrole/reports"><span class="me-2"><i class="bi bi-file-text"></i></span>System Role Report</a>
                        </li>
                        <li>
                            <a href="/customer/reports"><span class="me-2"><i class="bi bi-file-text"></i></span>Customer Report</a>
                        </li>
                        <li>
                            <a href="/supplier/reports"><span class="me-2"><i class="bi bi-file-text"></i></span>Supplier Report</a>
                        </li>
                        <li>
                            <a href="/category/reports"><span class="me-2"><i class="bi bi-file-text"></i></span>Category Report</a>
                        </li>
                        <li>
                            <a href="/unit/reports"><span class="me-2"><i class="bi bi-file-text"></i></span>Unit Of Measurement Report</a>
                        </li>
                        <li>
                            <a href="/item/reports"><span class="me-2"><i class="bi bi-file-text"></i></span>Item Report</a>
                        </li>
                        <li>
                            <a href="/warehouse/reports"><span class="me-2"><i class="bi bi-file-text"></i></span>Warehouse Report</a>
                        </li>
                    </ul>
                    <div class="report-title mt-2">
                        <span class="report-text">Purchase Reports</span>
                        <a type="button" id="puDropdown" onclick="DropDown(event)"><i class="fa fa-circle-chevron-down" subMenu="puMenu"></i></a>
                    </div>
                    <ul id="puMenu">
                        <li>
                            <a href="/itemarrival/reports"><span class="me-2"><i class="bi bi-file-text"></i></span>Item Arrival Report</a>
                        </li>
                        <li>
                            <a type="button" displayId="purchaseFilter" closeId="salesFilter" onclick="DisplayBlock(event)"><span class="me-2"><i class="bi bi-file-text"></i></span>Purchase Invoice Report</a>
                        </li>
                    </ul>
                </div>
                <div class="col-xl-6">
                    <div class="report-title mt-2">
                        <span class="report-text">Sales Reports</span>
                        <a type="button" id="saleDropdown" onclick="DropDown(event)"><i class="fa fa-circle-chevron-down" subMenu="saleMenu"></i></a>
                    </div>
                    <ul id="saleMenu">
                        <li>
                            <a type="button" displayId="salesFilter" closeId="purchaseFilter" onclick="DisplayBlock(event)"><span class="me-2"><i class="bi bi-file-text"></i></span>Sales Invoice Report</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-4 report-filter">
            <form action="/purchaseinvoices/reports" id="purchaseFilter">
                <div class="row mb-4">
                    <span class="report-text" style="width: fit-content;">Purchase Report Filter</span>
                </div>
                <div class="row px-2 justify-content-center">
                    <div class="form-check col-3">
                        <input class="form-check-input cust-form-check" type="radio" name="PaymentStatus" id="paidPayment" value="paid" @if (request('PaymentStatus') === "paid") checked = "checked" @endif>
                        <label class="form-check-label" for="paidPayment">
                            Paid
                        </label>
                    </div>
                    <div class="form-check col-3">
                        <input class="form-check-input cust-form-check" type="radio" name="PaymentStatus" id="unpaidPayment" value="nopaid" @if (request('PaymentStatus') === "nopaid") checked = "checked" @endif>
                        <label class="form-check-label" for="unpaidPayment">
                            Unpaid
                        </label>
                    </div>
                    <div class="form-check col-3">
                        <input class="form-check-input cust-form-check" type="radio" name="PaymentStatus" id="all" value="all" @if (request('PaymentStatus') === "all") checked = "checked" @endif>
                        <label class="form-check-label" for="all">
                            All
                        </label>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <label for="endDate" class="form-label cust-label">Start Date</label>
                    </div>
                    <div class="col-8">
                        <input type="date" class="form-control cust-input-box col-xxl-8" id="startDate" value="{{request('startDate')}}" name="startDate">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <label for="endDate" class="form-label cust-label">End Date</label>
                    </div>
                    <div class="col-8">
                        <input type="date" class="form-control cust-input-box col-xxl-8" id="endDate" value="{{request('endDate')}}" name="endDate">
                    </div>
                </div>
                <div class="row mt-2 justify-content-end">
                    <div class="col-4 text-end">
                        <button type="submit" class="btn main-btn py-1 px-3"><span class="me-1"><i class="bi bi-funnel"></i></span>Filter</button>
                    </div>
                </div>
            </form>
            <form action="/salesinvoices/reports" id="salesFilter">
                <div class="row mb-4">
                    <span class="report-text" style="width: fit-content;">Sales Report Filter</span>
                </div>
                <div class="row px-2 justify-content-center">
                    <div class="form-check col-3">
                        <input class="form-check-input cust-form-check" type="radio" name="PaymentStatus" id="salesPaid" value="paid" @if (request('PaymentStatus') === "paid") checked = "checked" @endif>
                        <label class="form-check-label" for="salesPaid">
                            Paid
                        </label>
                    </div>
                    <div class="form-check col-3">
                        <input class="form-check-input cust-form-check" type="radio" name="PaymentStatus" id="salesUnpaid" value="nopaid" @if (request('PaymentStatus') === "nopaid") checked = "checked" @endif>
                        <label class="form-check-label" for="salesUnpaid">
                            Unpaid
                        </label>
                    </div>
                    <div class="form-check col-3">
                        <input class="form-check-input cust-form-check" type="radio" name="PaymentStatus" id="salesAll" value="all" @if (request('PaymentStatus') === "all") checked = "checked" @endif>
                        <label class="form-check-label" for="salesAll">
                            All
                        </label>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <label for="endDate" class="form-label cust-label">Start Date</label>
                    </div>
                    <div class="col-8">
                        <input type="date" class="form-control cust-input-box col-xxl-8" id="saleStartDate" value="{{request('saleStartDate')}}" name="saleStartDate">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <label for="endDate" class="form-label cust-label">End Date</label>
                    </div>
                    <div class="col-8">
                        <input type="date" class="form-control cust-input-box col-xxl-8" id="saleEndDate" value="{{request('saleEndDate')}}" name="saleEndDate">
                    </div>
                </div>
                <div class="row mt-2 justify-content-end">
                    <div class="col-4 text-end">
                        <button type="submit" class="btn main-btn py-1 px-3"><span class="me-1"><i class="bi bi-funnel"></i></span>Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    {{-- Customer Delete Modal --}}

        <div class="modal fade" id="customerDeleteModal" aria-labelledby="customerDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i></h1>
                        <p class="text-center">Are you sure?</p>
                        <div class="text-center">
                            <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                            <a href="" id="deleteCustBtn" class="btn btn-primary py-1">Sure</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- End of Custoemr Delete Modal --}}

    </div>

</x-layout>
