<x-layout title="Stock Damage List">

    <div class="container-fluid mt-2 content-body">

        {{-- Section Title --}}

        <div class="row justify-content-between">

            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Stock Damage List</h3>
            </div>

            {{-- Create New Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/stockdamage/add" class="btn main-btn" type="button">
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
                        <label for="damageNo" class="form-label cust-label">Damage No</label>
                        <input type="text" class="form-control cust-input-box" id="damageNo" value="{{request('DamageNo')}}" name="DamageNo">
                    </div>
                    {{-- Filter Button --}}
                    <div class="col-10 col-md-9 col-xl-5 col-xxl-4 mb-2 pt-2">
                        <div class="d-flex justify-content-center align-items-center mt-2" style="height: 100%">
                            {{-- Filter Button --}}
                            <button class="btn filter-btn py-1 px-2 px-sm-3"><span class="me-1"><i class="bi bi-funnel"></i></span>Filter</button>
                            {{-- Reset Button --}}
                            <a type="button" href="/stockdamage/index" class="btn btn-light ms-1 ms-sm-3 py-1 px-2 px-sm-3" id="filterCancel">
                                <span class="me-1"><i class="bi bi-x-circle"></i></span>Reset
                            </a>
                            {{-- Deleted Invoice Button --}}
                            <button type="button" class="btn deleted-invoice py-1 px-2 px-sm-3 ms-1 ms-sm-2 position-relative" data-bs-toggle="modal" data-bs-target="#deletedTransfer">
                                <span class="me-1"><i class="bi bi-list-ul"></i></span>Deleted Invoice 
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="background-color: #ff0000;">{{count($deletestockdamages)}}</span>
                           </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    {{-- End of Filter Section --}}

        {{-- Damage List --}}

        <div class="row mt-2 justify-content-center">
            @php
                $role = auth()->user()->systemrole->RoleDesc;
            @endphp
            <div class="table-card">
                <table id="stockDamageList" class="table table-striped nowrap">
                    <thead>
                        <tr>
                            <th style="width: 150px !important;">Damage No</th>
                            <th style="width: 100px !important;">Damage Date</th>
                            <th style="width: 200px !important;">Warehouse Name</th>
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
                        @forelse ($stockdamages as $stockdamage)
                            <tr>
                                <td>{{$stockdamage->DamageNo}}</td>
                                <td>{{$stockdamage->DamageDate}}</td>
                                <td>{{$stockdamage->WarehouseName}}</td>
                                <td>{{$stockdamage->Remark}}</td>
                                @if ($role == 'admin')
                                    <td>{{ $stockdamage->CreatedBy }}</td>
                                    <td>{{ $stockdamage->CreatedDate }}</td>
                                    <td>{{ $stockdamage->ModifiedBy }}</td>
                                    <td>{{ $stockdamage->ModifiedDate }}</td>
                                    <td>{{ $stockdamage->DeletedBy }}</td>
                                    <td>{{ $stockdamage->DeletedDate }}</td>
                                @endif
                                <td class="text-center">
                                    <a href="/stockdamage/edit/{{$stockdamage->DamageNo}}"
                                        class="btn btn-primary py-0 px-1 me-2">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <button class="btn delete-btn py-0 px-1" id="{{$stockdamage->DamageNo}}"
                                        onclick="PassDamageNo(this.id);" data-bs-toggle="modal"
                                        data-bs-target="#damageDeleteModal">
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

        {{-- End of Stock Damage List --}}

        {{-- Damage Delete Modal --}}

        <div class="modal fade" id="damageDeleteModal" aria-labelledby="damageDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i>
                        </h1>
                        <p class="text-center">Are you sure?</p>
                        <div class="text-center">
                            <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                            <a href="" id="deleteDamageBtn" class="btn btn-primary py-1">Sure</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- End of Damage Delete Modal --}}

        {{-- Deleted Damage Modal --}}

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
                                        <th style="width: 150px !important;">Damage No</th>
                                        <th style="width: 100px !important;">Damage Date</th>
                                        <th style="width: 200px !important;">Warehouse Name</th>
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
                                    @forelse ($deletestockdamages as $deletestockdamage)
                                        <tr>
                                            <td>{{$deletestockdamage->DamageNo}}</td>
                                            <td>{{$deletestockdamage->DamageDate}}</td>
                                            <td>{{$deletestockdamage->WarehouseName}}</td>
                                            <td>{{$deletestockdamage->Remark}}</td>
                                            @if ($role == 'admin')
                                                <td>{{ $deletestockdamage->CreatedBy }}</td>
                                                <td>{{ $deletestockdamage->CreatedDate }}</td>
                                                <td>{{ $deletestockdamage->ModifiedBy }}</td>
                                                <td>{{ $deletestockdamage->ModifiedDate }}</td>
                                                <td>{{ $deletestockdamage->DeletedBy }}</td>
                                                <td>{{ $deletestockdamage->DeletedDate }}</td>
                                            @endif
                                            <td class="column-sticky last-column-tb text-center">
                                                <a href="/stockdamage/restore/{{ $deletestockdamage->DamageNo }}"
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

        {{-- End of Deleted Damage Modal --}}

    </div>

</x-layout>