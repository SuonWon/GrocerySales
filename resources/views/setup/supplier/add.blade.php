<x-layout title="Create Supplier">

    <div class="container-fluid content-body mt-3">

    {{-- Section Title --}}

        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="section-title">Create Supplier</h3>
            </div>

            {{-- Back Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/supplier/index" class="btn main-btn">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

    {{-- End of Section Title --}}

    {{-- Generate Id --}}

        {{-- @php
            require app_path('./utils/GenerateId.php');
            $generateid = new GenerateId();
            $id = $generateid->generatePrimaryKeyId('suppliers','SupplierCode','SP-');
        @endphp --}}

    {{-- End of Generate Id --}}
        
    {{-- Form Section --}}

        <form action="/supplier/add" method="POST" enctype="multipart/form-data" class="row form-card mt-3 needs-validation" novalidate>
            @csrf
            <div class="col-12 col-lg-6">
                <div class="row">
                    {{-- Supplier Code --}}
                    
                    {{-- <div class="col-5 col-md-6 col-xl-4 mb-3">
                        <label for="supplierCode" class="form-label cust-label">Supplier Code</label>
                        <input type="text" class="form-control cust-input-box" id="supplierCode" name="SupplierCode" value="{{$id}}" disabled>
                    </div> --}}
                    {{-- Supplier Name --}}
                    <div class="col-12 col-xxl-6 mb-3">
                        <label for="supplierName" class="form-label cust-label">Supplier Name</label>
                        <input type="text" class="form-control cust-input-box" id="supplierName" name="SupplierName" value="" required>
                        <div class="invalid-feedback">
                            Please fill supplier name.
                        </div>
                    </div>
                    {{-- Status --}}
                    <div class="col-2 mb-3">
                        <label class="cust-label form-label text-end" for="supplierIsActive">Status</label>
                        <div class="col-sm-8 form-check form-switch ms-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="supplierIsActive" name="IsActive" checked>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Contact Name --}}
                    <div class="col-12 col-xxl-6 mb-3">
                        <label for="supplierContactName" class="form-label cust-label">Contact Name</label>
                        <input type="text" class="form-control cust-input-box" id="supplierContactName" name="ContactName" value="" required>
                        <div class="invalid-feedback">
                            Please fill supplier's contact name.
                        </div>
                    </div>
                    {{-- Contact No --}}
                    <div class="col-6 mb-3">
                        <label for="supplierContactNo" class="form-label cust-label">Contact No</label>
                        <input type="tel" class="form-control cust-input-box" id="supplierContactNo" name="ContactNo" value="" required>
                        <div class="invalid-feedback">
                            Please fill supplier's contact no.
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Office No --}}
                    <div class="col-6 mb-3">
                        <label for="supplierOfficeNo" class="form-label cust-label cust-label text-end">Office No</label>
                        <input type="tel" class="form-control cust-input-box" id="supplierOfficeNo" name="OfficeNo" value="">
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="row">
                    {{-- Street --}}
                    <div class="col-12 mb-3">
                        <label for="supplierStreet" class="form-label cust-label text-end">Street</label>
                        <input type="text" class="form-control cust-input-box" id="supplierStreet" name="Street" value="">
                    </div>
                </div>
                <div class="row">
                    {{-- Township --}}
                    <div class="col-6 mb-3">
                        <label for="supplierTsp" class="form-label cust-label text-end">Township</label>
                        <input type="text" class="form-control cust-input-box" id="supplierTsp" name="Township" value="">
                    </div>
                    {{-- City --}}
                    <div class="col-6 mb-3">
                        <label for="supplierCity" class="form-label cust-label text-end">City</label>
                        <input type="text" class="form-control cust-input-box" id="supplierCity" name="City" value="">
                    </div>
                </div>
                <div class="row">
                    {{-- Remark --}}
                    <div class="col-12 mb-3">
                        <label for="supplierRemark" class="form-label cust-label text-end">Remark</label>
                        <textarea type="email" class="form-control cust-textarea" id="supplierRemark" name="Remark" rows="3"></textarea>
                    </div>
                </div>
            </div>
            {{-- Save Button --}}
            <div class="row px-0">
                <div class="col-12 px-0 text-end">
                    <button type="submit" class="btn btn-success">
                        <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Save
                    </button>
                </div>
            </div>
        </form>

    {{-- End of Form Section --}}
    
    </div>

</x-layout>