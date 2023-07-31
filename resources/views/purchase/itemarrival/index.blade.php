<x-layout title="Item Arrival">

    <div class="container-fluid mt-3 content-body">

    {{-- Section Title --}}

        <div class="row justify-content-between">
            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Items Arrival List</h3>
            </div>
    
            {{-- Create New Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/itemarrival/add" class="btn main-btn" type="button">
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
                    {{-- Start Date --}}
                    <div class="col-6 col-md-4 col-xl-2 col-xxl-2 mb-2">
                        <label for="arrivalStartedDate" class="form-label cust-label">Start Date</label>
                        <input type="date" class="form-control cust-input-box" id="arrivalStartedDate" value="{{request('StartDate')}}" name="StartDate">
                    </div>
                    {{-- End Date --}}
                    <div class="col-6 col-md-4 col-xl-2 col-xxl-2 mb-2">
                        <label for="arrivalEndDate" class="form-label cust-label">End Date</label>
                        <input type="date" class="form-control cust-input-box" id="arrivalEndDate" value="{{request('EndDate')}}" name="EndDate">
                    </div>
                    {{-- Plate No --}}
                    <div class="col-6 col-md-4 col-xl-2 col-xxl-2 mb-2">
                        <label for="plateNo" class="form-label cust-label">Plate No/Name</label>
                        <input type="text" class="form-control cust-input-box" id="plateNo" value="{{request('PlateNo')}}" name="PlateNo">
                    </div>
                    {{-- Status --}}
                    <div class="col-2 col-md-4 col-xl-2 col-xxl-1 pt-2">
                        <div class="form-check">
                            <input class="form-check-input col-4" type="radio" name="CompleteStatus" id="all" value="all" @if (request('CompleteStatus') === "all") checked = "checked" @endif>
                            <label class="form-check-label col-5" for="all">
                                All
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input col-4" type="radio" name="CompleteStatus" id="complete" value="complete" @if (request('CompleteStatus') === "complete") checked = "checked" @endif>
                            <label class="form-check-label col-5" for="complete">
                                Complete
                            </label>
                        </div>
                    </div>
                    {{-- Status --}}
                    <div class="col-2 col-md-4 col-xl-2 col-xxl-1 pt-2">
                        <div class="form-check">
                            <input class="form-check-input col-4" type="radio" name="CompleteStatus" id="ongoing" value="ongoing" @if (request('CompleteStatus') === "ongoing") checked = "checked" @endif>
                            <label class="form-check-label col-5" for="ongoing">
                                Ongoing
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input col-4" type="radio" name="CompleteStatus" id="delete" value="delete" @if (request('CompleteStatus') === "delete") checked = "checked" @endif>
                            <label class="form-check-label col-5" for="delete">
                                Void
                            </label>
                        </div>
                    </div>
                    {{-- Filter Button --}}
                    <div class="col-10 col-md-9 col-xl-5 col-xxl-4 mb-2 pt-2">
                        <div class="d-flex justify-content-center align-items-center mt-2" style="height: 100%">
                            {{-- Filter Button --}}
                            <button class="btn filter-btn py-1 px-2 px-sm-3"><span class="me-1"><i class="bi bi-funnel"></i></span>Filter</button>
                            {{-- Reset Button --}}
                            <a type="button" href="/itemarrival/index" class="btn btn-light ms-1 ms-sm-3 py-1 px-2 px-sm-3" id="filterCancel">
                                <span class="me-1"><i class="bi bi-x-circle"></i></span>Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    {{-- End of Filter Section --}}

    {{-- Arrival List --}}

        <div class="row mt-2 justify-content-center">
            @php
                $role = auth()->user()->systemrole->RoleDesc
            @endphp
            <div class="table-card">
                <table id="itemArrivalList" class="table table-striped nowrap">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Arrival Code</th>
                            <th style="width: 100px;">Plate No/Name</th>
                            <th style="width: 120px;">Arrival Date</th>
                            <th style="width: 120px;">Supplier Name</th>
                            <th style="width: 100px;">Status</th>
                            <th class="text-end" style="width: 150px;">Total Bags</th>
                            <th class="text-end" style="width: 150px;">Total Viss</th>
                            <th class="text-end" style="width: 150px;">Charges Per Bag/Viss</th>
                            <th class="text-end" style="width: 150px;">Charges</th>
                            <th class="text-end" style="width: 150px;">Other Charges</th>
                            <th class="text-end" style="width: 150px;">Total Charges</th>
                            @if ($role == 'admin')
                                <th style="width: 150px">Created By</th>
                                <th style="width: 150px">Created Date</th>
                                <th style="width: 150px">Modified By</th>
                                <th style="width: 150px">Modified Date</th>
                            @endif 
                            <th style="width: 350px;">Remark</th>
                            <th style="width: 50px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($itemarrivals as $itemarrival)
                            <tr>
                                <td>
                                    {{$itemarrival->ArrivalCode}}
                                </td>
                                <td>{{$itemarrival->PlateNo}}</td>
                                <td>{{$itemarrival->ArrivalDate}}</td>
                                <td>{{$itemarrival->SupplierName}}</td>
                                <td class="text-center">
                                    @if ($itemarrival->Status == 'N')
                                        <span class="badge text-bg-primary ">Ongoing</span>
                                    @elseif ($itemarrival->Status == 'O')
                                        <span class="badge text-bg-success ">Complete</span>
                                    @else 
                                        <span class="badge text-bg-danger ">Void</span>
                                    @endif
                                </td>
                                <td class="text-end">{{$itemarrival->TotalBags}}</td>
                                <td class="text-end">{{$itemarrival->TotalViss}}</td>
                                <td class="text-end">{{number_format($itemarrival->ChargesPerBag)}}</td>
                                <td class="text-end">{{number_format($itemarrival->TotalCharges)}}</td>
                                <td class="text-end">{{number_format($itemarrival->OtherCharges)}}</td>
                                <td class="text-end">{{number_format($itemarrival->TotalCharges + $itemarrival->OtherCharges)}}</td>
                                @if ($role == 'admin') 
                                    <td>{{$itemarrival->CreatedBy}}</td>
                                    <td>{{$itemarrival->CreatedDate}}</td>
                                    <td>{{$itemarrival->ModifiedBy}}</td>
                                    <td>{{$itemarrival->ModifiedDate}}</td>
                                @endif
                                <td>{{$itemarrival->Remark}}</td>
                                <td class="text-center">
                                    <a href="/itemarrival/edit/{{$itemarrival->ArrivalCode}}" class="btn btn-primary py-0 px-1 me-2">
                                            <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <button class="btn delete-btn py-0 px-1" id="{{$itemarrival->ArrivalCode}}" onclick="PassItemArrivalCode(this.id);" data-bs-toggle="modal" data-bs-target="#itemArrivalDeleteModal">
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
 
    {{-- End of Arrival List --}}

    {{-- Item Delete Modal --}}

        <div class="modal fade" id="itemArrivalDeleteModal" aria-labelledby="itemArrivalDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i></h1>
                        <p class="text-center">Are you sure?</p>
                        <div class="text-center">
                            <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                            <a href="" id="deleteItemArrivalBtn"  class="btn btn-primary py-1">Sure</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- End of Item Delete Modal --}}
    
    </div>

</x-layout>
