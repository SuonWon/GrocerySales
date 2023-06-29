<x-layout title="Create Category">

    <div class="container-fluid content-body mt-3">

    {{-- Section Title --}}

        <div class="row justify-content-between">
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Create Category</h3>
            </div>
            {{-- Back Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/category/index" class="btn main-btn py-1">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

    {{-- End of Section Title --}}

        
    {{-- Generate Id --}}
        {{-- @php
        require app_path('./utils/GenerateId.php');
        $generateid = new GenerateId();
        $id = $generateid->generatePrimaryKeyId('item_categories','ItemCategoryCode','CT-');
        @endphp --}}
    {{-- End of Generate Id --}}

    {{-- Form Section --}}
        <form action="/category/add" method="POST" enctype="multipart/form-data" class="row form-card mt-3 needs-validation" novalidate>
            @csrf
          
            <div class="col-12 col-lg-6">
            <div class="row">
                {{-- Category Code --}}
                {{-- <div class="col-md-6 col-lg-12 col-xl-6 mb-3">
                        <label for="ItemCategoryCode" class="form-label cust-label text-end">Category Code</label>
                        <input type="text" class="form-control cust-input-box" id="ItemCategoryCode" name="ItemCategoryCode" value="{{$id}}" disabled>
                </div> --}}
                {{-- Category Name --}}
                <div class="col-md-6 col-lg-12 col-xl-6 mb-3">
                        <label for="ItemCategoryName" class="form-label cust-label text-end">Category Name</label>
                        <input type="text" class="form-control cust-input-box" id="ItemCategoryName" name="ItemCategoryName" value="{{old('ItemCategoryName')}}" required>
                        <div class="invalid-feedback">
                        Please fill category name.
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-3">
                    <label for="categoryRemark" class="form-label cust-label text-end">Remark</label>
                    <textarea type="text" class="form-control cust-textarea" id="categoryRemark" name="Remark" rows="3"></textarea>
                </div>
            </div>

            {{-- Save Button --}}
            <div class="row">  
                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-success py-1" value="submit">
                            <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Save
                    </button>
                </div>
            </div>
            </div>
        </form>

    {{-- End of Form Section --}}

    </div>
     
 </x-layout>