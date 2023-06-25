<x-layout title="Edit Company Info">

    <div class="container-fluid content-body mt-3">

        {{-- Section Title --}}

        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="section-title">Company Info</h3>
            </div>
            {{-- <div class="col-4 p-0 text-end">
                <a href="/companyinformation/index" class="btn main-btn">
                    <span class="me-2"><i class="bi bi-chevron-double-left"></i></span> Back
                </a>
            </div> --}}
        </div>

        {{-- End of Section Title --}}

        {{-- Form Section --}}

        <form action="/companyinformation/update/{{$companyinformation->CompanyCode}}" method="post" enctype="multipart/form-data" class="row form-card mt-3 needs-validation" novalidate>
            @csrf
            <div class="col-12 col-lg-9 col-xl-7">
                <div class="row">
                    <div class="col-12 mb-3 companyImgUpload">
                        <div class="inputImageUpload shadow">
                            <input type="file" accept="image/*" class="inputImage shadow-sm" name="CompanyLogo" id="file" onchange="loadFile(event)">
                            <label for="file" class="inputImageLabelEdit"><i class="fa-regular fa-beat fa-image sizeImg"></i></label>
                            <img class="uploadImageDisplayEdit" id="output"  src='{{ asset($companyinformation->CompanyLogo) }}'/>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="CompanyCode" class="form-label cust-label">Company Code</label>
                        <input type="text" class="form-control cust-input-box" id="CompanyCode" name="CompanyCode" value="{{$companyinformation->CompanyCode}}" disabled>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="UserName" class="form-label cust-label">Company Name</label>
                        <input type="text" class="form-control cust-input-box" id="CompanyName" name="CompanyName" value="{{$companyinformation->CompanyName}}" required>
                        <div class="invalid-feedback">
                            Please fill Company name.
                        </div>
                    </div>

                    <div class="col-6 mb-3">
                        <label for="userPassword" class="form-label cust-label">Street</label>
                        <input type="text" class="form-control cust-input-box" id="Street" name="Street" value="{{$companyinformation->Street}}" required>
                        <div class="invalid-feedback">
                            Please fill the Street.
                        </div>
                    </div>

                    <div class="col-6 mb-3">
                        <label class="cust-label form-label text-end" for="userRole">City</label>
                        <input type="text" class="form-control cust-input-box" value="{{ $companyinformation->City }}" name="City" required>
                        <div class="invalid-feedback">
                            Please fill the Office Phone.
                        </div>
                    </div>

                    <div class="col-6 mb-3">
                        <label for="userPassword" class="form-label cust-label">Office Phone</label>
                        <input type="text" class="form-control cust-input-box" id="" name="OfficeNo" value="{{$companyinformation->OfficeNo}}" required>
                        <div class="invalid-feedback">
                            Please fill the Office Phone.
                        </div>
                    </div>

                    <div class="col-6 mb-3">
                        <label for="" class="form-label cust-label">Hot Line Phone</label>
                        <input type="text" class="form-control cust-input-box" id="" name="HotLineNo" value="{{$companyinformation->HotLineNo}}" required>
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
                    {{-- Update Button --}}
                    <button type="submit" class="btn btn-primary py-1">
                        <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Save
                    </button>
                    {{-- Delete Button --}}
                    {{-- <button type="button" id="{{$companyinformation->CompanyCode}}" class="btn delete-btn py-1" data-bs-toggle="modal" data-bs-target="#companyDeleteModal" onclick="PassCompanyCode(this.id)">
                        <span class="me-2"><i class="bi bi-trash-fill"></i></span> Delete
                    </button> --}}
                </div>
            </div>
        </form>

        {{-- End of Form Section --}}

        {{-- Company Delete Modal --}}

        <div class="modal fade" id="companyDeleteModal" aria-labelledby="companyDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i></h1>
                        <p class="text-center">Are you sure?</p>
                        <div class="text-center">
                            <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                            <a href="" id="deleteCompanyBtn" class="btn btn-primary py-1">Sure</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- End of Customer Delete Modal --}}
    </div>

</x-layout>



