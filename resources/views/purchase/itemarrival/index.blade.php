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

    {{-- Item List --}}

        <div class="row mt-2 justify-content-center">
            @php
                $role = auth()->user()->systemrole->RoleDesc
            @endphp
            <div class="table-card">
                <table id="itemArrivalList" class="table table-striped nowrap">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Arrival Code</th>
                            <th style="width: 100px;">Plate No</th>
                            <th style="width: 120px;">Arrival Date</th>
                            <th style="width: 100px;">Status</th>
                            <th class="text-end" style="width: 150px;">Charges Per Bag</th>
                            <th class="text-end" style="width: 150px;">Total Bags</th>
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
                                <td class="text-center">
                                    @if ($itemarrival->Status == 'N')
                                        <span class="badge text-bg-primary ">Ongoing</span>
                                    @elseif ($itemarrival->Status == 'O')
                                        <span class="badge text-bg-success ">Complete</span>
                                    @else 
                                        <span class="badge text-bg-danger ">Void</span>
                                    @endif
                                </td>
                                <td class="text-end">{{number_format($itemarrival->ChargesPerBag)}}</td>
                                <td class="text-end">{{$itemarrival->TotalBags}}</td>
                                <td class="text-end">{{number_format($itemarrival->OtherCharges)}}</td>
                                <td class="text-end">{{number_format($itemarrival->TotalCharges)}}</td>
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
 
    {{-- End of Item List --}}

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
