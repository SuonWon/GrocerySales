<x-layout title="Edit Category">

    <div class="container-fluid content-body mt-3">
    
    {{-- Section title --}}
        
        <div class="row justify-content-between">
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Update Category</h3>
            </div>
            <div class="col-4 p-0 text-end">
                <a href="/category/index" class="btn main-btn py-1">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
                <!-- <button class="btn btn-info text-white" type="button" data-bs-toggle="modal"
                    data-bs-target="#editCustomer">
                    <span class="me-2 text-white"><i class="bi bi-pencil-fill"></i></span>Edit Customer
                </button> -->
            </div>
        </div>

    {{-- End of Section title --}}

    {{-- Form Section --}}

        <form action="/category/update/{{$itemCategory->ItemCategoryCode}}" method="POST" class="row form-card mt-3 needs-validation" novalidate>
            @csrf
            <div class="col-12 col-lg-6">
                <div class="row">
                    {{-- Category Code --}}
                    <div class="col-md-6 col-lg-12 col-xl-6 mb-3">
                        <label for="ItemCategoryCode" class="form-label cust-label text-end">Category Code</label>
                        <input type="text" class="form-control cust-input-box" id="ItemCategoryCode" name="ItemCategoryCode" value="{{$itemCategory->ItemCategoryCode}}" disabled>
                    </div>
                    {{-- Category Name --}}
                    <div class="col-md-6 col-lg-12 col-xl-6 mb-3">
                        <label for="ItemCategoryName" class="form-label cust-label text-end">Category Name</label>
                        <input type="text" class="form-control cust-input-box" id="ItemCategoryName" name="ItemCategoryName" value="{{$itemCategory->ItemCategoryName}}" required>
                        <div class="invalid-feedback">
                            Please fill category name.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="categoryRemark" class="form-label cust-label text-end">Remark</label>
                        <textarea type="text" class="form-control cust-textarea" id="categoryRemark" name="Remark" rows="3">{{$itemCategory->Remark}}</textarea>
                    </div>
                </div>
                <div class="row">  
                    <div class="col-12 text-end mt-4">
                        {{-- Update Button --}}
                        <button type="submit" class="btn btn-success py-1">
                            <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Update
                        </button>
                        {{-- Delete Button --}}
                        <button type="button" class="btn delete-btn py-1 me-2" id="{{$itemCategory->ItemCategoryCode}}" onclick="PassId(this.id);" data-bs-toggle="modal" data-bs-target="#categoryDeleteModal">
                            <span class="me-2"><i class="bi bi-trash-fill"></i></span> Delete
                        </button>
                    </div>
                </div>
            </div>
        </form>

    {{-- End of Form Section --}}

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

{{-- <x-layout title="Edit Category">

     <h1>Edit Category</h1>

     <form action="/category/update/{{$itemcategory->ItemCategoryCode}}" method="post" >
          @csrf 

          <div class="form-group">
               <label for="ItemCategoryCode">ItemCategoryCode</label>
               <input type="text" name="ItemCategoryCode" value="{{$itemcategory->ItemCategoryCode}}" disabled >
          </div>

          <div class="form-group">
               <label for="ItemCategoryName">ItenCategoryName</label>
               <input type="text" name="ItemCategoryName" value="{{$itemcategory->ItemCategoryName}}">
          </div>

          <div class="form-group">
               <button type="submit" value="Update">Submit</button>
           </div>
     </form>
</x-layout> --}}