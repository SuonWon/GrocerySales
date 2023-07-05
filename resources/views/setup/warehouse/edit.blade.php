<x-layout title="Update Warehouse">

    <div class="container-fluid content-body mt-3">

    {{-- Section Title --}}

        <div class="row justify-content-between">

            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Update Warehouse</h3>
            </div>

            {{-- Back Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/warehouse/index" class="btn main-btn">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>

        </div>

    {{-- End of Section Title --}}

    {{-- Form Section --}}

        <form action="/warehouse/update/{{$warehouse->WarehouseCode}}" method="POST" enctype="multipart/form-data" class="row form-card mt-3 needs-validation" novalidate>
            @csrf
            <div class="col-12 col-lg-6">
                <div class="row">
                    {{-- Warehouse Code --}}
                    <div class="col-12 col-md-4 col-lg-12 col-xl-4 mb-3">
                        <label for="warehouseCode" class="form-label cust-label">Warehouse Code</label>
                        <input type="text" class="form-control cust-input-box" id="warehouseCode" name="WarehouseCode" value="{{$warehouse->WarehouseCode}}" disabled>
                    </div>
                    {{-- Warehouse Name --}}
                    <div class="col-12 col-md-8 col-lg-12 col-xl-8 mb-3">
                        <label for="custName" class="form-label cust-label">Warehouse Name</label>
                        <input type="text" class="form-control cust-input-box" id="custName" name="WarehouseName" value="{{$warehouse->WarehouseName}}" required>
                        <div class="invalid-feedback">
                            Please fill warehouse name.
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Street --}}
                    <div class="col-12 mb-3">
                        <label for="warehouseStreet" class="form-label cust-label">Street</label>
                        <input type="text" class="form-control cust-input-box" id="warehouseStreet" name="Street" value="{{$warehouse->Street}}">
                    </div>
                </div>
                <div class="row">
                    {{-- Township --}}
                    <div class="col-6 col-xl-4 mb-3">
                        <label for="warehouseTsp" class="form-label cust-label">Township</label>
                        <input type="text" class="form-control cust-input-box" id="warehouseTsp" name="Township" value="{{$warehouse->Township}}">
                    </div>
                    {{-- City --}}
                    <div class="col-6 col-xl-4 mb-3">
                        <label for="warehouseCity" class="form-label cust-label">City</label>
                        <input type="text" class="form-control cust-input-box" id="warehouseCity" name="City" value="{{$warehouse->City}}">
                    </div>
                    {{-- Contact No --}}
                    <div class="col-6 col-xl-4 mb-3">
                        <label for="warehouseContactNo" class="form-label cust-label">Contact No</label>
                        <input type="tel" class="form-control cust-input-box" id="warehouseContactNo" name="ContactNo" value="{{$warehouse->ContactNo}}" required>
                        <div class="invalid-feedback">
                            Please fill contact no.
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Remark --}}
                    <div class="col-12 mb-3">
                        <label for="custRemark" class="form-label cust-label text-end">Remark</label>
                        <textarea type="email" class="form-control cust-textarea" id="custRemark" name="custRemark" rows="3">{{$warehouse->Remark}}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        {{-- Update Button --}}
                        <button type="submit" class="btn btn-success py-1">
                            <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Update
                        </button>
                        {{-- Delete Button --}}
                        <button type="button" id="{{$warehouse->WarehouseCode}}" class="btn btn-danger py-1" onclick="PassWarehouseCode(this.id);" data-bs-toggle="modal" data-bs-target="#warehouseDeleteModal">
                            <span class="me-2"><i class="bi bi-trash-fill"></i></span> Delete
                        </button>
                    </div>
                </div>
            </div> 
        </form>

    {{-- End of Form Section --}}

    {{-- Customer Delete Modal --}}

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

    {{-- End of Customer Delete Modal --}}

    </div>
    
</x-layout>