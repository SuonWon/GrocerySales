<x-layout title="customer_edit">

    <div class="container-fluid content-body mt-3">

    {{-- Section Title --}}

        <div class="row justify-content-between">
            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Update Customer</h3>
            </div>
            {{-- Back Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/customer/index" class="btn main-btn">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

    {{-- End of Section Title --}}

    {{-- Form Section --}}

        <form action="/customer/update/{{$customer->CustomerCode}}" method="POST" enctype="multipart/form-data" class="row form-card mt-3 needs-validation" novalidate>
            @csrf
            <div class="col-12 col-lg-6">
                <div class="row">
                    {{-- Customer Code --}}
                    <div class="col-5 col-md-6 col-xl-4 mb-3">
                        <label for="custCode" class="form-label cust-label">Customer Code</label>
                        <input type="text" class="form-control cust-input-box" id="custCode" name="custCode" value="{{$customer->CustomerCode}}" disabled>
                    </div>
                    {{-- Status --}}
                    <div class="col-2 mb-3">
                        <label class="cust-label form-label text-end" for="isActive">Status</label>
                        <div class="col-sm-8 form-check form-switch ms-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="isActive" name="IsActive" {{$customer->IsActive == "on" ? "checked" : ''}}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Customer Name --}}
                    <div class="col-12 col-xxl-6 mb-3">
                        <label for="custName" class="form-label cust-label">Customer Name</label>
                        <input type="text" class="form-control cust-input-box" id="custName" name="CustomerName" value="{{$customer->CustomerName}}" required>
                        <div class="invalid-feedback">
                            Please fill customer name.
                        </div>
                    </div>
                    {{-- Company Name --}}
                    <div class="col-12 col-xxl-6 mb-3">
                        <label for="custCompanyName" class="form-label cust-label">Company Name</label>
                        <input type="text" class="form-control cust-input-box" id="custCompanyName" name="CompanyName" value="{{$customer->CompanyName}}">
                    </div>
                </div>
                <div class="row">
                    {{-- NRC No --}}
                    <div class="col-6 mb-3">
                        <label for="custNRC" class="form-label cust-label">NRC No</label>
                        <input type="text" class="form-control cust-input-box" id="custNRC" name="NRCNo" value="{{$customer->NRCNo}}" >
                        <div class="invalid-feedback">
                            Please fill NRC no.
                        </div>
                    </div>
                    {{-- Contact No --}}
                    <div class="col-6 mb-3">
                        <label for="custContactNo" class="form-label cust-label">Contact No</label>
                        <input type="tel" class="form-control cust-input-box" id="custContactNo" name="ContactNo" value="{{$customer->ContactNo}}" >
                        <div class="invalid-feedback">
                            Please fill contact no.
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Office No --}}
                    <div class="col-6 col-lg-6 mb-3">
                        <label for="custOfficeNo" class="form-label cust-label cust-label text-end">Office No</label>
                        <input type="tel" class="form-control cust-input-box" id="custOfficeNo" name="OfficeNo" value="{{$customer->OfficeNo}}">
                    </div>
                    {{-- Fax No --}}
                    <div class="col-6 col-lg-6 mb-3">
                        <label for="custFaxNo" class="form-label cust-label text-end">Fax No</label>
                        <input type="tel" class="form-control cust-input-box" id="custFaxNo" name="FaxNo" value="{{$customer->FaxNo}}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="row">
                    {{-- Email --}}
                    <div class="col-12 col-xl-6 mb-3">
                        <label for="custEmail" class="form-label cust-label text-end">Email</label>
                        <input type="email" class="form-control cust-input-box" id="custEmail" name="Email" value="{{$customer->Email}}" >
                        <div class="invalid-feedback">
                            Please fill email address.
                        </div>
                    </div>
                    {{-- Street --}}
                    <div class="col-12 col-xl-6 mb-3">
                        <label for="custStreet" class="form-label cust-label text-end">Street</label>
                        <input type="text" class="form-control cust-input-box" id="custStreet" name="Street" value="{{$customer->Street}}">
                    </div>
                </div>
                <div class="row">
                    {{-- City --}}
                    <div class="col-6 mb-3">
                        <label for="custCity" class="form-label cust-label text-end">City</label>
                        <input type="text" class="form-control cust-input-box" id="custCity" name="City" value="{{$customer->City}}">
                    </div>
                    {{-- Region --}}
                    <div class="col-6 mb-3">
                        <label for="custRegion" class="form-label cust-label text-end">Region</label>
                        <input type="text" class="form-control cust-input-box" id="custRegion" name="Region" value="{{$customer->Region}}">
                    </div>
                </div>
                <div class="row">
                    {{-- Remark --}}
                    <div class="col-12 mb-3">
                        <label for="custRemark" class="form-label cust-label text-end">Remark</label>
                        <textarea type="email" class="form-control cust-textarea" id="custRemark" name="Remark" rows="3">{{$customer->Remark}}</textarea>
                    </div>
                </div>
            </div>
            <div class="row px-0">
                <div class="col-12 px-0 text-end">
                    {{-- Update Button --}}
                    <button type="submit" class="btn btn-success">
                        <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Update
                    </button>
                    {{-- Delete Button --}}
                    <button type="button" id="{{$customer->CustomerCode}}" class="btn btn-danger" onclick="PassCustomerCode(this.id);" data-bs-toggle="modal" data-bs-target="#customerDeleteModal">
                        <span class="me-2"><i class="bi bi-trash-fill"></i></span> Delete
                    </button>
                </div>
            </div>
        </form>

    {{-- End of Form Section --}}

    {{-- Customer Delete Modal --}}

        <div class="modal fade" id="customerDeleteModal" aria-labelledby="customerDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i></h1>
                        <p class="text-center">Are you sure?</p>
                        <div class="text-center">
                            <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                            <a href="" id="deleteCustBtn" class="btn btn-primary py-1">Sure</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- End of Customer Delete Modal --}}

    </div>
    
