<x-layout title="Purchase List">

     <div class="container-fluid mt-2 content-body">

     {{-- Section Title --}}

          <div class="row justify-content-between">

               {{-- Title --}}
               <div class="col-8 col-md-6 p-0">
                    <h3 class="section-title">Purchase List</h3>
               </div>

               {{-- Create New Button --}}
               <div class="col-4 p-0 text-end">
                    <a href="/purchaseinvoices/add" class="btn main-btn" type="button">
                         <span class="me-1"><i class="bi bi-plus-circle"></i></span>New
                    </a>
               </div>
          </div>

     {{-- End of Section Title --}}

     {{-- Filter Section --}}

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
                              <label for="startedDate" class="form-label cust-label">Start Date</label>
                              <input type="date" class="form-control cust-input-box" id="startedDate" value="{{request('startDate')}}" name="startDate">
                         </div>
                         {{-- End Date --}}
                         <div class="col-6 col-md-4 col-xl-2 col-xxl-2 mb-2">
                              <label for="endDate" class="form-label cust-label">End Date</label>
                              <input type="date" class="form-control cust-input-box" id="endDate" value="{{request('endDate')}}" name="endDate">
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
                         <div class="col-10 col-md-9 col-xl-5 col-xxl-4 mb-2 pt-2">
                              <div class="d-flex justify-content-center align-items-center mt-2" style="height: 100%">
                                   {{-- Filter Button --}}
                                   <button class="btn filter-btn py-1 px-2 px-sm-3"><span class="me-1"><i class="bi bi-funnel"></i></span>Filter</button>
                                   {{-- Cancel Button --}}
                                   <a type="button" href="/purchaseinvoices/index" class="btn btn-light ms-1 ms-sm-3 py-1 px-2 px-sm-3" id="filterCancel">
                                        <span class="me-1"><i class="bi bi-x-circle"></i></span>Reset
                                   </a>
                                   {{-- Deleted Invoice Button --}}
                                   <button type="button" class="btn deleted-invoice py-1 px-2 px-sm-3 ms-1 ms-sm-3 position-relative" data-bs-toggle="modal" data-bs-target="#deletedInvoiceModal">
                                        <span class="me-1"><i class="bi bi-list-ul"></i></span>Deleted Invoice 
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="background-color: #f70808;">{{count($deletepurchaseinvoices)}}</span>
                                   </button>
                              </div>
                         </div>
                    </form>
               </div>
          </div>
     
     {{-- End of Filter Section --}}

     {{-- Purchase List --}}

          <div class="row mt-2 justify-content-center">
               @php
                    $role = auth()->user()->systemrole->RoleDesc
               @endphp
               <div class="table-card">
                    <table id="purchaseList" class="table table-striped nowrap">
                         <thead>
                              <tr>
                                   <th style="width: 150px !important;">Invoice No</th>
                                   <th style="width: 100px !important;">Purchase Date</th>
                                   <th style="width: 100px !important;">Paid Date</th>
                                   <th style="width: 150px !important;">Supplier Name</th>
                                   <th style="width: 100px !important;">Plate No/Name</th>
                                   <th class="text-end" style="width: 150px !important;">Sub Total</th>
                                   {{-- <th>Labor Charges</th>
                                   <th>Delivery Charges</th>
                                   <th>Weight Charges</th>
                                   <th>Service Charges</th> --}}
                                   <th class="text-end" style="width: 150px !important;">Total Charges</th> 
                                   <th class="text-end" style="width: 150px !important;">Grand Total</th>
                                   {{-- <th>Status</th> --}}
                                   <th class="text-end" style="width: 300px !important;">Remark</th>
                                   @if ($role == 'admin')
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                        <th>Modified By</th>
                                        <th>Modified Date</th>
                                        <th>Deleted By</th>
                                        <th>Deleted Date</th>
                                   @endif
                                   <th style="width: 50px !important;"></th>
                              </tr>
                         </thead>
                         <tbody>
                              @forelse ($purchaseinvoices as $purchaseinvoice)
                                   <tr>
                                        <td class="text-center">
                                             @if ($purchaseinvoice->IsPaid == 1)
                                                  <a href="/purchaseinvoices/details/{{$purchaseinvoice->InvoiceNo}}" class="details-link"><span class="text-success px-1"><i class="bi bi-check-circle-fill"></i></span>{{$purchaseinvoice->InvoiceNo}}</a>
                                             @else
                                                  <a href="/purchaseinvoices/details/{{$purchaseinvoice->InvoiceNo}}" class="details-link"><span class="text-danger px-1"><i class="fa fa-sack-xmark"></i></span> {{$purchaseinvoice->InvoiceNo}}</a>
                                             @endif
                                        </td>
                                        <td>{{$purchaseinvoice->PurchaseDate}}</td>
                                        <td>{{$purchaseinvoice->PaidDate}}</td>
                                        <td>{{$purchaseinvoice->SupplierName}}</td>
                                        <td>
                                             @foreach ($arrivals as $arrival)
                                                  @if ($purchaseinvoice->ArrivalCode == $arrival->ArrivalCode)
                                                       {{$arrival->PlateNo}}
                                                  @endif
                                             @endforeach
                                        </td>
                                        <td class="text-end">{{number_format($purchaseinvoice->SubTotal)}}</td>
                                        {{-- <td>{{$purchaseinvoice->LaborCharges}}</td>
                                        <td>{{$purchaseinvoice->DeliveryCharges}}</td>
                                        <td>{{$purchaseinvoice->WeightCharges}}</td>
                                        <td>{{$purchaseinvoice->ServiceCharges}}</td> --}}
                                        <td class="text-end">{{number_format($purchaseinvoice->TotalCharges)}}</td> 
                                        <td class="text-end">{{number_format($purchaseinvoice->GrandTotal)}}</td>
                                        {{-- <td>{{$purchaseinvoice->Status}}</td> --}}
                                        <td>{{$purchaseinvoice->Remark}}</td>
                                        @if ($role == 'admin')
                                             <td>{{$purchaseinvoice->CreatedBy}}</td>
                                             <td>{{$purchaseinvoice->CreatedDate}}</td>
                                             <td>{{$purchaseinvoice->ModifiedBy}}</td>
                                             <td>{{$purchaseinvoice->ModifiedDate}}</td>
                                             <td>{{$purchaseinvoice->DeletedBy}}</td>
                                             <td>{{$purchaseinvoice->DeletedDate}}</td>
                                        @endif
                                        <td class="text-center">
                                             <a href="/purchaseinvoices/edit/{{$purchaseinvoice->InvoiceNo}}" class="btn btn-primary py-0 px-1 me-2">
                                                  <i class="bi bi-pencil-fill"></i>
                                             </a>
                                             <button class="btn delete-btn py-0 px-1" id="{{$purchaseinvoice->InvoiceNo}}" onclick="PassPurchaseInNo(this.id);" data-bs-toggle="modal" data-bs-target="#purchaseDeleteModal">
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

     {{-- End of Purchase List --}}

     {{-- Purchase Delete Modal --}}

          <div class="modal fade" id="purchaseDeleteModal" aria-labelledby="purchaseDeleteModal">
               <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content">
                         <div class="modal-body" style="background-color: aliceblue">
                              <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i></h1>
                              <p class="text-center">Are you sure?</p>
                              <div class="text-center">
                                   <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                                   <a href="" id="deletePurchaseBtn" class="btn btn-primary py-1">Sure</a>
                              </div>
                         </div>
                    </div>
               </div>
          </div>

     {{-- End of Purchase Delete Modal --}}

     {{-- Deleted Invoice Modal --}}

          <div class="modal fade" id="deletedInvoiceModal" aria-labelledby="deletedInvoiceModal" style="z-index: 99999 !important;">
               <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                         <div class="modal-header py-3 bg-aliceblue">
                              <h3 class="section-title">Deleted Invoice List</h3>
                              <button type="button" class="cust-btn-close rounded-circle" data-bs-dismiss="modal" aria-label="Close">
                                   <i class="bi bi-x"></i>
                              </button>
                         </div>
                         <div class="modal-body">
                              <div class="table-width">
                                   <table class="table table-striped table-bordered">
                                        <thead>
                                             <tr>
                                                  <th class="column-sticky first-column-th">Invoice No</th>
                                                  <th>Purchase Date</th>
                                                  <th>Supplier Name</th>
                                                  <th>Arrival Code</th>
                                                  <th>Sub Total</th>
                                                  <th>Shipping Charges</th>
                                                  <th>Labor Charges</th>
                                                  <th>Delivery Charges</th>
                                                  <th>Weight Charges</th>
                                                  <th>Service Charges</th>
                                                  <th>Factory Charges</th>
                                                  <th>Total Charges</th>
                                                  <th>Grand Total</th>
                                                  <th>Paid Date</th>
                                                  <th>Status</th>
                                                  <th>Remark</th>
                                                  @if ($role == 'admin')
                                                       <th>Created By</th>
                                                       <th>Created Date</th>
                                                       <th>Modified By</th>
                                                       <th>Modified Date</th>
                                                       {{-- <th>Deleted By</th>
                                                       <th>Deleted Date</th> --}}
                                                  @endif
                                                  <th class="column-sticky last-column-th"></th>
                                                  {{-- <th></th> --}}
                                             </tr>
                                        </thead>
                                        <tbody style="white-space: nowrap;">
                                             @forelse ($deletepurchaseinvoices as $deletepurchaseinvoice)
                                                  <tr>
                                                       <td class="text-center column-sticky first-column-tb">
                                                            @if ($deletepurchaseinvoice->IsPaid == 1)
                                                                 <a href="/purchaseinvoices/details/{{$deletepurchaseinvoice->InvoiceNo}}"><span class="text-success px-1"><i class="bi bi-check-circle-fill"></i></span> {{$deletepurchaseinvoice->InvoiceNo}}</a>
                                                            @else
                                                                 <span class="text-danger px-1"><i class="bi bi-x-circle-fill"></i></span> {{$deletepurchaseinvoice->InvoiceNo}}
                                                            @endif
                                                       </td>
                                                       {{-- <td class="text-center">
                                                            @if ($deletepurchaseinvoice->IsPaid == 1)
                                                                 <span class="badge text-bg-success ">{{$deletepurchaseinvoice->InvoiceNo}}</span>
                                                            @else
                                                                 <span class="badge text-bg-danger ">{{$deletepurchaseinvoice->InvoiceNo}}</span>
                                                            @endif
                                                       </td> --}}
                                                       <td>{{$deletepurchaseinvoice->PurchaseDate}}</td>
                                                       <td>{{$deletepurchaseinvoice->SupplierName}}</td>
                                                       <td>{{$deletepurchaseinvoice->ArrivalCode}}</td>
                                                       <td class="text-end">{{number_format($deletepurchaseinvoice->SubTotal)}}</td>
                                                       <td class="text-end">{{number_format($deletepurchaseinvoice->ShippingCharges)}}</td>
                                                       <td class="text-end">{{number_format($deletepurchaseinvoice->LaborCharges)}}</td>
                                                       <td class="text-end">{{number_format($deletepurchaseinvoice->DeliveryCharges)}}</td>
                                                       <td class="text-end">{{number_format($deletepurchaseinvoice->WeightCharges)}}</td>
                                                       <td class="text-end">{{number_format($deletepurchaseinvoice->ServiceCharges)}}</td>
                                                       <td class="text-end">{{number_format($deletepurchaseinvoice->FactoryCharges)}}</td>
                                                       <td class="text-end">{{number_format($deletepurchaseinvoice->TotalCharges)}}</td>
                                                       <td class="text-end">{{number_format($deletepurchaseinvoice->GrandTotal)}}</td>
                                                       <td>{{$deletepurchaseinvoice->PaidDate}}</td>
                                                       <td>{{$deletepurchaseinvoice->Status}}</td>
                                                       <td>{{$deletepurchaseinvoice->Remark}}</td>
                                                       @if ($role == 'admin')
                                                            <td>{{$deletepurchaseinvoice->CreatedBy}}</td>
                                                            <td>{{$deletepurchaseinvoice->CreatedDate}}</td>
                                                            <td>{{$deletepurchaseinvoice->ModifiedBy}}</td>
                                                            <td>{{$deletepurchaseinvoice->ModifiedDate}}</td>
                                                            {{-- <td>{{$deletepurchaseinvoice->DeletedBy}}</td>
                                                            <td>{{$deletepurchaseinvoice->DeletedDate}}</td> --}}
                                                       @endif
                                                       <td class="column-sticky last-column-tb text-center">
                                                            <a href="/purchaseinvoices/restore/{{$deletepurchaseinvoice->InvoiceNo}}" class="btn btn-primary py-0 px-1 me-2">
                                                                 <i class="bi bi-arrow-clockwise"></i>
                                                            </a>
                                                       </td>
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
