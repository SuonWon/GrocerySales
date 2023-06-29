<x-layout title="System Role">

    <div class="container-fluid mt-3 content-body">

        {{-- Section Title --}}

        <div class="row justify-content-between">
            <div class="col-8 col-md-5 p-0">
                <h3 class="section-title">System Roles  List</h3>
            </div>

            {{-- Create New Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/systemrole/add" class="btn main-btn" type="button">
                    <span class="me-1"><i class="bi bi-plus-circle"></i></span>Add
                </a>
            </div>
        </div>

        {{-- End of Section Title --}}

        {{-- System Role List --}}

        <div class="row mt-3 justify-content-center">
            <x-error name="error"></x-error>
            <div class="table-card">
                <table id="systemroleList" class="table table-striped nowrap">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Role Id</th>
                            <th style="width: 200px;">Role Description</th>
                            <th style="width: 300px;">RolePermissions</th>
                            <th style="width: 150px;">Created By</th>
                            <th style="width: 150px;">Created Date</th>
                            <th style="width: 150px;">Modified By</th>
                            <th style="width: 150px;">Modified Date</th>
                            <th style="width: 300px;">Remark</th>
                            <th style="width: 50px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($systemroles as $systemrole)
                        <tr>
                            <td>{{$systemrole->RoleId}}</td>
                            <td>{{$systemrole->RoleDesc}}</td>
                            <td>{{$systemrole->RolePermissions}}</td>
                            <td>{{$systemrole->CreatedBy}}</td>
                            <td>{{$systemrole->CreatedDate}}</td>
                            <td>{{$systemrole->ModifiedBy}}</td>
                            <td>{{$systemrole->ModifiedDate}}</td>
                            <td>{{$systemrole->Remark}}</td>
                            <td class="text-center">
                                <a href="/systemrole/edit/{{$systemrole->RoleId}}" class="btn btn-primary py-0 px-1 me-2">
                                        <i class="bi bi-pencil-fill"></i>
                                </a>
                                <button class="btn delete-btn py-0 px-1 me-2" id="{{$systemrole->RoleId}}" onclick="PassRoleId(this.id);" data-bs-toggle="modal" data-bs-target="#systemRoleDeleteModal">
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

        {{-- End of System Role List --}}

        {{-- System Role Delete Modal --}}

        <div class="modal fade" id="systemRoleDeleteModal" aria-labelledby="systemRoleDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i></h1>
                        
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



