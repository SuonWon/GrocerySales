<x-layout title="Create User">

    <div class="container-fluid content-body mt-3">

        {{-- Section Title --}}
        <div class="row justify-content-between">
            <div class="col-5 p-0">
                <h3 class="section-title">User Create</h3>
            </div>
            <div class="col-4 p-0 text-end">
                <a href="/user/index" class="btn main-btn">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

        <x-error name="Password" ></x-error>

        <form action="/user/add" method="POST" enctype="multipart/form-data" class="row form-card mt-3 needs-validation" autocomplete="off" novalidate>
            @csrf
            <div class="col-12 col-lg-6">

                <div class="row">
                    <div class="col-5 col-md-6 col-xl-5 mb-3">
                        <label for="Username" class="form-label cust-label">User Name</label>
                        <input type="text" class="form-control cust-input-box" id="Username" value="{{old('UserName')}}" name="Username" autocomplete="off" required>
                        <div class="invalid-feedback">
                            Please fill the User Name.
                        </div>
                    </div>
                    <div class="col-2 mb-3">
                        <label class="cust-label form-label text-end" for="isActive">Status</label>
                        <div class="col-sm-8 form-check form-switch ms-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="isActive" name="IsActive" checked>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-xl-6 mb-3">
                        <label for="Fullname" class="form-label cust-label">Full Name</label>
                        <input type="text" class="form-control cust-input-box" value="{{old('Fullname')}}" id="Fullname" name="Fullname" required>
                        <div class="invalid-feedback">
                            Please fill the Full Name.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="Password" class="form-label cust-label">Password</label>
                        <input type="password" class="form-control cust-input-box" id="Password" value="" name="Password" required>
                        <div class="invalid-feedback">
                            Please fill the Password.
                        </div>
                    </div>

                    <div class="col-6 mb-3">
                        <label for="systemRoleList" class="form-label cust-label">System Role</label>
                        <select class="mb-3 form-select" id="systemRoleList" name="SystemRole" required>
                            <option value="" selected disabled>Choose</option>
                            @forelse ($systemroles as $SystemRole)
                                <option value="{{$SystemRole->RoleId}}" @if(old('SystemRole') == $SystemRole->RoleId) selected @endif>{{$SystemRole->RoleDesc}}</option>
                            @empty

                            @endforelse
                        </select>
                        <div class="invalid-feedback">
                            Please fill the  System Role.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="cust-label form-label text-end" for="Remark">Remark</label>
                        <textarea name="Remark" id="Remark" value="" class="form-control cust-textarea" rows="3">
                        </textarea>
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

<script>
    dselect(document.querySelector("#systemRoleList"), config);
</script>