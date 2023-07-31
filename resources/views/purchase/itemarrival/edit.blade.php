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
                        <label for="PlateNo" class="form-label cust-label">Plate No/Name</label>
                        <input type="text" class="form-control cust-input-box" id="PlateNo" name="PlateNo"
                            @if (old('PlateNo')) value="{{ old('PlateNo') }}" @else value="{{ $itemarrival->PlateNo }}" @endif
                            required>
                        <div class="invalid-feedback">
                            Please fill Plate No.
                        </div>
                    </div>
                    {{-- Supplier Name --}}
                    <div class="col-12 col-md-6">
                        <label for="supplierCodeList" class="form-label cust-label">Supplier Name</label>
                        <select class="mb-3 form-select" id="supplierCodeList" name="SupplierCode" required>

                            @if (isset($suppliers) && is_object($suppliers) && count($suppliers) > 0)

                                @forelse ($suppliers as $supplier)
                                    @if ($supplier->SupplierCode == $itemarrival->SupplierCode)
                                        <option value="{{ $supplier->SupplierCode }}" selected>
                                            {{ $supplier->SupplierName }}</option>
                                    @else
                                        <option value="{{ $supplier->SupplierCode }}">{{ $supplier->SupplierName }}
                                        </option>
                                    @endif

                                @empty
                                    <option disabled>No Supplier Found</option>
                                @endforelse

                            @endif
                        </select>
                        <div class="invalid-feedback">
                            Please fill Supplier name.
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Total Bags --}}
                    <div class="col-12 col-md-4 mb-3">
                        <label for="totalBags" class="form-label cust-label">Total Bags</label>
                        <input type="number" class="form-control cust-input-box" id="totalBags" name="TotalBags"
                            @if (old('TotalBags')) value="{{ old('TotalBags') }}" @else value="{{ $itemarrival->TotalBags }}" @endif
                            onkeyup="calculateTotalAmt();" onfocus="AutoSelectValue(event)" required>
                        <div class="invalid-feedback">
                            Please fill Total Bags.
                        </div>
                    </div>
                    {{-- Total Viss --}}
                    <div class="col-12 col-md-4 mb-3">
                        <label for="totalViss" class="form-label cust-label">Total Viss</label>
                        <input type="number" class="form-control cust-input-box" id="totalViss" name="TotalViss"
                            @if (old('TotalViss')) value="{{ old('TotalViss') }}" @else value="{{ $itemarrival->TotalViss }}" @endif
                            onkeyup="calculateTotalAmt();" onfocus="AutoSelectValue(event)" required>
                        <div class="invalid-feedback">
                            Please fill Total Bags.
                        </div>
                    </div>
                    {{-- Is Bag --}}
                    <div class="col-4 col-md-4 mb-3">
                        <label class="cust-label form-label text-end" for="isBag">IsBag</label>
                        <div class="col-sm-8 form-check form-switch ms-1">
                            <input class="form-check-input" type="checkbox" role="switch" id="isBag" name="IsBag"
                                onchange="calculateTotalAmt();" {{ $itemarrival->IsBag == 'T' ? 'checked' : '' }}>
                        </div>
                    </div>
                    {{-- Charges Per Bag --}}
                    <div class="col-12 col-md-4 mb-3">
                        <label for="chargesPerBag" class="form-label cust-label">Charges Per Bag/Viss</label>
                        <input type="number" class="form-control cust-input-box" id="chargesPerBag"
                            name="ChargesPerBag"
                            @if (old('ChargesPerBag')) value="{{ old('ChargesPerBag') }}" @else value="{{ number_format($itemarrival->ChargesPerBag, 0, '.', '') }}" @endif
                            onkeyup="calculateTotalAmt();" onfocus="AutoSelectValue(event)" required>
                        <div class="invalid-feedback">
                            Please fill Charges Per Bag.
                        </div>
                    </div>
                    {{-- Total Charges --}}
                    <div class="col-12 col-md-4 mb-3">
                        <label for="totalCharges" class="form-label cust-label">Charges</label>
                        <input type="number" class="form-control cust-input-box" id="totalCharges" name="TotalCharges"
                            value="{{ number_format($itemarrival->TotalCharges, 0, '.', '') }}" readonly>
                    </div>
                </div>
                <div class="row">
                    {{-- Other Charges --}}
                    <div class="col-12 col-md-4 mb-3">
                        <label for="otherCharges" class="form-label cust-label">Other Charges</label>
                        <input type="number" class="form-control cust-input-box" id="otherCharges" name="OtherCharges"
                            @if (old('OtherCharges')) value="{{ old('OtherCharges') }}" @else value="{{ number_format($itemarrival->OtherCharges, 0, '.', '') }}" @endif
                            onkeyup="calculateTotalAmt();" onfocus="AutoSelectValue(event)" required>
                        <div class="invalid-feedback">
                            Please fill other charges.
                        </div>
                    </div>
                    {{-- Total Charges --}}
                    <div class="col-12 col-md-4 mb-3">
                        <label for="fullTotalCharges" class="form-label cust-label">Total Charges</label>
                        <input type="number" class="form-control cust-input-box" id="fullTotalCharges"
                            name="FullTotalCharges"
                            value="{{ number_format($itemarrival->OtherCharges + $itemarrival->TotalCharges, 0, '.', '') }}"
                            readonly>
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

<script>

    dselect(document.querySelector("#supplierCodeList"), config);

    let calculateTotalAmt = () => {

        const chargesPerBag = Number(document.querySelector('#chargesPerBag').value);

        const totalBags = Number(document.querySelector('#totalBags ').value);

        const totalViss = Number(document.querySelector('#totalViss').value);

        const otherCharges = Number(document.querySelector('#otherCharges').value);

        const isBag = document.getElementById('isBag');

        let charges, netPrice = 0;

        if (isBag.checked) {

            charges = (chargesPerBag * totalBags);

            netPrice = (chargesPerBag * totalBags) + otherCharges;

        } else {

            charges = (chargesPerBag * totalViss);

            netPrice = (chargesPerBag * totalViss) + otherCharges;

        }

        document.querySelector('#fullTotalCharges').value = Math.round(netPrice);

        document.querySelector('#totalCharges').value = Math.round(charges);

        // if(chargesPerBag && totalBags && otherCharges) {

        //     let charges = (chargesPerBag * totalBags);

        //     let netPrice = (chargesPerBag * totalBags) + otherCharges;

        //     document.querySelector('#fullTotalCharges').value = netPrice;

        //     document.querySelector('#totalCharges').value = charges;

        // }else if(chargesPerBag && totalBags) {

        //     let netPrice = (chargesPerBag * totalBags);

        //     document.querySelector('#totalCharges').value = netPrice;

        // }else{

        //     document.querySelector('#totalCharges').value = '';

        // }
    }
</script>
