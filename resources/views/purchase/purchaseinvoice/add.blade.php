<x-layout title="Create Purchase">

    @php
        $warehouseList = [];
        $itemArray = [];
        $unitList = [];
        $supplierList = [];
        $itemArrival = [];
    @endphp

    @foreach ($items as $item)

        @php
            $itemArray[] = [
                'itemId' => $item->ItemCode,
                'itemName' => $item->ItemName,
                'itemPrice' => $item->UnitPrice,
                'weightByPrice' => $item->WeightByPrice,
            ]
        @endphp

    @endforeach

    @foreach ($warehouses as $warehouse )
    
        @php
            $warehouseList[] = [
                'warehouseCode' => $warehouse->WarehouseCode,
                'warehouseName' => $warehouse->WarehouseName
            ]
        @endphp

    @endforeach

    @foreach ($units as $unit)

        @php
            $unitList[] = [
                'unitCode' => $unit->UnitCode,
                'unitName' => $unit->UnitDesc
            ]
        @endphp

    @endforeach

    @foreach ($suppliers as $supplier)

        @php
            $supplierList[] = [
                'supplierCode' => $supplier->SupplierCode,
                'supplierName' => $supplier->SupplierName,
                'profit' => $supplier->Profit,
            ]
        @endphp
        
    @endforeach

    @foreach ($arrivals as $arrival)

        @php
            $itemArrival[] = [
                'arrivalCode' => $arrival->ArrivalCode,
                'charges' => $arrival->TotalCharges,
                'totalBags' => $arrival->TotalBags,
            ]
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

    {{-- Generate Id --}}
        {{-- @php

            require app_path('./utils/GenerateId.php');
            $generateid = new GenerateId();
            $id = $generateid->generatePrimaryKeyId('purchase_invoices','InvoiceNo','PV-',true,false);
    
        @endphp --}}
    {{-- End of Generate Id --}}
        
    {{-- Form Section --}}

        <x-error name="Email"></x-error>

        <form action="/purchaseinvoices/add" method="Post" id="saveFormData" class="row form-card mt-2 mb-3 needs-validation" novalidate>
            @csrf
            
            <div class="col-12 px-0">
                {{-- <input type="hidden" value="{{}}" name="InvoiceNo"> --}}
                <p class="p-0 content-title"><span>Basic Info</span></p>
                <div class="row">
                    {{-- Invoice No --}}
                    {{-- <div class="col-12 col-md-6 col-xl-4 col-xxl-2 mb-2">
                        <label for="invoiceNo" class="form-label cust-label">Invoice No</label>
                        <input type="text" class="form-control cust-input-box" id="invoiceNo" name="InvoiceNo" value="{{$id}}" disabled>
                    </div> --}}
                    {{-- Purchase Date --}}
                    <div class="col-12 col-md-6 col-xl-4 col-xxl-2 mb-2">
                        <label for="purchaseDate" class="form-label cust-label">Purchase Date</label>
                        <input type="date" class="form-control cust-input-box" id="purchaseDate" name="PurchaseDate" value="{{$currentDate}}" required>
                        <div class="invalid-feedback">
                            Please fill Purchase Date.
                        </div>
                    </div>
                    {{-- Supplier Code --}}
                    <div class="col-12 col-md-6 col-xl-4 col-xxl-2 mb-2">
                        <label for="supplierCodeList" class="form-label cust-label">Supplier Name</label>
                        <select class="mb-3 form-select" id="supplierCodeList" name="SupplierCode" onchange="AddSupplierData();" required>
                            <option selected disabled value="">Choose</option>
                            @if(isset($suppliers) && is_object($suppliers) && count($suppliers) > 0)
                                @forelse ($suppliers as $supplier)

                                    <option value="{{$supplier->SupplierCode}}">{{$supplier->SupplierName}}</option>

                                @empty

                                    <option disabled>No Supplier Found</option>

                                @endforelse

                                @else

                                    <option disabled selected>No Supplier Found</option>

                                @endif
                        </select>
                        <div class="invalid-feedback">
                            Please fill Supplier Code.
                        </div>
                    </div>
                    {{-- Arrival Code --}}
                    <div class="col-12 col-md-6 col-xl-4 col-xxl-3 mb-2">
                        <label for="arrivalCodeList" class="form-label cust-label">Plate No/Name</label>
                        <div class="d-flex">
                            <div class="col-10">
                                <select class="mb-3 me-2 form-select" id="arrivalCodeList" name="ArrivalCode" onchange="AddArrivalData(event);" required>
                                    <option value="" selected disabled>Choose</option>
                                    @if(isset($arrivals) && is_object($arrivals) && count($arrivals) > 0)
                                        @forelse ($arrivals as $arrival)
                                            
                                            <option value="{{$arrival->ArrivalCode}}">{{$arrival->PlateNo}}</option>
        
                                        @empty
        
                                            <option>No data</option>
        
                                        @endforelse
                                    @else
                                        <option disabled></option>
                                    @endif
                                </select>
                                <div class="invalid-feedback">
                                    Please fill Arrival Code.
                                </div>
                            </div>
                            <input class="form-check-input cust-form-check col-2" type="checkbox" value="" name="IsArrivalComplete" id="isArrivalComplete">
                        </div>
                        
                        
                        
                    </div>
                    {{-- Remarks --}}
                    <div class="col-12 col-md-6 col-xl-4 col-xxl-4 mb-2">
                        <label 6class="cust-label form-label text-end" for="purchaseRemark">Remark</label>
                        <textarea class="form-control cust-textarea mt-2" name="" id="purchaseRemark" rows="2"></textarea>
                    </div>
                </div>
                
                <p class="p-0 content-title"><span>Payment Info</span></p>
                <div class="row">
                    <div class="col-md-8 col-xl-7 col-xxl-6">
                        <div class="row">
                            
                            {{-- Paid Date --}}
                            <div class="col-12 col-md-6 col-xl-5 col-xxl-4 mb-2">
                                <label for="paidDate" class="form-label cust-label">Paid Date</label>
                                <input type="date" class="form-control cust-input-box" id="paidDate" name="PaidDate" value="" disabled>
                            </div>
                            {{-- Paid Status --}}
                            <div class="col-12 col-md-6 col-xl-4 col-xxl-3 mb-2">
                                <label class="cust-label form-label text-end" for="isPaid">Paid</label>
                                <div class="col-sm-8 form-check form-switch">
                                    <input class="form-check-input cust-form-switch" type="checkbox" role="switch" id="isPaid" name="IsPaid" onchange="PuPaidCheck(event)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <p class="p-0 content-title"><span>Details</span></p>
                <button class="btn btn-noBorder" id="addNewRow" type="button"><span class="me-2"><i class="bi bi-plus-circle"></i></span>New</button>
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

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-3 justify-content-between">
                    <div class="col-xl-5 col-xxl-4">
                        <p class="p-0 content-title"><span>Charges</span></p>
                        {{-- Shipping Charges --}}
                        <div class="row justify-content-end">
                            <label for="shippingCharges" class="form-label text-end charges-label col-6">တန်ဆာခ :</label>
                            <div class="col-5 col-xl-5 col-xxl-6 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="shippingCharges" name="ShippingCharges" value="0" onblur="PuCharges(event);">
                            </div>
                        </div>
                        {{-- Labor Charges --}}
                        <div class="row justify-content-end">
                            <label for="laborCharges" class="form-label text-end charges-label col-6">ကမ်းတတ်အလုပ်သမားခ :</label>
                            <div class="col-5 col-xl-5 col-xxl-6 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="laborCharges" name="LaborCharges" value="0" onblur="PuCharges(event);">
                            </div>
                        </div>
                        {{-- Delivery Charges --}}
                        <div class="row justify-content-end">
                            <label for="deliveryCharges" class="form-label text-end charges-label col-6">ကမ်းတတ်ကားခ :</label>
                            <div class="col-5 col-xl-5 col-xxl-6 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="deliveryCharges" name="DeliveryCharges" value="0" onblur="PuCharges(event);">
                            </div>
                        </div>
                        {{-- Weight Charges --}}
                        <div class="row justify-content-end">
                            <label for="weightCharges" class="form-label text-end charges-label col-6">ပွဲရုံအလုပ်သမားခ :</label>
                            <div class="col-5 col-xl-5 col-xxl-6 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="weightCharges" name="WeightCharges" value="0" onblur="PuCharges(event);">
                            </div>
                        </div>
                        {{-- Service Charges --}}
                        <div class="row justify-content-end">
                            <label for="serviceCharges" class="form-label text-end charges-label col-6">အကျိုးဆောင်ခ :</label>
                            <div class="col-5 col-xl-5 col-xxl-6 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="serviceCharges" name="ServiceCharges" value="0" rowNo="23" onblur="PuCharges(event);">
                            </div>
                        </div>
                        {{-- Factory Charges --}}
                        <div class="row justify-content-end">
                            <label for="factoryCharges" class="form-label text-end charges-label col-6">စက်ကြိတ်ခ :</label>
                            <div class="col-5 col-xl-5 col-xxl-6 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="factoryCharges" name="FactoryCharges" value="0" rowNo="23" onblur="PuCharges(event);">
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="col-xl-6">
                        {{-- Sub Total --}}
                        <div class="row justify-content-end mt-2">
                            <label for="subTotal" class="form-label text-end cust-label col-5 col-xl-4 col-xxl-3">Sub Total :</label>
                            <div class="col-5 col-xl-5 col-xxl-4 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="subTotal" name="SubTotal" value="0" disabled>
                            </div>
                        </div>
                        {{-- Total Charges --}}
                        <div class="row justify-content-end">
                            <label for="totalCharges" class="form-label text-end cust-label col-5 col-xl-4 col-xxl-3">Total Charges :</label>
                            <div class="col-5 col-xl-5 col-xxl-4 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="totalCharges" name="TotalCharges" value="0" disabled>
                            </div>
                        </div>
                        {{-- Grand Total --}}
                        <div class="row justify-content-end">
                            <label for="grandTotal" class="form-label text-end cust-label col-5 col-xl-4 col-xxl-3">Grand Total :</label>
                            <div class="col-5 col-xl-5 col-xxl-4 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="grandTotal" name="GrandTotal" value="0" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Save Button --}}
                <div class="row mt-2">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success me-2" id="saveData">
                            <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Save
                        </button>
                        <button type="button" class="btn btn-primary" id="printPuBtn">
                            <span class="me-2"><i class="fa fa-print"></i></span> Save & Preview
                        </button>
                    </div>
                </div>
            </div>
            
        </form>
    
    {{-- End of form Section --}}

    </div>

