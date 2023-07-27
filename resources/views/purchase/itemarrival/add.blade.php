<x-layout title="Create Item">

    <div class="container-fluid content-body mt-3">

        {{-- Section Title --}}

        <div class="row justify-content-between">
            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Create Item Arrvial</h3>
            </div>
            {{-- Back Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/itemarrival/index" class="btn main-btn">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

        {{-- End of Section Title --}}

        {{-- Generate Id --}}

        {{-- @php
     require app_path('./utils/GenerateId.php');
     $generateid = new GenerateId();
     $id = $generateid->generatePrimaryKeyId('item_arrivals','ArrivalCode','IA-',false,true);
    
     @endphp --}}

        {{-- End of Generate Id --}}

        <x-error name="error"></x-error>

        {{-- Form Section --}}

        <form action="/itemarrival/add" method="POST" class="row form-card mt-3 needs-validation" novalidate>
            @csrf
            <div class="col-12 col-md-12 col-lg-8 col-xl-6">

                <div class="row">
                    {{-- Plate No --}}
                    <div class="col-12 col-md-6 mb-3">
                        <label for="PlateNo" class="form-label cust-label">Plate No/Name</label>
                        <input type="text" class="form-control cust-input-box" id="PlateNo" name="PlateNo"
                            value="{{ old('PlateNo') }}">
                        <div class="invalid-feedback">
                            Please fill Plate No.
                        </div>
                    </div>
                    {{-- Arrival Date --}}
                    <div class="col-12 col-md-6 mb-3">
                        <label for="ArrivalDate" class="form-label cust-label">Arrival Date</label>
                        <input type="date" class="form-control cust-input-box" id="ArrivalDate" name="ArrivalDate"
                            value="{{ $todayDate }}" required>
                        <div class="invalid-feedback">
                            Please fill Arrival Date.
                        </div>
                    </div>
                    {{-- Supplier Code --}}
                    <div class="col-12 col-md-6 mb-2">
                        <label for="supplierNameList" class="form-label cust-label">Supplier Name</label>
                        <select class="mb-3 form-select" id="supplierNameList" name="SupplierCode" required>
                            <option selected disabled value="">Choose</option>
                            @if(isset($suppliers) && is_object($suppliers) && count($suppliers) > 0)
                                @forelse ($suppliers as $supplier)

                                    <option value="{{$supplier->SupplierCode}}">{{$supplier->SupplierName}}</option>

                                @empty

                                    <option disabled>No Supplier Found</option>

                                @endforelse

                                @else

                                    <option disabled selected>No Supplier Found</option>

                                @endif
                        </select>
                        <div class="invalid-feedback">
                            Please fill Supplier Name.
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Total Bags --}}
                    <div class="col-12 col-md-4 mb-3">
                        <label for="totalBags" class="form-label cust-label">Total Bags</label>
                        <input type="number" class="form-control cust-input-box" id="totalBags" name="TotalBags"
                            value="{{ old('TotalBags') ? old('TotalBags') : 0 }}" onfocus="AutoSelectValue(event)" onkeyup="calculateTotalAmt()"
                            required>
                        <div class="invalid-feedback">
                            Please fill Total Bags.
                        </div>
                    </div>
                    {{-- Total Viss --}}
                    <div class="col-8 col-md-4 mb-3">
                        <label for="totalViss" class="form-label cust-label">Total Viss</label>
                        <input type="number" class="form-control cust-input-box" id="totalViss" name="TotalViss"
                            value="{{ old('TotalViss') ? old('TotalViss') : 0 }}" onfocus="AutoSelectValue(event)" onkeyup="calculateTotalAmt();"
                            required>
                        <div class="invalid-feedback">
                            Please fill Total Viss.
                        </div>
                    </div>
                    {{-- Is Bag --}}
                    <div class="col-4 col-md-4 mb-3">
                        <label class="cust-label form-label text-end" for="isBag">IsBag</label>
                        <div class="col-sm-8 form-check form-switch ms-1">
                            <input class="form-check-input" type="checkbox" role="switch" id="isBag" name="IsBag" onchange="calculateTotalAmt();" checked>
                        </div>
                    </div>
                    {{-- Charges Per Bag --}}
                    <div class="col-12 col-md-4 mb-3">
                        <label for="chargesPerBag" class="form-label cust-label">Charges Per Bag/Viss</label>
                        <input type="number" class="form-control cust-input-box" id="chargesPerBag"
                            name="ChargesPerBag" value="{{ old('ChargesPerBag') ? old('ChargesPerBag') : 0 }}"
                            onkeyup="calculateTotalAmt()" onfocus="AutoSelectValue(event)" required>
                        <div class="invalid-feedback">
                            Please fill Charges Per Bag.
                        </div>
                    </div>
                    {{-- Total Charges --}}
                    <div class="col-12 col-md-4 mb-3">
                        <label for="totalCharges" class="form-label cust-label">Charges</label>
                        <input type="number" class="form-control cust-input-box" id="totalCharges" name="TotalCharges"
                            value="0" readonly>
                    </div>
                </div>

                <div class="row">
                    {{-- Other Charges --}}
                    <div class="col-12 col-md-4 mb-3">
                        <label for="otherCharges" class="form-label cust-label">Other Charges</label>
                        <input type="number" class="form-control cust-input-box" id="otherCharges" name="OtherCharges"
                            value="{{ old('OtherCharges') ? old('OtherCharges') : 0 }}" onfocus="AutoSelectValue(event)" onkeyup="calculateTotalAmt()">
                    </div>
                    {{-- Total Charges --}}
                    <div class="col-12 col-md-4 mb-3">
                        <label for="fullTotalCharges" class="form-label cust-label">Total Charges</label>
                        <input type="number" class="form-control cust-input-box" id="fullTotalCharges"
                            name="FullTotalCharges" value="0" readonly>
                    </div>
                </div>
                <div class="row">
                    {{-- Remark --}}
                    <div class="col-12 mb-3">
                        <label for="itemRemark" class="form-label cust-label text-end">Remark</label>
                        <textarea type="email" class="form-control cust-textarea" id="itemRemark" name="Remark" rows="3"></textarea>
                    </div>
                </div>
                <div class="row px-0">
                    <div class="col-12 px-0 text-end">
                        {{-- Save Button --}}
                        <button type="submit" class="btn btn-success">
                            <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Save
                        </button>
                    </div>
                </div>
            </div>
        </form>

        {{-- End of Form Section --}}

    </div>

</x-layout>

<script>

    dselect(document.querySelector("#supplierNameList"), config);

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
