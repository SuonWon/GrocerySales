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
        <div class="landscapeReport mx-auto bg-light text-dark">
            <div id="buttons" class="text-end">
                <button class="btn btn-primary me-2" id="printPuVoucher"><i class="fa fa-print"></i></button>
                <a href="/salesinvoices/details/{{$saleinvoice->InvoiceNo}}" class="btn btn-danger" id="backButton"><i class="fa fa-xmark"></i></a>
            </div>
            <div class="w-100 text-center mb-3">
                <div class="col-12 lh-lg fs-6">
                    <div>
                        <h5 class="mb-2 title_fs ">ဦးသာဆင့် + ဒေါ်တင်ကြည်</h5>
                        <h5 class="title_fs mb-0">( သ္မီး )ကိုစန်းဝေ + မမြင့်မြင့်ထွေး</h5>
                    </div>
                    @if ($companyinfo)
                        <span class="p-title fs-2 fw-bold">{{$companyinfo->CompanyName}}</span>
                        <div>
                            <span>{{$companyinfo->Street}}</span>၊<span> {{$companyinfo->City}}။</span>
                        </div>
                        <div class="row">
                            <span class="col-8 offset-2"><i class="fa-solid fa-phone"></i> {{$companyinfo->HotLineNo}}, {{$companyinfo->OfficeNo}}</span>
                        </div>
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
                <div class="col-6">
                    <div class="row px-2">
                        <div class="col-4 text-end">
                            <p>Paid Date </p>
                        </div>
                        <div class="col-8 text-start px-1">
                            <p>: {{$saleinvoice->PaidDate}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-4 text-end">
                            <p>Paid Status </p>
                        </div>
                        <div class="col-8 text-start px-1">
                            <p>: {{ $saleinvoice->IsPaid == 1? "Paid" : "Unpaid"}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row p-details-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Item Code</th>
                            <th>Warehouse Code</th>
                            <th class="text-end">Quantity</th>
                            <th class="text-center">Unit</th>
                            <th class="text-end">QPU</th>
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
                        @forelse ($saleinvoice->saleinvoicedetails as $key => $saleinvoicedetail)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$saleinvoicedetail->ItemName}}</td>
                                <td>{{$saleinvoicedetail->WarehouseName}}</td>
                                <td class="text-end">{{number_format($saleinvoicedetail->Quantity)}}</td>
                                <td class="text-center">{{$saleinvoicedetail->UnitDesc}}</td>
                                <td class="text-end">{{$saleinvoicedetail->QtyPerUnit}}</td>
                                <td class="text-end">{{$saleinvoicedetail->TotalViss}}</td>
                                <td class="text-end">{{number_format($saleinvoicedetail->UnitPrice)}}</td>
                                <td class="text-end">{{number_format($saleinvoicedetail->Amount)}}</td>
                                <td class="text-end">{{$saleinvoicedetail->LineDisPer}}</td>
                                <td class="text-end">{{number_format($saleinvoicedetail->LineDisAmt)}}</td>
                                <td class="text-end">{{number_format($saleinvoicedetail->LineTotalAmt)}}</td>
                                <td class="text-center">{{$saleinvoicedetail->IsFOC == 1 ? "FOC" : "" }}</td>
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
                            <p>: {{number_format($saleinvoice->LaborCharges)}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Delivery Charges</p>
                        </div>
                        <div class="col-8 text-start px-1">
                            <p>: {{number_format($saleinvoice->DeliveryCharges)}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Weight Charges</p>
                        </div>
                        <div class="col-8 text-start px-1">
                            <p>: {{number_format($saleinvoice->WeightCharges)}}</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-4 text-start">
                            <p>Service Charges</p>
                        </div>
                        <div class="col-8 text-start px-1">
                            <p>: {{number_format($saleinvoice->ServiceCharges)}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col-6 text-end">
                            <p>Sub Total :</p>
                        </div>
                        <div class="col-6 text-end">
                            <p>{{number_format($saleinvoice->SubTotal)}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-end">
                            <p>Total Charges :</p>
                        </div>
                        <div class="col-6 text-end">
                            <p>{{number_format($saleinvoice->TotalCharges)}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-end">
                            <p>Grand Total :</p>
                        </div>
                        <div class="col-6 text-end">
                            <p>{{number_format($saleinvoice->GrandTotal)}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-bottom mx-auto text-end px-4 py-3" style="width: 934px;" id="newPuBtn">
            <a href="/salesinvoices/add" class="btn btn-primary" style="height: 40px; font-size: 1rem;"><span class="me-2"><i class="fa fa-plus"></i></span> New Sale Invoice</a>
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
