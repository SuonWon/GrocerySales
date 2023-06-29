
<x-layout title="Update User">

    <div class="container-fluid content-body mt-3">
        <x-error name="error"></x-error>
        {{-- Section Title --}}

        <div class="row justify-content-between">
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Update User</h3>
            </div>
            <div class="col-4 p-0 text-end">
                <a href="/user/index" class="btn main-btn">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

        {{-- End of Section Title --}}

        {{-- Form Section --}}

        <form action="/user/update/{{$user->Username}}" method="POST" enctype="multipart/form-data" class="row form-card mt-3 needs-validation" novalidate>
            @csrf
            
            <div class="col-12 col-lg-6">

                <div class="row">
                    <div class="col-5 col-md-6 col-xl-5 mb-3">
                        <label for="Username" class="form-label cust-label">User Name</label>
                        <input type="text" class="form-control cust-input-box" id="Username" value="{{$user->Username}}" name="Username" required>
                        <div class="invalid-feedback">
                            Please fill the User Name.
                        </div>
                        <x-error name="Username"></x-error>
                    </div>
                    <div class="col-2 mb-3">
                        <label class="cust-label form-label text-end" for="isActive">Status</label>
                        <div class="col-sm-8 form-check form-switch ms-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="isActive" name="IsActive" {{$user->IsActive == 1 ? "checked": ""}}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-xl-6 mb-3">
                        <label for="Fullname" class="form-label cust-label">Full Name</label>
                        <input type="text" class="form-control cust-input-box" id="Fullname" value="{{$user->Fullname}}" name="Fullname" required>
                        <div class="invalid-feedback">
                            Please fill the Full Name.
                        </div>
                        <x-error name="Fullname"></x-error>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="Password" class="form-label cust-label">Password</label>
                        <input type="password" class="form-control cust-input-box" id="Password"  name="Password">
                        <div class="invalid-feedback">
                            Please fill the Password.
                        </div>
                        <x-error name="Password"></x-error>
                    </div>

                    <div class="col-6 mb-3">
                        <label for="Fullname" class="form-label cust-label">System Role</label>
                        <select name="SystemRole" id="systemRoleList" class="form-select">
                            @forelse ($systemroles as $SystemRole)
                                <option value="{{$SystemRole->RoleId}}" @if ($SystemRole->RoleId == $user->SystemRole)
                                    selected="selected"
                                @endif>{{$SystemRole->RoleDesc}}</option>
                            @empty

                            @endforelse
                        </select>
                        <div class="invalid-feedback">
                            Please fill the  System Role.
                        </div>
                        <x-error name="SystemRole"></x-error>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="cust-label form-label text-end" for="Remark">Remark</label>
                        <textarea name="Remark" id="Remark" class="form-control cust-textarea" rows="3">{{$user->Remark}}</textarea>
                        <x-error name="Remark"></x-error>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-end mt-4">
                        {{-- Update Button --}}
                        <button type="submit" class="btn btn-success py-1">
                            <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Update
                        </button>
                        {{-- Delete Button --}}
                        <button type="button" class="btn delete-btn py-1" id="{{$user->Username}}" onclick="PassUserId(this.id);" data-bs-toggle="modal" data-bs-target="#userDeleteModal">
                            <span class="me-2"><i class="bi bi-trash-fill"></i></span> Delete
                        </button>
                    </div>
                </div>
            </div>
            
        </form>

        {{-- End of Form Section --}}

        {{-- Customer Delete Modal --}}

        <div class="modal fade" id="userDeleteModal" aria-labelledby="userDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i></h1>
                        <p class="text-center">Are you sure?</p>
                        <div class="text-center">
                            <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                            <a href="" id="deleteUserBtn" class="btn btn-primary py-1">Sure</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- End of  Delete Modal --}}

    </div>

</x-layout>

<script>
    dselect(document.querySelector("#systemRoleList"), config);
</script>


