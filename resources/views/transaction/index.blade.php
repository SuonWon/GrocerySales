<x-layout title="Transaction List">

    @php
        $transactionList = []
    @endphp

    @foreach ($transactions as $transaction)
        @php
            $transactionList[] = [
                'id' => $transaction->Id,
                'customerCode' => $transaction->CustomerCode,
                'date' => $transaction->Date,
                'cashType' => $transaction->CashType,
                'amount' => $transaction->Amount,
                'remark' => $transaction->Remark,
                'status' => $transaction->Status,
            ];
        @endphp
    @endforeach


    <div class="container-fluid mt-2 content-body">

        {{-- Section Title --}}

        <div class="row justify-content-between">

            {{-- Title --}}
            <div class="col-12 p-0 d-flex gap-2 justify-content-between">
                <h3 class="section-title">Transaction List</h3>
                <div>
                    <button class="btn btn-success px-2 py-1 cust-label" data-bs-toggle="modal" data-bs-target="#cashInOut" onclick="AddTransaction('in');">
                        <span class="me-1"><i class="bi bi-plus-circle"></i></span>Cash In
                    </button>
                    <button class="btn btn-danger px-2 py-1 cust-label" data-bs-toggle="modal" data-bs-target="#cashInOut" onclick="AddTransaction('out');">
                        <span class="me-1"><i class="bi bi-dash-circle"></i></span>Cash Out
                    </button>
                </div>
            </div>
        </div>

        {{-- End of Section Title --}}

        {{-- Filter Section --}}

        <div class="row mt-1">
            <div class="filter-box">
                <form action="" method="GET" class="row justify-content-left">
                    @csrf
                    {{-- Start Date --}}
                    <div class="col-6 col-md-4 col-xl-2 col-xxl-2 mb-2">
                        <label for="saleStartDate" class="form-label cust-label">Start Date</label>
                        <input type="date" class="form-control cust-input-box" id="saleStartDate"
                            value="{{ request('saleStartDate') }}" name="saleStartDate">
                    </div>
                    {{-- End Date --}}
                    <div class="col-6 col-md-4 col-xl-2 col-xxl-2 mb-2">
                        <label for="saleEndDate" class="form-label cust-label">End Date</label>
                        <input type="date" class="form-control cust-input-box" id="saleEndDate"
                            value="{{ request('saleEndDate') }}" name="saleEndDate">
                    </div>
                    {{-- Payment Status --}}
                    <div class="col-2 col-md-4 col-xl-2 col-xxl-1">
                        <div class="form-check">
                            <input class="form-check-input col-4" type="radio" name="PaymentStatus" id="all"
                                value="all" @if (request('PaymentStatus') === 'all') checked = "checked" @endif>
                            <label class="form-check-label col-5" for="all">
                                All
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input col-4" type="radio" name="PaymentStatus" id="paidPayment"
                                value="paid" @if (request('PaymentStatus') === 'paid') checked = "checked" @endif>
                            <label class="form-check-label col-5" for="paidPayment">
                                Paid
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input col-4" type="radio" name="PaymentStatus" id="unpaidPayment"
                                value="nopaid" @if (request('PaymentStatus') === 'nopaid') checked = "checked" @endif>
                            <label class="form-check-label col-5" for="unpaidPayment">
                                Unpaid
                            </label>
                        </div>
                    </div>
                    {{-- Filter Button --}}
                    <div class="col-10 col-md-9 col-xl-6 col-xxl-4 mb-2 pt-2">
                        <div class="d-flex justify-content-center align-items-center mt-2" style="height: 100%">
                            {{-- Filter Button --}}
                            <button class="btn filter-btn py-1 px-2 px-sm-3" id="filterBtn"><span class="me-1"><i
                                        class="bi bi-funnel"></i></span>Filter</button>
                            {{-- Cancel Button --}}
                            <a href="/salesinvoices/index" type="button"
                                class="btn btn-light ms-1 ms-sm-2 py-1 px-2 px-sm-3" id="filterCancel"><span
                                    class="me-1"><i class="bi bi-x-circle"></i></span>Reset</a>
                            {{-- Deleted Invoice Button --}}
                            {{-- <button type="button"
                                class="btn deleted-invoice py-1 px-2 px-sm-3 ms-1 ms-sm-2 position-relative"
                                data-bs-toggle="modal" data-bs-target="#deletedSalesInvoices">
                                <span class="me-1"><i class="bi bi-list-ul"></i></span>Deleted Invoice
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                                    style="background-color: #ff0000;">{{ count($deletesalesinvoices) }}</span>
                            </button> --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- End of Filter Section --}}

        {{-- Transaction List --}}

        <div class="row mt-2 justify-content-center">
            @php
                $role = auth()->user()->systemrole->RoleDesc;
            @endphp
            <div class="table-card">
                <table id="salesList" class="table table-striped nowrap">
                    <thead>
                        <tr>
                            {{-- <th style="width: 150px !important;">Transaction Id</th> --}}
                            <th style="width: 120px !important;">Transaction Date</th>
                            <th style="width: 150px !important;">Customer Name</th>
                            <th style="width: 100px !important;">Cash Type</th>
                            <th class="text-end" style="width: 150px !important;">Amount</th>
                            <th class="text-center" style="width: 300px !important;">Remark</th>
                            @if ($role == 'admin')
                                <th style="width: 150px">Created By</th>
                                <th style="width: 150px">Created Date</th>
                                <th style="width: 150px">Modified By</th>
                                <th style="width: 150px">Modified Date</th>
                            @endif
                            <th style="width: 50px !important;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                {{-- <td>{{$transaction->Id}}</td> --}}
                                <td>{{$transaction->Date}}</td>
                                <td>{{$transaction->CustomerName}}</td>
                                <td>{{$transaction->CashType}}</td>
                                <td class="text-end">{{number_format($transaction->Amount)}}</td>
                                <td>{{$transaction->Remark}}</td>
                                @if ($role == 'admin')
                                        <td>{{$transaction->CreatedBy}}</td>
                                        <td>{{$transaction->CreatedDate}}</td>
                                        <td>{{$transaction->ModifiedBy}}</td>
                                        <td>{{$transaction->ModifiedDate}}</td>
                                @endif
                                <td class="text-center">
                                    <button data-bs-toggle="modal" data-bs-target="#cashInOut" id="{{$transaction->Id}}" class="btn btn-primary py-0 px-1 me-2" onclick="UpdateTransaction(this.id);">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button class="btn delete-btn py-0 px-1" id="{{$transaction->Id}}" onclick="PassTransactionId(this.id);" data-bs-toggle="modal" data-bs-target="#transactionDelete">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- End of Transaction List --}}

        {{-- Cash In Modal --}}

            <div class="modal fade" id="cashInOut" aria-labelledby="cashInOut" style="z-index: 99999 !important;">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header py-3" id="modalHeader">
                            <h3 class="section-title items-center mb-0" id="cashTitle"></h3>
                            <button type="button" class="cust-btn-close rounded-circle" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <form id="transactionForm" action="/walletTransaction/add" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="modal-body">
                                <div class="row px-2">
                                    {{-- Transaction Date --}}
                                    <div class="col-12 col-md-6 col-xl-5 px-1">
                                        <label for="transactionDate" class="form-label cust-label">Date</label>
                                        <input type="Date" class="form-control cust-input-box" id="transactionDate"
                                        name="Date" value="{{$todayDate}}">
                                    </div>
                                    {{-- customer Code --}}
                                    <div class="col-12 col-md-6 col-xl-7 px-1">
                                        <label for="customerList" class="form-label cust-label">Customer Name</label>
                                        <select class="mb-3 form-select" id="customerList" name="CustomerCode" required>
                                            <option value="" selected disabled>Choose</option>
                                            @if (isset($customers) && is_object($customers) && count($customers) > 0)
                                                @forelse ($customers as $customer)
                                                    <option value="{{ $customer->CustomerCode }}">{{ $customer->CustomerName }}</option>
                                                @empty
                                                    <option disabled>No Customer Found</option>
                                                @endforelse
                                            @else
                                                <option disabled selected>No Customer Found</option>
                                            @endif
                                        </select>
                                        <div class="invalid-feedback">
                                            Please fill customer.
                                        </div>
                                    </div>
                                    {{-- Cash Type --}}
                                    <div class="col-12 col-md-6 col-xl-5 px-1">
                                        <label for="cashTypeList" class="form-label cust-label">Cash Type</label>
                                        <select class="mb-3 form-select" id="cashType" name="CashType" required>
                                            <option value="CASHIN">Cash In</option>
                                            <option value="CASHOUT" selected>Cash Out</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please fill cash type.
                                        </div>
                                    </div>
                                    {{-- Transaction Date --}}
                                    <div class="col-12 col-md-6 col-xl-7 px-1">
                                        <label for="transactionAmount" class="form-label cust-label">Amount</label>
                                        <input type="number" class="form-control cust-input-box text-end" id="transactionAmount"
                                        name="Amount" value="0" onfocus="SelectValue(event);">
                                    </div>
                                    {{-- Transaction Date --}}
                                    <div class="col-12 px-1">
                                        <label for="remark" class="form-label cust-label">Remark</label>
                                        <textarea rows="2" class="form-control cust-textarea" id="remark"
                                        name="Remark" value="" required></textarea>
                                        <div class="invalid-feedback">
                                            Please fill remark.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">
                                    <span class="me-2">
                                        <i class="fa fa-floppy-disk" id="faDisk"></i>
                                        <i class="fa-solid fa-spinner fa-spin" id="faSaveRotate"></i>
                                    </span>
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>  
            </div>

        {{-- End of Cash In Modal --}}

        {{-- Sales Delete Modal --}}

            <div class="modal fade" id="transactionDelete" aria-labelledby="transactionDelete">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i></h1>
                        <p class="text-center">Are you sure?</p>
                        <div class="text-center">
                            <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                            <a href="" id="deleteTransactionBtn" class="btn btn-primary py-1">Sure</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

        {{-- End of Sales Delete Modal --}}

    </div>

