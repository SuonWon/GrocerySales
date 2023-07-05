<x-layout title="Item Category">

    <div class="container-fluid mt-3 content-body">

    {{-- Section Title --}}

        <div class="row justify-content-between">
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Category Lists</h3>
            </div>

            {{-- Create New Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/category/add" class="btn main-btn" type="button">
                    <span class="me-1"><i class="bi bi-plus-circle"></i></span>New
                </a>
            </div>
        </div>

    {{-- End of Section Title --}}

    {{-- Category List --}}

        <div class="row mt-3 justify-content-center">
            <div class="table-card">
                <table id="itemCategoryList" class="table table-striped nowrap">
                    <thead>
                        <tr>
                            <th style="width: 120px !important;">Category Code</th>
                            <th style="width: 350px !important;">Category Name</th>
                            <th style="width: 450px !important;">Remark</th>
                            <th style="width: 250px !important;">Created By</th>
                            <th style="width: 200px !important;">Created Date</th>
                            <th style="width: 250px !important;">Modified By</th>
                            <th style="width: 200px !important;">Modified Date</th>
                            <th style="width: 50px !important;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($itemcategories as $itemCategory)
                        <tr>
                            <td>{{$itemCategory->ItemCategoryCode}}</td>
                            <td>{{$itemCategory->ItemCategoryName}}</td>
                            <td>{{$itemCategory->Remark}}</td>
                            <td>{{$itemCategory->CreatedBy}}</td>
                            <td>{{$itemCategory->CreatedDate}}</td>
                            <td>{{$itemCategory->ModifiedBy}}</td>
                            <td>{{$itemCategory->ModifiedDate}}</td>
                            <td class="text-center">
                                <a href="/category/edit/{{$itemCategory->ItemCategoryCode}}" class="btn btn-primary py-0 px-1 me-2">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <button class="btn delete-btn py-0 px-1" id="{{$itemCategory->ItemCategoryCode}}" onclick="PassId(this.id);" data-bs-toggle="modal" data-bs-target="#categoryDeleteModal">
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

    {{-- End of Category List --}}

    {{-- Category Delete Modal Dialog --}}

        <div class="modal fade" id="categoryDeleteModal" aria-labelledby="categoryDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i></h1>
                        <p class="text-center">Are you sure?</p>
                        <div class="text-center">
                            <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                            <a href="" id="deleteCategoryBtn" class="btn btn-primary py-1">Sure</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- End of Category Delete Modal Dialog --}}

    </div>
 
</x-layout>