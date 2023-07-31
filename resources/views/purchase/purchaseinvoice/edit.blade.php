<x-layout title="Edit Purchase">

    @php
        $purchaseProductDataList = [];
        $warehouseList = [];
        $itemArray = [];
        $unitList = [];
        $itemArrival = [];
        $supplierList = [];
    @endphp

    @foreach ($purchaseinvoice->purchaseinvoicedetails as $key => $purchaseinvoicedetail)
        @php
            $purchaseProductDataList[] = [
                'referenceNo' => $key + 1,
                'ReferenceNo' => $purchaseinvoicedetail->ReferenceNo,
                'WarehouseNo' => $purchaseinvoicedetail->WarehouseCode,
                'WarehouseName' => $purchaseinvoicedetail->WarehouseName,
                'ItemCode' => $purchaseinvoicedetail->ItemCode,
                'ItemName' => $purchaseinvoicedetail->ItemName,
                'WeightPrice' => $purchaseinvoicedetail->WeightByPrice,
                'Quantity' => $purchaseinvoicedetail->Quantity,
                'PackedUnit' => $purchaseinvoicedetail->PackedUnit,
                'QtyPerUnit' => $purchaseinvoicedetail->QtyPerUnit,
                'UnitName' => $purchaseinvoicedetail->UnitDesc,
                'TotalViss' => $purchaseinvoicedetail->TotalViss,
                'UnitPrice' => $purchaseinvoicedetail->UnitPrice,
                'Amount' => $purchaseinvoicedetail->Amount,
                'LineDisPer' => $purchaseinvoicedetail->LineDisPer,
                'LineDisAmt' => $purchaseinvoicedetail->LineDisAmt,
                'LineTotalAmt' => $purchaseinvoicedetail->LineTotalAmt,
                'IsFOC' => $purchaseinvoicedetail->IsFOC,
            ];
        @endphp
    @endforeach

    @foreach ($items as $item)
        @php
            $itemArray[] = [
                'itemId' => $item->ItemCode,
                'itemName' => $item->ItemName,
                'itemPrice' => $item->UnitPrice,
                'weightPrice' => $item->WeightByPrice,
            ];
        @endphp
    @endforeach

    @foreach ($warehouses as $warehouse)
        @php
            $warehouseList[] = [
                'warehouseCode' => $warehouse->WarehouseCode,
                'warehouseName' => $warehouse->WarehouseName,
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

    @foreach ($suppliers as $supplier)
        @php
            $supplierList[] = [
                'supplierCode' => $supplier->SupplierCode,
                'supplierName' => $supplier->SupplierName,
                'profit' => $supplier->Profit,
            ];
        @endphp
    @endforeach

    @foreach ($arrivals as $arrival)
        @php
            $itemArrival[] = [
                'arrivalCode' => $arrival->ArrivalCode,
                'plateNo' => $arrival->PlateNo,
                'supplierCode' => $arrival->SupplierCode,
                'charges' => $arrival->TotalCharges,
                'totalBags' => $arrival->TotalBags,
                'otherCharges' => $arrival->OtherCharges,
            ];
        @endphp
    @endforeach

    <div class="container-fluid content-body mt-3">

        {{-- Section Title --}}

        <div class="row justify-content-between">
            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Purchase Invoice</h3>
            </div>
            {{-- Back Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/purchaseinvoices/index" class="btn main-btn">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

        {{-- End of Section Title --}}



        {{-- Form Section --}}

        <x-error name="Email"></x-error>

        <form action="/purchaseinvoices/update/{{ $purchaseinvoice->InvoiceNo }}" method="Post" id="updatePurchaseForm"
            class="row form-card mt-2 mb-3 needs-validation" novalidate>
            @csrf
            <div class="col-12 px-0">

                <p class="p-0 content-title"><span>Basic Info</span></p>
                <div class="row">
                    {{-- Invoice No --}}
                    <div class="col-12 col-md-6 col-xl-4 col-xxl-2 mb-2">
                        <label for="invoiceNo" class="form-label cust-label">Invoice No</label>
                        <input type="text" class="form-control cust-input-box" id="invoiceNo" name="InvoiceNo"
                            value="{{ $purchaseinvoice->InvoiceNo }}" disabled>
                    </div>
                    {{-- Purchase Date --}}
                    <div class="col-12 col-md-6 col-xl-4 col-xxl-2 mb-2">
                        <label for="purchaseDate" class="form-label cust-label">Purchase Date</label>
                        <input type="date" class="form-control cust-input-box" id="purchaseDate" name="PurchaseDate"
                            value="{{ $purchaseinvoice->PurchaseDate }}" required>
                        <div class="invalid-feedback">
                            Please fill Purchase Date.
                        </div>
                    </div>
                    {{-- Supplier Code --}}
                    <div class="col-12 col-md-6 col-xl-4 col-xxl-2 mb-2">
                        <label for="supplierCodeList" class="form-label cust-label">Supplier Name</label>
                        <select class="mb-3 form-select" id="supplierCodeList" name="SupplierCode"
                            onchange="AddSupplierData();" required>

                            @if (isset($suppliers) && is_object($suppliers) && count($suppliers) > 0)

                                @forelse ($suppliers as $supplier)
                                    @if ($supplier->SupplierCode == $purchaseinvoice->SupplierCode)
                                        <option value="{{ $supplier->SupplierCode }}" selected>
                                            {{ $supplier->SupplierName }}</option>
                                    @else
                                        <option value="{{ $supplier->SupplierCode }}">{{ $supplier->SupplierName }}
                                        </option>
                                    @endif

                                @empty
                                    <option disabled>No Supplier Found</option>
                                @endforelse

                            @endif
                        </select>
                        <div class="invalid-feedback">
                            Please fill Supplier Code.
                        </div>
                    </div>
                    {{-- Arrival Code --}}
                    <div class="col-12 col-md-6 col-xl-4 col-xxl-2 mb-2">
                        <label for="arrivalCodeList" class="form-label cust-label">Plate No/Name</label>
                        <div class="d-flex">
                            <div class="col-12">
                                <select class="mb-3 form-select me-2" id="arrivalCodeList" name="ArrivalCode" onchange="AddArrivalData(event);" required>

                                    @forelse ($selectArrival as $arrival)
                                        @if ($arrival->ArrivalCode == $purchaseinvoice->ArrivalCode)
                                            <option value="{{ $arrival->ArrivalCode }}" selected>
                                                {{ $arrival->PlateNo }}
                                            </option>
                                        @elseif ($arrival->Status == 'N')
                                            <option value="{{ $arrival->ArrivalCode }}">{{ $arrival->PlateNo }}
                                            </option>
                                        @endif

                                    @empty
                                        <option disabled>No Arrival Code Found</option>
                                    @endforelse
                                </select>
                                <div class="invalid-feedback">
                                    Please fill Arrival Code.
                                </div>
                            </div>
                            {{-- <input class="form-check-input cust-form-check col-2" type="checkbox" value="" name="IsComplete" id="isArrivalComplete" {{$purchaseinvoice->IsComplete == 1 ? 'checked' : ''}}> --}}
                        </div>

                    </div>
                    {{-- Remarks --}}
                    <div class="col-12 col-md-6 col-xl-4 col-xxl-4 mb-2">
                        <label 6class="cust-label form-label text-end" for="purchaseRemark">Remark</label>
                        <textarea class="form-control cust-textarea mt-2" name="" id="purchaseRemark" rows="2">{{ $purchaseinvoice->Remark }}</textarea>
                    </div>
                </div>

                <p class="p-0 content-title"><span>Payment Info</span></p>
                <div class="row">
                    <div class="col-md-8 col-xl-7 col-xxl-6">
                        <div class="row">

                            {{-- Paid Date --}}
                            <div class="col-12 col-md-6 col-xl-5 col-xxl-4 mb-2">
                                <label for="paidDate" class="form-label cust-label">Paid Date</label>
                                <input type="date" class="form-control cust-input-box" id="paidDate" name="PaidDate"
                                    value="{{ $purchaseinvoice->PaidDate }}"
                                    {{ $purchaseinvoice->IsPaid == 1 ? '' : 'disabled' }}>
                            </div>
                            {{-- Paid Status --}}
                            <div class="col-12 col-md-6 col-xl-4 col-xxl-3 mb-2">
                                <label class="cust-label form-label text-end" for="isPaid">Paid</label>
                                <div class="col-sm-8 form-check form-switch">
                                    <input class="form-check-input cust-form-switch" type="checkbox" role="switch"
                                        id="isPaid" name="IsPaid"
                                        {{ $purchaseinvoice->IsPaid == 1 ? 'checked' : '' }}
                                        onchange="PuEPaidCheck(event);">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="p-0 content-title"><span>Details</span></p>
                <button class="btn btn-noBorder" id="addNewRow" type="button"><span class="me-2"><i
                            class="bi bi-plus-circle"></i></span>New</button>
                <div class="row">
                    <div class="purchaseTable">
                        <table class="table" id="purchaseProdList">
                            <thead class="sticky-top">
                                <tr id="0">
                                    {{-- <th style="width: 50px;">No</th> --}}
                                    <th style="width: 200px;">Item Name</th>
                                    <th style="width: 200px;">Warehouse Name</th>
                                    <th style="width: 120px;">Quantity</th>
                                    <th style="width: 80px;">Unit</th>
                                    <th style="width: 80px;">QPU</th>
                                    <th style="width: 150px;">Total Viss</th>
                                    <th style="width: 120px;">Unit Price</th>
                                    <th style="width: 150px;">Amount</th>
                                    <th style="width: 60px;">Discount(%)</th>
                                    <th style="width: 120px;">Discount</th>
                                    <th style="width: 170px;">Total Amount</th>
                                    <th style="width: 50px;">FOC</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="displaySelectedItems">
                                @foreach ($purchaseinvoice->purchaseinvoicedetails as $key => $purchaseinvoicedetail)
                                    <tr id="{{ $key + 1 }}">
                                        {{-- <td class="px-0 py-0">
                                            <input type="text" class="tableInput" name="" id="referenceNo" value="{{$key + 1}}" disabled>
                                        </td> --}}
                                        {{-- Item Name --}}
                                        <td class="px-0 py-0" id="row_{{ $key + 1 }}">
                                            <select name="" id="{{ $key + 1 }}"
                                                class="itemCodeList_{{ $key + 1 }}"
                                                onchange="AddProduct(this.id,this.value)">
                                                @if (isset($items) && is_object($items) && count($items) > 0)
                                                    @forelse ($items as $item)
                                                        @if ($item->ItemCode == $purchaseinvoicedetail->ItemCode)
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
                                        {{-- Warehouse Name --}}
                                        <td class="px-0 py-0">
                                            <select name="" id="{{ $key + 1 }}"
                                                class="warehouseList_{{ $key + 1 }}"
                                                onchange="AddWarehouse(this.id,this.value);">
                                                @if (isset($warehouses) && is_object($warehouses) && count($warehouses) > 0)
                                                    @forelse ($warehouses as $warehouse)
                                                        @if ($warehouse->WarehouseCode == $purchaseinvoicedetail->WarehouseCode)
                                                            <option value="{{ $warehouse->WarehouseCode }}" selected>
                                                                {{ $warehouse->WarehouseName }}</option>
                                                        @else
                                                            <option value="{{ $warehouse->WarehouseCode }}">
                                                                {{ $warehouse->WarehouseName }}</option>
                                                        @endif
                                                    @empty
                                                        <option disabled>No Warehouse Code Found</option>
                                                    @endforelse
                                                @endif
                                            </select>
                                        </td>
                                        {{-- Quantity --}}
                                        <td class="px-0 py-0">
                                            <input type="text" class="text-end" id="{{ $key + 1 }}"
                                                value="{{ number_format($purchaseinvoicedetail->Quantity) }}"
                                                onblur="AddUnitQty(event,this.id,this.value);"
                                                onfocus="PEditFocus(event)" nextFocus="puprice_{{ $key + 1 }}">
                                        </td>
                                        {{-- Unit --}}
                                        <td class="px-0 py-0">
                                            <select name="" class="unitCodeList_{{ $key + 1 }}"
                                                id="{{ $key + 1 }}" onchange="AddUnit(this.id, this.value);">
                                                @if (isset($units) && is_object($units) && count($units) > 0)
                                                    @forelse ($units as $unit)
                                                        @if ($unit->UnitCode == $purchaseinvoicedetail->UnitCode)
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
                                        {{-- QtyPerUnit --}}
                                        <td class="px-0 py-0">
                                            <input type="number" class="qtyunit_{{ $key + 1 }}" name=""
                                                id="{{ $key + 1 }}"
                                                value="{{ $purchaseinvoicedetail->QtyPerUnit }}"
                                                onblur="AddQtyPerUnit(event,this.id,this.value)"
                                                onfocus="PEditFocus(event)">
                                        </td>
                                        {{-- Total Viss --}}
                                        <td class="px-0 py-0">
                                            <input type="number" class="puviss_{{ $key + 1 }}" name=""
                                                id="{{ $key + 1 }}"
                                                value="{{ $purchaseinvoicedetail->TotalViss }}"
                                                onblur="AddTotalViss(event,this.id,this.value)"
                                                onfocus="PEditFocus(event)">
                                        </td>
                                        {{-- Unit Price --}}
                                        <td class="px-0 py-0">
                                            <input type="text" class="puprice_{{ $key + 1 }} text-end"
                                                id="{{ $key + 1 }}"
                                                value="{{ number_format($purchaseinvoicedetail->UnitPrice) }}"
                                                onblur="AddUnitPrice(event,this.id, this.value)"
                                                onfocus="PEditFocus(event)" nextFocus="puviss_{{ $key + 1 }}">
                                        </td>
                                        {{-- Item Amount --}}
                                        <td class="px-0 py-0">
                                            <input type="text" class="tableInput text-end" name=""
                                                id="itemAmount"
                                                value="{{ number_format($purchaseinvoicedetail->Amount) }}" disabled>
                                        </td>
                                        {{-- Discount Rate --}}
                                        <td class="px-0 py-0">
                                            <input type="number" class="tableInput" name=""
                                                id="{{ $key + 1 }}"
                                                value="{{ $purchaseinvoicedetail->LineDisPer }}"
                                                onblur="AddDiscountRate(this.id, this.value);"
                                                onfocus="PEditFocus(event)">
                                        </td>
                                        {{-- Discount Amount --}}
                                        <td class="px-0 py-0">
                                            <input type="text" class="text-end" name=""
                                                id="{{ $key + 1 }}"
                                                value="{{ number_format($purchaseinvoicedetail->LineDisAmt) }}"
                                                onblur="AddDiscountAmount(this.id, this.value);"
                                                onfocus="PEditFocus(event)">
                                        </td>
                                        {{-- Line Total Amount --}}
                                        <td class="px-0 py-0">
                                            <input type="text" class="text-end" id="totalAmt"
                                                value="{{ number_format($purchaseinvoicedetail->LineTotalAmt) }}"
                                                disabled>
                                        </td>
                                        {{-- Is Foc --}}
                                        <td class="px-3 py-0">
                                            <input type="checkbox" class="form-check-input cust-form-check mt-2"
                                                id="{{ $key + 1 }}"
                                                {{ $purchaseinvoicedetail->IsFOC == 1 ? 'checked' : '' }}
                                                onchange="AddFoc(event, this.id)">
                                        </td>
                                        {{-- Action Button --}}
                                        <td class="px-2 py-0">
                                            <button type="button" id="{{ $key + 1 }}"
                                                class="btn delete-btn py-0 mt-1 px-1"
                                                onclick="DeletePurInvoiceRow(this.id)">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-3 justify-content-between">
                    <div class="col-xl-5 col-xxl-4">
                        <p class="p-0 content-title"><span>Charges</span></p>
                        {{-- Shipping Charges --}}
                        <div class="row justify-content-end">
                            <label for="shippingCharges" class="form-label text-end charges-label col-6">တန်ဆာခ
                                :</label>
                            <div class="col-5 col-xl-5 col-xxl-6 mb-2">
                                <input type="text" class="form-control cust-input-box text-end"
                                    id="shippingCharges" name="ShippingCharges"
                                    value=@foreach ($arrivals as $arrival)
                                        @if ($arrival->ArrivalCode == $purchaseinvoice->ArrivalCode)
                                            {{number_format($arrival->TotalCharges)}}
                                        @endif
                                    @endforeach
                                    onblur="PuEditCharges(event);">
                            </div>
                        </div>
                        {{-- Other Charges --}}
                        <div class="row justify-content-end">
                            <label for="otherCharges" class="form-label text-end charges-label col-6">ကြိုထုတ်ငွေ
                                :</label>
                            <div class="col-5 col-xl-5 col-xxl-6 mb-2">
                                <input type="text" class="form-control cust-input-box text-end"
                                    id="otherCharges" name="OtherCharges"
                                    value=@foreach ($arrivals as $arrival)
                                        @if ($arrival->ArrivalCode == $purchaseinvoice->ArrivalCode)
                                            {{number_format($arrival->OtherCharges)}}
                                        @endif
                                    @endforeach
                                    onblur="PuEditCharges(event);">
                            </div>
                        </div>
                        {{-- Labor Charges --}}
                        <div class="row justify-content-end">
                            <label for="laborCharges"
                                class="form-label text-end charges-label col-6">ကမ်းတတ်အလုပ်သမားခ :</label>
                            <div class="col-5 col-xl-5 col-xxl-6 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="laborCharges"
                                    name="LaborCharges" value="{{ number_format($purchaseinvoice->LaborCharges) }}"
                                    onblur="PuEditCharges(event);">
                            </div>
                        </div>
                        {{-- Delivery Charges --}}
                        <div class="row justify-content-end">
                            <label for="deliveryCharges" class="form-label text-end charges-label col-6">ကမ်းတတ်ကားခ
                                :</label>
                            <div class="col-5 col-xl-5 col-xxl-6 mb-2">
                                <input type="text" class="form-control cust-input-box text-end"
                                    id="deliveryCharges" name="DeliveryCharges"
                                    value="{{ number_format($purchaseinvoice->DeliveryCharges) }}"
                                    onblur="PuEditCharges(event);">
                            </div>
                        </div>
                        {{-- Weight Charges --}}
                        <div class="row justify-content-end">
                            <label for="weightCharges"
                                class="form-label text-end charges-label col-6">ပွဲရုံအလုပ်သမားခ :</label>
                            <div class="col-5 col-xl-5 col-xxl-6 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="weightCharges"
                                    name="WeightCharges" value="{{ number_format($purchaseinvoice->WeightCharges) }}"
                                    onblur="PuEditCharges(event);">
                            </div>
                        </div>
                        {{-- Service Charges --}}
                        <div class="row justify-content-end">
                            <label for="serviceCharges" class="form-label text-end charges-label col-6">အကျိုးဆောင်ခ
                                :</label>
                            <div class="col-5 col-xl-5 col-xxl-6 mb-2">
                                <input type="text" class="form-control cust-input-box text-end"
                                    id="serviceCharges" name="ServiceCharges"
                                    value="{{ number_format($purchaseinvoice->ServiceCharges) }}" rowNo="23"
                                    onblur="PuEditCharges(event);">
                            </div>
                        </div>
                        {{-- Service Charges --}}
                        <div class="row justify-content-end">
                            <label for="factoryCharges" class="form-label text-end charges-label col-6">စက်ကြိတ်ခ
                                :</label>
                            <div class="col-5 col-xl-5 col-xxl-6 mb-2">
                                <input type="text" class="form-control cust-input-box text-end"
                                    id="factoryCharges" name="FactoryCharges"
                                    value="{{ number_format($purchaseinvoice->FactoryCharges) }}" rowNo="23"
                                    onblur="PuEditCharges(event);">
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="col-xl-6">
                        {{-- Sub Total --}}
                        <div class="row justify-content-end mt-2">
                            <label for="subTotal" class="form-label text-end cust-label col-5 col-xl-4 col-xxl-3">Sub
                                Total :</label>
                            <div class="col-5 col-xl-5 col-xxl-4 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="subTotal"
                                    name="SubTotal" value="{{ number_format($purchaseinvoice->SubTotal) }}" disabled>
                            </div>
                        </div>
                        {{-- Total Charges --}}
                        <div class="row justify-content-end">
                            <label for="totalCharges"
                                class="form-label text-end cust-label col-5 col-xl-4 col-xxl-3">Total Charges :</label>
                            <div class="col-5 col-xl-5 col-xxl-4 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="totalCharges"
                                    name="TotalCharges" value="{{ number_format($purchaseinvoice->TotalCharges) }}"
                                    disabled>
                            </div>
                        </div>
                        {{-- Grand Total --}}
                        <div class="row justify-content-end">
                            <label for="grandTotal"
                                class="form-label text-end cust-label col-5 col-xl-4 col-xxl-3">Grand Total :</label>
                            <div class="col-5 col-xl-5 col-xxl-4 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="grandTotal"
                                    name="GrandTotal" value="{{ number_format($purchaseinvoice->GrandTotal) }}"
                                    disabled>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Save Button --}}
                <div class="row mt-2">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success me-2" id="saveData">
                            <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Update
                        </button>
                        <button type="button" class="btn btn-primary me-2" id="pUpdatePuVoucher">
                            <span class="me-2"><i class="fa fa-print"></i></span> Save & Preview
                        </button>
                        <button type="button" class="btn delete-btn" id="{{ $purchaseinvoice->InvoiceNo }}"
                            onclick="PassPurchaseInNo(this.id);" data-bs-toggle="modal"
                            data-bs-target="#purchaseDeleteModal">
                            <span class="me-2"><i class="bi bi-trash-fill"></i></span> Delete
                        </button>
                    </div>
                </div>
            </div>

        </form>

        {{-- End of form Section --}}

        {{-- Purchase Delete Modal --}}

        <div class="modal fade" id="purchaseDeleteModal" aria-labelledby="purchaseDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i
                                class="bi bi-exclamation-diamond-fill"></i></h1>
                        <p class="text-center">Are you sure?</p>
                        <div class="text-center">
                            <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                            <a href="" id="deletePurchaseBtn" class="btn btn-primary py-1">Sure</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- End of Purchase Delete Modal --}}

    </div>

