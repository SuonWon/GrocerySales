<x-layout title="Users">

    <div class="container-fluid mt-3 content-body">

        {{-- Section Title --}}

        <div class="row justify-content-between">
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">User  Lists</h3>
            </div>

            {{-- Create New Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/user/add" class="btn main-btn" type="button">
                    <span class="me-1"><i class="bi bi-plus-circle"></i></span>Add
                </a>
            </div>
        </div>

        {{-- End of Section Title --}}

        {{-- Customer List --}}

        <div class="row mt-3 justify-content-center">
            <div class="table-card">
                <table id="userList" class="table table-striped nowrap">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 200px !important;">User Name</th>
                            <th style="width: 200px !important;">Full Name</th>
                            <th style="width: 200px !important;">System Role</th>
                            <th style="width: 150px !important;">Created By</th>
                            <th style="width: 150px !important;">Created Date</th>
                            <th style="width: 150px !important;">Modified By</th>
                            <th style="width: 150px !important;">Modified Date</th>
                            <th style="width: 300px !important;">Remark</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="text-center">
                                    @if ($user->IsActive == 1)
                                        <span class="badge text-bg-success ">{{$user->Username}}</span>
                                    @else
                                        <span class="badge text-bg-danger ">{{$user->Username}}</span>
                                    @endif
                                </td>
                                <td>{{$user->Fullname}}</td>
                                <td>{{$user->RoleDesc}}</td>
                                <td>{{$user->CreatedBy}}</td>
                                <td>{{$user->CreatedDate}}</td>
                                <td>{{$user->ModifiedBy}}</td>
                                <td>{{$user->ModifiedDate}}</td>
                                <th>{{$user->Remark}}</th>
                                <td class="text-center">
                                    <a href="/user/edit/{{$user->Username}}" class="btn btn-primary py-0 px-1 me-2">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <button class="btn delete-btn py-0 px-1" id="{{$user->Username}}" onclick="PassUserId(this.id);" data-bs-toggle="modal" data-bs-target="#userDeleteModal">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- End of Customer List --}}

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