</x-layout>

<script src="{{asset('assets/js/moment.js')}}"></script>

<script>

    dselect(document.querySelector("#customerList"), config);

    dselect(document.querySelector("#cashType"), config);

    var transactionList = @json($transactionList);

    var transactionForm = document.getElementById("transactionForm");

    var modalHeader = document.getElementById("modalHeader");

    var cashTitle = document.getElementById("cashTitle");

    var cashType = document.getElementById("cashType");

    function AddTransaction(type) {
        let todayDate = moment().format("YYYY-MM-DD");
        cashTitle.innerText = type == "in" ? "Cash In" : "Cash Out";
        modalHeader.classList.remove(type == "in" ? "bg-danger" : "bg-success");
        modalHeader.classList.add(type == "in" ? "bg-success" : "bg-danger");
        cashType.value = type == "in" ? "CASHIN" : "CASHOUT";
        transactionForm.removeAttribute("action");
        transactionForm.removeAttribute("method");
        transactionForm.setAttribute("action", "/walletTransaction/add");
        transactionForm.setAttribute("method", "POST");
        document.getElementById("transactionAmount").value = 0;
        document.getElementById("customerList").value = "";
        document.getElementById("transactionDate").value = todayDate;
        document.getElementById("remark").value = "";
        dselect(document.querySelector("#cashType"), config);
        dselect(document.querySelector("#customerList"), config);
    }

    function UpdateTransaction(id) {
        selectedData = transactionList.find(el => el.id == id);
        let transactionDate = moment(selectedData.date).format("YYYY-MM-DD");
        // let month = transactionDate.getMonth() < 10 ? `0${transactionDate.getMonth()+1}` : `${transactionDate.getMonth()+1}`;
        cashTitle.innerText = selectedData.cashType == "CASHIN" ? "Cash In" : "Cash Out";
        modalHeader.classList.remove(selectedData.cashType == "CASHIN" ? "bg-danger" : "bg-success");
        modalHeader.classList.add(selectedData.cashType == "CASHIN" ? "bg-success" : "bg-danger");
        transactionForm.removeAttribute("action");
        transactionForm.removeAttribute("method");
        cashType.value = selectedData.cashType;
        document.getElementById("transactionDate").value = transactionDate;
        // document.getElementById("transactionDate").value = `${transactionDate.getFullYear()}-${month}-${transactionDate.getDate()}`;
        document.getElementById("transactionAmount").value = selectedData.amount;
        document.getElementById("remark").value = selectedData.remark;
        transactionForm.setAttribute("action", `/walletTransaction/edit/${id}`);
        transactionForm.setAttribute("method", "POST");
        document.getElementById("customerList").value = selectedData.customerCode;
        dselect(document.querySelector("#cashType"), config);
        dselect(document.querySelector("#customerList"), config);
    }

    function SelectValue(event) {
        event.target.select()
    }

</script>
