<x-layout title="Create_Customer">

    <div class="container-fluid content-body mt-3">

    {{-- Section Title --}}

        <div class="row justify-content-between">
            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Create Customer</h3>
            </div>
            {{-- Back Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/customer/index" class="btn main-btn">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

    {{-- End of Section Title --}}

    {{-- Generate Id --}}
        {{-- @php
            require app_path('./utils/GenerateId.php');
            $generateid = new GenerateId();
            $id = $generateid->generatePrimaryKeyId('customers','CustomerCode','CS-');
        @endphp --}}
    {{-- End of Generate Id --}}
        
    {{-- Form Section --}}

        <x-error name="Email"></x-error>

        <form action="/customer/add" method="POST" enctype="multipart/form-data" class="row form-card mt-3 needs-validation" novalidate>
            @csrf
            <div class="col-12 col-lg-6">
                
                <div class="row">
                    {{-- Customer Name --}}
                    <div class="col-12 col-xl-6 mb-3">
                        <label for="CustomerName" class="form-label cust-label">Customer Name</label>
                        <input type="text" class="form-control cust-input-box" id="CustomerName" name="CustomerName" value="{{old('CustomerName')}}" required>
                        <div class="invalid-feedback">
                            Please fill customer name.
                        </div>
                    </div>
                    {{-- Customer Code --}}
                    {{-- <div class="col-5 col-md-6 col-xl-4 mb-3">
                        <label for="custCode" class="form-label cust-label">Customer Code</label>
                        <input type="text" class="form-control cust-input-box" id="custCode" name="CustomerCode" value="{{$id}}" disabled>
                    </div> --}}
                    {{-- Status --}}
                    <div class="col-2 mb-3">
                        <label class="cust-label form-label text-end" for="isActive">Status</label>
                        <div class="col-sm-8 form-check form-switch ms-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="isActive" name="IsActive" checked>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Company Name --}}
                    <div class="col-12 col-xl-6 mb-3">
                        <label for="custCompanyName" class="form-label cust-label">Company Name</label>
                        <input type="text" class="form-control cust-input-box" id="custCompanyName" name="CompanyName">
                    </div>
                    {{-- NRC No --}}
                    <div class="col-6 mb-3">
                        <label for="custNRC" class="form-label cust-label">NRC No</label>
                        <input type="text" class="form-control cust-input-box" id="custNRC" name="NRCNo">
                        <div class="invalid-feedback">
                            Please fill NRC No.
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Contact No --}}
                    <div class="col-6 mb-3">
                        <label for="custContactNo" class="form-label cust-label">Contact No</label>
                        <input type="tel" class="form-control cust-input-box" id="custContactNo" name="ContactNo">
                        <div class="invalid-feedback">
                            Please fill contact no.
                        </div>
                    </div>
                    {{-- Office No --}}
                    <div class="col-6 col-lg-6 mb-3">
                        <label for="custOfficeNo" class="form-label cust-label cust-label text-end">Office No</label>
                        <input type="tel" class="form-control cust-input-box" id="custOfficeNo" name="OfficeNo">
                    </div>
                </div>
                <div class="row">
                    {{-- Fax No --}}
                    <div class="col-6 col-lg-6 mb-3">
                        <label for="custFaxNo" class="form-label cust-label text-end">Fax No</label>
                        <input type="tel" class="form-control cust-input-box" id="custFaxNo" name="FaxNo">
                    </div>
                </div>
                
            </div>
            <div class="col-12 col-lg-6">
                <div class="row">
                    {{-- Email --}}
                    <div class="col-12 col-xl-6 mb-3">
                        <label for="custEmail" class="form-label cust-label text-end">Email</label>
                        <input type="text" class="form-control cust-input-box" id="custEmail" name="Email" >
                        <div class="invalid-feedback">
                            Please fill email address.
                        </div>
                    </div>
                    {{-- Street --}}
                    <div class="col-12 col-xl-6 mb-3">
                        <label for="custStreet" class="form-label cust-label text-end">Street</label>
                        <input type="text" class="form-control cust-input-box" id="custStreet" name="Street">
                    </div>
                </div>
                <div class="row">
                    {{-- City --}}
                    <div class="col-6 mb-3">
                        <label for="custCity" class="form-label cust-label text-end">City</label>
                        <input type="text" class="form-control cust-input-box" id="custCity" name="City">
                    </div>
                    {{-- Region --}}
                    <div class="col-6 mb-3">
                        <label for="custRegion" class="form-label cust-label text-end">Region</label>
                        <input type="text" class="form-control cust-input-box" id="custRegion" name="Region">
                    </div>
                </div>
                <div class="row">
                    {{-- Remark --}}
                    <div class="col-12 mb-3">
                        <label for="custRemark" class="form-label cust-label text-end">Remark</label>
                        <textarea type="email" class="form-control cust-textarea" id="custRemark" name="Remark" rows="3"></textarea>
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
    
    {{-- End of form Section --}}

    </div>

</x-layout>