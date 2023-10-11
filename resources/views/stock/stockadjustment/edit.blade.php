<x-layout title="stock Adjustment edit">

    @php
        $itemArray = [];
        $unitList = [];
        $transferDetailsList = [];
    @endphp

    @foreach ($items as $item)
        @php
            $itemArray[] = [
                'itemId' => $item->ItemCode,
                'itemName' => $item->ItemName,
                'itemPrice' => $item->UnitPrice,
                'weightByPrice' => $item->WeightByPrice,
            ];
        @endphp
    @endforeach

    @foreach ($units as $unit)
        @php
            $unitList[] = [
                'unitCode' => $unit->UnitCode,
                'unitName' => $unit->UnitDesc,
            ];
        @endphp
    @endforeach

    @foreach ($stockadjustment->stockadjustmentdetails as $key => $stockadjustmentdetail)
        @php
            $adjustmentDetailsList[] = [
                'LineNo' => $key + 1,
                'ItemCode' => $stockadjustmentdetail->ItemCode,
                'ItemName' => $stockadjustmentdetail->ItemName,
                'OldItemCode' => $stockadjustmentdetail->ItemCode,
                'Quantity' => (int) $stockadjustmentdetail->Quantity,
                'WeightByPrice' => (int) $stockadjustmentdetail->WeightByPrice,
                'PackedUnit' => $stockadjustmentdetail->PackedUnit,
                'QtyPerUnit' => (float) $stockadjustmentdetail->QtyPerUnit,
                'UnitName' => $stockadjustmentdetail->UnitDesc,
                'TotalViss' => (float) $stockadjustmentdetail->TotalViss,
                'OldTotalViss' => (float) $stockadjustmentdetail->TotalViss,
                'UnitPrice' => (int) $stockadjustmentdetail->UnitPrice,
                'Amount' => (int) $stockadjustmentdetail->Amount,
                'AdjustType' => $stockadjustmentdetail->AdjustType,
                'OldAdjustType' => $stockadjustmentdetail->AdjustType
            ];
        @endphp
    @endforeach

    <div class="container-fluid content-body mt-3">

        {{-- Section Title --}}

        <div class="row justify-content-between">
            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Update Stock Adjustment</h3>
            </div>
            {{-- Back Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/stockadjustment/index" class="btn main-btn">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

        {{-- End of Section Title --}}

        {{-- Form Section --}}

        <x-error name="Email"></x-error>

        <form action="/stockadjustment/update" method="Post" id="saveAdjustData"
            class="row form-card mt-2 mb-3 needs-validation" novalidate>
            @csrf

            <div class="col-12 px-0">

                <p class="p-0 content-title"><span>Basic Info</span></p>
                <div class="row">
                    {{-- Damage No --}}
                    <div class="col-12 col-md-6 col-xl-4 col-xxl-2 mb-2">
                        <label for="adjustmentNo" class="form-label cust-label">Adjustment No</label>
                        <input type="text" class="form-control cust-input-box" id="adjustmentNo" name="AdjustmentNo"
                            value="{{ $stockadjustment->AdjustmentNo }}" disabled>
                    </div>
                    {{-- Damage Date --}}
                    <div class="col-12 col-md-6 col-xl-4 col-xxl-2 mb-2">
                        <label for="adjustmentDate" class="form-label cust-label">Adjustment Date</label>
                        <input type="datetime" class="form-control cust-input-box" id="adjustmentDate"
                            name="AdjustmentDate" value="{{ $stockadjustment->AdjustmentDate }}" required>
                    </div>
                    <div class="invalid-feedback">
                        Please fill Adjustment date.
                    </div>
                    {{-- Warehouse --}}
                    <div class="col-12 col-md-6 col-xl-4 col-xxl-3 mb-2">
                        <label for="adjustmentWarehouse" class="form-label cust-label">Warehouse Name</label>
                        <select class="mb-3 form-select" id="adjustmentWarehouse" name="WarehouseNo" required>
                            <option value="" selected disabled>Choose</option>
                            @if (isset($warehouses) && is_object($warehouses) && count($warehouses) > 0)

                                @forelse ($warehouses as $warehouse)
                                    @if ($warehouse->WarehouseCode == $stockadjustment->Warehouse)
                                        <option value="{{ $warehouse->WarehouseCode }}" selected>
                                            {{ $warehouse->WarehouseName }}</option>
                                    @else
                                        <option value="{{ $warehouse->WarehouseCode }}">{{ $warehouse->WarehouseName }}
                                        </option>
                                    @endif

                                @empty
                                    <option disabled>No Warehouse Found</option>
                                @endforelse

                            @endif
                        </select>
                        <div class="invalid-feedback">
                            Please fill warehouse name.
                        </div>
                    </div>
                    {{-- Remarks --}}
                    <div class="col-12 col-md-6 col-xl-4 col-xxl-4 mb-2">
                        <label class="cust-label form-label text-end" for="adjustmentRemark">Remark</label>
                        <textarea class="form-control cust-textarea" name="" id="adjustmentRemark" rows="2">{{ $stockadjustment->Remark }}</textarea>
                    </div>
                </div>
                <p class="p-0 content-title"><span>Details</span></p>
                <button class="btn btn-noBorder" id="addNewLine" type="button"><span class="me-2">
                        <i class="bi bi-plus-circle"></i></span>New
                </button>
                <div class="row">
                    <div class="col-12">
                        <div class="saleTable">
                            <table class="table" id="stockAdjustmentItems">
                                <thead class="sticky-top">
                                    <tr id="0">
                                        <th style="width: 180px;">Item Name</th>
                                        <th style="width: 80px;" class="text-end">Quantity</th>
                                        {{-- <th style="width: 120px;">NQty</th> --}}
                                        <th style="width: 120px;">Unit</th>
                                        <th style="width: 100px;" class="text-end">Qty Per Unit</th>
                                        <th style="width: 130px;" class="text-end">Total Viss</th>
                                        <th style="width: 120px;" class="text-end">Unit Price</th>
                                        <th style="width: 150px;" class="text-end">Amount</th>
                                        <th style="width: 150px;" class="text-center">Adjust Type</th>
                                        <th style="width: 40px"></th>
                                    </tr>
                                </thead>
                                <tbody id="stockItemData">
                                    @foreach ($stockadjustment->stockadjustmentdetails as $key => $stockadjustmentdetail)
                                        <tr id="{{ $key + 1 }}">
                                            <td class="px-0 py-0" id="row{{ $key + 1 }}">
                                                <select name="" id="{{ $key + 1 }}"
                                                    class="stockItemList_{{ $key + 1 }}"
                                                    onchange="AddStockItem(event)">
                                                    @if (isset($items) && is_object($items) && count($items) > 0)
                                                        @forelse ($items as $item)
                                                            @if ($item->ItemCode == $stockadjustmentdetail->ItemCode)
                                                                <option value="{{ $item->ItemCode }}" selected>
                                                                    {{ $item->ItemName }}</option>
                                                            @else
                                                                <option value="{{ $item->ItemCode }}">
                                                                    {{ $item->ItemName }}</option>
                                                            @endif
                                                        @empty
                                                            <option disabled>No Item</option>
                                                        @endforelse
                                                    @endif
                                                </select>
                                            </td>
                                            <td class="px-0 py-0">
                                                <input type="number" value="{{ $stockadjustmentdetail->Quantity }}"
                                                    id="{{ $key + 1 }}" onblur="AddStockQty(event);"
                                                    onfocus="StockFocusValue(event)" />
                                            </td>
                                            <td class="px-0 py-0">
                                                <select name="" class="stockUnitList_{{ $key + 1 }}"
                                                    id="{{ $key + 1 }}" onchange="AddStockUnit(event);">
                                                    @if (isset($units) && is_object($units) && count($units) > 0)
                                                        @forelse ($units as $unit)
                                                            @if ($unit->UnitCode == $stockadjustmentdetail->PackedUnit)
                                                                <option value="{{ $unit->UnitCode }}" selected>
                                                                    {{ $unit->UnitDesc }}</option>
                                                            @else
                                                                <option value="{{ $unit->UnitCode }}">
                                                                    {{ $unit->UnitDesc }}</option>
                                                            @endif
                                                        @empty
                                                            <option disabled>No Unit Code Found</option>
                                                        @endforelse
                                                    @endif
                                                </select>
                                            </td>
                                            <td class="px-0 py-0">
                                                <input type="number" id="{{ $key + 1 }}"
                                                    onblur="AddStockQPU(event)" onfocus="StockFocusValue(event)"
                                                    value="{{ $stockadjustmentdetail->QtyPerUnit }}">
                                            </td>
                                            <td class="px-0 py-0">
                                                <input type="number" id="{{ $key + 1 }}"
                                                    onblur="AddStockViss(event)" onfocus="StockFocusValue(event)"
                                                    value="{{ $stockadjustmentdetail->TotalViss }}">
                                            </td>
                                            <td class="px-0 py-0">
                                                <input type="number" value="{{ $stockadjustmentdetail->UnitPrice }}"
                                                    id="{{ $key + 1 }}" onblur="AddStockPrice(event);"
                                                    onfocus="StockFocusValue(event)">
                                            </td>
                                            <td class="px-0 py-0">
                                                <input type="number" id="stockItemAmount"
                                                    value="{{ $stockadjustmentdetail->Amount }}" disabled>
                                            </td>
                                            <td class="px-0 py-0">
                                                <select name="" class="adjustType_{{$key + 1}}"
                                                    id="{{$key + 1}}" onchange="AddAdjustType(event);">
                                                    <option value="{{ $stockadjustmentdetail->AdjustType }}" disabled selected> {{ $stockadjustmentdetail->AdjustType }} </option>
                                                    <option value="add">add (+)</option>
                                                    <option value="minus">minus (-)</option>
                                                </select>
                                            </td>
                                            <td class="px-2 py-0">
                                                <button type="button" id="{{ $key + 1 }}"
                                                    class="btn delete-btn py-0 mt-1 px-1" id=""
                                                    onclick="DeleteLine(this.id)">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- Save Button --}}
                <div class="row mt-2">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success me-2" id="saveData">
                            <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Save
                        </button>
                        <button type="button" class="btn delete-btn" id="{{ $stockadjustment->AdjustmentNo }}"
                            onclick="PassAdjustmentNo(this.id);" data-bs-toggle="modal"
                            data-bs-target="#adjustmentDeleteModal">
                            <span class="me-2"><i class="bi bi-trash-fill"></i></span> Delete
                        </button>
                    </div>
                </div>
            </div>

        </form>

        {{-- End of form Section --}}

        {{-- Damage Delete Modal --}}

        <div class="modal fade" id="adjustmentDeleteModal" aria-labelledby="adjustmentDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i
                                class="bi bi-exclamation-diamond-fill"></i>
                        </h1>
                        <p class="text-center">Are you sure?</p>
                        <div class="text-center">
                            <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                            <a href="" id="deleteAdjustBtn" class="btn btn-primary py-1">Sure</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- End of Damage Delete Modal --}}

    </div>

    {{-- <script type="text/javascript">
        function postdata() {
            let data = {};
            let stockadjustmentDetailsArr = [];

            let stockadjustmentdetailsobject = {
                LineNo: 0,
                ItemCode: "SI-0001",
                OldItemCode: "SI-0001",
                Quantity: "100",
                PackedUnit: "kg",
                QtyPerUnit: "20",
                TotalViss: "70",
                OldTotalViss: "50",
                UnitPrice: "10000",
                Amount: "1000000",
                AdjustType: 'minus',
                OldAdjustType: 'add',

            }

            stockadjustmentDetailsArr.push(stockadjustmentdetailsobject);

            data.AdjustmentDate = '2023-08-17';
            data.Warehouse = "WH-0001";
            data.OldWarehouse = "WH-0001";
            data.Remark = "hello";
            data.Status = "O";



            data.stockadjustmentdetails = stockadjustmentDetailsArr;

            data = JSON.stringify(data);

            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });

            $.ajax({
                url: '/stockadjustment/update/AD-230800001',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(response) {

                    console.log(response);

                    if (response.message == "good") {

                        console.log(response.message);

                    }

                },
                error: function(error) {
                    console.log('no');
                    console.log(error.responseText);
                    res = JSON.parse(error.responseText);
                    console.log(res);
                }
            });

        }
    </script> --}}
