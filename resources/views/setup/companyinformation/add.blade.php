
<x-layout title="Create_Customer">

    <div class="container-fluid content-body mt-3">

        {{-- Section Title --}}
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="section-title">Create Company</h3>
            </div>
            <div class="col-4 p-0 text-end">
                <a href="/companyinformation/index" class="btn main-btn">
                    <span class="me-2"><i class="bi bi-chevron-double-left"></i></span> Back
                </a>
            </div>
        </div>
        @php
        require app_path('./utils/GenerateId.php');
        $generateid = new GenerateId();
        $id = $generateid->generatePrimaryKeyId('company_information','CompanyCode','CI-');
        @endphp

        <form action="/companyinformation/add" method="POST" enctype="multipart/form-data" class="row form-card mt-3 needs-validation" novalidate>
            @csrf
            
            <div class="col-12 col-lg-9 col-xl-7">
                <input type="hidden" value="{{$id}}" name="CompanyCode">
                <div class="row">
                    <div class="col-12 mb-3 companyImgUpload">
                        <div class="inputImageUpload shadow">
                            <input type="file" accept="image/*" class="inputImage shadow-sm" name="CompanyLogo" id="file" onchange="loadFile(event)" value="" required>
                            <label for="file" class="inputImageLabel @error('CompanyLogo') is-invalid @enderror"><i class="fa-regular fa-beat fa-image sizeImg"></i></label>
                            <img class="uploadImageDisplay" id="output" />
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="CompanyCode" class="form-label cust-label">Company Code</label>
                        <input type="text" class="form-control cust-input-box" id="CompanyCode" name="CompanyCode" value="{{$id}}" disabled>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="UserName" class="form-label cust-label">Company Name</label>
                        <input type="text" class="form-control cust-input-box" id="CompanyName" name="CompanyName" required>
                        <div class="invalid-feedback">
                            Please fill the Company Name.
                        </div>
                    </div>

                    <div class="col-6 mb-3">
                        <label for="userPassword" class="form-label cust-label">Street</label>
                        <input type="text" class="form-control cust-input-box" id="Street" name="Street" required>
                        <div class="invalid-feedback">
                            Please fill the Street.
                        </div>
                    </div>

                    <div class="col-6 mb-3">
                        <label class="cust-label form-label text-end" for="userRole">City</label>
                        <input type="text" class="form-control cust-input-box" name="City" required>
                        <div class="invalid-feedback">
                            Please fill the Office Phone.
                        </div>
                    </div>

                    <div class="col-6 mb-3">
                        <label for="userPassword" class="form-label cust-label">Office Phone</label>
                        <input type="text" class="form-control cust-input-box" id="" name="OfficeNo" required>
                        <div class="invalid-feedback">
                            Please fill the Office Phone.
                        </div>
                    </div>

                    <div class="col-6 mb-3">
                        <label for="" class="form-label cust-label">Hot Line Phone</label>
                        <input type="text" class="form-control cust-input-box" id="" name="HotLineNo" required>
                        <div class="invalid-feedback">
                            Please fill the Hot Line Phone.
                        </div>
                    </div>

                    <!-- <div class="col-12 mb-3">
                        <label class="cust-label form-label text-end" for="userRemark">Remark</label>
                        <textarea name="" id="userRemark" class="form-control cust-textarea" cols="30" rows="3">
                        </textarea>
                    </div> -->
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-success">
                        <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Save
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-layout>

