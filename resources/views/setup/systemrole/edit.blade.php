
<x-layout title="Update Role">

    <div class="container-fluid content-body mt-3">

        {{-- Section Title --}}

        <div class="row justify-content-between">
            <div class="col-3 p-0">
                <h3 class="section-title">Update System Role</h3>
            </div>
            <div class="col-4 p-0 text-end">
                <a href="/systemrole/index" class="btn main-btn">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

        {{-- End of Section Title --}}

        {{-- Form Section --}}

        <form action="/systemrole/update/{{$systemrole->RoleId}}" method="post" enctype="multipart/form-data" class="row form-card mt-3 needs-validation" novalidate>
            @csrf
            <div class="col-12 col-lg-6">
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="RoleId" class="form-label cust-label">Role Id</label>
                        <input type="text" class="form-control cust-input-box" id="RoleId" name="RoleId" value="{{$systemrole->RoleId}}" disabled>
                    </div>

                    <div class="col-6 mb-3">
                        <label for="RoleDesc" class="form-label cust-label">Role Description</label>
                        <input type="text" class="form-control cust-input-box" id="RoleDesc" value="{{$systemrole->RoleDesc}}" name="RoleDesc" required>
                        <div class="invalid-feedback">
                            Please fill the Role Description.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="RolePermissions" class="form-label cust-label">Role Permission</label>
                        <div class="row px-3">

                           

                            <div class="d-flex col-3 mt-1">
                                <input class="form-check-input cust-form-check me-2" name="rolepermissions[]"  {{ in_array('dashboard', $systemrole->RolePermissions) ? 'checked' : '' }} value="dashboard" type="checkbox" id="dashboard">
                                <label class="cust-label" for="dashboard">
                                    Dashboard
                                </label>
                            </div>

                            <div class="d-flex col-3 mt-1">
                                <input class="form-check-input cust-form-check me-2" name="rolepermissions[]"  {{ in_array('setup', $systemrole->RolePermissions) ? 'checked' : '' }} value="setup" type="checkbox" id="setup">
                                <label class="cust-label" for="setup">
                                    Setup
                                </label>
                            </div>
                          
                            
                            <div class="d-flex col-3 mt-1">
                                <input class="form-check-input cust-form-check me-2" type="checkbox" id="system" name="rolepermissions[]" value="system" {{ in_array('system', $systemrole->RolePermissions) ? 'checked' : '' }}>
                                <label class="cust-label" for="system">
                                    System
                                </label>
                            </div>
                            <div class="d-flex col-3 mt-1">
                                <input class="form-check-input cust-form-check me-2" type="checkbox" id="purchase" name="rolepermissions[]" value="purchase" {{ in_array('purchase', $systemrole->RolePermissions) ? 'checked' : '' }}>
                                <label class="cust-label" for="purchase">
                                    Purchase
                                </label>
                            </div>
                            <div class="d-flex col-3 mt-1">
                                <input class="form-check-input cust-form-check me-2" type="checkbox" id="sales" name="rolepermissions[]" value="sales" {{ in_array('sales', $systemrole->RolePermissions) ? 'checked' : '' }}>
                                <label class="cust-label" for="sales">
                                    Sales
                                </label>
                            </div>
                            <div class="d-flex col-3 mt-1">
                                <input class="form-check-input cust-form-check me-2" type="checkbox" value="report" name="rolepermissions[]" id="report" {{ in_array('report', $systemrole->RolePermissions) ? 'checked' : '' }}>
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
                        <label for="roleRemark" class="cust-label form-label">Remark</label>
                        <textarea type="text" class="form-control cust-textarea" id="roleRemark" name="Remark" rows="3">{{ $systemrole->Remark }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-end mt-4">
                        {{-- Update Button --}}
                        <button type="submit" class="btn btn-success py-1">
                            <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Update
                        </button>
                        {{-- Delete Button --}}
                        <button type="button" class="btn delete-btn py-1" id="{{$systemrole->RoleId}}" onclick="PassRoleId(this.id);" data-bs-toggle="modal" data-bs-target="#systemRoleDeleteModal">
                            <span class="me-2"><i class="bi bi-trash-fill"></i></span> Delete
                        </button>
                    </div>
                </div>
            </div>
            
        </form>

        {{-- End of Form Section --}}

        {{-- System Role Delete Modal --}}

        <div class="modal fade" id="systemRoleDeleteModal" aria-labelledby="systemRoleDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i></h1>
                        <x-error name="error"></x-error>
                        <p class="text-center">Are you sure?</p>
                        <div class="text-center">
                            <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                            <a href="" id="deleteRoleBtn" class="btn btn-primary py-1">Sure</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- End of  Delete Modal --}}

    </div>

</x-layout>



