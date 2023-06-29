<x-layout title="Create Sales">


    @php
        $saleWarehouseList = [];
        $saleItemArray = [];
        $saleUnitList = [];
    @endphp

    @foreach ($items as $item)

        @php
            $saleItemArray[] = [
                'itemId' => $item->ItemCode,
                'itemName' => $item->ItemName,
                'itemPrice' => $item->UnitPrice,
            ]
        @endphp

    @endforeach

    @foreach ($warehouses as $warehouse )
    
        @php
            $saleWarehouseList[] = [
                'warehouseCode' => $warehouse->WarehouseCode,
                'warehouseName' => $warehouse->WarehouseName
            ]
        @endphp

    @endforeach

    @foreach ($units as $unit)

        @php
            $saleUnitList[] = [
                'unitCode' => $unit->UnitCode,
                'unitName' => $unit->UnitDesc
            ]
        @endphp

    @endforeach

    <div class="container-fluid content-body mt-3">

    {{-- Section Title --}}
        
        <div class="row justify-content-between">
            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Sales Invoice</h3>
            </div>
            {{-- Back Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/salesinvoices/index" class="btn main-btn">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

    {{-- End of Section Title --}}

    {{-- Generate Id --}}
        {{-- @php
            require app_path('./utils/GenerateId.php');
            $generateid = new GenerateId();
            $id = $generateid->generatePrimaryKeyId('sale_invoices','InvoiceNo','SV-',true);
     
        @endphp --}}
    {{-- End of Generate Id --}}
        
    {{-- Form Section --}}

        <x-error name="Email"></x-error>

        <form action="/salesinvoices/add" method="Post" id="saveSalesForm" class="row form-card mt-2 mb-3 needs-validation" novalidate>
            @csrf
            
            <div class="col-12 px-0">
                
                <p class="p-0 content-title"><span>Basic Info</span></p>
                <div class="row">
                    {{-- Invoice No --}}
                    {{-- <div class="col-12 col-md-6 col-xl-4 col-xxl-2 mb-2">
                        <label for="saleInvoiceNo" class="form-label cust-label">Invoice No</label>
                        <input type="text" class="form-control cust-input-box" id="saleInvoiceNo" name="InvoiceNo" value="{{$id}}" disabled>
                    </div> --}}
                    {{-- Sale Date --}}
                    <div class="col-12 col-md-6 col-xl-4 col-xxl-2 mb-2">
                        <label for="saleDate" class="form-label cust-label">Sales Date</label>
                        <input type="date" class="form-control cust-input-box" id="saleDate" name="SaleDate" value="{{$currentDate}}" required>
                    </div>
                    <div class="invalid-feedback">
                            Please fill sales date.
                        </div>
                    {{-- customer Code --}}
                    <div class="col-12 col-md-6 col-xl-4 col-xxl-2 mb-2">
                        <label for="customerNameList" class="form-label cust-label">Customer Name</label>
                        <select class="mb-3 form-select" id="customerNameList" name="CustomerCode" required>
                            <option value="" selected disabled>Choose</option>
                            @if(isset($customers) && is_object($customers) && count($customers) > 0)
                                @forelse ($customers as $customer)
                                    
                                        <option value="{{$customer->CustomerCode}}">{{$customer->CustomerName}}</option>
                                    
                                
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
                    {{-- Plate No --}}
                    <div class="col-12 col-md-6 col-xl-4 col-xxl-2 mb-2">
                        <label for="salePlateNo" class="form-label cust-label">Plate No</label>
                        <input type="text" class="form-control cust-input-box" id="salePlateNo" name="PlateNo" value="">
                        
                    </div>
                    {{-- Remarks --}}
                    <div class="col-12 col-md-6 col-xl-4 col-xxl-4 mb-2">
                        <label 6class="cust-label form-label text-end" for="salesRemark">Remark</label>
                        <textarea class="form-control cust-textarea mt-2" name="" id="salesRemark" rows="2"></textarea>
                    </div>
                </div>
                <p class="p-0 content-title"><span>Payment Info</span></p>
                <div class="row">
                    <div class="col-md-8 col-xl-7 col-xxl-6">
                        <div class="row">

                            {{-- Paid Date --}}
                            <div class="col-12 col-md-6 col-xl-5 col-xxl-4 mb-2">
                                <label for="salePaidDate" class="form-label cust-label">Paid Date</label>
                                <input type="date" class="form-control cust-input-box" id="salePaidDate" name="PaidDate" value="" disabled>
                            </div>
                            {{-- Paid Status --}}
                            <div class="col-12 col-md-6 col-xl-4 col-xxl-3 mb-2">
                                <label class="cust-label form-label text-end" for="saleIsPaid">Paid</label>
                                <div class="col-sm-8 form-check form-switch">
                                    <input class="form-check-input cust-form-switch" type="checkbox" role="switch" id="saleIsPaid" name="IsPaid" onchange="SPaidCheck(event);">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                
                <p class="p-0 content-title"><span>Details</span></p>
                <button class="btn btn-noBorder" id="addNewProd" type="button"><span class="me-2"><i class="bi bi-plus-circle"></i></span>New</button>
                <div class="row">
                    <div class="saleTable">
                        <table class="table" id="saleProdList">
                            <thead class="sticky-top">
                                <tr id="0">
                                    <th style="width: 50px;">No</th>
                                    <th style="width: 200px;">Item Code</th>
                                    <th style="width: 200px;">Warehouse Code</th>
                                    <th style="width: 120px;">Quantity</th>
                                    <th style="width: 80px;">Unit</th>
                                    <th style="width: 120px;">Unit Price</th>
                                    <th style="width: 150px;">Total Viss</th>
                                    <th style="width: 150px;">Amount</th>
                                    <th style="width: 60px;">Discount(%)</th>
                                    <th style="width: 120px;">Discount</th>
                                    <th style="width: 170px;">Total Amount</th>
                                    <th style="width: 50px;">FOC</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="selectedSalesItems">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-3 justify-content-between">
                    <div class="col-xl-5 col-xxl-4">
                        <p class="p-0 content-title"><span>Charges</span></p>
                        {{-- Labor Charges --}}
                        <div class="row justify-content-end">
                            <label for="saleLaborCharges" class="form-label text-end cust-label col-5">Labor Charges :</label>
                            <div class="col-5 col-xxl-6 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="saleLaborCharges" name="LaborCharges" value="0" onblur="SaleCharges(event);">
                            </div>
                        </div>
                        {{-- Delivery Charges --}}
                        <div class="row justify-content-end">
                            <label for="saleDeliveryCharges" class="form-label text-end cust-label col-5">Delivery Charges :</label>
                            <div class="col-5 col-xxl-6 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="saleDeliveryCharges" name="DeliveryCharges" value="0" onblur="SaleCharges(event);">
                            </div>
                        </div>
                        {{-- Weight Charges --}}
                        <div class="row justify-content-end">
                            <label for="saleWeightCharges" class="form-label text-end cust-label col-5">Weight Charges :</label>
                            <div class="col-5 col-xxl-6 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="saleWeightCharges" name="WeightCharges" value="0" onblur="SaleCharges(event);">
                            </div>
                        </div>
                        {{-- Service Charges --}}
                        <div class="row justify-content-end">
                            <label for="saleServiceCharges" class="form-label text-end cust-label col-5">Service Charges :</label>
                            <div class="col-5 col-xxl-6 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="saleServiceCharges" name="ServiceCharges" value="0" onblur="SaleCharges(event);">
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="col-xl-6">
                        {{-- Sub Total --}}
                        <div class="row justify-content-end mt-2">
                            <label for="saleSubTotal" class="form-label text-end cust-label col-5 col-xl-4 col-xxl-3">Sub Total :</label>
                            <div class="col-5 col-xl-5 col-xxl-4 mb-2">
                                <input type="number" class="form-control cust-input-box" id="saleSubTotal" name="SubTotal" value="0" disabled>
                            </div>
                        </div>
                        {{-- Total Charges --}}
                        <div class="row justify-content-end">
                            <label for="saleTotalCharges" class="form-label text-end cust-label col-5 col-xl-4 col-xxl-3">Total Charges :</label>
                            <div class="col-5 col-xl-5 col-xxl-4 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="saleTotalCharges" name="TotalCharges" value="0" disabled>
                            </div>
                        </div>
                        {{-- Grand Total --}}
                        <div class="row justify-content-end">
                            <label for="saleGrandTotal" class="form-label text-end cust-label col-5 col-xl-4 col-xxl-3">Grand Total :</label>
                            <div class="col-5 col-xl-5 col-xxl-4 mb-2">
                                <input type="text" class="form-control cust-input-box text-end" id="saleGrandTotal" name="GrandTotal" value="0" disabled>
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
                        <button type="button" class="btn btn-primary" id="printSalesInBtn">
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

    dselect(document.querySelector("#customerNameList"), config);
    
    var saleRowNo = 1;

    let saleItemArray = @json($saleItemArray);

    let saleWarehouseList = @json($saleWarehouseList);

    let saleUnitList = @json($saleUnitList);

    let saleProductDataList = [];

    $(document).ready(function(){

        let saleProductData = {
            referenceNo : saleRowNo,
            WarehouseNo : "",
            WarehouseName: "",
            ItemCode : "",
            ItemName : "",
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

        tableRow.setAttribute("id", saleRowNo);

        tableRow.innerHTML = `<td class="px-0 py-0">
                                <input type="text" class="tableInput" name="" id="referenceNo" value="`+ saleRowNo +`" disabled>
                            </td>
                            <td class="px-0 py-0" id="sRow`+ saleRowNo +`">
                                <select name="" id="`+ saleRowNo +`" class="saleItemList_`+ saleRowNo +`" onchange="AddSaleItem(this.id,this.value)">
                                    <option selected disabled>Choose</option>
                                    @forelse ($items as $item) 
                                        <option value="{{$item->ItemCode}}">{{$item->ItemName}}</option>
                                    @empty
                                        <option disabled>No Item</option>
                                    @endforelse
                                </select>
                            </td>
                            <td class="px-0 py-0">
                                <select name="" id="`+ saleRowNo +`" class="saleWhList_`+ saleRowNo +`" onchange="AddSaleWh(this.id, this.value);">
                                    <option selected disabled>Choose</option>
                                    @forelse ($warehouses as $warehouse) 
                                        <option value="{{$warehouse->WarehouseCode}}">{{$warehouse->WarehouseName}}</option>
                                    @empty
                                        <option disabled>No Arrival Code Found</option>
                                    @endforelse
                                </select>
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="text-end" value="0" id="`+ saleRowNo +`" onblur="AddSaleQty(event,this.id,this.value);" onfocus="SAddFocusValue(event)" nextfocus="unitprice_`+ saleRowNo +`">
                            </td>
                            <td class="px-0 py-0">
                                <select name="" class="saleUnitList_`+ saleRowNo +`" id="`+ saleRowNo +`" onchange="AddSaleUnit(this.id, this.value);">
                                    <option selected disabled>Choose</option>
                                    @forelse ($units as $unit) 
                                        <option value="{{$unit->UnitCode}}">{{$unit->UnitDesc}}</option>
                                    @empty
                                        <option disabled>No Arrival Code Found</option>
                                    @endforelse
                                </select>
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="unitprice_`+ saleRowNo +`" value="0" id="`+ saleRowNo +`" onblur="AddSalePrice(event,this.id,this.value);" onfocus="SAddFocusValue(event)" nextfocus="saleviss_`+ saleRowNo +`" >
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="saleviss_`+ saleRowNo +` text-end" id="`+ saleRowNo +`" onblur="AddSaleTotalViss(event,this.id,this.value)" onfocus="SAddFocusValue(event)" >
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="tableInput" name="" id="itemAmount" disabled>
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="tableInput" name="" id="`+ saleRowNo +`" onblur="AddSaleDisRate(this.id, this.value);" value="0" onfocus="SAddFocusValue(event)">
                            </td>
                            <td class="px-0 py-0">
                                <input type="text" class="text-end" name="" id="`+ saleRowNo +`" onblur="AddSaleDisAmt(this.id, this.value);" value="0" onfocus="SAddFocusValue(event)">
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="tableInput" name="" id="totalAmt" disabled>
                            </td>
                            <td class="px-3 py-0">
                                <input type="checkbox" class="form-check-input cust-form-check mt-2" id="`+ saleRowNo +`" onchange="AddSaleFoc(event, this.id)">
                            </td>
                            <td class="px-2 py-0">
                                <button type="button" id="`+ saleRowNo +`" class="btn delete-btn py-0 mt-1 px-1" id="" onclick="DeleteSalesRow(this.id)">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>`;

            saleProductDataList.push(saleProductData);

            document.getElementById("selectedSalesItems").appendChild(tableRow);

            dselect(document.querySelector(".saleWhList_"+ saleRowNo), config);

            dselect(document.querySelector(".saleItemList_"+ saleRowNo), config);

            dselect(document.querySelector(".saleUnitList_"+ saleRowNo), config);

            saleRowNo++;

    });

    $("#addNewProd").on("click", ()=>{

        let saleProductData = {
            referenceNo : saleRowNo,
            WarehouseNo : "",
            WarehouseName: "",
            ItemCode : "",
            ItemName : "",
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

        newRow.setAttribute("id", saleRowNo);

        newRow.innerHTML = `<td class="px-0 py-0">
                                <input type="text" class="tableInput" name="" id="referenceNo" value="`+ saleRowNo +`" disabled>
                            </td>
                            <td class="px-0 py-0" id="sRow`+ saleRowNo +`">
                                <select name="" id="`+ saleRowNo +`" class="saleItemList_`+ saleRowNo +`" onchange="AddSaleItem(this.id,this.value)">
                                    <option selected disabled>Choose</option>
                                    @forelse ($items as $item) 
                                        <option value="{{$item->ItemCode}}">{{$item->ItemName}}</option>
                                    @empty
                                        <option disabled>No Item</option>
                                    @endforelse
                                </select>
                            </td>
                            <td class="px-0 py-0">
                                <select name="" id="`+ saleRowNo +`" class="saleWhList_`+ saleRowNo +`" onchange="AddSaleWh(this.id, this.value);">
                                    <option selected disabled>Choose</option>
                                    @forelse ($warehouses as $warehouse) 
                                        <option value="{{$warehouse->WarehouseCode}}">{{$warehouse->WarehouseName}}</option>
                                    @empty
                                        <option disabled>No Arrival Code Found</option>
                                    @endforelse
                                </select>
                            </td>
                            <td class="px-0 py-0">
                                <input type="text" class="text-end" value="0" id="`+ saleRowNo +`" onblur="AddSaleQty(event,this.id,this.value);" onfocus="SAddFocusValue(event)" nextfocus="unitprice_`+ saleRowNo +`">
                            </td>
                            <td class="px-0 py-0">
                                <select name="" class="saleUnitList_`+ saleRowNo +`" id="`+ saleRowNo +`" onchange="AddSaleUnit(this.id, this.value);">
                                    <option selected disabled>Choose</option>
                                    @forelse ($units as $unit) 
                                        <option value="{{$unit->UnitCode}}">{{$unit->UnitDesc}}</option>
                                    @empty
                                        <option disabled>No Arrival Code Found</option>
                                    @endforelse
                                </select>
                            </td>
                            <td class="px-0 py-0">
                                <input type="text" class="unitprice_`+ saleRowNo +` text-end" value="0" id="`+ saleRowNo +`" onblur="AddSalePrice(event,this.id,this.value);" onfocus="SAddFocusValue(event)" nextfocus="saleviss_`+ saleRowNo +`" >
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="saleviss_`+ saleRowNo +` text-end" id="`+ saleRowNo +`" onblur="AddSaleTotalViss(event,this.id,this.value)" onfocus="SAddFocusValue(event)" >
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="tableInput" name="" id="itemAmount" disabled>
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="tableInput" name="" id="`+ saleRowNo +`" onblur="AddSaleDisRate(this.id, this.value);" value="0" onfocus="SAddFocusValue(event)">
                            </td>
                            <td class="px-0 py-0">
                                <input type="text" class="text-end" name="" id="`+ saleRowNo +`" onblur="AddSaleDisAmt(this.id, this.value);" value="0" onfocus="SAddFocusValue(event)">
                            </td>
                            <td class="px-0 py-0">
                                <input type="number" class="tableInput" name="" id="totalAmt" disabled>
                            </td>
                            <td class="px-3 py-0">
                                <input type="checkbox" class="form-check-input cust-form-check mt-2" id="`+ saleRowNo +`" onchange="AddSaleFoc(event, this.id)">
                            </td>
                            <td class="px-2 py-0">
                                <button type="button" id="`+ saleRowNo +`" class="btn delete-btn py-0 mt-1 px-1" id="" onclick="DeleteSalesRow(this.id)">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>`;

        document.getElementById("selectedSalesItems").appendChild(newRow);

        dselect(document.querySelector(".saleWhList_"+ saleRowNo), config);

        dselect(document.querySelector(".saleItemList_"+ saleRowNo), config);

        dselect(document.querySelector(".saleUnitList_"+ saleRowNo), config);

        saleProductDataList.push(saleProductData);

        saleRowNo++;

    });

    // ======= Add Item Function ======== //

    function AddSaleItem(refNo,inputValue){

        saleProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                e.ItemCode = inputValue;

                saleItemArray.forEach(element => {

                    if (element.itemId == inputValue) {

                        e.UnitPrice = element.itemPrice;

                        e.ItemName = element.itemName;

                        e.Amount = e.Quantity * e.UnitPrice;

                        e.LineTotalAmt = CheckSaleDiscount(e.Amount, e.LineDisAmt, e.LineDisPer, e.IsFOC);

                        SaleRowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "");

                    }

                });

                

            }

        });

        SaleSubTotalAmt();

        SaleGrandTotalAmt();
        
    }

    // ====== End of Add Item Function ======= //

    // ======= Add Warehouse Function ======== //

    function AddSaleWh(refNo,inputValue){

        saleProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                e.WarehouseNo = inputValue;

                saleWarehouseList.forEach(element => {

                    if (element.warehouseCode == inputValue) {

                        e.WarehouseName = element.warehouseName;

                        SaleRowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "");

                    }

                });

            }

        });

    }

    // ====== End of Add Warehouse Function ======= //

    // ======= Add Unit Function ======== //

    function AddSaleUnit(refNo,inputValue){

        saleProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                e.PackedUnit = inputValue;

                saleUnitList.forEach(element => {

                    if (element.unitCode == inputValue) {

                        e.UnitName = element.unitName;

                        SaleRowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "");

                    }

                });

            }

        });

    }

    // ====== End of Add Unit Function ======= //

    // ====== Add Unit Qty Function ========== //

    function AddSaleQty(event, refNo, inputValue){

        let nextFocus = event.target.getAttribute("nextfocus");

        saleProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                if (inputValue > 0 ) {

                    e.Quantity = Number(inputValue.replace(/,/g, ""));

                } else {

                    e.Quantity = 0;

                }
                
                e.Amount = e.UnitPrice *  e.Quantity;

                e.LineTotalAmt = CheckSaleDiscount(e.Amount, e.LineDisAmt, e.LineDisPer, e.IsFOC);

                SaleRowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, nextFocus);

            }

        });

        

        SaleSubTotalAmt();

        SaleGrandTotalAmt();

    }

    // ====== End of Add Unit Function ========== //

    // ====== Add Unit Price Function ====== //

    function AddSalePrice(event, refNo, inputValue) {

        let nextFocus = event.target.getAttribute("nextfocus");

        saleProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                if (inputValue > 0 ) {

                    e.UnitPrice = Number(inputValue.replace(/,/g, ""));

                } else {

                    e.UnitPrice = 0;

                }
                
                e.Amount = e.Quantity *  inputValue;

                e.LineTotalAmt = CheckSaleDiscount(e.Amount, e.LineDisAmt, e.LineDisPer, e.IsFOC);

                SaleRowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, nextFocus); 

            }

        });

        SaleSubTotalAmt();

        SaleGrandTotalAmt();

    }

    // ========= End of Add Unit Price Function ===========//

    // ========= Add Total Viss Function =========== //

    function AddSaleTotalViss(event, refNo, inputValue) {

        saleProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                if (inputValue > 0 ) {

                    e.TotalViss = inputValue;

                } else {

                    e.TotalViss = 0;

                }

                SaleRowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "");

            }

        });
        
    }

    // ========= End of Add Total Viss Function ========= //

    // ========= Add Discount Amount Function ===========//

    function AddSaleDisAmt(refNo, inputValue) {

        saleProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                if (inputValue == "" || inputValue < 0) {

                    e.LineDisAmt = 0;

                } else {

                    e.LineDisAmt = Number(inputValue.replace(/,/g, ""));

                }
                
                e.LineTotalAmt = e.Amount - e.LineDisAmt;

                SaleRowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "");

            }

        });

        SaleSubTotalAmt();

        SaleGrandTotalAmt();

    }

    // ========= End of Add Discount Amount Function ========= //

    // ========= Add Discount Rate Function ===========//

    function AddSaleDisRate(refNo, inputValue) {

        saleProductDataList.forEach(e => {

            if (e.referenceNo == refNo ) {

                if ((inputValue == 0 || inputValue < 0 || inputValue > 100) ) {

                    e.LineDisPer = 0;

                } else {

                    e.LineDisPer = inputValue;

                }
                
                e.LineTotalAmt = e.Amount - ((e.LineDisPer / 100) * e.Amount);

                SaleRowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "");

            }

        });

        SaleSubTotalAmt();

        SaleGrandTotalAmt();

    }

    // ========= End of Add Discount Rate Function ========= //

    // ========= Add Foc Function ============= //

    function AddSaleFoc(event, refNo) {

        saleProductDataList.forEach(e => {

            if (e.referenceNo == refNo) {

                if (event.target.checked == true) {

                    e.IsFOC = 1;

                    e.LineTotalAmt = 0;

                    SaleRowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "");

                } else {

                    e.IsFOC = 0;

                    let unitTotalAmt = e.UnitPrice * e.Quantity;

                    if (e.LineDisAmt != 0) {

                        e.LineTotalAmt = unitTotalAmt - e.LineDisAmt;

                    } else if (e.LineDisPer != 0) {

                        e.LineTotalAmt = unitTotalAmt - (unitTotalAmt * (e.LineDisPer / 100));

                    } else {

                        e.LineTotalAmt = unitTotalAmt;

                    }

                    SaleRowReplace(refNo, e.WarehouseNo, e.WarehouseName, e.ItemCode, e.ItemName, e.Quantity, e.PackedUnit, e.UnitName, e.TotalViss, e.UnitPrice, e.Amount, e.LineDisPer, e.LineDisAmt, e.LineTotalAmt, e.IsFOC, "");

                }
                

            }
            

        });

        SaleSubTotalAmt();

        SaleGrandTotalAmt();

    }

    // ========= End of Foc Function =========== //

    // ========= Row Replace Function ========== //

    function SaleRowReplace(refNo, WarehouseNo, WarehouseName, ItemCode, ItemName, Quantity, PackedUnit, UnitName, TotalViss, UnitPrice, Amount, LineDisPer, LineDisAmt, LineTotalAmt, IsFoc, nextFocus) {

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

        let mainTable = document.getElementById("saleProdList");

        let noRow = mainTable.rows.length;

        for(let i = 0; i < noRow; i++) {

            let rowId = mainTable.rows[i].getAttribute("id");

            if( rowId == refNo) {

                mainTable.rows[i].innerHTML = `<td class="px-0 py-0">
                                        <input type="text" class="tableInput" name="" id="referenceNo" value="`+ refNo +`" disabled>
                                    </td>
                                    <td class="px-0 py-0" id="row_`+ refNo +`">
                                        <select name="" id="`+ refNo +`" class="saleItemList_`+ refNo +`" onchange="AddSaleItem(this.id,this.value)">
                                            <option value="`+ ItemCode +`" selected disabled>`+ ItemName +`</option>
                                            @forelse ($items as $item) 
                                                <option value="{{$item->ItemCode}}">{{$item->ItemName}}</option>
                                            @empty
                                                <option disabled>No Item</option>
                                            @endforelse
                                        </select>
                                    </td>
                                    <td class="px-0 py-0">
                                        <select name="" id="`+ refNo +`" class="saleWhList_`+ refNo +`" onchange="AddSaleWh(this.id,this.value);">
                                            <option value="`+ WarehouseNo +`" selected disabled>`+ WarehouseName +`</option>
                                            @forelse ($warehouses as $warehouse) 
                                                <option value="{{$warehouse->WarehouseCode}}">{{$warehouse->WarehouseName}}</option>
                                            @empty
                                                <option disabled>No Warehouse Code Found</option>
                                            @endforelse
                                        </select>
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="text" class="text-end" value="`+ Quantity.toLocaleString() +`" id="`+ refNo +`" onblur="AddSaleQty(event,this.id,this.value);" onfocus="SAddFocusValue(event)" nextfocus="unitprice_`+ refNo +`">
                                    </td>
                                    <td class="px-0 py-0">
                                        <select name="" class="saleUnitList_`+ refNo +`" id="`+ refNo +`" onchange="AddSaleUnit(this.id, this.value);">
                                            <option value="`+ PackedUnit +`" selected disabled>`+ UnitName +`</option>
                                            @forelse ($units as $unit) 
                                                <option value="{{$unit->UnitCode}}">{{$unit->UnitDesc}}</option>
                                            @empty
                                                <option disabled>No Unit Code Found</option>
                                            @endforelse
                                        </select>
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="text" class="unitprice_`+ refNo +` text-end" value="`+ UnitPrice.toLocaleString() +`" id="`+ refNo +`" onblur="AddSalePrice(event,this.id,this.value);" onfocus="SAddFocusValue(event)" nextfocus="saleviss_`+ refNo +`" >
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="number" class="saleviss_`+ refNo +` text-end" value="`+ TotalViss +`" id="`+ refNo +`" onblur="AddSaleTotalViss(event,this.id,this.value)" onfocus="SAddFocusValue(event)" >
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="number" class="tableInput" name="" id="itemAmount" value="`+ UnitPrice * Quantity +`" disabled>
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="number" class="tableInput" name="" id="`+ refNo +`" value="`+ LineDisPer +`" onblur="AddSaleDisRate(this.id, this.value);"`+ checkDisRate + ` onfocus="SAddFocusValue(event)">
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="text" class="text-end" name="" id="`+ refNo +`" value="`+ LineDisAmt.toLocaleString() +`" onblur="AddSaleDisAmt(this.id, this.value);"`+ checkDisAmt +` onfocus="SAddFocusValue(event)">
                                    </td>
                                    <td class="px-0 py-0">
                                        <input type="text" class="text-end" name="" id="totalAmt" value="`+ LineTotalAmt.toLocaleString() +`" disabled>
                                    </td>
                                    <td class="px-3 py-0">
                                        <input type="checkbox" class="form-check-input cust-form-check mt-2" id="`+ refNo +`"`+ checkFoc +` onchange="AddSaleFoc(event, this.id)" >
                                    </td>
                                    <td class="px-2 py-0">
                                        <button type="button" id="`+ refNo +`" class="btn delete-btn py-0 mt-1 px-1" id="" onclick="DeleteSalesRow(this.id)">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>`;
            }

        }

        if (nextFocus != "") {

            document.querySelector("."+nextFocus).focus();

        }

        dselect(document.querySelector(".saleWhList_"+ refNo), config);

        dselect(document.querySelector(".saleItemList_"+ refNo), config);

        dselect(document.querySelector(".saleUnitList_"+ refNo), config);
    }

    // ========= End of Row Replace Function ========= //

    // ========= Delete Row Function ===========//
    
    function DeleteSalesRow(refNo) {

        let mainTable = document.getElementById("saleProdList");

        let noRow = mainTable.rows.length;

        for(let i = 0; i < noRow; i++) {

            let rowId = mainTable.rows[i].getAttribute("id");

            if( rowId == refNo) {

                document.getElementById("saleProdList").deleteRow(i);

                break;

            }

        }

        saleProductDataList = saleProductDataList.filter((element) => element.referenceNo != refNo);
        

        SaleSubTotalAmt();

        SaleGrandTotalAmt();
    }

    // =========== End of Delete Row Function ============ //

    // ========== Display Sub Total Amount Function ========== //

    function SaleSubTotalAmt() {

        let subTotal = 0;

        saleProductDataList.forEach(element => {

            subTotal += Number(element.LineTotalAmt);

        });    
        
        document.getElementById("saleSubTotal").value = subTotal;

    }

    // ========== End of Display Sub Total Amount Function ========== //

    // ========== Display Grand Total Amount Function ========= //
    
    function SaleGrandTotalAmt() {

        let grandTotal = Number($("#saleSubTotal").val().replace(/,/g,"")) - Number($("#saleTotalCharges").val().replace(/,/g,""));

        document.getElementById("saleGrandTotal").value = grandTotal.toLocaleString();

    }

    // ========== End of Display Grand Total Amount Function =========== //

    // ========== Check Discount Function ============= //

    function CheckSaleDiscount(amount, disAmt, disRate, isFoc) {

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

    function SaleTotalCharges() {

        let laborCharge = Number($("#saleLaborCharges").val().replace(/,/g, ""));

        let deliveryCharge = Number($("#saleDeliveryCharges").val().replace(/,/g, ""));

        let weightCharge = Number($("#saleWeightCharges").val().replace(/,/g,""));

        let serviceCharge = Number($("#saleServiceCharges").val().replace(/,/g,""));

        let totalCharges = laborCharge + deliveryCharge + weightCharge + serviceCharge;

        $("#saleTotalCharges").val(totalCharges.toLocaleString());

        SaleGrandTotalAmt();

    }

    function SaleCharges(event) {

        let check = /^[0-9]+$/;

        if (event.target.value < 0 || !check.test(event.target.value)) {

            $("#"+event.target.id).val(0);

        }

        let inputValue = Number((event.target.value).replace(/,/g, ""));

        $("#"+event.target.id).val(inputValue.toLocaleString());

        SaleTotalCharges()

    }

    // ========= End of Display Total Charges Function ========= //

    // ========= Save and Print Function ========== //

    $("#printSalesInBtn").on('click', SaveSalesData);

    // ========= End of Save and Print Function ========= //

    // ========= Save Data to Database ========== //

    $("#saveSalesForm").submit(SaveSalesData);

    function SaveSalesData(event) {

        event.preventDefault();

        let saleInvoiceDetailsArr = [];

        saleProductDataList.forEach(element => {

            if (element.ItemCode != "") {

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

                saleInvoiceDetailsArr.push(purchaseInvoiceDetailsObject);

            }

        });

        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        });

        let data = {};

        // data.InvoiceNo = $("#saleInvoiceNo").val();
        data.SalesDate = $("#saleDate").val();
        data.CustomerCode = $("#customerNameList").val();
        data.PlateNo = $("#salePlateNo").val();
        data.SubTotal = Number($("#saleSubTotal").val().replace(/,/g, ""));
        data.LaborCharges = Number($("#saleLaborCharges").val().replace(/,/g, ""));
        data.DeliveryCharges = Number($("#saleDeliveryCharges").val().replace(/,/g, ""));
        data.WeightCharges = Number($("#saleWeightCharges").val().replace(/,/g, ""));
        data.ServiceCharges = Number($("#saleServiceCharges").val().replace(/,/g, ""));
        data.TotalCharges = Number($("#saleTotalCharges").val().replace(/,/g, ""));
        data.GrandTotal = Number($("#saleGrandTotal").val().replace(/,/g, ""));
        data.Remark = $("#salesRemark").val();
        data.IsPaid = document.getElementById("saleIsPaid").checked ? 1 : 0;
        data.PaidDate = $("#salePaidDate").val() == "" ? null : $("#salePaidDate").val();
        data.saleinvoicedetails  = saleInvoiceDetailsArr;

        data = JSON.stringify(data);

    

        $.ajax({
            url: '/salesinvoices/add' ,
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {

                console.log(response);
                
                if(response.message == "good"){

                    if (event.target.id == 'printSalesInBtn') {

                        sessionStorage.setItem('save', 'success');

                        window.location.href = "/salesinvoices/salesvoucher/" + response.InvoiceNo;

                    } else {

                        sessionStorage.setItem('save', 'success');

                        window.location.href = "/salesinvoices/add";

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
    };

    // ========= End of Save Data to Database ========== //

    // ========= Focus Functions ========= //

    function SAddFocusValue(event) {

        let inputValue = Number(event.target.value.replace(/,/g, ''));

        event.target.removeAttribute('value');

        event.target.removeAttribute('type');

        event.target.setAttribute('type', 'number');

        event.target.setAttribute('value', inputValue);

        event.target.select();

    }

    function SAddSelectValue() {

        $(this).select();

    }

    $("#saleLaborCharges").on('focus', SAddSelectValue)

    $("#saleWeightCharges").on('focus', SAddSelectValue);

    $("#saleDeliveryCharges").on('focus', SAddSelectValue);

    $("#saleServiceCharges").on('focus', SAddSelectValue);


    // ========= End of Focus Functions ========= //

    // ========= Paid Check Functions ========= //

    function SPaidCheck(event) {

        if (event.target.checked) { 

            let date = new Date();

            let month = date.getMonth() + 1 < 10 ? "0" + (date.getMonth() + 1) : date.getMonth() + 1;

            let year = date.getFullYear();

            let day = date.getDate();

            document.getElementById("salePaidDate").value = year + "-" + month + "-" + day;

            document.getElementById("salePaidDate").removeAttribute("disabled");

        } else {

            document.getElementById("salePaidDate").value = "";

            document.getElementById("salePaidDate").setAttribute("disabled", "true");

        }

    }

    // ========= End of Paid Check Functions ========= //

</script>