<x-layout title="Company Info">

     <div class="container-fluid mt-3 content-body">

         {{-- Section Title --}}

         <div class="row justify-content-between">
             <div class="col-5 p-0">
                 <h3 class="section-title">Company List</h3>
             </div>

             {{-- Create New Button --}}
             <div class="col-4 p-0 text-end">
                 <a href="{{ route('addcompanyinformation') }}" class="btn main-btn" type="button">
                     <span class="me-2"><i class="bi bi-plus-circle"></i></span>Add
                 </a>
             </div>
         </div>

         {{-- End of Section Title --}}

         {{-- Company List --}}

         <div class="row mt-3 justify-content-center">

            <img src="{{ asset('assets/images/example.jpg') }}" alt="">
             <div class="table-card">
                 <table id="companyList" class="table table-striped nowrap">
                     <thead>
                         <tr>
                              <th>Company Code</th>
                              <th>Company Logo</th>
                              <th>Company Name</th>
                              <th>Street</th>
                              <th>City</th>
                              <th>Office No</th>
                              <th>Hot Line No</th>
                              <th>Created By</th>
                              <th>Created Date</th>
                              <th>Modified By</th>
                              <th>Modified Date</th>
                              <th></th>
                         </tr>
                     </thead>
                     <tbody>
                         @forelse ($companyinformations as $company)
                              <tr>
                                   <td>{{$company->CompanyCode}}</td>
                                   <td>
                                   <img src='{{ asset($company->CompanyLogo) }}' class="rounded-3" alt="" style="width:100px;height:100px;"/>
                                   </td>
                                   <td>{{$company->CompanyName}}</td>
                                   <td>{{$company->Street}}</td>
                                   <td>{{$company->City}}</td>
                                   <th>{{$company->OfficeNo}}</th>
                                   <th>{{$company->HotLineNo}}</th>
                                   <td>{{$company->CreatedBy}}</td>
                                   <td>{{$company->CreatedDate}}</td>
                                   <td>{{$company->ModifiedBy}}</td>
                                   <td>{{$company->ModifiedDate}}</td>
                                   <td class="text-center">
                                        <a href="/companyinformation/edit/{{$company->CompanyCode}}" class="btn btn-primary py-0 px-1 me-2">
                                             <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <button class="btn delete-btn py-0 px-1 me-2" id="{{$company->CompanyCode}}" onclick="PassCompanyCode(this.id);" data-bs-toggle="modal" data-bs-target="#companyDeleteModal">
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

         {{-- End of Company List --}}

         {{-- Company Delete Modal --}}

         <div class="modal fade" id="companyDeleteModal" aria-labelledby="companyDeleteModal">
             <div class="modal-dialog modal-sm modal-dialog-centered">
                 <div class="modal-content">
                     <div class="modal-body" style="background-color: aliceblue">
                         <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i></h1>
                         <p class="text-center">Are you sure?</p>
                         <div class="text-center">
                             <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                             <a href="" id="deleteCompanyBtn" class="btn btn-primary py-1">Sure</a>
                         </div>
                     </div>
                 </div>
             </div>
         </div>

         {{-- End of  Delete Modal --}}
     </div>

 </x-layout>



