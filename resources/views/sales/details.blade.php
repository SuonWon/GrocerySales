<x-layout title="Purchase Invoice Details">

    <div class="container-fluid content-body mt-3">

    {{-- Section Title --}}
        
        <div class="row justify-content-between">
            {{-- Title --}}
            <div class="col-7 col-md-6 p-0">
                <h3 class="section-title">Sales Invoice Details</h3>
            </div>
            {{-- Button --}}
            <div class="col-5 col-xxl-3 p-0 text-end">
                <a href="/salesinvoices/detailspreview/{{$saleinvoice->InvoiceNo}}" class="btn btn-primary me-2">
                    <span class="me-1"><i class="fa fa-print"></i></span>Preview
                </a>
                <a href="/salesinvoices/index" class="btn main-btn">
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
                            <p>: {{$saleinvoice->InvoiceNo}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Sales Date </p>
                        </div>
                        <div class="col-8 text-start px-1">
                            <p>: {{$saleinvoice->SalesDate}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Customer Name </p>
                        </div>
                        <div class="col-8 text-start px-1">
                            @forelse ($customers as $customer)
                                @if ($customer->CustomerCode == $saleinvoice->CustomerCode)
                                    <p>: {{$customer->CustomerName}}</p>
                                @endif
                            @empty
                            @endforelse
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Plate No </p>
                        </div>
                        <div class="col-8 text-start px-1">
                            <p>: {{$saleinvoice->PlateNo}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Remark </p>
                        </div>
                        <div class="col-8 text-start px-1">
                            <p>: {{$saleinvoice->Remark}}</p>
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
                            <p>: {{$saleinvoice->PaidDate}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Paid Status </p>
                        </div>
                        <div class="col-8 text-start px-1">
                            
                            <p>: {{ $saleinvoice->IsPaid == 1? "Paid" : "Unpaid"}}</p>
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
                            <p>{{number_format($saleinvoice->ShippingCharges)}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-5 text-end">
                            <p>ကမ်းတတ်အလုပ်သမားခ :</p>
                        </div>
                        <div class="col-5 text-end">
                            <p>{{number_format($saleinvoice->LaborCharges)}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-5 text-end">
                            <p>ကမ်းတတ်ကားခ :</p>
                        </div>
                        <div class="col-5 text-end">
                            <p>{{number_format($saleinvoice->DeliveryCharges)}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-5 text-end">
                            <p>ပွဲရုံအလုပ်သမားခ :</p>
                        </div>
                        <div class="col-5 text-end">
                            <p>{{number_format($saleinvoice->WeightCharges)}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-5 text-end">
                            <p>အကျိုးဆောင်ခ :</p>
                        </div>
                        <div class="col-5 text-end">
                            <p>{{number_format($saleinvoice->ServiceCharges)}}</p>
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
                                    <p>: {{$saleinvoice->CreatedDate}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4 text-start">
                                    <p>Created By </p>
                                </div>
                                <div class="col-8 text-start px-1">
                                    
                                    <p>: {{$saleinvoice->CreatedBy}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4 text-start">
                                    <p>Modified Date </p>
                                </div>
                                <div class="col-8 text-start px-1">
                                    
                                    <p>: {{$saleinvoice->ModifiedDate}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4 text-start">
                                    <p>Modified By </p>
                                </div>
                                <div class="col-8 text-start px-1">
                                    
                                    <p>: {{$saleinvoice->ModifiedBy}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4 text-start">
                                    <p>Deleted Date </p>
                                </div>
                                <div class="col-8 text-start px-1">
                                    
                                    <p>: {{$saleinvoice->DeletedDate}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4 text-start">
                                    <p>Deleted By </p>
                                </div>
                                <div class="col-8 text-start px-1">
                                    
                                    <p>: {{$saleinvoice->DeletedBy}}</p>
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
                            <th class="text-end">Quantity</th>
                            <th class="text-center">Unit</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Total Viss</th>
                            <th class="text-end">Amount</th>
                            <th class="text-end">Discount(%)</th>
                            <th class="text-end">Discount</th>
                            <th class="text-end">Total Amount</th>
                            <th class="text-center">FOC</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($saleinvoice->saleinvoicedetails as $key => $saleinvoicedetail)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$saleinvoicedetail->ItemName}}</td>
                                <td>{{$saleinvoicedetail->WarehouseName}}</td>
                                <td class="text-end">{{$saleinvoicedetail->Quantity}}</td>
                                <td class="text-center">{{$saleinvoicedetail->PackedUnit}}</td>
                                <td class="text-end">{{$saleinvoicedetail->UnitPrice}}</td>
                                <td class="text-end">{{$saleinvoicedetail->TotalViss}}</td>
                                <td class="text-end">{{$saleinvoicedetail->Amount}}</td>
                                <td class="text-end">{{$saleinvoicedetail->LineDisPer}}</td>
                                <td class="text-end">{{$saleinvoicedetail->LineDisAmt}}</td>
                                <td class="text-end">{{$saleinvoicedetail->LineTotalAmt}}</td>
                                <td class="text-center">{{$saleinvoicedetail->IsFoc == 1 ? "FOC" : "" }}</td>
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
                                <p>{{$saleinvoice->SubTotal}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-end">
                                <p>Total Charges :</p>
                            </div>
                            <div class="col-6 text-end">
                                <p>{{$saleinvoice->TotalCharges}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-end">
                                <p>Grand Total :</p>
                            </div>
                            <div class="col-6 text-end">
                                <p>{{$saleinvoice->GrandTotal}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-layout>