</x-layout>

<script>

    dselect(document.querySelector("#arrivalCodeList"), config);

    dselect(document.querySelector("#supplierCodeList"), config);
    
    var rowNo = 1;

    let itemArray = @json($itemArray);

    let warehouseList = @json($warehouseList);

    let unitList = @json($unitList);

    let supplierList = @json($supplierList);

    let itemArrival = @json($itemArrival);

    let purchaseProductDataList = [];

    $(document).ready(function(){

        let purchaseProductData = {
            referenceNo : rowNo,
            WarehouseNo : "",
            WarehouseName: "",
            ItemCode : "",
            ItemName : "",
            WeightPrice: 1,
            Quantity : 1,
            PackedUnit : "",
            UnitName : "",
            TotalViss : 1,
            UnitPrice : 0,
            Amount : 0,
            LineDisPer : 0,
            LineDisAmt : 0,
            LineTotalAmt : 0,
            IsFOC : 0
        }

        const tableRow = document.createElement('tr');

        tableRow.setAttribute("id", rowNo);

        tableRow.innerHTML = `
                            <td class="px-0 py-0" id="row_`+ rowNo +`">
                                <select name="" id="`+ rowNo +`" class="itemCodeList_`+ rowNo +`" onchange="AddProduct(this.id,this.value)">
                                    <option selected disabled>Choose</option>
                                    @forelse ($items as $item) 
                                        <option value="{{$item->ItemCode}}">{{$item->ItemName}}</option>
                                    @empty
                                        <option disabled>No Arrival Code Found</option>
                                    @endforelse
                                </select>
                            </td>
                            <td class="px-0 py-0">
                                <select name="" id="`+ rowNo +`" class="warehouseList_`+ rowNo +`" onchange="AddWarehouse(this.id,this.value);">
                                    <option selected disabled>Choose</option>
                                    @forelse ($warehouses as $warehouse) 
                                        <option value="{{$warehouse->WarehouseCode}}">{{$warehouse->WarehouseName}}</option>
                                    @empty
                                        <option disabled>No Arrival Code Found</option>
                                    @endforelse
                                </select>
                            </td>
                            <td class="px-0 py-0">
                                <input type="text" class="text-end" id="`+ rowNo +`" onblur="AddUnitQty(event,this.id,this.value);" onfocus="PAddFocus(event);" nextfocus="puprice_`+ rowNo +`">
                            </td>
                            <td class="px-0 py-0">
                                <select name="" class="unitCodeList_`+ rowNo +`" id="`+ rowNo +`" onchange="AddUnit(this.id, this.value);">
                                    <option selected disabled>Choose</option>
                                    @forelse ($units as $unit) 
                                        <option value="{{$unit->UnitCode}}">{{$unit->UnitDesc}}</option>
                                    @empty
                                        <option disabled>No Unit Code Found</option>
                                    @endforelse
                                </select>
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="puviss_`+ rowNo +` text-end" name="" id="`+ rowNo +`" onblur="AddTotalViss(event,this.id,this.value)" onfocus="PAddFocus(event);">
                            </td>
                            <td class="px-0 py-0">
                                <input type="text" class="puprice_`+ rowNo +` text-end" name="" id="`+ rowNo +`" onblur="AddUnitPrice(event,this.id,this.value);" value="" onfocus="PAddFocus(event);" nextfocus="puviss_`+ rowNo +`">
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="tableInput" name="" id="itemAmount" disabled>
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="tableInput" name="" id="`+ rowNo +`" onblur="AddDiscountRate(this.id, this.value);" value="0" onfocus="PAddFocus(event);">
                            </td>
                            <td class="px-0 py-0">
                                <input type="text" class="text-end" name="" id="`+ rowNo +`" onblur="AddDiscountAmount(this.id, this.value);" value="0" onfocus="PAddFocus(event);">
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="tableInput" name="" id="totalAmt" disabled>
                            </td>
                            <td class="px-3 py-0">
                                <input type="checkbox" class="form-check-input cust-form-check mt-2" id="`+ rowNo +`" onchange="AddFoc(event, this.id)" />
                            </td>
                            <td class="px-2 py-0">
                                <button type="button" id="`+ rowNo +`" class="btn delete-btn py-0 mt-1 px-1" id="" onclick="DeletePurInvoiceRow(this.id)">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>`;

            purchaseProductDataList.push(purchaseProductData);

            document.getElementById("displaySelectedItems").appendChild(tableRow);

            dselect(document.querySelector(".warehouseList_"+ rowNo), config);

            dselect(document.querySelector(".itemCodeList_"+ rowNo), config);

            dselect(document.querySelector(".unitCodeList_"+ rowNo), config);

            rowNo++;

    });

    // ======= Add New Row Function ====== //

    $("#addNewRow").on("click", ()=>{

        let purchaseProductData = {
            referenceNo : rowNo,
            WarehouseNo : "",
            WarehouseName: "",
            ItemCode : "",
            ItemName : "",
            WeightPrice: 1,
            Quantity : 1,
            PackedUnit : "",
            UnitName : "",
            TotalViss : 1,
            UnitPrice : 0,
            Amount : 0,
            LineDisPer : 0,
            LineDisAmt : 0,
            LineTotalAmt : 0,
            IsFOC : 0
        }

        const newRow = document.createElement('tr');

        newRow.setAttribute("id", rowNo);

        newRow.innerHTML = `
                            <td class="px-0 py-0" id="row_`+ rowNo +`">
                                <select name="" id="`+ rowNo +`" class="itemCodeList_`+ rowNo +`" onchange="AddProduct(this.id,this.value)">
                                    <option selected disabled>Choose</option>
                                    @forelse ($items as $item) 
                                        <option value="{{$item->ItemCode}}">{{$item->ItemName}}</option>
                                    @empty
                                        <option disabled>No Item</option>
                                    @endforelse
                                </select>
                            </td>
                            <td class="px-0 py-0">
                                <select name="" id="`+ rowNo +`" class="warehouseList_`+ rowNo +`" onchange="AddWarehouse(this.id,this.value);">
                                    <option selected disabled>Choose</option>
                                    @forelse ($warehouses as $warehouse) 
                                        <option value="{{$warehouse->WarehouseCode}}">{{$warehouse->WarehouseName}}</option>
                                    @empty
                                        <option disabled>No Arrival Code Found</option>
                                    @endforelse
                                </select>
                            </td>
                            <td class="px-0 py-0">
                                <input type="text" class="text-end" id="`+ rowNo +`" onblur="AddUnitQty(event,this.id,this.value);" onfocus="PAddFocus(event);" nextfocus="puprice_`+ rowNo +`">
                            </td>
                            <td class="px-0 py-0">
                                <select name="" class="unitCodeList_`+ rowNo +`" id="`+ rowNo +`" onchange="AddUnit(this.id, this.value);">
                                    <option selected disabled>Choose</option>
                                    @forelse ($units as $unit) 
                                        <option value="{{$unit->UnitCode}}">{{$unit->UnitDesc}}</option>
                                    @empty
                                        <option disabled>No Arrival Code Found</option>
                                    @endforelse
                                </select>
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="puviss_`+ rowNo +` text-end" name="" id="`+ rowNo +`" onblur="AddTotalViss(this.id,this.value)" onfocus="PAddFocus(event);">
                            </td>
                            <td class="px-0 py-0">
                                <input type="text" class="puprice_`+ rowNo +` text-end" id="`+ rowNo +`" onblur="AddUnitPrice(event,this.id,this.value);" value="" onfocus="PAddFocus(event);" nextfocus="puviss_`+ rowNo +`">
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="tableInput" name="" id="itemAmount" disabled>
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="tableInput" name="" id="`+ rowNo +`" onblur="AddDiscountRate(this.id, this.value);" value="0" onfocus="PAddFocus(event);">
                            </td>
                            <td class="px-0 py-0">
                                <input type="text" class="text-end" id="`+ rowNo +`" onblur="AddDiscountAmount(this.id, this.value);" value="0" onfocus="PAddFocus(event);">
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="tableInput" name="" id="totalAmt" disabled>
                            </td>
                            <td class="px-3 py-0">
                                <input type="checkbox" class="form-check-input cust-form-check mt-2" id="`+ rowNo +`" onchange="AddFoc(event, this.id)" />
                            </td>
                            <td class="px-2 py-0">
                                <button type="button" id="`+ rowNo +`" class="btn delete-btn py-0 mt-1 px-1" id="" onclick="DeletePurInvoiceRow(this.id)">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>`;

        document.getElementById("displaySelectedItems").appendChild(newRow);

        dselect(document.querySelector(".warehouseList_"+ rowNo), config);

        dselect(document.querySelector(".itemCodeList_"+ rowNo), config);

        dselect(document.querySelector(".unitCodeList_"+ rowNo), config);

        purchaseProductDataList.push(purchaseProductData);

        rowNo++;

    });

    // ======= End of Add New Row Function ====== //

    // ======= Add Item Function ======== //

    function AddProduct(refNo,inputValue){

        purchaseProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                e.ItemCode = inputValue;

                itemArray.forEach(element => {

                    if (element.itemId == inputValue) {

                        e.UnitPrice = element.itemPrice;

                        e.ItemName = element.itemName;

                        e.WeightPrice = element.weightByPrice;

                        e.Amount = Math.floor(e.UnitPrice * (e.TotalViss / e.WeightPrice));

                        e.LineTotalAmt = CheckDiscount(e.Amount, e.LineDisAmt, e.LineDisPer, e.IsFOC);

                        RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "");

                    }

                });

                

            }

        });

        SubTotalAmount();

        GrandTotalAmount();
        
    }

    // ====== End of Add Item Function ======= //

    // ======= Add Warehouse Function ======== //

    function AddWarehouse(refNo,inputValue){

        purchaseProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                e.WarehouseNo = inputValue;

                warehouseList.forEach(element => {

                    if (element.warehouseCode == inputValue) {

                        e.WarehouseName = element.warehouseName;

                        RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "");

                    }

                });

            }

        });

    }

    // ====== End of Add Warehouse Function ======= //

    // ======= Add Unit Function ======== //

    function AddUnit(refNo,inputValue){

        purchaseProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                e.PackedUnit = inputValue;

                unitList.forEach(element => {

                    if (element.unitCode == inputValue) {

                        e.UnitName = element.unitName;

                        RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "");

                    }

                });

            }

        });

    }

    // ====== End of Add Unit Function ======= //

    // ====== Add Unit Qty Function ========== //

    function AddUnitQty(event, refNo, inputValue){

        let nextFocus = event.target.getAttribute('nextfocus');

        purchaseProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                if (inputValue > 0) {

                    e.Quantity = Number(inputValue.replace(/,/g, ''));

                } else {

                    e.Quantity = 0;

                }

                e.Amount = Math.floor(e.UnitPrice * (e.TotalViss / e.WeightPrice));

                e.LineTotalAmt = CheckDiscount(e.Amount, e.LineDisAmt, e.LineDisPer, e.IsFOC);

                RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, nextFocus);

            }

        });

        SubTotalAmount();

        GrandTotalAmount();

    }

    // ====== End of Add Unit Function ========== //

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

                e.LineTotalAmt = CheckDiscount(e.Amount, e.LineDisAmt, e.LineDisPer, e.IsFOC);

                RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, nextFocus); 

            }

        });

        SubTotalAmount();

        GrandTotalAmount();

    }

    // ========= End of Add Unit Price Function ===========//

    // ========= Add Total Viss Function =========== //

    function AddTotalViss(refNo, inputValue) {

        purchaseProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                if (inputValue > 0) {

                    e.TotalViss = inputValue;

                } else {

                    e.TotalViss = 0;

                }

                e.Amount = Math.floor(e.UnitPrice * (e.TotalViss / e.WeightPrice));

                e.LineTotalAmt = CheckDiscount(e.Amount, e.LineDisAmt, e.LineDisPer, e.IsFOC);

                RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "");

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

                RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "");

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

                }else if (inputValue < 0 || inputValue > 100) {

                    e.LineDisPer = 0;

                } else {

                    e.LineDisPer = inputValue;

                }
                
                e.LineTotalAmt = e.Amount - ((inputValue / 100) * e.Amount);

                RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "");

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

                    RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "");

                } else {

                    e.IsFOC = 0;

                    //let unitTotalAmt = e.UnitPrice * e.Quantity;

                    let unitTotalAmt = e.Amount

                    if (e.LineDisAmt != 0) {

                        e.LineTotalAmt = unitTotalAmt - e.LineDisAmt;

                    } else if (e.LineDisPer != 0) {

                        e.LineTotalAmt = unitTotalAmt - (unitTotalAmt * (e.LineDisPer / 100));

                    } else {

                        e.LineTotalAmt = unitTotalAmt;

                    }

                    RowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "");

                }
                

            }

        });

        SubTotalAmount();

        GrandTotalAmount();

    }

    // ========= End of Foc Function =========== //

    // ========= Row Replace Function ========== //

    function RowReplace(refNo, WarehouseNo, WarehouseName, ItemCode, ItemName, Quantity, PackedUnit, UnitName, TotalViss, UnitPrice, Amount, LineDisPer, LineDisAmt, LineTotalAmt, IsFoc, nextFocus) {

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

        for(let i = 0; i < noRow; i++) {

            let rowId = mainTable.rows[i].getAttribute("id");

            if( rowId == refNo) {

                mainTable.rows[i].innerHTML = `
                                    <td class="px-0 py-0" id="row_`+ refNo +`">
                                        <select name="" id="`+ refNo +`" class="itemCodeList_`+ refNo +`" onchange="AddProduct(this.id,this.value)">
                                            <option value="`+ ItemCode +`" selected disabled>`+ ItemName +`</option>
                                            @forelse ($items as $item) 
                                                <option value="{{$item->ItemCode}}">{{$item->ItemName}}</option>
                                            @empty
                                                <option disabled>No Item</option>
                                            @endforelse
                                        </select>
                                    </td>
                                    <td class="px-0 py-0">
                                        <select name="" id="`+ refNo +`" class="warehouseList_`+ refNo +`" onchange="AddWarehouse(this.id,this.value);">
                                            <option value="`+ WarehouseNo +`" selected disabled>`+ WarehouseName +`</option>
                                            @forelse ($warehouses as $warehouse) 
                                                <option value="{{$warehouse->WarehouseCode}}">{{$warehouse->WarehouseName}}</option>
                                            @empty
                                                <option disabled>No Warehouse Code Found</option>
                                            @endforelse
                                        </select>
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="text" class="text-end" id="`+ refNo +`" value="`+ Quantity.toLocaleString() +`" onblur="AddUnitQty(event,this.id,this.value);" onfocus="PAddFocus(event);" nextfocus="puprice_`+ refNo +`">
                                    </td>
                                    <td class="px-0 py-0">
                                        <select name="" class="unitCodeList_`+ refNo +`" id="`+ refNo +`" onchange="AddUnit(this.id, this.value);">
                                            <option value="`+ PackedUnit +`" selected disabled>`+ UnitName +`</option>
                                            @forelse ($units as $unit) 
                                                <option value="{{$unit->UnitCode}}">{{$unit->UnitDesc}}</option>
                                            @empty
                                                <option disabled>No Unit Code Found</option>
                                            @endforelse
                                        </select>
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="number" class="puviss_`+ rowNo +`" id="`+ refNo +`" value="`+ TotalViss +`" onblur="AddTotalViss(this.id,this.value)" onfocus="PAddFocus(event);">
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="text" class="puprice_`+ refNo +` text-end" id="`+ refNo +`"  value="`+ UnitPrice.toLocaleString() +`" onblur="AddUnitPrice(event,this.id, this.value)" onfocus="PAddFocus(event);" nextfocus="puviss_`+ rowNo +`">
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="text" class="text-end" name="" id="itemAmount" value="`+ Amount.toLocaleString() +`" disabled>
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="number" class="tableInput" name="" id="`+ refNo +`" value="`+ LineDisPer +`" onblur="AddDiscountRate(this.id, this.value);"`+ checkDisRate + ` onfocus="PAddFocus(event);">
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="text" class="text-end" id="`+ refNo +`" value="`+ LineDisAmt.toLocaleString() +`" onblur="AddDiscountAmount(this.id, this.value);"`+ checkDisAmt +` onfocus="PAddFocus(event);">
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="text" class="text-end" name="" id="totalAmt" value="`+ LineTotalAmt.toLocaleString() +`" disabled>
                                    </td>
                                    <td class="px-3 py-0">
                                        <input type="checkbox" class="form-check-input cust-form-check mt-2" id="`+ refNo +`"`+ checkFoc +` onchange="AddFoc(event, this.id)" />
                                    </td>
                                    <td class="px-2 py-0">
                                        <button type="button" id="`+ refNo +`" class="btn delete-btn py-0 mt-1 px-1" id="" onclick="DeletePurInvoiceRow(this.id)">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>`;
            }

        }

        // if (nextFocus != "") {
        //     document.querySelector("."+nextFocus).focus();
        // }

        dselect(document.querySelector(".warehouseList_"+ refNo), config);

        dselect(document.querySelector(".itemCodeList_"+ refNo), config);

        dselect(document.querySelector(".unitCodeList_"+ refNo), config);

        SubTotalAmount();

        GrandTotalAmount();
    }

    // ========= End of Row Replace Function ========= //

    // ========= Delete Row Function ===========//
    
    function DeletePurInvoiceRow(refNo) {

        let mainTable = document.getElementById("purchaseProdList");

        let noRow = mainTable.rows.length;

        for(let i = 0; i < noRow; i++) {

            let rowId = mainTable.rows[i].getAttribute("id");

            if( rowId == refNo) {

                document.getElementById("purchaseProdList").deleteRow(i);

                break;

            }

        }

        rowNo = refNo;

        purchaseProductDataList = purchaseProductDataList.filter((element) => element.referenceNo != refNo);

        SubTotalAmount();

        GrandTotalAmount();
    }

    // =========== End of Delete Row Function ============ //

    // ========== Display Sub Total Amount Function ========== //

    function SubTotalAmount() {

        let subTotal = 0;

        purchaseProductDataList.forEach(element => {

            subTotal += element.LineTotalAmt;

        });    
        
        document.getElementById("subTotal").value = subTotal.toLocaleString();

        AddSupplierData();

    }

    // ========== End of Display Sub Total Amount Function ========== //

    // ========== Display Grand Total Amount Function ========= //
    
    function GrandTotalAmount() {

        let grandTotal = Number($("#subTotal").val().replace(/,/g,"")) - Number($("#totalCharges").val().replace(/,/g,""));

        document.getElementById("grandTotal").value = grandTotal.toLocaleString();

    }

    // ========== End of Display Grand Total Amount Function =========== //

    // ========== Check Discount Function ============= //

    function CheckDiscount(amount, disAmt, disRate, isFoc) {

        let lineTotalAmt = 0;

        if (isFoc == 0) {

            if (disAmt != 0) {

            lineTotalAmt = amount - disAmt;

            } else if (disRate != 0) {

                lineTotalAmt = amount - (amount *(disRate / 100))

            } else {

                lineTotalAmt = amount;

            }

        }

        return lineTotalAmt;

    }

    // ========== End of Check Discount Function ========== //

    // ========= Display Total Charges Function ========== //

    function DisplayTotalCharges() {

        let shippingCharge = Number($("#shippingCharges").val().replace(/,/g, ""));
        
        let laborCharge = Number($("#laborCharges").val().replace(/,/g, ""));

        let deliveryCharge = Number($("#deliveryCharges").val().replace(/,/g, ""));

        let weightCharge = Number($("#weightCharges").val().replace(/,/g,""));

        let serviceCharge = Number($("#serviceCharges").val().replace(/,/g,""));

        let factoryCharges = Number($("#factoryCharges").val().replace(/,/g,""));

        let totalCharges = shippingCharge + laborCharge + deliveryCharge + weightCharge + serviceCharge + factoryCharges;

        $("#totalCharges").val(totalCharges.toLocaleString());

        GrandTotalAmount();

    }

    function PuCharges(event) {

        let check = /^[0-9/,]+$/;

        if (event.target.value < 0 || !check.test(event.target.value)) {

            $("#"+event.target.id).val(0);

        }

        let inputValue = Number((event.target.value).replace(/,/g, ""));

        $("#"+event.target.id).val(inputValue.toLocaleString());

        DisplayTotalCharges();

    }

    // ========= End of Display Total Charges Function ========= //

    // ========= Print Function ======== //

    $("#printPuBtn").on('click', savePuData);

    // ========= End of Print Function ======== //

    // ========= Save Data to Database =========== //

    $("#saveFormData").submit(savePuData);

    function savePuData(event){

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
                    WarehouseNo : element.WarehouseNo,
                    ItemCode : element.ItemCode,
                    Quantity : element.Quantity,
                    PackedUnit : element.PackedUnit,
                    TotalViss : element.TotalViss,
                    UnitPrice : element.UnitPrice,
                    Amount : element.Amount,
                    LineDisPer : element.LineDisPer,
                    LineDisAmt : element.LineDisAmt,
                    LineTotalAmt : element.LineTotalAmt,
                    IsFOC : element.IsFOC
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

        // data.InvoiceNo = $("#invoiceNo").val();
        data.PurchaseDate = $("#purchaseDate").val();
        data.SupplierCode = supplierCode;
        data.ArrivalCode = arrivalCode;
        data.IsComplete = document.getElementById("isArrivalComplete").checked ? 1 : 0;
        // console.log(data.IsArrivalComplete);
        data.SubTotal = Number($("#subTotal").val().replace(/,/g, ""));
        data.ShippingCharges = Number($("#shippingCharges").val().replace(/,/g, ""));
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

        console.log(data);

        $.ajax({
            url: '/purchaseinvoices/add' ,
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {

                console.log(response);

                if(response.message == "good"){

                    if(event.target.id == "printPuBtn") {

                        sessionStorage.setItem('save', 'success');

                        window.location.href = "/purchaseinvoices/printpuvoucher/"+ response.InvoiceNo

                    } else {

                        sessionStorage.setItem('save', 'success');

                        window.location.href = "/purchaseinvoices/add";

                    }

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

    // ========= End of Save Data to Database ======== //

    // ========= Focus Functions ========= //

    function PAddFocus(event) {

        let inputValue = Number(event.target.value.replace(/,/g, ''));

        event.target.removeAttribute('value');

        event.target.removeAttribute('type');

        event.target.setAttribute('type', 'number');

        event.target.setAttribute('value', inputValue);

        event.target.select();

    }

    function PAddSelect() {

        $(this).select();

    }

    $("#shippingCharges").on('focus', PAddSelect)

    $("#laborCharges").on('focus', PAddSelect)

    $("#weightCharges").on('focus', PAddSelect);

    $("#deliveryCharges").on('focus', PAddSelect);

    $("#serviceCharges").on('focus', PAddSelect);

    $("#factoryCharges").on('focus', PAddSelect);


    // ========= End of Focus Functions ========= //

    // ========= Paid Check Functions ========= //

    function PuPaidCheck(event) {

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

    // ========= Add Shipping Charges Function ======= //

    function AddArrivalData(event) {

        let arrivalCode = event.target.value;

        itemArrival.forEach((e) => {
            
            if(e.arrivalCode == arrivalCode) {

                document.querySelector("#shippingCharges").value = Number(e.charges).toLocaleString();

            }

        });

        DisplayTotalCharges();
    }

    // ========= End of Add Shipping Charges Function ======= //


    // ========= Add Supplier Data ========= //

    function AddSupplierData() {

        let supplierCode = document.querySelector("#supplierCodeList").value;

        let subTotal = Number(document.querySelector("#subTotal").value.replace(/,/g,""));

        supplierList.forEach((e) => {

            if (e.supplierCode == supplierCode) {

                document.querySelector("#serviceCharges").value = Math.floor(subTotal * (e.profit / 100)).toLocaleString();

            }

        });

        DisplayTotalCharges();

    }

    // ========= End of Add Supplier Data ========= //

</script>