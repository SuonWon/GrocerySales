
<x-layout title="Create Role">

    <div class="container-fluid content-body mt-3">

        {{-- Section Title --}}
        <div class="row justify-content-between">
            <div class="col-8 col-md-5 p-0">
                <h3 class="section-title">Create System Role</h3>
            </div>
            <div class="col-4 p-0 text-end">
                <a href="/systemrole/index" class="btn main-btn">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

        <form action="/systemrole/add" method="POST" enctype="multipart/form-data" class="row form-card mt-3 needs-validation" novalidate>
            @csrf
            
            <div class="col-12 col-lg-7 col-xl-6">
                <input type="hidden" value="" name="RoleId">
            
                <div class="row">
                    {{-- <div class="col-6 mb-3">
                        <label for="RoleId" class="form-label cust-label">Role Id</label>
                        <input type="text" class="form-control cust-input-box" id="RoleId" name="RoleId" value="" disabled>
                    </div> --}}
                    <div class="col-6 mb-3">
                        <label for="RoleDesc" class="form-label cust-label">Role Description</label>
                        <input type="text" class="form-control cust-input-box" id="RoleDesc" name="RoleDesc" value="{{old('RoleDesc')}}" required>
                        <div class="invalid-feedback">
                            Please fill the Role Description.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="RolePermissions" class="form-label cust-label">Role Permission</label>
                        <div class="row px-3">
                            <div class="d-flex col-4 col-md-3 col-lg-4 mt-1">
                                <input class="form-check-input cust-form-check me-2" type="checkbox" value="dashboard" name="rolepermissions[]" id="dashboard">
                                <label class="cust-label" for="dashboard">
                                    Dashboard
                                </label>
                            </div>
                            <div class="d-flex col-4 col-md-3 col-lg-4 mt-1">
                                <input class="form-check-input cust-form-check me-2" type="checkbox" value="setup" name="rolepermissions[]" id="setup">
                                <label class="cust-label" for="setup">
                                    Setup
                                </label>
                            </div>
                            <div class="d-flex col-4 col-md-3 col-lg-4 mt-1">
                                <input class="form-check-input cust-form-check me-2" type="checkbox" value="system" name="rolepermissions[]" id="system">
                                <label class="cust-label" for="system">
                                    System
                                </label>
                            </div>
                            <div class="d-flex col-4 col-md-3 col-lg-4 mt-1">
                                <input class="form-check-input cust-form-check me-2" type="checkbox" value="purchase" name="rolepermissions[]" id="purchase">
                                <label class="cust-label" for="purchase">
                                    Purchase
                                </label>
                            </div>
                            <div class="d-flex col-4 col-md-3 col-lg-4 mt-1">
                                <input class="form-check-input cust-form-check me-2" type="checkbox" value="sales" name="rolepermissions[]" id="sales">
                                <label class="cust-label" for="sales">
                                    Sales
                                </label>
                            </div>
                            <div class="d-flex col-4 col-md-3 col-lg-4 mt-1">
                                <input class="form-check-input cust-form-check me-2" type="checkbox" value="report" name="rolepermissions[]" id="report">
                                <label class="cust-label" for="report">
                                    Report
                                </label>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            Please fill the Role Permission.
                        </div>
                    </div>
                    
                    <div class="col-12 mb-3">
                        <label for="roleRemark" class="cust-label form-label text-end">Remark</label><textarea type="text" class="form-control cust-textarea" id="roleRemark" name="Remark" rows="3"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success">
                            <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Save
                        </button>
                    </div>
                </div>
            </div>
            
        </form>
    </div>

</x-layout>

