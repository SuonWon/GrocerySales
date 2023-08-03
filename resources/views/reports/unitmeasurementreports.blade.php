<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=2.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UOM Report</title>
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
        <div class="reportSection mx-auto bg-light text-dark">
            <div id="buttons" class="text-end">
                <button class="btn btn-primary me-2" id="printPuVoucher"><i class="fa fa-print"></i></button>
                <a href="/report/index" class="btn btn-danger" id="backButton"><i class="fa fa-xmark"></i></a>
            </div>
            <div class="w-100 text-center mb-3">
                <div>
                    <h5 class="mb-2 title_fs ">ဦးသာဆင့် + ဒေါ်တင်ကြည်</h5>
                    <h5 class="title_fs mb-0">( သ္မီး )ကိုစန်းဝေ + မမြင့်မြင့်ထွေး</h5>
                </div>
                <div class="col-6 lh-lg offset-3 fs-6">
                    @if ($companyinfo)
                        <span class="p-title">{{$companyinfo->CompanyName}}</span>
                        <span class="d-block">{{$companyinfo->Street}}၊ {{$companyinfo->City}}</span>
                        <span class=""> <i class="fa-solid fa-phone"></i> {{$companyinfo->HotLineNo}}, {{$companyinfo->OfficeNo}}</span>
                    @endif
                </div>
            </div>
            <div class="row p-details-table">
                <table class="table table-boderless">
                    <thead>
                        <tr>
                            <th style="width: 150px;">Code</th>
                            <th style="width: 400px;">Name</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($units as $unit)
                            <tr>
                            <td>{{$unit->UnitCode}}</td>
                            <td>{{$unit->UnitDesc}}</td>
                            <td>{{$unit->Remark}}</td>
                        </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
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
