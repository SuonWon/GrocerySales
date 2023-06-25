<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=2.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style media="print">
        
        .p-margin-left{
            margin-left: 800px;
        }

        .p-details-table table thead {
            color: black;
            font-size: 0.75rem;
        }

        .p-details-table table tbody {
            font-size: 0.7rem;
        }

    </style>
    
</head>
<body style="font-size: 0.85rem">
    <section class="w-100 bg-secondary">
        <div class="voucherSection mx-auto bg-light text-dark">
            <div id="buttons" class="text-end">
                <button class="btn btn-primary me-2" id="printPuVoucher"><i class="fa fa-print"></i></button>
                <a href="/purchaseinvoices/details/{{$purchaseinvoice->InvoiceNo}}" class="btn btn-danger" id="backButton"><i class="fa fa-xmark"></i></a>
            </div>
            <div class="w-100 text-center mb-3">
                
                <div class="col-6 lh-lg offset-3 fs-6">
                    @if ($companyinfo)
                        <span class="p-title">{{$companyinfo->CompanyName}}</span>
                        <span class="d-block">{{$companyinfo->Street}}</span>
                        <span class=""> <i class="fa-solid fa-phone"></i> {{$companyinfo->HotLineNo}} <i class="fa-solid fa-phone mx-1"></i>{{$companyinfo->OfficeNo}}</span>
                    @endif
                    
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
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
                <div class="col-6">
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
            <div class="row p-details-table">
                <table class="table table-boderless">
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
                            <th class="text-center">FOC</th>
                            <th class="text-end">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($purchaseinvoice->purchaseinvoicedetails as $key => $purchaseinvoicedetail)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$purchaseinvoicedetail->ItemName}}</td>
                                <td>{{$purchaseinvoicedetail->WarehouseName}}</td>
                                <td class="text-end">{{number_format($purchaseinvoicedetail->Quantity)}}</td>
                                <td class="text-center">{{$purchaseinvoicedetail->PackedUnit}}</td>
                                <td class="text-end">{{number_format($purchaseinvoicedetail->UnitPrice)}}</td>
                                <td class="text-end">{{$purchaseinvoicedetail->TotalViss}}</td>
                                <td class="text-end">{{number_format($purchaseinvoicedetail->Amount)}}</td>
                                <td class="text-end">{{$purchaseinvoicedetail->LineDisPer}}</td>
                                <td class="text-end">{{number_format($purchaseinvoicedetail->LineDisAmt)}}</td>
                                <td class="text-center">{{$purchaseinvoicedetail->IsFOC == 1 ? "FOC" : "" }}</td>
                                <td class="text-end">{{number_format($purchaseinvoicedetail->LineTotalAmt)}}</td>
                            </tr>
                        @empty
                            
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="row mt-2">
                <div class="col-8">
                    
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Labor Charges</p>
                        </div>
                        <div class="col-8 text-start px-1">
                            <p>: {{number_format($purchaseinvoice->LaborCharges)}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Delivery Charges</p>
                        </div>
                        <div class="col-8 text-start px-1">
                            <p>: {{number_format($purchaseinvoice->DeliveryCharges)}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Weight Charges</p>
                        </div>
                        <div class="col-8 text-start px-1">
                            <p>: {{number_format($purchaseinvoice->WeightCharges)}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Service Charges</p>
                        </div>
                        <div class="col-8 text-start px-1">
                            <p>: {{number_format($purchaseinvoice->ServiceCharges)}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col-6 text-end">
                            <p>Sub Total :</p>
                        </div>
                        <div class="col-6 text-end">
                            <p>{{number_format($purchaseinvoice->SubTotal)}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-end">
                            <p>Total Charges :</p>
                        </div>
                        <div class="col-6 text-end">
                            <p>{{number_format($purchaseinvoice->TotalCharges)}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-end">
                            <p>Grand Total :</p>
                        </div>
                        <div class="col-6 text-end">
                            <p>{{number_format($purchaseinvoice->GrandTotal)}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-bottom mx-auto text-end px-4 py-3" style="width: 934px;" id="newPuBtn">
            <a href="/purchaseinvoices/add" class="btn btn-primary" style="height: 40px; font-size: 1rem;"><span class="me-2"><i class="fa fa-plus"></i></span> New Purchase Invoice</a>
        </div>
        
        
    </section>
    <!-- Jquery CDN link -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>

    <!-- Bootstrap JS -->
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

    <script>

        $("#printPuVoucher").on("click", function(event) {

            $("#buttons").css("display", "none");

            $("#newPuBtn").css("display", "none");

            window.print();
                        
            $("#buttons").css("display", "");

            $("#newPuBtn").css("display", "");

        });

    </script>
</body>
</html>
