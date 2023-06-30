<x-layout title="dashboard">

    <style>

        :root{
            --orange-100:  #FFF5C5;
            --orange-500: #FFA500;
            --green-100:  #c9ffc4;
            --green-500: #00b809;
            --realGreen-100: #d0fbe5;
            --green-600: #046c4e;
            --blue-100: #e4e9ff;
            --blue-500: #3b44ff;
            --purple-100: #FFE1FE;
            --purple-500:  #ff16f4;
            --red-100: #fff0f0;
            --red-500: #B10303;
            --orange-shadow: #481a00;
            --green-shadow: #003406;
            --blue-shadow: #000577;
            --purple-shadow: #620063;
            --red-shadow: #920a0a;
        }

        .creditColor {
            color: var(--orange-500);
            background-color: var(--orange-100);
        }

        .debitColor {
            color:var(--green-600);
            background-color: var(--realGreen-100);
        }

        .cardSection{
            display: flex;
            flex-direction: row;
            align-items: center;
            box-sizing: border-box;
        }

        .dashboardCard{
            height: 150px;
            padding: 10px;
            background-color: white;
            border-radius: 5px;
        }

        .dashboardCard-body{
            display: flex;
            flex-direction: row;
            justify-content: start;
            align-items: center;
        }

        .cardImg{
            width: 70px;
            height: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .firstCardColor {
            color: var(--red-500);
            background-color: var(--red-100);
            box-shadow: 0 0.1px 0.1px var(--red-shadow);
        }

        .secondCardColor {
            color: var(--orange-500);
            background-color: var(--orange-100);
            box-shadow: 0 0.1px 0.1px var(--orange-shadow);
        }

        .thirdCardColor {
            color: var(--green-500);
            background-color: var(--green-100);
            box-shadow: 0 0.1px 0.1px var(--green-shadow);
        }

        .fourthCardColor {
            color: var(--blue-500);
            background-color: var(--blue-100);
            box-shadow: 0 0.1px 0.1px var(--blue-shadow);
        }

        .fivethCardColor {
            color: var(--purple-500);
            background-color: var(--purple-100);
            box-shadow: 0 0.1px 0.1px var(--purple-shadow);
        }

        .cardContent{
            display: flex;
            flex-direction: column;
            width: 200px;
        }

        .dashBoardMainTitle {
            width: 100%;
            height: 50px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: start;
            font-size: 30px;
            font-weight: bold;
        }

        .dashboardTitle{
            width: 100%;
            height: 50px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: start;
            background-color: #fff;
            font-size: 20px;
            color: #36616D;
        }

        .forCredit{
            background: var(--red-100);
            color: var(--red-500);
        }

        .dashboardTbHeight{
            height: 500px;
        }

    </style>

    <div class="container-fluid mt-3">

        {{-- Cards Section  --}}
        <div class="cardSection row px-1">

            {{-- Total Sale Invoice & Total Sale Amount --}}
            <div class=" col-12 col-md-6 col-lg-4 col-xxl-3 p-2">
                <div class="dashboardCard firstCardShadow shadow-sm">
                    <div class="dashboardCard-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="cardImg rounded firstCardColor">
                                <i class="fa-solid fa-money-bill-1-wave fa-xl"></i>
                            </div>
                        </div>
                        <div class="cardContent mx-2 text-end">
                            <span class="text-muted fs-6">Sale Invoice</span>
                            <span class="fs-5 fw-bold mb-2">{{ $totalsaleinvoice }}</span>
                            <span class="text-muted fs-6">Sale Amount</span>
                            <span class="fs-5 fw-bold">{{ number_format($totalsaleamount) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Purchase Invoice & Total Purchase Amount --}}
            <div class="col-12 col-md-6 col-lg-4 col-xxl-3 p-2">
                <div class="dashboardCard secondCardShadow shadow-sm">
                    <div class="dashboardCard-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="cardImg rounded secondCardColor">
                                <i class="fa-solid fa-money-bill-1-wave fa-xl"></i>
                            </div>
                        </div>
                        <div class="cardContent mx-2 text-end">
                            <span class="text-muted fs-6">Purchase Invoice</span>
                            <span class="fs-5 fw-bold mb-2">{{ $totalpurchaseinvoice }}</span>
                            <span class="text-muted fs-6">Purchase Amount</span>
                            <span class="fs-5 fw-bold">{{ number_format($totalpurchaseamount) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Credit Sale Invoice & Total Credit Sale Amount --}}
            <div class="col-12 col-md-6 col-lg-4 col-xxl-3 p-2">
                <div class="dashboardCard thirdCardShadow shadow-sm">
                    <div class="dashboardCard-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="cardImg rounded thirdCardColor">
                                <i class="fa-solid fa-money-bill-1-wave fa-xl"></i>
                            </div>
                            <div class="text-danger mx-2 mt-3">(Due)</div>
                        </div>
                        <div class="cardContent mx-2 text-end">
                            <span class="text-muted fs-6">Sale Invoice</span>
                            <span class="fs-5 fw-bold mb-2">{{ $totalsalecreditinvoice }}</span>
                            <span class="text-muted fs-6">Sale Amount</span>
                            <span class="fs-5 fw-bold">{{ number_format($totalsalecreditamount) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Credit Purchase Invoice & Total Credit Purchase Amount --}}
            <div class="col-12 col-md-6 col-lg-4 col-xxl-3 p-2">
                <div class="dashboardCard fourthCardShadow shadow-sm">
                    <div class="dashboardCard-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="cardImg rounded fourthCardColor">
                                <i class="fa-solid fa-money-bill-1-wave fa-xl"></i>
                            </div>
                            <div class="text-danger mt-3">(Due)</div>
                        </div>
                        <div class="cardContent mx-2 text-end">
                            <span class="text-muted fs-6">Purchase Invoice</span>
                            <span class="fs-5 fw-bold mb-2">{{ $totalpurchasecreditinvoice }}</span>
                            <span class="text-muted fs-6">Purchase Amount</span>
                            <span class="fs-5 fw-bold">{{ number_format($totalpurchasecreditamount) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Top Customer & Recently Arrival Product Section --}}
        <div class="row justify-content-center mt-4">

            {{-- Top Ten Customers --}}
            <div class="col-12 col-xxl-8">
                <div class="table-card rounded-1 dashboardTbHeight">
                    <div class="dashboardTitle section-title">
                        <h5 class="fw-bold">Top Ten Customer</h5>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="text-muted">Code</th>
                                <th scope="col" class="text-muted">Name</th>
                                <th scope="col" class="text-muted">NRC</th>
                                <th scope="col" class="text-muted text-end">Amount</th>
                                <th scope="col" class="text-muted text-center">Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($toptencustomers as $customer)
                                <tr class="lh-3">
                                    <td>{{ $customer->CustomerCode }}</td>
                                    <td>{{ $customer->CustomerName }}</td>
                                    <td>{{ $customer->NRCNo }}</td>
                                    <td class="text-end">{{ number_format($customer->amount) }}</td>
                                    <td class="text-center">{{ $customer->address }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Recently Arrival Product --}}
            <div class="col-12 col-xxl-4 my-3 my-xxl-0">
                <div class="table-card rounded-1 dashboardTbHeight">
                    <div class="dashboardTitle section-title">
                        <h5 class="fw-bold">Recently Arrival Products</h5>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="text-muted">Code</th>
                                <th scope="col" class="text-muted">Name</th>
                                <th scope="col" class="text-muted">Unit</th>
                                <th scope="col" class="text-muted">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{$item->ItemCode}}</td>
                                    <td>{{$item->ItemName}}</td>
                                    <td>{{$item->UnitDesc}}</td>
                                    <td>{{$item->Quantity}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{--Recently Purchase & Sale Invoice Section --}}
        <div class="row mt-4 px-3">
            <div class="col-12">

                {{-- Recently Ten Purchase Invoices --}}
                <div class="row justify-content-center my-3">
                    <div class="table-card col-12 rounded-1">
                        <div class="dashboardTitle section-title">
                            <h5 class="fw-bold">Recently Purchase Invoice</h5>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-muted text-center">Invoice No</th>
                                    <th scope="col" class="text-muted text-center class="text-center"">Date</th>
                                    <th scope="col" class="text-muted text-center">Supplier</th>
                                    <th scope="col" class="text-muted text-end">Paid Date</th>
                                    <th scope="col" class="text-muted text-end">Amount</th>
                                    <th scope="col" class="text-muted text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentpurchaseinvoice as $recentPurchase)
                                    <tr>
                                        <td class="text-center">{{ $recentPurchase->InvoiceNo }}</td>
                                        <td class="text-center">{{ $recentPurchase->PurchaseDate }}</td>
                                        <td class="text-center">{{ $recentPurchase->SupplierName }}</td>
                                        <td class="text-end">{{ $recentPurchase->PaidDate }} </td>
                                        <td class="text-end">{{ number_format($recentPurchase->GrandTotal) }}</td>
                                        <td class="text-center">
                                            <span class="@if ($recentPurchase->PaidDate  == null) creditColor @else debitColor @endif rounded-4">
                                                {{ $recentPurchase->PaidDate  == null ? "Due" : "Paid" }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Recently Ten Sale Invoices  --}}
                <div class="row justify-content-center rounded my-3">
                    <div class="table-card col-12 rounded-1">
                        <div class="dashboardTitle section-title">
                            <h5 class="fw-bold">Recently Sale Invoice</h5>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-muted text-center">Invoice No</th>
                                    <th scope="col" class="text-muted text-center">Date</th>
                                    <th scope="col" class="text-muted text-center">Customer</th>
                                    <th scope="col" class="text-muted text-end">Paid Date</th>
                                    <th scope="col" class="text-muted text-end">Amount</th>
                                    <th scope="col" class="text-muted text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentsaleinvoice as $recentSale)
                                    <tr>
                                        <td class="text-center">{{ $recentSale->InvoiceNo }}</td>
                                        <td class="text-center">{{ $recentSale->SalesDate }}</td>
                                        <td class="text-center">{{ $recentSale->CustomerName }}</td>
                                        <td class="text-end">{{ $recentSale->PaidDate }}</td>
                                        <td class="text-end" class="text-end">{{ number_format($recentSale->GrandTotal) }}</td>
                                        <td class="text-center">
                                            <span class="@if ($recentSale->PaidDate == null) creditColor @else debitColor @endif rounded-4">
                                                {{ $recentSale->PaidDate == null ? "Due" : "Paid" }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
