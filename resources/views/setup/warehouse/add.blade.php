<x-layout title="Create Warehouse">

    <div class="container-fluid content-body mt-3">

    {{-- Section Title --}}
    
        <div class="row justify-content-between">

            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Create Warehouse</h3>
            </div>

            {{-- Back Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/warehouse/index" class="btn main-btn">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

    {{-- End of Section Title --}}

    {{-- Generate Id --}}

        {{-- @php
            require app_path('./utils/GenerateId.php');
            $generateid = new GenerateId();
            $id = $generateid->generatePrimaryKeyId('warehouses', 'WarehouseCode', 'WH-');
        @endphp --}}

    {{-- End of Generate Id --}}

    {{-- Form Section --}}

        <form action="/warehouse/add/" method="POST" enctype="multipart/form-data" class="row form-card mt-3 needs-validation" novalidate>
            @csrf
          
            <div class="col-12 col-lg-6">
                <div class="row">
                    {{-- Warehouse Code --}}
                    {{-- <div class="col-12 col-md-4 col-lg-12 col-xl-4 mb-3">
                        <label for="warehouseCode" class="form-label cust-label">Warehouse Code</label>
                        <input type="text" class="form-control cust-input-box" id="warehouseCode" name="WarehouseCode" value="{{$id}}" disabled>
                    </div> --}}
                    {{-- Warehouse Name --}}
                    <div class="col-12 col-md-8 col-lg-12 col-xl-8 mb-3">
                        <label for="warehouseName" class="form-label cust-label">Warehouse Name</label>
                        <input type="text" class="form-control cust-input-box" id="warehouseName" name="WarehouseName" value="" required>
                        <div class="invalid-feedback">
                            Please fill warehouse name.
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Street --}}
                    <div class="col-12 mb-3">
                        <label for="warehouseStreet" class="form-label cust-label">Street</label>
                        <input type="text" class="form-control cust-input-box" id="warehouseStreet" name="Street" value="">
                    </div>
                    
                </div>
                <div class="row">
                    {{-- Township --}}
                    <div class="col-6 col-xl-4 mb-3">
                        <label for="warehouseTsp" class="form-label cust-label">Township</label>
                        <input type="text" class="form-control cust-input-box" id="warehouseTsp" name="Township" value="">
                    </div>
                    {{-- City --}}
                    <div class="col-6 col-xl-4 mb-3">
                        <label for="warehouseCity" class="form-label cust-label">City</label>
                        <input type="text" class="form-control cust-input-box" id="warehouseCity" name="City" value="">
                    </div>
                    {{-- Contact No --}}
                    <div class="col-6 col-xl-4 mb-3">
                        <label for="warehouseContactNo" class="form-label cust-label">Contact No</label>
                        <input type="tel" class="form-control cust-input-box" id="warehouseContactNo" name="ContactNo" value="" required>
                        <div class="invalid-feedback">
                            Please fill contact no.
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Remark --}}
                    <div class="col-12 mb-3">
                        <label for="custRemark" class="form-label cust-label text-end">Remark</label>
                        <textarea type="email" class="form-control cust-textarea" id="custRemark" name="Remark" rows="3"></textarea>
                    </div>
                </div>
                <div class="row">
                    {{-- Save Button --}}
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success py-1">
                            <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Save
                        </button>
                    </div>
                </div>
            </div>
        </form>

    {{-- End of Form Section --}}

    </div>
    
</x-layout>