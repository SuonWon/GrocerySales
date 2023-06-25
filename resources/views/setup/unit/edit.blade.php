<x-layout title="Edit Unit">

    <div class="container-fluid content-body mt-3">

    {{-- Section title --}}

        <div class="row justify-content-between">
            {{-- Title --}}
            <div class="col-6 p-0">
                <h3 class="section-title">Update Unit</h3>
            </div>
            {{-- Back Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/unit/index" class="btn main-btn py-1">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

    {{-- End of Section title --}}

    {{-- Form Section --}}

        <form action="/unit/update/{{$unit->UnitCode}}" method="POST" enctype="multipart/form-data" class="row form-card mt-3 needs-validation" novalidate>
            @csrf
            <div class="col-12 col-lg-6">
                <div class="row">
                    {{-- Unit Code --}}
                    <input type="hidden" value="{{$unit->UnitCode}}" name="UnitCode">
                    <div class="col-md-6 col-lg-12 col-xl-6 mb-3">
                        <label for="UnitCode" class="form-label cust-label text-end">Unit Code</label>
                        <input type="text" class="form-control cust-input-box" id="UnitCode" name="UnitCode" value="{{$unit->UnitCode}}" disabled>
                    </div>
                    {{-- Unit Name --}}
                    <div class="col-md-6 col-lg-12 col-xl-6 mb-3">
                        <label for="UnitDesc" class="form-label cust-label text-end">Unit Name</label>
                        <input type="text" class="form-control cust-input-box" id="UnitDesc" name="UnitDesc" value="{{$unit->UnitDesc}}" required>
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
                    <div class="col-12 text-end mt-4">
                        {{-- Update Button --}}
                        <button type="submit" class="btn btn-success py-1">
                                <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Update
                        </button>
                        {{-- Delete Button --}}
                        <button type="button" id="{{$unit->UnitCode}}" class="btn delete-btn py-1" onclick="PassUnitCode(this.id);" data-bs-toggle="modal" data-bs-target="#unitDeleteModal">
                            <span class="me-2"><i class="bi bi-trash-fill"></i></span> Delete
                        </button>
                    </div>
                </div>
            </div>
        </form>

    {{-- End of Form Section --}}

    {{-- Unit Delete Modal Dialog --}}

        <div class="modal fade" id="unitDeleteModal" aria-labelledby="unitDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i></h1>
                        <p class="text-center">Are you sure?</p>
                        <div class="text-center">
                            <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                            <a href="" id="deleteUnitBtn" class="btn btn-primary py-1">Sure</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- End of Unit Delete Modal Dialog --}}

    </div>
     
     
 </x-layout>