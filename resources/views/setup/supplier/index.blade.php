<x-layout title="Supplier">

    <div class="container-fluid mt-3 content-body">

    {{-- Section Title --}}

        <div class="row justify-content-between">

            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Supplier Lists</h3>
            </div>

            {{-- Create New Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/supplier/add" class="btn main-btn" type="button">
                    <span class="me-1"><i class="bi bi-plus-circle"></i></span>New
                </a>
            </div>
        </div>

    {{-- End of Section Title --}}

    {{-- Supplier List --}}

        <div class="row mt-3 justify-content-center">
            <div class="table-card">
                <table id="supplierList" class="table table-striped nowrap">
                    <thead>
                        <tr>
                            <th style="width: 120px;">Supplier Code</th>
                            <th style="width: 200px;">Supplier Name</th>
                            <th style="width: 200px;">Contact Name</th>
                            <th class="text-end" style="width: 150px">Profit</th>
                            <th style="width: 150px;">Contact No</th>
                            <th style="width: 150px;">Office No</th>
                            <th style="width: 200px;">Street</th>
                            <th style="width: 120px;">Township</th>
                            <th style="width: 120px;">City</th>
                            <th style="width: 200px;">Remark</th>
                            <th style="width: 200px;">Created By</th>
                            <th style="width: 200px;">Created Date</th>
                            <th style="width: 200px;">Modified By</th>
                            <th style="width: 200px;">Modified Date</th>
                            <th style="width: 50px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($suppliers as $supplier)
                            <tr>
                                <td class="text-center">
                                    @if ($supplier->IsActive == 1)
                                        <span class="badge text-bg-success ">{{$supplier->SupplierCode}}</span>
                                    @else
                                        <span class="badge text-bg-danger ">{{$supplier->SupplierCode}}</span>
                                    @endif
                                </td>
                                <td>{{$supplier->SupplierName}}</td>
                                <td>{{$supplier->ContactName}}</td>
                                <td class="text-end">{{$supplier->Profit}}</td>
                                <td>{{$supplier->ContactNo}}</td>
                                <td>{{$supplier->OfficeNo}}</td>
                                <td>{{$supplier->Street}}</td>
                                <td>{{$supplier->Township}}</td>
                                <td>{{$supplier->City}}</td>
                                <td>{{$supplier->Remark}}</td>
                                <td>{{$supplier->CreatedBy}}</td>
                                <td>{{$supplier->CreatedDate}}</td>
                                <td>{{$supplier->ModifiedBy}}</td>
                                <td>{{$supplier->ModifiedDate}}</td>
                                <td class="text-center">
                                    <a href="/supplier/edit/{{$supplier->SupplierCode}}" class="btn btn-primary py-0 px-1 me-2">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <button class="btn delete-btn py-0 px-1" id="{{$supplier->SupplierCode}}" onclick="PassSupplierCode(this.id);" data-bs-toggle="modal" data-bs-target="#supplierDeleteModal">
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

    {{-- End of Supplier List --}}

    {{-- Supplier Delete Modal --}}

        <div class="modal fade" id="supplierDeleteModal" aria-labelledby="supplierDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i></h1>
                        <p class="text-center">Are you sure?</p>
                        <div class="text-center">
                            <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                            <a href="" id="deleteSupplierBtn" class="btn btn-primary py-1">Sure</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- End of Supplier Delete Modal --}}

    </div>

</x-layout>

