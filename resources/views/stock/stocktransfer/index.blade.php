<x-layout title="Stock Transfer List">

    <div class="container-fluid mt-2 content-body">

        {{-- Section Title --}}

        <div class="row justify-content-between">

            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Stock Transfer List</h3>
            </div>

            {{-- Create New Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/stocktransfer/add/" class="btn main-btn" type="button">
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
                        <label for="transferStartedDate" class="form-label cust-label">Start Date</label>
                        <input type="date" class="form-control cust-input-box" id="transferStartedDate" value="{{request('StartDate')}}" name="StartDate">
                    </div>
                    {{-- End Date --}}
                    <div class="col-6 col-md-4 col-xl-2 col-xxl-2 mb-2">
                        <label for="transferEndDate" class="form-label cust-label">End Date</label>
                        <input type="date" class="form-control cust-input-box" id="transferEndDate" value="{{request('EndDate')}}" name="EndDate">
                    </div>
                    {{-- Plate No --}}
                    <div class="col-6 col-md-4 col-xl-2 col-xxl-2 mb-2">
                        <label for="transferNo" class="form-label cust-label">Transfer No</label>
                        <input type="text" class="form-control cust-input-box" id="transferNo" value="{{request('TransferNo')}}" name="TransferNo">
                    </div>
                    {{-- Filter Button --}}
                    <div class="col-10 col-md-9 col-xl-5 col-xxl-4 mb-2 pt-2">
                        <div class="d-flex justify-content-center align-items-center mt-2" style="height: 100%">
                            {{-- Filter Button --}}
                            <button class="btn filter-btn py-1 px-2 px-sm-3"><span class="me-1"><i class="bi bi-funnel"></i></span>Filter</button>
                            {{-- Reset Button --}}
                            <a type="button" href="/stocktransfer/index" class="btn btn-light ms-1 ms-sm-3 py-1 px-2 px-sm-3" id="filterCancel">
                                <span class="me-1"><i class="bi bi-x-circle"></i></span>Reset
                            </a>
                            {{-- Deleted Invoice Button --}}
                            <button type="button" class="btn deleted-invoice py-1 px-2 px-sm-3 ms-1 ms-sm-2 position-relative" data-bs-toggle="modal" data-bs-target="#deletedTransfer">
                                <span class="me-1"><i class="bi bi-list-ul"></i></span>Deleted Invoice 
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="background-color: #ff0000;">{{count($deletestocktransfers)}}</span>
                           </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    {{-- End of Filter Section --}}

        {{-- Stock Transfer List --}}

        <div class="row mt-2 justify-content-center">
            @php
                $role = auth()->user()->systemrole->RoleDesc;
            @endphp
            <div class="table-card">
                <table id="stockTransferList" class="table table-striped nowrap">
                    <thead>
                        <tr>
                            <th style="width: 150px !important;">Transfer No</th>
                            <th style="width: 100px !important;">Transfer Date</th>
                            <th style="width: 200px !important;">From Warehouse</th>
                            <th style="width: 200px !important;">To Warehouse</th>
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
                        @forelse ($stocktransfers as $stocktransfer)
                            <tr>
                                <td>{{$stocktransfer->TransferNo}}</td>
                                <td>{{$stocktransfer->TransferDate}}</td>
                                <td>{{$stocktransfer->FromWarehouse}}</td>
                                <td>{{$stocktransfer->ToWarehouse}}</td>
                                <td>{{$stocktransfer->Remark}}</td>
                                @if ($role == 'admin')
                                    <td>{{ $stocktransfer->CreatedBy }}</td>
                                    <td>{{ $stocktransfer->CreatedDate }}</td>
                                    <td>{{ $stocktransfer->ModifiedBy }}</td>
                                    <td>{{ $stocktransfer->ModifiedDate }}</td>
                                    <td>{{ $stocktransfer->DeletedBy }}</td>
                                    <td>{{ $stocktransfer->DeletedDate }}</td>
                                @endif
                                <td class="text-center">
                                    <a href="/stocktransfer/edit/{{$stocktransfer->TransferNo}}"
                                        class="btn btn-primary py-0 px-1 me-2">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <button class="btn delete-btn py-0 px-1" id="{{$stocktransfer->TransferNo}}"
                                        onclick="PassTransferNo(this.id);" data-bs-toggle="modal"
                                        data-bs-target="#transferDeleteModal">
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

        {{-- End of Stock Transfer List --}}

        {{-- Transfer Delete Modal --}}

        <div class="modal fade" id="transferDeleteModal" aria-labelledby="transferDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i>
                        </h1>
                        <p class="text-center">Are you sure?</p>
                        <div class="text-center">
                            <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                            <a href="" id="deleteTransferBtn" class="btn btn-primary py-1">Sure</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- End of Transfer Delete Modal --}}

        {{-- Deleted Transfer Modal --}}

        <div class="modal fade" id="deletedTransfer" aria-labelledby="deletedTransfer"
            style="z-index: 99999 !important;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header py-3 bg-aliceblue">
                        <h3 class="section-title">Deleted Transfer List</h3>
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
                                        <th style="width: 150px !important;">Transfer No</th>
                                        <th style="width: 100px !important;">Transfer Date</th>
                                        <th style="width: 200px !important;">From Warehouse</th>
                                        <th style="width: 200px !important;">To Warehouse</th>
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
                                    @forelse ($deletestocktransfers as $deletestocktransfer)
                                        <tr>
                                            <td>{{$deletestocktransfer->TransferNo}}</td>
                                            <td>{{$deletestocktransfer->TransferDate}}</td>
                                            <td>{{$deletestocktransfer->FromWarehouse}}</td>
                                            <td>{{$deletestocktransfer->ToWarehouse}}</td>
                                            <td>{{$deletestocktransfer->Remark}}</td>
                                            @if ($role == 'admin')
                                                <td>{{ $deletestocktransfer->CreatedBy }}</td>
                                                <td>{{ $deletestocktransfer->CreatedDate }}</td>
                                                <td>{{ $deletestocktransfer->ModifiedBy }}</td>
                                                <td>{{ $deletestocktransfer->ModifiedDate }}</td>
                                                <td>{{ $deletestocktransfer->DeletedBy }}</td>
                                                <td>{{ $deletestocktransfer->DeletedDate }}</td>
                                            @endif
                                            <td class="column-sticky last-column-tb text-center">
                                                <a href="/stocktransfer/restore/{{ $deletestocktransfer->TransferNo }}"
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
