<x-layout title="Warehouse">

    <div class="container-fluid mt-3 content-body">

    {{-- Section Title --}}

        <div class="row justify-content-between">

            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Warehouse Lists</h3>
            </div>

            {{-- Create New Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/warehouse/add" class="btn main-btn" type="button">
                    <span class="me-1"><i class="bi bi-plus-circle"></i></span>New
                </a>
            </div>

        </div>

    {{-- End of Section Title --}}

    {{-- Warehouse List --}}

        <div class="row mt-3 justify-content-center">
            <div class="table-card">
                <table id="warehouseList" class="table table-striped nowrap">
                    <thead>
                        <tr>
                            <th style="width: 150px !important;">Warehouse Code</th>
                            <th style="width: 200px !important;">Warehouse Name</th>
                            <th style="width: 250px !important;">Street</th>
                            <th style="width: 150px !important;">Township</th>
                            <th style="width: 150px !important;">City</th>
                            <th style="width: 150px !important;">Contact No</th>
                            <th style="width: 150px !important;">Created Date</th>
                            <th style="width: 150px !important;">Created By</th>
                            <th style="width: 150px !important;">Modified By</th>
                            <th style="width: 150px !important;">Modified Date</th>
                            <th style="width: 300px !important;">Remark</th>
                            <th style="width: 50px !important;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($warehouses as $warehouse)
                        <tr>
                            <td>{{$warehouse->WarehouseCode}}</td>
                            <td>{{$warehouse->WarehouseName}}</td>
                            <td>{{$warehouse->Street}}</td>
                            <td>{{$warehouse->Township}}</td>
                            <td>{{$warehouse->City}}</td>
                            <td>{{$warehouse->ContactNo}}</td>
                            <td>{{$warehouse->CreatedBy}}</td>
                            <td>{{$warehouse->CreatedDate}}</td>
                            <td>{{$warehouse->ModifiedBy}}</td>
                            <td>{{$warehouse->ModifiedDate}}</td>
                            <td>{{$warehouse->Remark}}</td>
                            <td class="text-center">
                                <a href="/warehouse/edit/{{$warehouse->WarehouseCode}}" class="btn btn-primary py-0 px-1 me-2">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <button class="btn delete-btn py-0 px-1" id="{{$warehouse->WarehouseCode}}" onclick="PassWarehouseCode(this.id);" data-bs-toggle="modal" data-bs-target="#warehouseDeleteModal">
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

    {{-- End of Warehouse List --}}

    {{-- Warehouse Delete Modal Dialog --}}

        <div class="modal fade" id="warehouseDeleteModal" aria-labelledby="warehouseDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i></h1>
                        <p class="text-center">Are you sure?</p>
                        <div class="text-center">
                            <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                            <a href="" id="deleteWarehouseBtn" class="btn btn-primary py-1">Sure</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- End of Warehouse Delete Modal Dialog --}}

    </div>

</x-layout>