<x-layout title="Edit Item Arrival">

    <div class="container-fluid content-body mt-3">

        {{-- Section Title --}}

        <div class="row justify-content-between">
            {{-- Title --}}
            <div class="col-6 p-0">
                <h3 class="section-title">Edit Item Arrival</h3>
            </div>
            {{-- Back Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/itemarrival/index" class="btn main-btn">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

        {{-- End of Section Title --}}

        <x-error name="error"></x-error>

        {{-- Form Section --}}

        <form action="/itemarrival/update/{{ $itemarrival->ArrivalCode }}" method="POST"
            class="row form-card mt-3 needs-validation" novalidate>
            @csrf
            <div class="col-12 col-md-12 col-lg-8 col-xl-6">
                <div class="row">
                    {{-- Item Code --}}
                    <div class="col-12 col-md-6 mb-3">
                        <label for="ArrivalCode" class="form-label cust-label">Arrival Code</label>
                        <input type="text" class="form-control cust-input-box" id="ArrivalCode" name="ArrivalCode"
                            value="{{ $itemarrival->ArrivalCode }}" disabled>
                    </div>
                    {{-- Arrival Date --}}
                    <div class="col-12 col-md-6 mb-3">
                        <label for="ArrivalDate" class="form-label cust-label">Arrival Date</label>
                        <input type="date" class="form-control cust-input-box" id="ArrivalDate" name="ArrivalDate"
                            @if (old('ArrivalDate')) value="{{ old('ArrivalDate') }}" @else value="{{ $itemarrival->ArrivalDate }}" @endif
                            required>
                        <div class="invalid-feedback">
                            Please fill Arrival Date.
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Plate No --}}
                    <div class="col-12 col-md-6 mb-3">
                        <label for="PlateNo" class="form-label cust-label">Plate No</label>
                        <input type="text" class="form-control cust-input-box" id="PlateNo" name="PlateNo"
                            @if (old('PlateNo')) value="{{ old('PlateNo') }}" @else value="{{ $itemarrival->PlateNo }}" @endif
                            required>
                        <div class="invalid-feedback">
                            Please fill Plate No.
                        </div>
                    </div>
                    {{-- Charges Per Bag --}}
                    <div class="col-12 col-md-6 mb-3">
                        <label for="ChargesPerBag" class="form-label cust-label">Charges Per Bag</label>
                        <input type="number" class="form-control cust-input-box" id="ChargesPerBag"
                            name="ChargesPerBag"
                            @if (old('ChargesPerBag')) value="{{ old('ChargesPerBag') }}" @else value="{{ $itemarrival->ChargesPerBag }}" @endif
                            required>
                        <div class="invalid-feedback">
                            Please fill Charges Per Bag.
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Total Bags --}}
                    <div class="col-12 col-md-4 mb-3">
                        <label for="TotalBags" class="form-label cust-label">Total Bags</label>
                        <input type="number" class="form-control cust-input-box" id="TotalBags" name="TotalBags"
                            @if (old('TotalBags')) value="{{ old('TotalBags') }}" @else value="{{ $itemarrival->TotalBags }}" @endif
                            required>
                        <div class="invalid-feedback">
                            Please fill Total Bags.
                        </div>
                    </div>

                    {{-- Other Charges --}}
                    <div class="col-12 col-md-4 mb-3">
                        <label for="OtherCharges" class="form-label cust-label">Other Charges</label>
                        <input type="number" class="form-control cust-input-box" id="OtherCharges" name="OtherCharges"
                            @if (old('OtherCharges')) value="{{ old('OtherCharges') }}" @else value="{{ $itemarrival->OtherCharges }}" @endif
                            required>
                        <div class="invalid-feedback">
                            Please fill other charges.
                        </div>
                    </div>

                    {{-- Total Charges --}}
                    <div class="col-12 col-md-4 mb-3">
                        <label for="TotalCharges" class="form-label cust-label">Total Charges</label>
                        <input type="number" class="form-control cust-input-box" id="TotalCharges" name="TotalCharges"
                            value="{{ $itemarrival->TotalCharges }}" readonly>
                    </div>
                </div>
                <div class="row">
                    {{-- Remark --}}
                    <div class="col-12 mb-3">
                        <label for="itemRemark" class="form-label cust-label text-end">Remark</label>
                        <textarea type="email" class="form-control cust-textarea" id="itemRemark" name="Remark" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="row px-0">
                <div class="col-8 col-md-6 px-0 text-end">
                    {{-- Save Button --}}
                    <button type="submit" class="btn btn-success me-2">
                        <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Save
                    </button>
                    {{-- Delete Button --}}
                    <button type="button" class="btn delete-btn" id="{{ $itemarrival->ArrivalCode }}"
                        onclick="PassItemArrivalCode(this.id);" data-bs-toggle="modal"
                        data-bs-target="#itemArrivalDeleteModal">
                        <span class="me-2"><i class="bi bi-trash-fill"></i></span> Delete
                    </button>
                </div>
            </div>
        </form>

        {{-- End of Form Section --}}

        {{-- Item Arrival Delete Modal --}}

        <div class="modal fade" id="itemArrivalDeleteModal" aria-labelledby="itemArrivalDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i
                                class="bi bi-exclamation-diamond-fill"></i></h1>
                        <p class="text-center">Are you sure?</p>
                        <div class="text-center">
                            <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                            <a href="" id="deleteItemArrivalBtn" class="btn btn-primary py-1">Sure</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- End of Item Arrival Delete Modal --}}

    </div>

</x-layout>

<script></script>
