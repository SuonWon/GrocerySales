<x-layout title="Create Category">

    <div class="container-fluid content-body mt-3">

    {{-- Section Title --}}

        <div class="row justify-content-between">

            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Create Unit</h3>
            </div>

            {{-- New Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/unit/index" class="btn main-btn py-1">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

    {{-- End of Section Title --}}

    {{-- Form Section --}}

        <form action="/unit/add" method="post" enctype="multipart/form-data" class="row form-card mt-3 needs-validation" novalidate>
            @csrf
            <div class="col-12 col-lg-6">
                <div class="row">
                    {{-- Unit Code --}}
                    <div class="col-md-6 col-lg-12 col-xl-6 mb-3">
                        <label for="UnitCode" class="form-label cust-label text-end">Unit Code</label>
                        <input type="text" class="form-control cust-input-box" id="UnitCode" name="UnitCode" value="{{old("UnitCode")}}" required>
                        <div class="invalid-feedback">
                            Please fill unit code.
                        </div>
                    </div>
                    {{-- Unit Name --}}
                    <div class="col-md-6 col-lg-12 col-xl-6 mb-3">
                        <label for="UnitDesc" class="form-label cust-label text-end">Unit Name</label>
                        <input type="text" class="form-control cust-input-box" id="UnitDesc" name="UnitDesc" value="{{old("UnitDesc")}}" required>
                        <div class="invalid-feedback">
                            Please fill unit name.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="unitRemark" class="form-label cust-label text-end">Remark</label>
                        <textarea type="text" class="form-control cust-textarea" id="unitRemark" name="Remark" rows="3"></textarea>
                    </div>
                </div>
                <div class="row">  
                    {{-- Save Button --}}
                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-success py-1">
                            <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Save
                        </button>
                    </div>
                </div>
            </div>
        </form>

    {{-- End of Form Section --}}

    </div>
     
 </x-layout>