</x-layout>

{{-- <x-layout title="Edit Customer">


    <h1>Update current customer</h1>

    <form action="/customer/update/{{$customer->CustomerCode}}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="customername">Customername</label>
            <input type="text" value="{{$customer->CustomerName}}" name="CustomerName" id="customername">
            <x-error name="CustomerName"></x-error>
        </div>

        <div class="form-group">
            <label for="NRCNo">NRCNo</label>
            <input type="text" value="{{$customer->NRCNo}}" name="NRCNo" id="NRCNo">
        </div>

        <div class="form-group">
            <label for="CompanyName">CompanyName</label>
            <input type="text" value="{{$customer->CompanyName}}" name="CompanyName" id="CompanyName">
        </div>

        <div class="form-group">
            <label for="Street">Street</label>
            <input type="text" value="{{$customer->Street}}" name="Street" id="Street">
        </div>

        <div class="form-group">
            <label for="City">City</label>
            <input type="text" value="{{$customer->City}}" name="City" id="City">
        </div>

        <div class="form-group">
            <label for="Region">Region</label>
            <input type="text" value="{{$customer->Region}}" name="Region" id="Region">
        </div>


        <div class="form-group">
            <label for="ContactNo">ContactNo</label>
            <input type="text" value="{{$customer->ContactNo}}" name="ContactNo" id="ContactNo">
        </div>

        <div class="form-group">
            <label for="OfficeNo">OfficeNo</label>
            <input type="text" value="{{$customer->OfficeNo}}" name="OfficeNo" id="OfficeNo">
        </div>

        <div class="form-group">
            <label for="FaxNo">FaxNo</label>
            <input type="text" value="{{$customer->FaxNo}}" name="FaxNo" id="FaxNo">
        </div>

        <div class="form-group">
            <label for="Email">Email</label>
            <input type="email" value="{{$customer->Email}}" name="Email" id="Email">
            <x-error name="Email"></x-error>
        </div>

        <div class="form-group">
            <label>IsActive</label>
            @if ($customer->IsActive == "Active")
                <input class="form-check-input" type="radio" value="1" checked name="IsActive" id="IsActive1">
                <label for="isActive1">Active</label>
                <input class="form-check-input" type="radio" value="0" name="IsActive" id="IsActive2">
                <label for="isActive2">InActive</label>
            @else
                <input class="form-check-input" type="radio" value="1"  name="IsActive" id="IsActive1">
                <label for="isActive1">Active</label>
                <input class="form-check-input" type="radio" value="0" checked name="IsActive" id="IsActive2">
                <label for="isActive2">InActive</label>
            @endif
        </div>

        <div class="form-group">
            <label for="Remark">Remark</label>
            <textarea name="Remark" id="Remark" cols="10" rows="1">{{$customer->Remark}}</textarea>
        </div>

        <div class="form-group">
            <button type="submit" value="Update">Submit</button>
        </div>
        
    </form>

</x-layout> --}}