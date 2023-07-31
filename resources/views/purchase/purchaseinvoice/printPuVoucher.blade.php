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
        width: 30px;
    }

    .dataRow :nth-child(2){
        width: 210px;
    }

    .dataRow :nth-child(3){
        width: 121px;
    }

    .dataRow :nth-child(4){
        width: 105px;
    }

    .dataRow :nth-child(5){
        width: 101px;
    }

    .dataRow :nth-child(6){
        width: 101px;
    }

    </style>

</head>
<body>
    @php
        $purchaseProductDataList = [];
    @endphp
    @foreach ($purchaseinvoice->purchaseinvoicedetails as $key => $purchaseinvoicedetail)
        @php
            $purchaseProductDataList[] = [
                'LineNo' => $key + 1,
                'ItemCode' => $purchaseinvoicedetail->ItemCode,
                'ItemName' => $purchaseinvoicedetail->ItemName,
                'WeightPrice' => $purchaseinvoicedetail->WeightByPrice,
                'Quantity' => $purchaseinvoicedetail->Quantity,
                'PackedUnit' => $purchaseinvoicedetail->PackedUnit,
                'UnitName' => $purchaseinvoicedetail->UnitDesc,
                'TotalViss' => $purchaseinvoicedetail->TotalViss,
                'UnitPrice' => $purchaseinvoicedetail->UnitPrice,
                'Amount' => $purchaseinvoicedetail->Amount,
                'LineDisPer' => $purchaseinvoicedetail->LineDisPer,
                'LineDisAmt' => $purchaseinvoicedetail->LineDisAmt,
                'LineTotalAmt' => $purchaseinvoicedetail->LineTotalAmt,
                'IsFOC' => $purchaseinvoicedetail->IsFOC,
                'LineTotal' => $purchaseinvoicedetail->IsFOC == 1 ? "FOC" : $purchaseinvoicedetail->LineTotalAmt, 
            ];
        @endphp
    @endforeach
    <section class="bg-secondary">
        <div class="voucherSection mx-auto bg-light text-dark">
            <div id="buttons" class="text-end">
                <button class="btn btn-primary me-2" id="printPuVoucher"><i class="fa fa-print"></i></button>
                <a href="/purchaseinvoices/index" class="btn btn-danger" id="backButton"><i class="fa fa-xmark"></i></a>
            </div>
            <div class="w-100 text-center mb-2">
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
            <div class="title">
                <div class="row">
                    <div class="col-7 d-flex flex-column">
                        <div class="mb-2 default_fs row">
                            <span class="col-4 pe-0">ဘောင်ချာနံပါတ်</span>
                            <span class="col-5" id="vInvoiceNo">: {{$purchaseinvoice->InvoiceNo}}</span>
                        </div>
                        <div class="mb-2 default_fs row">
                            <span class="col-4 pe-0">ယာဉ်အမှတ်</span>
                            <span class="col-5" id="vArrivalCode"> :
                                @foreach ($arrivals as $arrival)

                                    @if ($arrival->ArrivalCode == $purchaseinvoice->ArrivalCode)
                                        {{$arrival->PlateNo}}
                                    @endif
                                    
                                @endforeach
                            </span>
                        </div>
                        <div class="mb-2 default_fs row">
                            <span class="col-4 pe-0">အိတ်အရေအတွက်</span>
                            <span class="col-5" id="pVtotalBags"></span>
                        </div>
                    </div>
                    <div class="col-5 d-flex flex-column px-4">
                        <div class="mb-2 default_fs row">
                            <span class="col-4 pe-0">နေ့စွဲ</span>
                            <span class="col-8" id="vPurchaseDate">: {{$purchaseinvoice->PurchaseDate}}</span>
                        </div>
                        <div class="mb-2 default_fs row">
                            <span class="col-4 pe-0">ကုန်သည်</span>
                            <span class="col-8" id="vSupplier">: 
                                @forelse ($suppliers as $supplier)

                                    @if ($supplier->SupplierCode == $purchaseinvoice->SupplierCode)
                                        {{$supplier->SupplierName}}
                                    @endif

                                    @empty
                                            No Supplier Found
                                @endforelse
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="purchaseInvoiceTable py-2 border-bottom border-black border-1">
                <table>
                    <thead>
                        <tr class="text-end border-top border-bottom border-black custom-header-h mf-header">
                            <th class="text-start py-1">No.</th>
                            <th class="text-start">အမျိုးအမည်</th>
                            <th>အရေအတွက်</th>
                            <th>ပိဿာ</th>
                            <th>ဈေးနှုန်း</th>
                            <th>သင့်ငွေ</th>
                        </tr>
                    </thead>
                    <tbody id="purchaseItemLists">
                        {{-- @foreach ( $purchaseinvoice->purchaseinvoicedetails  as $key => $purchaseinvoicedetail )
                            <tr class="dataRow text-end mt-4">
                                <td class="text-start">{{$key + 1}}</td>
                                <td class="text-start">{{$purchaseinvoicedetail->ItemName}}</td>
                                <td>{{number_format($purchaseinvoicedetail->Quantity)}} {{$purchaseinvoicedetail->UnitDesc}}</td>
                                <td>{{$purchaseinvoicedetail->TotalViss}}</td>
                                <td>{{number_format($purchaseinvoicedetail->UnitPrice)}}</td>
                                <td>{{$purchaseinvoicedetail->IsFOC == 1 ? "FOC" : number_format($purchaseinvoicedetail->LineTotalAmt)}}</td>
                            </tr>
                        @endforeach --}}

                    </tbody>
                </table>
            </div>

            <!-- Charges And Amount Calculation Section -->
            <div class="chargesNetPrce mt-2 position-relative">
                <div class="row">
                    <!-- Left Amount Calculation -->
                    <div class="col-5 d-flex flex-column lh-md mf-normal">
                        <div class="row justify-content-between p-0 m-0">
                            <div class="col-8 text-start p-0 m-0">
                                <span>တန်ဆာခ</span>
                            </div>
                            <div class="col-4 p-0 d-flex justify-content-between">
                                <span>:</span><span id="pVShippingCharges"></span>
                            </div>
                        </div>
                        <div class="row justify-content-between p-0 m-0">
                            <div class="col-8 text-start p-0 m-0">
                                <span>ဝန်ဆောင်ခ</span>
                            </div>
                            <div class="col-4 p-0 d-flex justify-content-between">
                                <span>:</span><span id="pVServiceCharges"></span>
                            </div>
                        </div>
                        <div class="row justify-content-between p-0 m-0">
                            <div class="col-8 text-start p-0 m-0">
                                <span>စက်ကြိတ်ခ</span>
                            </div>
                            <div class="col-4 p-0 d-flex justify-content-between">
                                <span>:</span><span id="pVFactoryCharges"> </span>
                            </div>
                        </div>
                        <div class="border-bottom border-1 border-dark my-1 col-12"></div>
                        <div class="row justify-content-between m-0 p-0">
                            <div class="col-8 text-start p-0 m-0">
                                <span class="p-0 m-0 default_fs">စုစုပေါင်းအသုံးစရိတ်</span>
                            </div>
                            <div class="col-4 p-0 d-flex justify-content-between">
                                <span>:</span><span id="pVTotalChargesOne"> {{number_format($purchaseinvoice->TotalCharges)}}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Amount Calculation -->
                    <div class="col-5 d-flex flex-column text-end offset-2 ps-0 lh-md mf-normal">
                        <div class="row justify-content-between">
                            <div class="col-7 offset-1 pe-0">
                               <span> စုစုပေါင်း :</span>
                            </div>
                            <div class="col-4 text-end ps-0">
                                <span id="pVSubTotal"></span>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-7 offset-1 pe-0 default_fs">
                                စုစုပေါင်းအသုံးစရိတ် :
                            </div>
                            <div class="col-4 text-end ps-0">
                                <span id="pVTotalChargesTwo">{{number_format($purchaseinvoice->TotalCharges)}}</span>
                            </div>
                        </div>
                        <div class="border-bottom border-1 border-dark my-1 col-10 offset-2"></div>
                        <div class="row justify-content-between">
                            <div class="col-7 offset-1 pe-0 default_fs">
                                အသားတင်စုစုပေါင်း :
                            </div>
                            <div class="col-4 text-end ps-0">
                                <span id="pVGrandTotal">{{number_format($purchaseinvoice->GrandTotal)}}</span>
                            </div>
                        </div>
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
                <div class="row default_fs text-end fixed-bottom px-3">
                    <span id="printDate"></span>
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

    {{-- Myanmar Number CDN Link --}}
    <script src="https://unpkg.com/myanmar-num-to-word@latest"></script>

    <script>

        $(document).ready(function (){

            let purchaseDataList = @json($purchaseProductDataList);

            let purchaseList = ``;

            document.getElementById("pVtotalBags").innerHTML = ": "+myanmarNumToWord.convertToBurmeseNumber(Number({{$totalBags}})) +" အိတ်";

            document.getElementById("pVShippingCharges").innerHTML = myanmarNumToWord.convertToBurmeseNumber(Number({{$purchaseinvoice->ShippingCharges}}));

            document.getElementById("pVServiceCharges").innerHTML = myanmarNumToWord.convertToBurmeseNumber(Number({{$purchaseinvoice->ServiceCharges + $purchaseinvoice->WeightCharges + $purchaseinvoice->LaborCharges + $purchaseinvoice->DeliveryCharges}}));

            document.getElementById("pVFactoryCharges").innerHTML = myanmarNumToWord.convertToBurmeseNumber(Number({{$purchaseinvoice->FactoryCharges}}));

            document.getElementById("pVTotalChargesOne").innerHTML = myanmarNumToWord.convertToBurmeseNumber(Number({{$purchaseinvoice->TotalCharges}}));

            document.getElementById("pVSubTotal").innerHTML = myanmarNumToWord.convertToBurmeseNumber(Number({{$purchaseinvoice->SubTotal}}));

            document.getElementById("pVTotalChargesTwo").innerHTML = myanmarNumToWord.convertToBurmeseNumber(Number({{$purchaseinvoice->TotalCharges}}));

            document.getElementById("pVGrandTotal").innerHTML = myanmarNumToWord.convertToBurmeseNumber(Number({{$purchaseinvoice->GrandTotal}}));

            purchaseDataList.forEach((e) => {
                console.log(e.ItemName);

                purchaseList += `<tr class="dataRow text-end mt-4 mf-normal">
                                <td class="text-start">`+ e.LineNo +`</td>
                                <td class="text-start">`+ e.ItemName +`</td>
                                <td>`+ myanmarNumToWord.convertToBurmeseNumber(Number(e.Quantity)) + " " + e.UnitName +`</td>
                                <td>`+  myanmarNumToWord.convertToBurmeseNumber(e.TotalViss) +`</td>
                                <td>`+  myanmarNumToWord.convertToBurmeseNumber(Number(e.UnitPrice)) +`</td>
                                <td>`+  myanmarNumToWord.convertToBurmeseNumber(Number(e.LineTotal)) +`</td>
                            </tr>`;
            });

            document.getElementById("purchaseItemLists").innerHTML = purchaseList;

            toastr.options.timeOut = 500;
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

            let date = new Date();

            let month = date.getMonth() + 1 < 10 ? "0" + (date.getMonth() + 1) : date.getMonth() + 1;

            let year = date.getFullYear();

            let day = date.getDate() < 10 ? "0" + (date.getDate()) : date.getDate();

            let hour = date.getHours();

            let minute = date.getMinutes();

            document.getElementById("printDate").innerHTML = day + "-" + month + "-" + year + " " + hour + ":" + minute;

            window.print();

            $("#buttons").css("display", "");

            $("#newPuBtn").css("display", "");

            document.getElementById("printDate").innerHTML = "";

        });



    </script>
</body>
</html>
