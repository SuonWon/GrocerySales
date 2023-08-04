<x-layout title="Purchase Invoice Details">

    <div class="container-fluid content-body mt-3">

    {{-- Section Title --}}
        
        <div class="row justify-content-between">
            {{-- Title --}}
            <div class="col-7 col-md-6 p-0">
                <h3 class="section-title">Purchase Invoice Details</h3>
            </div>
            {{-- Button --}}
            <div class="col-5 col-xxl-2 p-0 text-end">
                <a href="/purchaseinvoices/pudetailspreview/{{$purchaseinvoice->InvoiceNo}}" class="btn btn-primary me-2">
                    <span class="me-1"><i class="fa fa-print"></i></span>Preview
                </a>
                <a href="/purchaseinvoices/index" class="btn main-btn">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

        <div class="row details-box mt-2" id="printArea">
            <div class="col-xxl-4 px-1 mt-2">
                <div class="info-box">
                    <p class="content-title"><span>Basic Info</span></p>
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Invoice No </p>
                        </div>
                        <div class="col-8 text-start px-1">
                            <p>: {{$purchaseinvoice->InvoiceNo}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Purchase Date </p>
                        </div>
                        <div class="col-8 text-start px-1">
                            <p>: {{$purchaseinvoice->PurchaseDate}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Supplier Name </p>
                        </div>
                        <div class="col-8 text-start px-1">
                            @forelse ($suppliers as $supplier)
                                @if ($supplier->SupplierCode == $purchaseinvoice->SupplierCode)
                                    <p>: {{$supplier->SupplierName}}</p>
                                @endif
                            @empty
                            @endforelse
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Arrival Code </p>
                        </div>
                        <div class="col-8 text-start px-1">
                            <p>: {{$purchaseinvoice->ArrivalCode}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Remark </p>
                        </div>
                        <div class="col-8 text-start px-1">
                            <p>: {{$purchaseinvoice->Remark}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 px-1 mt-2">
                <div class="info-box">
                    <p class="content-title"><span>Payment Info</span></p>
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Paid Date </p>
                        </div>
                        <div class="col-8 text-start px-1">
                            <p>: {{$purchaseinvoice->PaidDate}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Paid Status </p>
                        </div>
                        <div class="col-8 text-start px-1">
                            
                            <p>: {{ $purchaseinvoice->IsPaid == 1? "Paid" : "Unpaid"}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 px-1 mt-2">
                <div class="info-box">
                    <p class="content-title"><span>Charges Info</span></p>
                    <div class="row px-2">
                        <div class="col-5 text-end">
                            <p>တန်ဆာခ :</p>
                        </div>
                        <div class="col-5 text-end">
                            <p>{{number_format($purchaseinvoice->ShippingCharges)}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-5 text-end">
                            <p>ကမ်းတတ်အလုပ်သမားခ :</p>
                        </div>
                        <div class="col-5 text-end">
                            <p>{{number_format($purchaseinvoice->LaborCharges)}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-5 text-end">
                            <p>ကမ်းတတ်ကားခ :</p>
                        </div>
                        <div class="col-5 text-end">
                            <p>{{number_format($purchaseinvoice->DeliveryCharges)}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-5 text-end">
                            <p>ပွဲရုံအလုပ်သမားခ :</p>
                        </div>
                        <div class="col-5 text-end">
                            <p>{{number_format($purchaseinvoice->WeightCharges)}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-5 text-end">
                            <p>အကျိုးဆောင်ခ :</p>
                        </div>
                        <div class="col-5 text-end">
                            <p>{{number_format($purchaseinvoice->ServiceCharges)}}</p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-xxl-8 px-1 mt-2">
                <div class="info-box">
                    <p class="content-title"><span>Other Info</span></p>
                    <div class="row px-2">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4 text-start">
                                    <p>Created Date </p>
                                </div>
                                <div class="col-8 text-start px-1">
                                    <p>: {{$purchaseinvoice->CreatedDate}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4 text-start">
                                    <p>Created By </p>
                                </div>
                                <div class="col-8 text-start px-1">
                                    
                                    <p>: {{$purchaseinvoice->CreatedBy}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4 text-start">
                                    <p>Modified Date </p>
                                </div>
                                <div class="col-8 text-start px-1">
                                    
                                    <p>: {{$purchaseinvoice->ModifiedDate}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4 text-start">
                                    <p>Modified By </p>
                                </div>
                                <div class="col-8 text-start px-1">
                                    
                                    <p>: {{$purchaseinvoice->ModifiedBy}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4 text-start">
                                    <p>Deleted Date </p>
                                </div>
                                <div class="col-8 text-start px-1">
                                    
                                    <p>: {{$purchaseinvoice->DeletedDate}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4 text-start">
                                    <p>Deleted By </p>
                                </div>
                                <div class="col-8 text-start px-1">
                                    
                                    <p>: {{$purchaseinvoice->DeletedBy}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="col-12 mt-2 details-table">
                <table class="table table-striped table-boderless">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Item Code</th>
                            <th>Warehouse Code</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">NQty</th>
                            <th class="text-center">Unit</th>
                            <th class="text-end">QPU</th>
                            <th class="text-end">ExViss</th>
                            <th class="text-end">Total Viss</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Amount</th>
                            <th class="text-end">Discount(%)</th>
                            <th class="text-end">Discount</th>
                            <th class="text-end">Total Amount</th>
                            <th class="text-center">FOC</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($purchaseinvoice->purchaseinvoicedetails as $key => $purchaseinvoicedetail)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$purchaseinvoicedetail->ItemName}}</td>
                                <td>{{$purchaseinvoicedetail->WarehouseName}}</td>
                                <td class="text-end">{{$purchaseinvoicedetail->Quantity}}</td>
                                <td class="text-end">{{$purchaseinvoicedetail->NewQuantity}}</td>
                                <td class="text-center">{{$purchaseinvoicedetail->UnitDesc}}</td>
                                <td class="text-end">{{$purchaseinvoicedetail->QtyPerUnit}}</td>
                                <td class="text-end">{{$purchaseinvoicedetail->ExtraViss}}</td>
                                <td class="text-end">{{$purchaseinvoicedetail->TotalViss}}</td>
                                <td class="text-end">{{$purchaseinvoicedetail->UnitPrice}}</td>
                                <td class="text-end">{{$purchaseinvoicedetail->Amount}}</td>
                                <td class="text-end">{{$purchaseinvoicedetail->LineDisPer}}</td>
                                <td class="text-end">{{$purchaseinvoicedetail->LineDisAmt}}</td>
                                <td class="text-end">{{$purchaseinvoicedetail->LineTotalAmt}}</td>
                                <td class="text-center">{{$purchaseinvoicedetail->IsFoc == 1 ? "FOC" : "" }}</td>
                            </tr>
                        @empty
                            
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-12 mt-2">
                <div class="row justify-content-end">
                    <div class="col-xxl-4">
                        <div class="row">
                            <div class="col-6 text-end">
                                <p>Sub Total :</p>
                            </div>
                            <div class="col-6 text-end">
                                <p>{{$purchaseinvoice->SubTotal}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-end">
                                <p>Total Charges :</p>
                            </div>
                            <div class="col-6 text-end">
                                <p>{{$purchaseinvoice->TotalCharges}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-end">
                                <p>Grand Total :</p>
                            </div>
                            <div class="col-6 text-end">
                                <p>{{$purchaseinvoice->GrandTotal}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-layout>