</x-layout>

<script>
    dselect(document.querySelector("#arrivalCodeList"), config);

    dselect(document.querySelector("#supplierCodeList"), config);


    let itemArray = @json($itemArray);

    let warehouseList = @json($warehouseList);

    let unitList = @json($unitList);

    let supplierList = @json($supplierList);

    let itemArrival = @json($itemArrival);

    let purchaseProductDataList = @json($purchaseProductDataList);

    let rowNo = purchaseProductDataList.length + 1;

    $(document).ready(function() {

        purchaseProductDataList.forEach((e) => {

            dselect(document.querySelector(".warehouseList_" + e.referenceNo), config);

            dselect(document.querySelector(".itemCodeList_" + e.referenceNo), config);

            dselect(document.querySelector(".unitCodeList_" + e.referenceNo), config);

        });

        DisplayTotalCharges();

    });

    $("#addNewRow").on("click", () => {

        let purchaseProductData = {
            referenceNo: rowNo,
            WarehouseNo: "",
            WarehouseName: "",
            ItemCode: "",
            ItemName: "",
            WeightPrice: 1,
            Quantity: 1,
            PackedUnit: "",
            QtyPerUnit: 0,
            UnitName: "",
            TotalViss: 1,
            UnitPrice: 0,
            Amount: 0,
            LineDisPer: 0,
            LineDisAmt: 0,
            LineTotalAmt: 0,
            IsFOC: 0
        }

        const newRow = document.createElement('tr');

        newRow.setAttribute("id", rowNo);

        newRow.innerHTML = `
                            <td class="px-0 py-0" id="row_` + rowNo + `">
                                <select name="" id="` + rowNo + `" class="itemCodeList_` + rowNo + `" onchange="AddProduct(this.id,this.value)">
                                    <option selected disabled>Choose</option>
                                    @forelse ($items as $item) 
                                        <option value="{{ $item->ItemCode }}">{{ $item->ItemName }}</option>
                                    @empty
                                        <option disabled>No Item</option>
                                    @endforelse
                                </select>
                            </td>
                            <td class="px-0 py-0">
                                <select name="" id="` + rowNo + `" class="warehouseList_` + rowNo + `" onchange="AddWarehouse(this.id,this.value);">
                                    <option selected disabled>Choose</option>
                                    @forelse ($warehouses as $warehouse) 
                                        <option value="{{ $warehouse->WarehouseCode }}">{{ $warehouse->WarehouseName }}</option>
                                    @empty
                                        <option disabled>No Arrival Code Found</option>
                                    @endforelse
                                </select>
                            </td>
                            <td class="px-0 py-0">
                                <input type="text" class="text-end" id="` + rowNo +
            `" onblur="AddUnitQty(event,this.id,this.value);" value="0" onfocus="PEditFocus(event);" nextfocus="puprice_` +
            rowNo + `">
                            </td>
                            <td class="px-0 py-0">
                                <select name="" class="unitCodeList_` + rowNo + `" id="` + rowNo + `" onchange="AddUnit(this.id, this.value);">
                                    <option selected disabled>Choose</option>
                                    @forelse ($units as $unit) 
                                        <option value="{{ $unit->UnitCode }}">{{ $unit->UnitDesc }}</option>
                                    @empty
                                        <option disabled>No Arrival Code Found</option>
                                    @endforelse
                                </select>
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" id="` + rowNo + `" onblur="AddQtyPerUnit(event,this.id,this.value)" onfocus="PEditFocus(event);">
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" id="` + rowNo + `" onblur="AddTotalViss(event,this.id,this.value)" onfocus="PEditFocus(event);">
                            </td>
                            <td class="px-0 py-0">
                                <input type="text" class="puprice_` + rowNo + ` text-end" name="" id="` + rowNo +
            `" onblur="AddUnitPrice(event,this.id,this.value);" value="" onfocus="PEditFocus(event);" nextfocus="puviss_` +
            rowNo + `">
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="tableInput" name="" id="itemAmount" disabled>
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="tableInput" name="" id="` + rowNo + `" onblur="AddDiscountRate(this.id, this.value);" value="0" onfocus="PEditFocus(event);">
                            </td>
                            <td class="px-0 py-0">
                                <input type="text" class="text-end" name="" id="` + rowNo + `" onblur="AddDiscountAmount(this.id, this.value);" value="0" onfocus="PEditFocus(event);">
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="tableInput" name="" id="totalAmt" disabled>
                            </td>
                            <td class="px-3 py-0">
                                <input type="checkbox" class="form-check-input cust-form-check mt-2" id="` + rowNo + `" onchange="AddFoc(event, this.id)">
                            </td>
                            <td class="px-2 py-0">
                                <button type="button" id="` + rowNo + `" class="btn delete-btn py-0 mt-1 px-1" id="" onclick="DeletePurInvoiceRow(this.id)">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>`;

        document.getElementById("displaySelectedItems").appendChild(newRow);

        dselect(document.querySelector(".warehouseList_" + rowNo), config);

        dselect(document.querySelector(".itemCodeList_" + rowNo), config);

        dselect(document.querySelector(".unitCodeList_" + rowNo), config);

        purchaseProductDataList.push(purchaseProductData);

        rowNo++;

    });

    // ======= End of Add New Row Function ====== //

    // ======= Add Item Function ======== //

    function AddProduct(refNo, inputValue) {

        purchaseProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                e.ItemCode = inputValue;

                itemArray.forEach(element => {

                    if (element.itemId == inputValue) {

                        e.UnitPrice = element.itemPrice;

                        e.ItemName = element.itemName;

                        e.WeightPrice = element.weightPrice;

                        e.TotalViss = e.QtyPerUnit * e.Quantity;

                        e.Amount = Math.floor(e.UnitPrice * (e.TotalViss / e.WeightPrice));

                        e.LineTotalAmt = CheckDiscount(e.Amount, e.LineDisAmt, e.LineDisPer);

                        RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e
                            .Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount,
                            e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "", e.QtyPerUnit);

                    }

                });



            }

        });

        SubTotalAmount();

        GrandTotalAmount();

    }

    // ====== End of Add Item Function ======= //

    // ======= Add Warehouse Function ======== //

    function AddWarehouse(refNo, inputValue) {

        purchaseProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                e.WarehouseNo = inputValue;

                warehouseList.forEach(element => {

                    if (element.warehouseCode == inputValue) {

                        e.WarehouseName = element.warehouseName;

                        RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e
                            .Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount,
                            e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "", e.QtyPerUnit);

                    }

                });

            }

        });

    }

    // ====== End of Add Warehouse Function ======= //

    // ======= Add Unit Function ======== //

    function AddUnit(refNo, inputValue) {

        purchaseProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                e.PackedUnit = inputValue;

                unitList.forEach(element => {

                    if (element.unitCode == inputValue) {

                        e.UnitName = element.unitName;

                        RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e
                            .Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount,
                            e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "", e.QtyPerUnit);

                    }

                });

            }

        });

    }

    // ====== End of Add Unit Function ======= //

    // ====== Add Unit Qty Function ========== //

    function AddUnitQty(event, refNo, inputValue) {

        let nextFocus = event.target.getAttribute('nextfocus');

        purchaseProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                if (inputValue > 0) {

                    e.Quantity = Number(inputValue.replace(/,/g, ""));

                } else {

                    e.Quantity = 0;

                }

                e.TotalViss = e.Quantity * e.QtyPerUnit;

                e.Amount = Math.floor(e.UnitPrice * (e.TotalViss / e.WeightPrice));

                e.LineTotalAmt = CheckDiscount(e.Amount, e.LineDisAmt, e.LineDisPer);

                RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e
                    .PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt,
                    e.LineTotalAmt, e.IsFOC, nextFocus, e.QtyPerUnit);

            }

        });

        SubTotalAmount();

        GrandTotalAmount();

    }

    // ====== End of Add Unit Function ========== //

    // ====== Add QtyPerUnit Function ========== //

    function AddQtyPerUnit(event, refNo, inputValue) {

        purchaseProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                if (inputValue > 0) {

                    e.QtyPerUnit = Number(inputValue.replace(/,/g, ''));

                } else {

                    e.QtyPerUnit = 0;

                }

                e.TotalViss = (e.Quantity * e.QtyPerUnit).toFixed(3);

                e.Amount = Math.floor(e.UnitPrice * (e.TotalViss / e.WeightPrice));

                e.LineTotalAmt = CheckDiscount(e.Amount, e.LineDisAmt, e.LineDisPer, e.IsFOC);

                RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e
                    .PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt,
                    e.LineTotalAmt, e.IsFOC, "", e.QtyPerUnit);

            }

        });

        SubTotalAmount();

        GrandTotalAmount();

    }

    // ====== End of Add QtyPerUnit Function ========= //

    // ====== Add Unit Price Function ====== //

    function AddUnitPrice(event, refNo, inputValue) {

        let nextFocus = event.target.getAttribute('nextfocus');

        purchaseProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                if (inputValue > 0) {

                    e.UnitPrice = Number(inputValue.replace(/,/g, ''));

                } else {

                    e.UnitPrice = 0;

                }

                e.Amount = Math.floor(e.UnitPrice * (e.TotalViss / e.WeightPrice));

                e.LineTotalAmt = CheckDiscount(e.Amount, e.LineDisAmt, e.LineDisPer);

                RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e
                    .PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt,
                    e.LineTotalAmt, e.IsFOC, nextFocus, e.QtyPerUnit);

            }

        });

        SubTotalAmount();

        GrandTotalAmount();

    }

    // ========= End of Add Unit Price Function ===========//

    // ========= Add Total Viss Function =========== //

    function AddTotalViss(event, refNo, inputValue) {

        purchaseProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                if (inputValue > 0) {

                    e.TotalViss = inputValue;

                } else {

                    e.TotalViss = 0;

                }

                e.Amount = Math.floor(e.UnitPrice * (e.TotalViss / e.WeightPrice));

                e.LineTotalAmt = CheckDiscount(e.Amount, e.LineDisAmt, e.LineDisPer);

                RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e
                    .PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt,
                    e.LineTotalAmt, e.IsFOC, "", e.QtyPerUnit);

            }

        });

        SubTotalAmount();

        GrandTotalAmount();

    }

    // ========= End of Add Total Viss Function ========= //

    // ========= Add Discount Amount Function ===========//

    function AddDiscountAmount(refNo, inputValue) {

        purchaseProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                if (inputValue == "" || inputValue < 0) {

                    e.LineDisAmt = 0;

                } else {

                    e.LineDisAmt = Number(inputValue.replace(/,/g, ""));

                }

                e.LineTotalAmt = e.Amount - e.LineDisAmt;

                RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e
                    .PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt,
                    e.LineTotalAmt, e.IsFOC, "", e.QtyPerUnit);

            }

        });

        SubTotalAmount();

        GrandTotalAmount();

    }

    // ========= End of Add Discount Amount Function ========= //

    // ========= Add Discount Rate Function ===========//

    function AddDiscountRate(refNo, inputValue) {

        purchaseProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                if (inputValue == 0) {

                    e.LineDisPer = 0;

                } else if (inputValue < 0 || inputValue > 100) {

                    e.LineDisPer = 0;

                } else {

                    e.LineDisPer = inputValue;

                }

                e.LineTotalAmt = e.Amount - ((e.LineDisPer / 100) * e.Amount);

                RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e
                    .PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt,
                    e.LineTotalAmt, e.IsFOC, "", e.QtyPerUnit);

            }

        });

        SubTotalAmount();

        GrandTotalAmount();

    }

    // ========= End of Add Discount Rate Function ========= //

    // ========= Add Foc Function ============= //

    function AddFoc(event, refNo) {

        purchaseProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                if (event.target.checked == true) {

                    e.IsFOC = 1;

                    e.LineTotalAmt = 0;

                    RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e
                        .PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e
                        .LineDisAmt, e.LineTotalAmt, e.IsFOC, "", e.QtyPerUnit);

                } else {

                    e.IsFOC = 0;

                    //let unitTotalAmt = e.UnitPrice * e.Quantity;

                    unitTotalAmt = e.Amount;

                    if (e.LineDisAmt != 0) {

                        e.LineTotalAmt = unitTotalAmt - e.LineDisAmt;

                    } else if (e.LineDisPer != 0) {

                        e.LineTotalAmt = unitTotalAmt - (unitTotalAmt * (e.LineDisPer / 100));

                    } else {

                        e.LineTotalAmt = unitTotalAmt;

                    }

                    RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e
                        .PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e
                        .LineDisAmt, e.LineTotalAmt, e.IsFOC, "", e.QtyPerUnit);

                }


            }

        });

        SubTotalAmount();

        GrandTotalAmount();

    }

    // ========= End of Foc Function =========== //

    // ========= Row Replace Function ========== //

    function RowReplace(refNo, WarehouseNo, WarehouseName, ItemCode, ItemName, Quantity, PackedUnit, UnitName,
        TotalViss, UnitPrice, Amount, LineDisPer, LineDisAmt, LineTotalAmt, IsFoc, nextFocus = "", QtyPerUnit) {

        let checkFoc = "";

        let checkDisRate = "";

        let checkDisAmt = "";

        if (LineDisAmt != 0) {

            checkDisRate = "disabled";

        }

        if (LineDisPer != 0) {

            checkDisAmt = "disabled";

        }

        if (IsFoc == 1) {

            checkFoc = "checked";

        }

        let mainTable = document.getElementById("purchaseProdList");

        let noRow = mainTable.rows.length;

        for (let i = 0; i < noRow; i++) {

            let rowId = mainTable.rows[i].getAttribute("id");

            if (rowId == refNo) {

                mainTable.rows[i].innerHTML = `
                                    <td class="px-0 py-0" id="row_` + refNo + `">
                                        <select name="" id="` + refNo + `" class="itemCodeList_` + refNo + `" onchange="AddProduct(this.id,this.value)">
                                            <option value="` + ItemCode + `" selected disabled>` + ItemName + `</option>
                                            @forelse ($items as $item) 
                                                <option value="{{ $item->ItemCode }}">{{ $item->ItemName }}</option>
                                            @empty
                                                <option disabled>No Item</option>
                                            @endforelse
                                        </select>
                                    </td>
                                    <td class="px-0 py-0">
                                        <select name="" id="` + refNo + `" class="warehouseList_` + refNo + `" onchange="AddWarehouse(this.id,this.value);">
                                            <option value="` + WarehouseNo + `" selected disabled>` + WarehouseName + `</option>
                                            @forelse ($warehouses as $warehouse) 
                                                <option value="{{ $warehouse->WarehouseCode }}">{{ $warehouse->WarehouseName }}</option>
                                            @empty
                                                <option disabled>No Warehouse Code Found</option>
                                            @endforelse
                                        </select>
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="text" class="text-end" name="" id="` + refNo + `" value="` +
                    Quantity +
                    `" onblur="AddUnitQty(event,this.id,this.value);" onfocus="PEditFocus(event);" nextfocus="puprice_` +
                    refNo + `">
                                    </td>
                                    <td class="px-0 py-0">
                                        <select name="" class="unitCodeList_` + refNo + `" id="` + refNo + `" onchange="AddUnit(this.id, this.value);">
                                            <option value="` + PackedUnit + `" selected disabled>` + UnitName + `</option>
                                            @forelse ($units as $unit) 
                                                <option value="{{ $unit->UnitCode }}">{{ $unit->UnitDesc }}</option>
                                            @empty
                                                <option disabled>No Unit Code Found</option>
                                            @endforelse
                                        </select>
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="number" class="qtyunit` + refNo + `" name="" id="` + refNo +
                    `" value="` + QtyPerUnit + `" onblur="AddQtyPerUnit(event,this.id,this.value)" onfocus="PEditFocus(event);">
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="number" class="puviss_` + refNo + `" name="" id="` + refNo +
                    `" value="` + TotalViss + `" onblur="AddTotalViss(event,this.id,this.value)" onfocus="PEditFocus(event);">
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="text" class="puprice_` + refNo + ` text-end" id="` + refNo +
                    `"  value="` + Number(UnitPrice).toFixed(0) +
                    `" onblur="AddUnitPrice(event,this.id, this.value)" onfocus="PEditFocus(event);" nextfocus="puviss_` +
                    refNo + `">
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="text" class="text-end" name="" id="itemAmount" value="` + Amount
                    .toLocaleString() + `" disabled>
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="number" class="tableInput" name="" id="` + refNo + `" value="` +
                    LineDisPer + `" onblur="AddDiscountRate(this.id, this.value);"` + checkDisRate + ` onfocus="PEditFocus(event);">
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="text" class="text-end" id="` + refNo + `" value="` + LineDisAmt
                    .toLocaleString() + `" onblur="AddDiscountAmount(this.id, this.value);"` + checkDisAmt + ` onfocus="PEditFocus(event);">
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="text" class="text-end" name="" id="totalAmt" value="` +
                    LineTotalAmt.toLocaleString() + `" disabled>
                                    </td>
                                    <td class="px-3 py-0">
                                        <input type="checkbox" class="form-check-input cust-form-check mt-2" id="` +
                    refNo + `"` + checkFoc + ` onchange="AddFoc(event, this.id)" >
                                    </td>
                                    <td class="px-2 py-0">
                                        <button type="button" id="` + refNo + `" class="btn delete-btn py-0 mt-1 px-1" id="" onclick="DeletePurInvoiceRow(this.id)">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>`;
            }

        }

        // if (nextFocus != "") {
        //     document.querySelector("."+nextFocus).focus();
        // }

        dselect(document.querySelector(".warehouseList_" + refNo), config);

        dselect(document.querySelector(".itemCodeList_" + refNo), config);

        dselect(document.querySelector(".unitCodeList_" + refNo), config);

        SubTotalAmount();

        GrandTotalAmount();
    }

    // ========= End of Row Replace Function ========= //

    // ========= Delete Row Function ===========//

    function DeletePurInvoiceRow(refNo) {

        let mainTable = document.getElementById("purchaseProdList");

        let noRow = mainTable.rows.length;

        for (let i = 0; i < noRow; i++) {

            let rowId = mainTable.rows[i].getAttribute("id");

            if (rowId == refNo) {

                document.getElementById("purchaseProdList").deleteRow(i);

                break;

            }

        }

        purchaseProductDataList = purchaseProductDataList.filter((element) => element.referenceNo != refNo);

        SubTotalAmount();

        GrandTotalAmount();

    }

    // =========== End of Delete Row Function ============ //

    // ========== Display Sub Total Amount Function ========== //

    function SubTotalAmount() {

        let subTotal = 0;

        purchaseProductDataList.forEach(element => {

            subTotal += Number(element.LineTotalAmt);

        });

        document.getElementById("subTotal").value = subTotal.toLocaleString();

        AddSupplierData();

    }

    // ========== End of Display Sub Total Amount Function ========== //

    // ========== Display Grand Total Amount Function ========= //

    function GrandTotalAmount() {

        let grandTotal = Number($("#subTotal").val().replace(/,/g, "")) - Number($("#totalCharges").val().replace(/,/g,
            ""));

        document.getElementById("grandTotal").value = grandTotal.toLocaleString();

    }

    // ========== End of Display Grand Total Amount Function =========== //

    // ========== Check Discount Function ============= //

    function CheckDiscount(amount, disAmt, disRate) {

        let lineTotalAmt = 0;

        if (disAmt != 0) {

            lineTotalAmt = amount - disAmt;

        } else if (disRate != 0) {

            lineTotalAmt = amount - (amount * (disRate / 100))

        } else {

            lineTotalAmt = amount;

        }

        return lineTotalAmt;

    }

    // ========== End of Check Discount Function ========== //

    // ========= Display Total Charges Function ========== //

    function DisplayTotalCharges() {

        let shippingCharges = Number($("#shippingCharges").val().replace(/,/g, ""));

        let laborCharge = Number($("#laborCharges").val().replace(/,/g, ""));

        let deliveryCharge = Number($("#deliveryCharges").val().replace(/,/g, ""));

        let weightCharge = Number($("#weightCharges").val().replace(/,/g, ""));

        let serviceCharge = Number($("#serviceCharges").val().replace(/,/g, ""));

        let factoryCharges = Number($("#factoryCharges").val().replace(/,/g, ""));

        let otherCharges = Number($("#otherCharges").val().replace(/,/g, ""));

        let totalCharges = laborCharge + deliveryCharge + weightCharge + serviceCharge + shippingCharges +
            factoryCharges + otherCharges;

        $("#totalCharges").val(totalCharges.toLocaleString());

        GrandTotalAmount();

    }

    function PuEditCharges(event) {

        let check = /^[0-9/,]+$/;

        if (event.target.value < 0 || !check.test(event.target.value)) {

            $("#" + event.target.id).val(0);

        }

        let inputValue = Number((event.target.value).replace(/,/g, ""));

        $("#" + event.target.id).val(inputValue.toLocaleString());

        DisplayTotalCharges();

    }

    // ========= End of Display Total Charges Function ========= //

    // ========= Print Update Purchase Voucher ========= //

    $("#pUpdatePuVoucher").on('click', PrintPurchaseUpdate)

    // ========= End of Print Update Purchase Voucher ======== //

    // ========= Update Data to Database ========== //

    $("#updatePurchaseForm").submit(PrintPurchaseUpdate)

    function PrintPurchaseUpdate(event) {

        event.preventDefault();

        let supplierCode = $("#supplierCodeList").val();

        let arrivalCode = $("#arrivalCodeList").val();

        if (supplierCode == null) {

            toastr.warning('Please enter Supplier Name');

            return;

        } else if (arrivalCode == null) {

            toastr.warning('Please enter Arrival Plate No/Name');

            return;
        }

        let purchaseInvoiceDetailsArr = [];

        let errorMsg = "";

        let lineNo = 0;

        purchaseProductDataList.forEach(element => {

            if (element.ItemCode != "") {

                if (element.WarehouseNo == "") {

                    errorMsg = "W";

                    lineNo = element.referenceNo;

                    return;

                } else if (element.PackedUnit == "") {

                    errorMsg = "U";

                    lineNo = element.referenceNo;

                    return;

                }

                let purchaseInvoiceDetailsObject = {
                    WarehouseNo: element.WarehouseNo,
                    ItemCode: element.ItemCode,
                    Quantity: element.Quantity,
                    PackedUnit: element.PackedUnit,
                    QtyPerUnit: element.QtyPerUnit,
                    TotalViss: element.TotalViss,
                    UnitPrice: element.UnitPrice,
                    Amount: element.Amount,
                    LineDisPer: element.LineDisPer,
                    LineDisAmt: element.LineDisAmt,
                    LineTotalAmt: element.LineTotalAmt,
                    IsFOC: element.IsFOC
                }

                purchaseInvoiceDetailsArr.push(purchaseInvoiceDetailsObject);

            }

        });

        if (errorMsg == "W") {

            toastr.warning('Please enter Warehouse Name in line no ' + lineNo);

            return;

        } else if (errorMsg == "U") {

            toastr.warning('Please enter Unit Name in line no ' + lineNo);

            return;

        }

        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        });

        let data = {};

        data.InvoiceNo = $("#invoiceNo").val();
        data.PurchaseDate = $("#purchaseDate").val();
        data.SupplierCode = supplierCode;
        data.ArrivalCode = arrivalCode;
        //data.IsComplete = document.getElementById("isArrivalComplete").checked ? 1 : 0;
        data.SubTotal = Number($("#subTotal").val().replace(/,/g, ""));
        data.ShippingCharges = Number($("#shippingCharges").val().replace(/,/g, ""));
        data.OtherCharges = Number($("#otherCharges").val().replace(/,/g, ""));
        data.LaborCharges = Number($("#laborCharges").val().replace(/,/g, ""));
        data.DeliveryCharges = Number($("#deliveryCharges").val().replace(/,/g, ""));
        data.WeightCharges = Number($("#weightCharges").val().replace(/,/g, ""));
        data.ServiceCharges = Number($("#serviceCharges").val().replace(/,/g, ""));
        data.FactoryCharges = Number($("#factoryCharges").val().replace(/,/g, ""));
        data.TotalCharges = Number($("#totalCharges").val().replace(/,/g, ""));
        data.GrandTotal = Number($("#grandTotal").val().replace(/,/g, ""));
        data.Remark = $("#purchaseRemark").val();
        data.IsPaid = document.getElementById("isPaid").checked ? 1 : 0;
        data.PaidDate = $("#paidDate").val() == "" ? null : $("#paidDate").val();
        data.purchaseInvoiceDetails = purchaseInvoiceDetailsArr;

        data = JSON.stringify(data);

        //console.log(data);

        let url = $("#updatePurchaseForm").attr('action');

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {

                console.log(response);

                if (response.message == "good") {

                    if (event.target.id == "pUpdatePuVoucher") {

                        sessionStorage.setItem('update', 'success');

                        window.location.href = "/purchaseinvoices/printpuvoucher/" + $("#invoiceNo").val();

                    } else {

                        sessionStorage.setItem('update', 'success');

                        window.location.href = "/purchaseinvoices/index";

                    }

                }

            },
            error: function(error) {

                console.log('no');

                console.log(error.responseText);

                //res = JSON.parse(error.responseText);
                //console.log(res);
            }
        });
    };

    // ========= End of Update Data to Database ========== //

    // ========= Focus Functions ========= //

    function PEditFocus(event) {

        let inputValue = Number(event.target.value.replace(/,/g, ''));

        event.target.removeAttribute('value');

        event.target.removeAttribute('type');

        event.target.setAttribute('type', 'number');

        event.target.setAttribute('value', inputValue);

        event.target.select();

    }

    function PEditSelect(event) {

        $(this).select();

    }

    $("#otherCharges").on('focus', PEditSelect);

    $("#shippingCharges").on('focus', PEditSelect);

    $("#laborCharges").on('focus', PEditSelect);

    $("#weightCharges").on('focus', PEditSelect);

    $("#deliveryCharges").on('focus', PEditSelect);

    $("#serviceCharges").on('focus', PEditSelect);

    $("#factoryCharges").on('focus', PEditSelect);


    // ========= End of Focus Functions ========= //

    // ========= Paid Check Functions ========= //

    function PuEPaidCheck(event) {

        if (event.target.checked) {

            let date = new Date();

            let month = date.getMonth() + 1 < 10 ? "0" + (date.getMonth() + 1) : date.getMonth() + 1;

            let year = date.getFullYear();

            let day = date.getDate() < 10 ? "0" + (date.getDate()) : date.getDate();

            document.getElementById("paidDate").value = year + "-" + month + "-" + day;

            document.getElementById("paidDate").removeAttribute("disabled");

        } else {

            document.getElementById("paidDate").value = "";

            document.getElementById("paidDate").setAttribute("disabled", "true");

        }

    }

    // ========= End of Paid Check Functions ========= //

    // ========= End of Paid Check Functions ========= //

    // ========= Add Shipping Charges Function ======= //

    function AddArrivalData(event) {

        let arrivalCode = event.target.value;

        itemArrival.forEach((e) => {

            if (e.arrivalCode == arrivalCode) {

                document.querySelector("#shippingCharges").value = Number(e.charges).toLocaleString();
                document.querySelector("#otherCharges").value = Number(e.otherCharges).toLocaleString();

            }

        });

        DisplayTotalCharges();
    }

    // ========= End of Add Shipping Charges Function ======= //


    // ========= Add Supplier Data ========= //

    function AddSupplierData() {

        let supplierCode = document.querySelector("#supplierCodeList").value;

        let arrivalCodeCheck = document.querySelector("#arrivalCodeList").value;

        let subTotal = Number(document.querySelector("#subTotal").value.replace(/,/g, ""));

        let arrivalOptions = "<option value='' selected disabled>Choose</option>";

        supplierList.forEach((e) => {

            if (e.supplierCode == supplierCode) {

                document.querySelector("#serviceCharges").value = Math.floor(subTotal * (e.profit / 100))
                    .toLocaleString();

            }

        });

        if (arrivalCodeCheck == "") {

            let resultArrivals = itemArrival.filter(i => i.supplierCode == supplierCode);

            if (resultArrivals == "") {

                arrivalOptions = "<option value=''>There is no arrival.</option>";

            } else {

                resultArrivals.forEach(i => {

                arrivalOptions += `<option value="`+ i.arrivalCode +`">`+ i.plateNo +`</option>`;

                });

            }

            document.querySelector("#arrivalCodeList").innerHTML = arrivalOptions;

            dselect(document.querySelector("#arrivalCodeList"), config);

        }

        DisplayTotalCharges();

    }

    // ========= End of Add Supplier Data ========= //
</script>