</x-layout>

<script>
    dselect(document.querySelector("#adjustmentWarehouse"), config);

    let itemList = @json($itemArray);

    let unitList = @json($unitList);

    let stockItemDataList = @json($adjustmentDetailsList);

    let OldWarehouseNo = "{{ $stockadjustment->Warehouse }}";

    var lineNo = stockItemDataList.length + 1;

    $(document).ready(function() {

        stockItemDataList.forEach(e => {

            dselect(document.querySelector(".stockItemList_" + e.LineNo), config);

            dselect(document.querySelector(".stockUnitList_" + e.LineNo), config);

            dselect(document.querySelector(".adjustType_" + e.LineNo), {
                search: false,
                maxHeight: '150px'
            });

        });

    });

    // ===== Add New Line in Details Table ===== //

    $("#addNewLine").on('click', () => {

        let stockItemData = {
            LineNo: lineNo,
            ItemCode: "",
            ItemName: "",
            OldItemCode: "",
            Quantity: 1,
            WeightByPrice: 1,
            PackedUnit: "",
            QtyPerUnit: 0,
            UnitName: "",
            TotalViss: 0,
            OldTotalViss: 0,
            UnitPrice: 0,
            Amount: 0,
            AdjustType: "add",
            OldAdjustType: "",
        }

        const tableRow = document.createElement('tr');

        tableRow.setAttribute("id", lineNo);

        tableRow.innerHTML = `
            <td class="px-0 py-0" id="row` + lineNo + `">
                <select name="" id="` + lineNo + `" class="stockItemList_` + lineNo + `" onchange="AddStockItem(event)">
                    <option selected disabled>Choose</option>
                    @if (isset($items) && is_object($items) && count($items) > 0)
                        @forelse ($items as $item)
                            <option value="{{ $item->ItemCode }}">{{ $item->ItemName }}</option>
                        @empty
                            <option disabled>No Item Found</option>
                        @endforelse
                    @else
                        <option disabled selected>No Item Found</option>
                    @endif
                </select>
            </td>
            <td class="px-0 py-0">
                <input type="number" value="0" id="` + lineNo + `" onblur="AddStockQty(event);" onfocus="StockFocusValue(event)" />
            </td>
            <td class="px-0 py-0">
                <select name="" class="stockUnitList_` + lineNo + `" id="` + lineNo + `" onchange="AddStockUnit(event);">
                    <option selected disabled>Choose</option>
                    @if (isset($units) && is_object($units) && count($units) > 0)
                        @forelse ($units as $unit)
                            <option value="{{ $unit->UnitCode }}">{{ $unit->UnitDesc }}</option>
                        @empty
                            <option disabled>No Unit Found</option>
                        @endforelse
                    @else
                        <option disabled selected>No Unit Found</option>
                    @endif
                </select>
            </td>
            <td class="px-0 py-0">
                <input type="number" id="` + lineNo + `" onblur="AddStockQPU(event)" onfocus="StockFocusValue(event)" value="0">
            </td>
            <td class="px-0 py-0">
                <input type="number" id="` + lineNo + `" onblur="AddStockViss(event)" onfocus="StockFocusValue(event)" value="0">
            </td>
            <td class="px-0 py-0">
                <input type="number" value="0" id="` + lineNo + `" onblur="AddStockPrice(event);" onfocus="StockFocusValue(event)">
            </td>
            <td class="px-0 py-0">
                <input type="number" id="stockItemAmount" disabled>
            </td>
            <td class="px-0 py-0">
                <select name="" class="adjustType_` + lineNo + `" id="` + lineNo + `" onchange="AddAdjustType(event);">
                    <option value="add">add (+)</option>
                    <option value="minus">minus (-)</option>
                </select>
            </td>
            <td class="px-2 py-0">
                <button type="button" id="` + lineNo + `" class="btn delete-btn py-0 mt-1 px-1" id="" onclick="DeleteLine(this.id)">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </td>`;

        stockItemDataList.push(stockItemData);

        document.getElementById("stockItemData").appendChild(tableRow);

        dselect(document.querySelector(".stockItemList_" + lineNo), config);

        dselect(document.querySelector(".stockUnitList_" + lineNo), config);

        dselect(document.querySelector(".adjustType_" + lineNo), {
            search: false,
            maxHeight: '150px'
        });

        lineNo++;

    });

    // ===== End of Add New Line in Details Table ===== //

    // ===== Add Stock Item Function ===== //

    function AddStockItem(event) {

        let rowNo = event.target.id;

        let inputValue = event.target.value;

        console.log(inputValue);

        stockItemDataList.forEach(e => {

            if (e.LineNo == rowNo) {

                e.ItemCode = inputValue;

                itemList.forEach(el => {

                    if (e.ItemCode == el.itemId) {

                        e.ItemName = el.itemName;

                        e.UnitPrice = el.itemPrice;

                        e.WeightPrice = el.weightByPrice;

                        TableRowReplace(rowNo, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e
                            .UnitName, e.QtyPerUnit, e.TotalViss, e.UnitPrice, e.Amount, e
                            .AdjustType);

                    }

                });

            }

        });
    }

    // ===== End of Add Stock Item Fucntion ===== //

    // ===== Add Stock Qty Function ===== //

    function AddStockQty(event) {

        let rowNo = event.target.id;

        let inputValue = event.target.value;

        stockItemDataList.forEach(e => {

            if (e.LineNo == rowNo) {

                if (inputValue > 0) {

                    e.Quantity = Number(inputValue);

                } else {

                    e.Quantity = 0;

                }

                e.TotalViss = (e.QtyPerUnit * e.Quantity).toFixed(3);

                e.Amount = Math.round(e.UnitPrice * (e.TotalViss / e.WeightPrice));

                TableRowReplace(rowNo, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e
                    .QtyPerUnit, e.TotalViss, e.UnitPrice, e.Amount, e.AdjustType);

            }

        });

    }

    // ===== End of Add Stock Qty Function  ===== //

    // ===== Add Stock Unit Function ===== //

    function AddStockUnit(event) {

        let rowNo = event.target.id;

        let inputValue = event.target.value;

        console.log(inputValue);

        stockItemDataList.forEach(e => {

            if (e.LineNo == rowNo) {

                e.PackedUnit = inputValue;

                unitList.forEach(el => {

                    if (e.PackedUnit == el.unitCode) {

                        e.UnitName = el.unitName;
                    }

                });

            }
        });
    }

    // ===== End of Add Stock Unit Function ===== //

    // ===== Add Qty Per Unit Function ===== // 

    function AddStockQPU(event) {

        let rowNo = event.target.id;

        let inputValue = event.target.value;

        stockItemDataList.forEach(e => {

            if (e.LineNo == rowNo) {

                if (inputValue > 0) {

                    e.QtyPerUnit = Number(inputValue);

                } else {

                    e.QtyPerUnit = 0;

                }

                e.TotalViss = (e.Quantity * e.QtyPerUnit).toFixed(3);

                e.Amount = Math.floor(e.UnitPrice * (e.TotalViss / e.WeightPrice));

                TableRowReplace(rowNo, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e
                    .QtyPerUnit, e.TotalViss, e.UnitPrice, e.Amount, e.AdjustType);

            }

        });
    }

    // ===== End of Add QtyPerUnit Function ===== //

    // ===== Add Stock Total Viss Function ===== //

    function AddStockViss(event) {

        let rowNo = event.target.id;

        let inputValue = event.target.value;

        stockItemDataList.forEach(e => {

            if (e.LineNo == rowNo) {

                if (inputValue > 0) {

                    e.TotalViss = Number(inputValue);

                } else {

                    e.TotalViss = 0;
                }

                e.Amount = Math.round(e.UnitPrice * (e.TotalViss / e.WeightPrice));

                TableRowReplace(rowNo, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e
                    .QtyPerUnit, e.TotalViss, e.UnitPrice, e.Amount, e.AdjustType);

            }

        });

    }

    // ===== End of Add Stock Total Viss Function ===== //

    // ===== Add Stock Price Function ===== //

    function AddStockPrice(event) {

        let rowNo = event.target.id;

        let inputValue = event.target.value;

        stockItemDataList.forEach(e => {

            if (e.LineNo == rowNo) {

                if (inputValue > 0) {

                    e.UnitPrice = Number(inputValue);

                } else {

                    e.UnitPrice = 0;

                }

                e.Amount = Math.round(e.UnitPrice * (e.TotalViss / e.WeightPrice));

                TableRowReplace(rowNo, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e
                    .QtyPerUnit, e.TotalViss, e.UnitPrice, e.Amount, e.AdjustType)

            }

        });

    }

    // ===== End of Add Stock Price Function ===== //

    // ===== Add Adjust Type Function ===== //

    function AddAdjustType(event) {

        let rowNo = event.target.id;

        console.log(event.target.value);

        stockItemDataList.forEach(e => {

            if (e.LineNo == rowNo) {

                e.AdjustType = event.target.value;

                TableRowReplace(rowNo, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e
                    .QtyPerUnit, e.TotalViss, e.UnitPrice, e.Amount, e.AdjustType);

            }

        });

    }

    // ===== End of Add Adjust Type Function ===== //

    // ===== Table Row Replace Function ===== //

    function TableRowReplace(refNo, ItemCode, ItemName, Quantity, PackedUnit, UnitName, QtyPerUnit, TotalViss,
        UnitPrice, Amount, AdjustType) {

        let mainTable = document.getElementById('stockAdjustmentItems');

        console.log(UnitName);

        let noRow = mainTable.rows.length;

        for (let i = 0; i < noRow; i++) {

            let rowId = mainTable.rows[i].getAttribute('id');

            if (rowId == refNo) {

                mainTable.rows[i].innerHTML = `
            <td class="px-0 py-0" id="row` + refNo + `">
                <select name="" id="` + refNo + `" class="stockItemList_` + refNo + `" onchange="AddStockItem(event)">
                    <option value="` + ItemCode + `" selected disabled>` + ItemName + `</option>
                    @if (isset($items) && is_object($items) && count($items) > 0)
                        @forelse ($items as $item)
                            <option value="{{ $item->ItemCode }}">{{ $item->ItemName }}</option>
                        @empty
                            <option disabled>No Item Found</option>
                        @endforelse
                    @else
                        <option disabled selected>No Item Found</option>
                    @endif
                </select>
            </td>
            <td class="px-0 py-0">
                <input type="number" value="` + Quantity + `" id="` + refNo + `" onblur="AddStockQty(event);" onfocus="StockFocusValue(event)" />
            </td>
            <td class="px-0 py-0">
                <select name="" class="stockUnitList_` + refNo + `" id="` + refNo + `" onchange="AddStockUnit(event);">
                    <option value="` + PackedUnit + `" selected disabled>` + UnitName + `</option>
                    @if (isset($units) && is_object($units) && count($units) > 0)
                        @forelse ($units as $unit)
                            <option value="{{ $unit->UnitCode }}">{{ $unit->UnitDesc }}</option>
                        @empty
                            <option disabled>No Unit Found</option>
                        @endforelse
                    @else
                        <option disabled>No Unit Found</option>
                    @endif
                </select>
            </td>
            <td class="px-0 py-0">
                <input type="number" id="` + refNo +
                    `" onblur="AddStockQPU(event)" onfocus="StockFocusValue(event)" value="` + QtyPerUnit + `">
            </td>
            <td class="px-0 py-0">
                <input type="number" id="` + refNo +
                    `" onblur="AddStockViss(event)" onfocus="StockFocusValue(event)" value="` + TotalViss + `">
            </td>
            <td class="px-0 py-0">
                <input type="number" value="` + UnitPrice + `" id="` + refNo + `" onblur="AddStockPrice(event);" onfocus="StockFocusValue(event)">
            </td>
            <td class="px-0 py-0">
                <input type="number" value="` + Amount + `" id="stockItemAmount" disabled>
            </td>
            <td class="px-0 py-0">
                <select name="" class="adjustType_` + refNo + `" id="` + refNo + `" onchange="AddAdjustType(event);">
                    <option value="`+ AdjustType +`" disabled selected>`+ AdjustType +`</option>
                    <option value="add">add (+)</option>
                    <option value="minus">minus (-)</option>
                </select>
            </td>
            <td class="px-2 py-0">
                <button type="button" id="` + refNo + `" class="btn delete-btn py-0 mt-1 px-1" id="" onclick="DeleteLine(this.id)">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </td>`;
            }
        }

        dselect(document.querySelector(".stockItemList_" + refNo), config);

        dselect(document.querySelector(".stockUnitList_" + refNo), config);

        dselect(document.querySelector(".adjustType_" + refNo), {
            search: false,
            maxHeight: '150px'
        });

    }

    // ===== End of Table Row Replace Function ===== //

    // ===== Delete Row Function ====== //

    function DeleteLine(rowNo) {

        let maintable = document.getElementById('stockTransferItems');

        let noRow = maintable.rows.length;

        for (let i = 0; i < noRow; i++) {

            let rowId = maintable.rows[i].getAttribute('id');

            if (rowId == rowNo) {

                maintable.deleteRow(i);

                break;
            }
        }

        stockItemDataList = stockItemDataList.filter(e => e.LineNo != rowNo);
    }

    // ====== End of Delete Row Function ====== //

    // ====== Focus Function ===== //

    function StockFocusValue(event) {

        let inputValue = Number(event.target.value.replace(/,/g, ''));

        event.target.removeAttribute('value');

        event.target.removeAttribute('type');

        event.target.setAttribute('type', 'number');

        event.target.setAttribute('value', inputValue);

        event.target.select();

    }

    // ====== End of Focus Function ===== //

    // ====== Save Data Function ===== //

    $("#saveAdjustData").submit(SaveTransferData);

    function SaveTransferData(event) {

        event.preventDefault();

        let adjustmentNo = $("#adjustmentNo").val();

        let WarehouseNo = $("#adjustmentWarehouse").val();

        let errorMsg = "";

        let rowNo = 0;

        if (WarehouseNo == null) {

            toastr.warning('Please enter warehouse name.');

            return;

        }

        let data = {};

        let stockAdjustDetails = [];

        stockItemDataList.forEach(e => {

            console.log(e.PackedUnit);

            if (e.ItemCode != "") {

                if (e.PackedUnit == "") {

                    errorMsg = "U";

                    rowNo = e.LineNo;

                    return;

                } else {

                    let stockAdjustObject = {
                        LineNo: e.LineNo,
                        ItemCode: e.ItemCode,
                        OldItemCode: e.OldItemCode,
                        Quantity: e.Quantity,
                        PackedUnit: e.PackedUnit,
                        QtyPerUnit: e.QtyPerUnit,
                        TotalViss: e.TotalViss,
                        OldTotalViss: e.OldTotalViss,
                        OldAdjustType: e.OldAdjustType,
                        UnitPrice: e.UnitPrice,
                        Amount: e.Amount,
                        AdjustType: e.AdjustType
                    }

                    stockAdjustDetails.push(stockAdjustObject);

                }

            }

        });

        if (errorMsg == "U") {

            toastr.warning('Please enter Unit Name in line no ' + rowNo);

            return;

        } else if (stockAdjustDetails.length == 0) {

            toastr.warning('Please choose at least one item.');

            return;

        }

        data.AdjustmentNo = adjustmentNo;
        data.AdjustmentDate = $("#adjustmentDate").val();
        data.Warehouse = WarehouseNo;
        data.OldWarehouse = OldWarehouseNo;
        data.Remark = $("#adjustmentRemark").val();
        data.Status = "O";

        data.stockadjustmentdetails = stockAdjustDetails;

        data = JSON.stringify(data);

        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        });

        $.ajax({
            url: '/stockadjustment/update/' + adjustmentNo,
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {

                console.log(response);

                if (response.message == "good") {

                    window.location.href = '/stockadjustment/index';

                }

            },
            error: function(error) {
                console.log('no');
                console.log(error.responseText);
                res = JSON.parse(error.responseText);
                console.log(res);
            }
        });

    }

    // ====== End of Save Data Function ===== //
</script>
