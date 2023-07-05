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

    <link rel="stylesheet" href="{{asset('assets/css/toastr.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
   
    @import url('https://fonts.googleapis.com/css2?family=Lora:wght@700&display=swap');

    .titleFont{
        font-family: 'Lora', serif;
    }

    .dataRow {
        width: 100%;
    }

    .dataRow :first-child{
        width: 40px;
    }

    .dataRow :nth-child(2){
        width: 250px;
    }

    .dataRow :nth-child(3){
        width: 80px;
    }

    .dataRow :nth-child(4){
        width: 90px;
    }

    .dataRow :nth-child(5){
        width: 100px;
    }

    .dataRow :nth-child(6){
        width: 120px;
    }

    .dataRow :nth-child(7){
        width: 110px;
    }

    .dataRow :nth-child(8){
        width: 170px;
    }

    </style>
    
</head>
<body>
    <section class="w-100 bg-secondary">
        <div class="voucherSection mx-auto bg-light text-dark">
            <div id="buttons" class="text-end">
                <button class="btn btn-primary me-2" id="printPuVoucher"><i class="fa fa-print"></i></button>
                <a href="/purchaseinvoices/edit/{{$purchaseinvoice->InvoiceNo}}" class="btn btn-danger" id="backButton"><i class="fa fa-xmark"></i></a>
            </div>
            <div class="w-100 text-center mb-3">
                <div class="col-6 lh-lg offset-3 fs-6">
                    @if ($companyinfo)
                        <span class="p-title">{{$companyinfo->CompanyName}}</span>
                        <span class="d-block mt-2">{{$companyinfo->Street}}</span>
                        <span class=""> <i class="fa-solid fa-phone"></i> {{$companyinfo->HotLineNo}} <i class="fa-solid fa-phone mx-1"></i>{{$companyinfo->OfficeNo}}</span>
                    @endif
                </div>
            </div>
            <div class="title mb-3">
                <div class="row">
                    <div class="col-8 d-flex flex-column">
                        <span class="mb-2">Invoice No &nbsp;&nbsp;: <span id="vInvoiceNo">{{$purchaseinvoice->InvoiceNo}}</span></span>
                        <span class="mb-2">Arrival Code : <span id="vArrivalCode">{{$purchaseinvoice->ArrivalCode}}</span></span>
                    </div>
                    <div class="col-4 d-flex flex-column px-4">
                        <span class="mb-2">Date <span class="ms-4">&nbsp; : <span id="vPurchaseDate"></span>{{$purchaseinvoice->PurchaseDate}}</span></span>
                        <span class="mb-2">Supplier 
                            <span class="ms-2"> : 
                                <span id="vSupplier">

                                    @forelse ($suppliers as $supplier)
                                        
                                        @if ($supplier->SupplierCode == $purchaseinvoice->SupplierCode)
                                            {{$supplier->SupplierName}}
                                        @endif

                                        @empty
                                                No Supplier Found
                                    @endforelse
                                </span> 
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="purchaseInvoiceTable pb-2 border-bottom border-black border-1">
                <table>
                    <thead>
                        <tr class="text-end border-top border-bottom border-black">
                            <th class="text-start">No.</th>
                            <th class="text-start">Name</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Viss</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Net Amount</th>
                        </tr>
                    </thead>
                    <tbody id="purchaseItemLists">
                        @foreach ( $purchaseinvoice->purchaseinvoicedetails  as $key => $purchaseinvoicedetail )
                            <tr class="dataRow text-end">
                                <td class="text-start">{{$key + 1}}</td>
                                <td class="text-start">{{$purchaseinvoicedetail->ItemName}}</td>
                                <td>{{$purchaseinvoicedetail->Quantity}}</td>
                                <td>{{$purchaseinvoicedetail->PackedUnit}}</td>
                                <td>{{$purchaseinvoicedetail->TotalViss}}</td>
                                <td>{{$purchaseinvoicedetail->UnitPrice}}</td>
                                <td>{{$purchaseinvoicedetail->LineDisAmt != 0 ? $purchaseinvoicedetail->LineDisAmt : ( $purchaseinvoicedetail->LineDisPer != 0 ? $purchaseinvoicedetail->LineDisPer . "%" : 0)}}</td>
                                <td>{{$purchaseinvoicedetail->IsFOC == 1 ? "FOC" : $purchaseinvoicedetail->LineTotalAmt}}</td>
                            </tr>                            
                        @endforeach
                        
                    </tbody>
                </table>
            </div>



            <!-- Charges And Amount Calculation Section -->
            <div class="chargesNetPrce mt-2 position-relative">
                <div class="row">
                    <!-- Left Amount Calculation -->
                    <div class="col-4 d-flex flex-column lh-lg">
                        <div class="row justify-content-between">
                            <div class="col-7 text-start pe-0">
                                Labour Charges :
                            </div>
                            <div class="col-3 text-end ps-0">
                                <span id="vLabourCharges"> {{$purchaseinvoice->LaborCharges}}</span>
                            </div>
                            <div class="col-2"></div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-7 text-start pe-0">
                                Weight Charges :
                            </div>
                            <div class="col-3 text-end ps-0">
                                <span id="vWeightCharges"> {{$purchaseinvoice->WeightCharges}}</span>
                            </div>
                            <div class="col-2"></div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-7 text-start pe-0">
                                Delivery Charges:
                            </div>
                            <div class="col-3 text-end ps-0">
                                <span id="vDeliveryCharges"> {{$purchaseinvoice->DeliveryCharges}}</span>
                            </div>
                            <div class="col-2"></div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-7 text-start pe-0">
                                Service Charges :
                            </div>
                            <div class="col-3 text-end ps-0">
                                <span id="vServiceCharges"> {{$purchaseinvoice->ServiceCharges}}</span>
                            </div>
                            <div class="col-2"></div>
                        </div>
                        <div class="border-bottom border-1 border-black col-10"></div>
                        <div class="row justify-content-between">
                            <div class="col-7 text-start pe-0">
                                Total Charges <span class="ms-3">:</span>
                            </div>
                            <div class="col-3 text-end ps-0">
                                <span id="vTotalChargesOne"> {{$purchaseinvoice->TotalCharges}}</span>
                            </div>
                            <div class="col-2"></div>
                        </div>
                    </div>

                    <!-- Right Amount Calculation -->
                    <div class="col-4 d-flex flex-column text-end offset-4 ps-0 lh-lg">
                        <div class="row justify-content-between">
                            <div class="col-6 offset-2 pe-0">
                                Subtotal :
                            </div>
                            <div class="col-4 text-end ps-0">
                                <span id="vSubTotal">{{$purchaseinvoice->SubTotal}}</span>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-6 offset-2 pe-0">
                                Total Charges :
                            </div>
                            <div class="col-4 text-end ps-0">
                                <span id="vTotalChargesTwo">{{$purchaseinvoice->TotalCharges}}</span>
                            </div>
                        </div>
                        <div class="border-bottom border-1 border-black col-9 offset-3"></div>
                        <div class="row justify-content-between">
                            <div class="col-6 offset-2 pe-0">
                                Grand Total :
                            </div>
                            <div class="col-4 text-end ps-0">
                                <span id="vGrandTotal">{{$purchaseinvoice->GrandTotal}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 offset-5">
                        <div class="row">
                            <div class="col-12 mb-0">
                                <h5>------------------</h5>
                            </div>
                            <div class="col-12">
                                <h5>Please sign here</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-bottom mx-auto text-end px-5 py-3" style="width: 934px;" id="newPuBtn">
            <a href="/purchaseinvoices/add" class="btn btn-primary" style="height: 40px; font-size: 1rem;"><span class="me-2"><i class="fa fa-plus"></i></span> New Purchase Invoice</a>
        </div>
        
        
    </section>
    <!-- Jquery CDN link -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>

    <!-- Bootstrap JS -->
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('assets/js/toastr.min.js')}}"></script>

    <script>

        $(document).ready(function (){

            toastr.options.timeOut = 5000;
            toastr.options.closeButton = true;
            toastr.options.positionClass = "toast-top-right";
            toastr.options.showMethod = "fadeIn";
            toastr.options.progressBar = true;
            toastr.options.hideMethod = "fadeOut";

            if (sessionStorage.getItem('save') == "success") {

                toastr.success('Save successful');

                sessionStorage.removeItem('save');
                
            } else if (sessionStorage.getItem('update') == "success") {

                toastr.success('Update successful');

                sessionStorage.removeItem('update');

            }

        });

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
