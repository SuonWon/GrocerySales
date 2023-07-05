<x-layout title="Sales List">

     <div class="container-fluid mt-2 content-body">

     {{-- Section Title --}}

          <div class="row justify-content-between">

               {{-- Title --}}
               <div class="col-8 col-md-6 p-0">
                    <h3 class="section-title">Sales List</h3>
               </div>

               {{-- Create New Button --}}
               <div class="col-4 p-0 text-end">
                    <a href="/salesinvoices/add" class="btn main-btn" type="button">
                         <span class="me-1"><i class="bi bi-plus-circle"></i></span>New
                    </a>
               </div>
          </div>

     {{-- End of Section Title --}}

          <div class="row mt-1">
               <div class="filter-box">
                    <form action="" method="GET" class="row justify-content-left">
                         @csrf
                         {{-- <div class="col-12 col-md-6 col-xl-4 col-xxl-1 mb-2">
                              <div class="d-flex justify-content-center align-items-center" style="height: 100%">
                                   <p class="mb-0">Filter By</p>
                              </div>
                         </div> --}}
                         {{-- Start Date --}}
                         <div class="col-6 col-md-4 col-xl-2 col-xxl-2 mb-2">
                              <label for="saleStartDate" class="form-label cust-label">Start Date</label>
                              <input type="date" class="form-control cust-input-box" id="saleStartDate" value="{{request('saleStartDate')}}" name="saleStartDate">
                         </div>
                         {{-- End Date --}}
                         <div class="col-6 col-md-4 col-xl-2 col-xxl-2 mb-2">
                              <label for="saleEndDate" class="form-label cust-label">End Date</label>
                              <input type="date" class="form-control cust-input-box" id="saleEndDate" value="{{request('saleEndDate')}}" name="saleEndDate">
                         </div>
                         {{-- Payment Status --}}
                         <div class="col-2 col-md-4 col-xl-2 col-xxl-1">
                              <div class="form-check">
                                   <input class="form-check-input col-4" type="radio" name="PaymentStatus" id="all" value="all" @if (request('PaymentStatus') === "all") checked = "checked" @endif>
                                   <label class="form-check-label col-5" for="all">
                                        All
                                   </label>
                              </div>
                              <div class="form-check">
                                   <input class="form-check-input col-4" type="radio" name="PaymentStatus" id="paidPayment" value="paid" @if (request('PaymentStatus') === "paid") checked = "checked" @endif>
                                   <label class="form-check-label col-5" for="paidPayment">
                                        Paid
                                   </label>
                              </div>
                              <div class="form-check">
                                   <input class="form-check-input col-4" type="radio" name="PaymentStatus" id="unpaidPayment" value="nopaid" @if (request('PaymentStatus') === "nopaid") checked = "checked" @endif>
                                   <label class="form-check-label col-5" for="unpaidPayment">
                                        Unpaid
                                   </label>
                              </div>
                         </div>
                         {{-- Filter Button --}}
                         <div class="col-10 col-md-9 col-xl-6 col-xxl-4 mb-2 pt-2">
                              <div class="d-flex justify-content-center align-items-center mt-2" style="height: 100%">
                                   {{-- Filter Button --}}
                                   <button class="btn filter-btn py-1 px-2 px-sm-3" id="filterBtn" ><span class="me-1"><i class="bi bi-funnel"></i></span>Filter</button>
                                   {{-- Cancel Button --}}
                                   <a href="/salesinvoices/index" type="button" class="btn btn-light ms-1 ms-sm-2 py-1 px-2 px-sm-3" id="filterCancel"><span class="me-1"><i class="bi bi-x-circle"></i></span>Reset</a>
                                   {{-- Deleted Invoice Button --}}
                                   <button type="button" class="btn deleted-invoice py-1 px-2 px-sm-3 ms-1 ms-sm-2 position-relative" data-bs-toggle="modal" data-bs-target="#deletedSalesInvoices">
                                        <span class="me-1"><i class="bi bi-list-ul"></i></span>Deleted Invoice 
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="background-color: #ff0000;">{{count($deletesalesinvoices)}}</span>
                                   </button>
                              </div>
                         </div>
                    </form>
               </div>
          </div>

    {{-- Sales List --}}

          <div class="row mt-2 justify-content-center">
               @php
                    $role = auth()->user()->systemrole->RoleDesc
               @endphp
               <div class="table-card">
                    <table id="salesList" class="table table-striped nowrap">
                         <thead>
                              <tr>
                                   <th style="width: 150px !important;">Invoice No</th>
                                   <th style="width: 100px !important;">Sales Date</th>
                                   <th style="width: 100px !important;">Paid Date</th>
                                   <th style="width: 150px !important;">Customer Name</th>
                                   <th style="width: 100px !important;">Plate No</th>
                                   <th class="text-end" style="width: 150px !important;">Sub Total</th>
                                   {{-- <th>Labor Charges</th>
                                   <th>Delivery Charges</th>
                                   <th>Weight Charges</th>
                                   <th>Service Charges</th> --}}
                                   <th class="text-end" style="width: 150px;">Total Charges</th>
                                   <th class="text-end" style="width: 150px;">Grand Total</th>
                                   {{-- <th>Status</th> --}}
                                   <th style="width: 300px !important;">Remark</th>
                                   @if ($role == 'admin')
                                        <th style="width: 150px">Created By</th>
                                        <th style="width: 150px">Created Date</th>
                                        <th style="width: 150px">Modified By</th>
                                        <th style="width: 150px">Modified Date</th>
                                        {{-- <th>Deleted By</th>
                                        <th>Deleted Date</th> --}}
                                   @endif
                                   <th style="width: 50px !important;"></th>
                              </tr>
                         </thead>
                         <tbody>
                              @forelse ($salesinvoices as $salesinvoice)
                                   <tr>
                                        <td class="text-center">
                                             @if ($salesinvoice->IsPaid == 1)
                                                  <a href="/salesinvoices/details/{{$salesinvoice->InvoiceNo}}" class="details-link"><span class="text-success px-1"><i class="bi bi-check-circle-fill"></i></span> {{$salesinvoice->InvoiceNo}}</a>
                                             @else
                                                  <a href="/salesinvoices/details/{{$salesinvoice->InvoiceNo}}" class="details-link"><span class="text-danger px-1"><i class="fa fa-sack-xmark"></i></span> {{$salesinvoice->InvoiceNo}}</a>
                                             @endif
                                        </td>
                                        {{-- <td class="text-center">
                                             @if ($salesinvoice->IsPaid == 1)
                                                  <span class="badge text-bg-success ">{{$salesinvoice->InvoiceNo}}</span>
                                             @else
                                                  <span class="badge text-bg-danger ">{{$salesinvoice->InvoiceNo}}</span>
                                             @endif
                                        </td> --}}
                                        <td>{{$salesinvoice->SalesDate}}</td>
                                        <td>
                                             {{$salesinvoice->PaidDate}}
                                        </td>
                                        <td>{{$salesinvoice->CustomerName}}</td>
                                        <td>{{$salesinvoice->PlateNo}}</td>
                                        <td class="text-end">{{number_format($salesinvoice->SubTotal)}}</td>
                                        {{-- <td>{{$salesinvoice->LaborCharges}}</td>
                                        <td>{{$salesinvoice->DeliveryCharges}}</td>
                                        <td>{{$salesinvoice->WeightCharges}}</td>
                                        <td>{{$salesinvoice->ServiceCharges}}</td> --}}
                                        <td class="text-end">{{number_format($salesinvoice->TotalCharges)}}</td>
                                        <td class="text-end">{{number_format($salesinvoice->GrandTotal)}}</td>
                                        {{-- <td>{{$salesinvoice->Status}}</td> --}}
                                        <td>{{$salesinvoice->Remark}}</td>
                                        @if ($role == 'admin')
                                             <td>{{$salesinvoice->CreatedBy}}</td>
                                             <td>{{$salesinvoice->CreatedDate}}</td>
                                             <td>{{$salesinvoice->ModifiedBy}}</td>
                                             <td>{{$salesinvoice->ModifiedDate}}</td>
                                             {{-- <td>{{$salesinvoice->DeletedBy}}</td>
                                             <td>{{$salesinvoice->DeletedDate}}</td> --}}
                                        @endif
                                        <td class="text-center">
                                             <a href="/salesinvoices/edit/{{$salesinvoice->InvoiceNo}}" class="btn btn-primary py-0 px-1 me-2">
                                                  <i class="bi bi-pencil-fill"></i>
                                             </a>
                                             <button class="btn delete-btn py-0 px-1" id="{{$salesinvoice->InvoiceNo}}" onclick="PassSaleInNo(this.id);" data-bs-toggle="modal" data-bs-target="#saleDeleteModal">
                                                  <i class="bi bi-trash-fill"></i>
                                             </button>
                                        </td>
                                   </tr>
                              @empty
                              
                              @endforelse
                         </tbody>
                    </table>
               </div>
          </div>

    {{-- End of Sales List --}}

    {{-- Sales Delete Modal --}}

          <div class="modal fade" id="saleDeleteModal" aria-labelledby="saleDeleteModal">
               <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content">
                         <div class="modal-body" style="background-color: aliceblue">
                         <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i></h1>
                         <p class="text-center">Are you sure?</p>
                         <div class="text-center">
                              <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                              <a href="" id="deleteSaleBtn" class="btn btn-primary py-1">Sure</a>
                         </div>
                         </div>
                    </div>
               </div>
          </div>

    {{-- End of Sales Delete Modal --}}

    {{-- Deleted Invoice Modal --}}

     <div class="modal fade" id="deletedSalesInvoices" aria-labelledby="deletedSalesInvoices" style="z-index: 99999 !important;">
          <div class="modal-dialog modal-xl">
               <div class="modal-content">
                    <div class="modal-header bg-aliceblue py-3">
                         <h3 class="section-title">Deleted Sales Invoices</h3>
                         <button type="button" class="cust-btn-close rounded-circle" data-bs-dismiss="modal" aria-label="Close">
                              <i class="bi bi-x"></i>
                         </button>
                    </div>
                    <div class="modal-body">
                         <div class="table-width">
                              <table id="" class="table table-striped table-bordered">
                                   <thead style="background-color: #36616d; color: aliceblue; white-space: nowrap;">
                                        <tr>
                                             <th>Invoice No</th>
                                             <th>Purchase Date</th>
                                             <th>Supplier Name</th>
                                             <th>Arrival Code</th>
                                             <th class="text-end">Sub Total</th>
                                             <th class="text-end">Labor Charges</th>
                                             <th class="text-end">Delivery Charges</th>
                                             <th class="text-end">Weight Charges</th>
                                             <th class="text-end">Service Charges</th>
                                             <th class="text-end">Total Charges</th>
                                             <th class="text-end">Grand Total</th>
                                             <th>Paid Date</th>
                                             <th>Status</th>
                                             <th>Remark</th>
                                             @if ($role == 'admin')
                                                  <th>Created By</th>
                                                  <th>Created Date</th>
                                                  <th>Modified By</th>
                                                  <th>Modified Date</th>
                                                  <th>Deleted By</th>
                                                  <th>Deleted Date</th>
                                             @endif
                                             {{-- <th></th> --}}
                                        </tr>
                                   </thead>
                                   <tbody style="white-space: nowrap;">
                                        @forelse ($deletesalesinvoices as $deletesalesinvoice)
                                        
                                             <tr>
                                                  <td class="text-center">
                                                       @if ($deletesalesinvoice->IsPaid == 1)
                                                            <span class="text-success px-1"><i class="bi bi-check-circle-fill"></i></span> {{$deletesalesinvoice->InvoiceNo}}
                                                       @else
                                                            <span class="text-danger px-1"><i class="bi bi-x-circle-fill"></i></span> {{$deletesalesinvoice->InvoiceNo}}
                                                       @endif
                                                  </td>
                                                  {{-- <td class="text-center">
                                                       @if ($deletesalesinvoice->IsPaid == 1)
                                                            <span class="badge text-bg-success ">{{$deletesalesinvoice->InvoiceNo}}</span>
                                                       @else
                                                            <span class="badge text-bg-danger ">{{$deletesalesinvoice->InvoiceNo}}</span>
                                                       @endif
                                                  </td> --}}
                                                  <td>{{$deletesalesinvoice->SalesDate}}</td>
                                                  <td>{{$deletesalesinvoice->CustomerName}}</td>
                                                  <td>{{$deletesalesinvoice->PlateNo}}</td>
                                                  <td class="text-end">{{number_format($deletesalesinvoice->SubTotal)}}</td>
                                                  <td class="text-end">{{number_format($deletesalesinvoice->LaborCharges)}}</td>
                                                  <td class="text-end">{{number_format($deletesalesinvoice->DeliveryCharges)}}</td>
                                                  <td class="text-end">{{number_format($deletesalesinvoice->WeightCharges)}}</td>
                                                  <td class="text-end">{{number_format($deletesalesinvoice->ServiceCharges)}}</td>
                                                  <td class="text-end">{{number_format($deletesalesinvoice->TotalCharges)}}</td>
                                                  <td class="text-end">{{number_format($deletesalesinvoice->GrandTotal)}}</td>
                                                  <td>{{$deletesalesinvoice->PaidDate}}</td>
                                                  <td>{{$deletesalesinvoice->Status}}</td>
                                                  <td>{{$deletesalesinvoice->Remark}}</td>
                                                  @if ($role == 'admin')
                                                       <td>{{$deletesalesinvoice->CreatedBy}}</td>
                                                       <td>{{$deletesalesinvoice->CreatedDate}}</td>
                                                       <td>{{$deletesalesinvoice->ModifiedBy}}</td>
                                                       <td>{{$deletesalesinvoice->ModifiedDate}}</td>
                                                       <td>{{$deletesalesinvoice->DeletedBy}}</td>
                                                       <td>{{$deletesalesinvoice->DeletedDate}}</td>
                                                  @endif
                                                  {{-- <td>
                                                       <a href="/purchaseinvoices/edit/{{$deletepurchaseinvoice->InvoiceNo}}" class="btn btn-primary py-0 px-1 me-2">
                                                            <i class="bi bi-pencil-fill"></i>
                                                       </a>
                                                       <button class="btn delete-btn py-0 px-1 me-2" id="{{$deletepurchaseinvoice->InvoiceNo}}" onclick="PassPurchaseInNo(this.id);" data-bs-toggle="modal" data-bs-target="#purchaseDeleteModal">
                                                            <i class="bi bi-trash-fill"></i>
                                                       </button>
                                                  </td> --}}
                                             </tr>
                                        @empty
                                        
                                        @endforelse
                                   </tbody>
                              </table>
                         </div>
                         
                    </div>
                    {{-- <div class="modal-footer">
                         <button type="button" class="btn btn-light" data-bs-dismiss="modal">Back</button>
                    </div> --}}
               </div>
          </div>  
     </div>

    {{-- End of Deleted Invoice Modal --}}

    </div>

</x-layout>

