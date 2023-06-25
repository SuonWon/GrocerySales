<x-layout title="customer">

     <div class="container-fluid mt-3 content-body">
 
     {{-- Section Title --}}
 
          <div class="row justify-content-between">

               {{-- Title --}}
               <div class="col-6 p-0">
                    <h3 class="section-title">Customer Lists</h3>
               </div>

               {{-- Create New Button --}}
               <div class="col-4 p-0 text-end">
                    <a href="/customer/add" class="btn main-btn" type="button">
                         <span class="me-1"><i class="bi bi-plus-circle"></i></span>New
                    </a>
               </div>
          </div>

     {{-- End of Section Title --}}

     {{-- Customer List --}}

     <div class="row mt-3 justify-content-center">
          <div class="table-card">
               <table id="custList" class="table table-striped nowrap">
                    <thead>
                         <tr>
                              <th style="width: 150px !important;">Customer Code</th>
                              <th style="width: 200px !important;">Customer Name</th>
                              <th style="width: 150px !important;">NRC No</th>
                              <th style="width: 200px !important;">Company Name</th>
                              <th style="width: 150px !important;">Contact No</th>
                              <th style="width: 150px !important;">Office No</th>
                              <th style="width: 150px !important;">Fax No</th>
                              <th style="width: 200px !important;">Email</th>
                              <th style="width: 250px !important;">Street</th>
                              <th style="width: 170px !important;">City</th>
                              <th style="width: 170px !important;">Region</th>
                              <th style="width: 150px !important;">Created By</th>
                              <th style="width: 150px !important;">Created Date</th>
                              <th style="width: 150px !important;">Modified By</th>
                              <th style="width: 150px !important;">Modified Date</th>
                              <th style="width: 300px !important;">Remark</th>
                              <th></th>
                         </tr>
                    </thead>
                    <tbody>
                         @forelse ($customers as $customer)
                              <tr>
                                   <td class="text-center">
                                        @if ($customer->IsActive == 1)
                                             <span class="badge text-bg-success ">{{$customer->CustomerCode}}</span>
                                        @else
                                             <span class="badge text-bg-danger ">{{$customer->CustomerCode}}</span>
                                        @endif
                                   </td>
                                   <td>{{$customer->CustomerName}}</td>
                                   <td>{{$customer->NRCNo}}</td>
                                   <td>{{$customer->CompanyName}}</td>
                                   <td>{{$customer->ContactNo}}</td>
                                   <td>{{$customer->OfficeNo}}</td>
                                   <td>{{$customer->FaxNo}}</td>
                                   <td>{{$customer->Email}}</td>
                                   <td>{{$customer->Street}}</td>
                                   <td>{{$customer->City}}</td>
                                   <td>{{$customer->Region}}</td>
                                   <td>{{$customer->CreatedBy}}</td>
                                   <td>{{$customer->CreatedDate}}</td>
                                   <td>{{$customer->ModifiedBy}}</td>
                                   <td>{{$customer->ModifiedDate}}</td>
                                   <td>{{$customer->Remark}}</td>
                                   <td>
                                        <a href="/customer/edit/{{$customer->CustomerCode}}" class="btn btn-primary py-0 px-1 me-2">
                                             <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <button class="btn delete-btn py-0 px-1 me-2" id="{{$customer->CustomerCode}}" onclick="PassCustomerCode(this.id);" data-bs-toggle="modal" data-bs-target="#customerDeleteModal">
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

     {{-- End of Customer List --}} 

     {{-- Customer Delete Modal --}}

          <div class="modal fade" id="customerDeleteModal" aria-labelledby="customerDeleteModal">
               <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content">
                         <div class="modal-body" style="background-color: aliceblue">
                              <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i></h1>
                              <p class="text-center">Are you sure?</p>
                              <div class="text-center">
                              <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                              <a href="" id="deleteCustBtn" class="btn btn-primary py-1">Sure</a>
                              </div>
                         </div>
                    </div>
               </div>
          </div>

     {{-- End of Custoemr Delete Modal --}}

     </div>

</x-layout>
