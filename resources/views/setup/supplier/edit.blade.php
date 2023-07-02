<x-layout title="Update Supplier">

    <div class="container-fluid content-body mt-3">

    {{-- Section Title --}}

        <div class="row justify-content-between">
            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Update Supplier</h3>
            </div>
            {{-- Back Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/supplier/index" class="btn main-btn">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

    {{-- End of Section Title --}}

    {{-- Form Section --}}

        <form action="/supplier/update/{{$supplier->SupplierCode}}" method="POST" enctype="multipart/form-data" class="row form-card mt-3 needs-validation" novalidate>
            @csrf
            <div class="col-12 col-lg-6">
                <div class="row">
                    <input type="hidden" value="{{$supplier->SupplierCode}}" name="SupplierCode">
                    {{-- Supplier Code --}}
                    <div class="col-5 col-md-6 col-xl-4 mb-3">
                        <label for="supplierCode" class="form-label cust-label">Supplier Code</label>
                        <input type="text" class="form-control cust-input-box" id="supplierCode" name="SupplierCode" value="{{$supplier->SupplierCode}}" disabled>
                    </div>
                    {{-- Status --}}
                    <div class="col-2 mb-3">
                        <label class="cust-label form-label text-end" for="supplierIsActive">Status</label>
                        <div class="col-sm-8 form-check form-switch ms-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="supplierIsActive" name="IsActive" {{$supplier->IsActive == "on" ? "checked" : ''}}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Supplier Name --}}
                    <div class="col-12 col-xxl-6 mb-3">
                        <label for="supplierName" class="form-label cust-label">Supplier Name</label>
                        <input type="text" class="form-control cust-input-box" id="supplierName" name="SupplierName" value="{{$supplier->SupplierName}}" required>
                        <div class="invalid-feedback">
                            Please fill supplier name.
                        </div>
                    </div>
                    {{-- Contact Name --}}
                    <div class="col-12 col-xxl-6 mb-3">
                        <label for="supplierContactName" class="form-label cust-label">Contact Name</label>
                        <input type="text" class="form-control cust-input-box" id="supplierContactName" name="ContactName" value="{{$supplier->ContactName}}" required>
                        <div class="invalid-feedback">
                            Please fill supplier's contact name.
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Contact No --}}
                    <div class="col-6 mb-3">
                        <label for="supplierContactNo" class="form-label cust-label">Contact No</label>
                        <input type="tel" class="form-control cust-input-box" id="supplierContactNo" name="ContactNo" value="{{$supplier->ContactNo}}">
                        <div class="invalid-feedback">
                            Please fill supplier's contact no.
                        </div>
                    </div>
                    {{-- Office No --}}
                    <div class="col-6 mb-3">
                        <label for="supplierOfficeNo" class="form-label cust-label cust-label text-end">Office No</label>
                        <input type="tel" class="form-control cust-input-box" id="supplierOfficeNo" name="OfficeNo" value="{{$supplier->OfficeNo}}">
                    </div>
                </div>
                <div class="row">
                    {{-- Street --}}
                    <div class="col-12 mb-3">
                        <label for="supplierStreet" class="form-label cust-label text-end">Street</label>
                        <input type="text" class="form-control cust-input-box" id="supplierStreet" name="Street" value="{{$supplier->Street}}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="row">
                    {{-- Township --}}
                    <div class="col-6 mb-3">
                        <label for="supplierTsp" class="form-label cust-label text-end">Township</label>
                        <input type="text" class="form-control cust-input-box" id="supplierTsp" name="Township" value="{{$supplier->Township}}">
                    </div>
                    {{-- City --}}
                    <div class="col-6 mb-3">
                        <label for="supplierCity" class="form-label cust-label text-end">City</label>
                        <input type="text" class="form-control cust-input-box" id="supplierCity" name="City" value="{{$supplier->City}}">
                    </div>
                </div>
                <div class="row">
                    {{-- Remark --}}
                    <div class="col-12 mb-3">
                        <label for="supplierRemark" class="form-label cust-label text-end">Remark</label>
                        <textarea type="email" class="form-control cust-textarea" id="supplierRemark" name="Remark" rows="3">{{$supplier->Remark}}</textarea>
                    </div>
                </div>
            </div>
            <div class="row px-0">
                <div class="col-12 px-0 text-end">
                    {{-- Update Button --}}
                    <button type="submit" class="btn btn-success py-1">
                        <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Update
                    </button>
                    {{-- Delete Button --}}
                    <button type="button" id="{{$supplier->SupplierCode}}" class="btn delete-btn py-1" onclick="PassSupplierCode(this.id);" data-bs-toggle="modal" data-bs-target="#supplierDeleteModal">
                        <span class="me-2"><i class="bi bi-trash-fill"></i></span> Delete
                    </button>
                </div>
            </div>
        </form>

    {{-- End of Form Section --}}

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