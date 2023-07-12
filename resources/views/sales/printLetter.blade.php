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
        width: 65px;
    }

    .dataRow :nth-child(2){
        width: 300px;
    }

    .dataRow :nth-child(3){
        width: 151px;
    }

    .dataRow :nth-child(4){
        width: 151px;
    }


    </style>

</head>
<body>
    <section class="bg-secondary">
        <div class="voucherSection mx-auto bg-light text-dark">
            <div id="buttons" class="text-end">
                <button class="btn btn-primary me-2" id="printPuVoucher"><i class="fa fa-print"></i></button>
                <a href="/salesinvoices/index/" class="btn btn-danger" id="backButton"><i class="fa fa-xmark"></i></a>
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
            <div class="title mb-1">
                <div class="row">
                    <div class="col-7 d-flex flex-column">
                        <span class="mb-2 default_fs">ဘောင်ချာနံပါတ်: <span id="vInvoiceNo">{{$saleinvoice->InvoiceNo}}</span></span>
                        <span class="mb-2 default_fs">ယာဉ်အမှတ်<span class="ms-3">&nbsp;: </span><span id="vArrivalCode">{{$saleinvoice->PlateNo}}</span></span>
                    </div>
                    <div class="col-5 d-flex flex-column px-4">
                        <span class="mb-2 default_fs">နေ့စွဲ <span class="ms-4">&nbsp;&nbsp;: <span id="vPurchaseDate"></span>{{$saleinvoice->SalesDate}}</span></span>
                        <span class="mb-2 default_fs">ဖောက်သည်
                            <span>:
                                <span id="vSupplier">

                                    @forelse ($customers as $customer)

                                        @if ($customer->CustomerCode == $saleinvoice->CustomerCode)
                                            {{$customer->CustomerName}}
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
            <div class="purchaseInvoiceTable py-2 border-bottom border-black border-1">
                <table>
                    <thead>
                        <tr class="text-end border-top border-bottom border-black custom-header-h">
                            <th class="text-start">စဉ်</th>
                            <th class="text-start">အမျိုးအမည်</th>
                            <th>အရေအတွက်</th>
                            <th>ပိဿာ</th>
                        </tr>
                    </thead>
                    <tbody id="purchaseItemLists">
                        @foreach ( $saleinvoice->saleinvoicedetails  as $key => $saleinvoicedetails )
                            <tr class="dataRow text-end mt-4">
                                <td class="text-start">{{$key + 1}}</td>
                                <td class="text-start">{{$saleinvoicedetails->ItemName}}</td>
                                <td>{{number_format($saleinvoicedetails->Quantity)}} {{$saleinvoicedetails->PackedUnit}}</td>
                                <td>{{$saleinvoicedetails->TotalViss}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row my-2">
                <div class="col-1 default_fs fw-bold">
                    <span>မှတ်ချက်: </span>
                </div>
                <div class="col-11 ps-4 default_fs">
                    <span>ဒါကတော့မှတ်ချက်ဖြစ်ပါသည်....</span>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-4 offset-4">
                    <div class="row">
                        <div class="col-12 mb-0">
                            <h5>-----------------------------</h5>
                        </div>
                        <div class="col-12">
                            <h5 class="fs-6">ကြီးပွားတိုးတက်ကြပါစေ။</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-bottom mx-auto text-end px-5 py-3" style="width: 934px;" id="newPuBtn">
            <a href="/salesinvoices/add" class="btn btn-primary" style="height: 40px; font-size: 1rem;"><span class="me-2"><i class="fa fa-plus"></i></span> New Purchase Invoice</a>
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
