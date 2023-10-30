<x-layout title="Stock Adjustment List">

    <div class="container-fluid mt-2 content-body">

        {{-- Section Title --}}

        <div class="row justify-content-between">

            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Stock Adjustment List</h3>
            </div>

            {{-- Create New Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/stockadjustment/add/" class="btn main-btn" type="button">
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
                        <label for="adjustmentStartDate" class="form-label cust-label">Start Date</label>
                        <input type="date" class="form-control cust-input-box" id="adjustmentStartDate" value="{{request('StartDate')}}" name="StartDate">
                    </div>
                    {{-- End Date --}}
                    <div class="col-6 col-md-4 col-xl-2 col-xxl-2 mb-2">
                        <label for="adjustmentEndDate" class="form-label cust-label">End Date</label>
                        <input type="date" class="form-control cust-input-box" id="adjustmentEndDate" value="{{request('EndDate')}}" name="EndDate">
                    </div>
                    {{-- Plate No --}}
                    <div class="col-6 col-md-4 col-xl-2 col-xxl-2 mb-2">
                        <label for="adjustmentNo" class="form-label cust-label">Adjustment No</label>
                        <input type="text" class="form-control cust-input-box" id="adjustmentNo" value="{{request('AdjustmentNo')}}" name="AdjustmentNo">
                    </div>
                    {{-- Filter Button --}}
                    <div class="col-10 col-md-9 col-xl-5 col-xxl-4 mb-2 pt-2">
                        <div class="d-flex justify-content-center align-items-center mt-2" style="height: 100%">
                            {{-- Filter Button --}}
                            <button class="btn filter-btn py-1 px-2 px-sm-3"><span class="me-1"><i class="bi bi-funnel"></i></span>Filter</button>
                            {{-- Reset Button --}}
                            <a type="button" href="/stockadjustment/index" class="btn btn-light ms-1 ms-sm-3 py-1 px-2 px-sm-3" id="filterCancel">
                                <span class="me-1"><i class="bi bi-x-circle"></i></span>Reset
                            </a>
                            {{-- Deleted Invoice Button --}}
                            <button type="button" class="btn deleted-invoice py-1 px-2 px-sm-3 ms-1 ms-sm-2 position-relative" data-bs-toggle="modal" data-bs-target="#deletedAdjustment">
                                <span class="me-1"><i class="bi bi-list-ul"></i></span>Deleted Invoice 
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="background-color: #ff0000;">{{count($deletestockadjustments)}}</span>
                           </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    {{-- End of Filter Section --}}

        {{-- Stock Adjustment List --}}

        <div class="row mt-2 justify-content-center">
            @php
                $role = auth()->user()->systemrole->RoleDesc;
            @endphp
            <div class="table-card">
                <table id="stockAdjustmentList" class="table table-striped nowrap">
                    <thead>
                        <tr>
                            <th style="width: 150px !important;">Adjustment No</th>
                            <th style="width: 100px !important;">Adjustment Date</th>
                            <th style="width: 200px !important;">Warehouse</th>
                            <th style="width: 200px !important;">Remark</th>
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
                        @forelse ($stockadjustments as $stockadjustment)
                            <tr>
                                <td>{{$stockadjustment->AdjustmentNo}}</td>
                                <td>{{$stockadjustment->AdjustmentDate}}</td>
                                <td>{{$stockadjustment->Warhouse}}</td>
                                <td>{{$stockadjustment->Remark}}</td>
                                @if ($role == 'admin')
                                    <td>{{ $stockadjustment->CreatedBy }}</td>
                                    <td>{{ $stockadjustment->CreatedDate }}</td>
                                    <td>{{ $stockadjustment->ModifiedBy }}</td>
                                    <td>{{ $stockadjustment->ModifiedDate }}</td>
                                    <td>{{ $stockadjustment->DeletedBy }}</td>
                                    <td>{{ $stockadjustment->DeletedDate }}</td>
                                @endif
                                <td class="text-center">
                                    <a href="/stockadjustment/edit/{{$stockadjustment->AdjustmentNo}}"
                                        class="btn btn-primary py-0 px-1 me-2">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <button class="btn delete-btn py-0 px-1" id="{{$stockadjustment->AdjustmentNo}}"
                                        onclick="PassAdjustmentNo(this.id);" data-bs-toggle="modal"
                                        data-bs-target="#adjustmentDeleteModal">
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

        {{-- End of Stock Adjustment List --}}

        {{-- Adjustment Delete Modal --}}

        <div class="modal fade" id="adjustmentDeleteModal" aria-labelledby="adjustmentDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i>
                        </h1>
                        <p class="text-center">Are you sure?</p>
                        <div class="text-center">
                            <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                            <a href="" id="deleteAdjustBtn" class="btn btn-primary py-1">Sure</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- End of Adjustment Delete Modal --}}

        {{-- Deleted Adjustment Modal --}}

        <div class="modal fade" id="deletedAdjustment" aria-labelledby="deletedAdjustment"
            style="z-index: 99999 !important;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header py-3 bg-aliceblue">
                        <h3 class="section-title">Deleted Adjustment List</h3>
                        <button type="button" class="cust-btn-close rounded-circle" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-width">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 150px !important;">Adjustment No</th>
                                        <th style="width: 100px !important;">Adjustment Date</th>
                                        <th style="width: 200px !important;">Warehouse</th>
                                        <th style="width: 200px !important;">Remark</th>
                                        @if ($role == 'admin')
                                            <th>Created By</th>
                                            <th>Created Date</th>
                                            <th>Modified By</th>
                                            <th>Modified Date</th>
                                            <th>Deleted By</th>
                                            <th>Deleted Date</th>
                                        @endif
                                        <th class="column-sticky last-column-th"></th>
                                        {{-- <th></th> --}}
                                    </tr>
                                </thead>
                                <tbody style="white-space: nowrap;">
                                    @forelse ($deletestockadjustments as $deletestockadjustment)
                                        <tr>
                                            <td>{{$deletestockadjustment->AdjustmentNo}}</td>
                                            <td>{{$deletestockadjustment->AdjustmentDate}}</td>
                                            <td>{{$deletestockadjustment->Warehouse}}</td>
                                            <td>{{$deletestockadjustment->Remark}}</td>
                                            @if ($role == 'admin')
                                                <td>{{ $deletestockadjustment->CreatedBy }}</td>
                                                <td>{{ $deletestockadjustment->CreatedDate }}</td>
                                                <td>{{ $deletestockadjustment->ModifiedBy }}</td>
                                                <td>{{ $deletestockadjustment->ModifiedDate }}</td>
                                                <td>{{ $deletestockadjustment->DeletedBy }}</td>
                                                <td>{{ $deletestockadjustment->DeletedDate }}</td>
                                            @endif
                                            <td class="column-sticky last-column-tb text-center">
                                                <a href="/stockadjustment/restore/{{ $deletestockadjustment->TransferNo }}"
                                                    class="btn btn-primary py-0 px-1 me-2">
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
                </div>
            </div>
        </div>

        {{-- End of Deleted Transfer Modal --}}

    </div>

</x-layout>
