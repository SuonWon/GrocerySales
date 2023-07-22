<x-layout title="Create Item">

    @php
        $warehouseList = [];
    @endphp

    @foreach ($warehouses as $warehouse)
        @php
            $warehouseList[] = [
                'WarehouseCode' => $warehouse->WarehouseCode,
                'StockQty' => '0',
            ];
        @endphp
    @endforeach

    <div class="container-fluid content-body mt-3">

        {{-- Section Title --}}

        <div class="row justify-content-between">
            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Create Item</h3>
            </div>
            {{-- Back Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/item/index" class="btn main-btn">
                    <span class="me-1"><i class="bi bi-chevron-double-left"></i></span>Back
                </a>
            </div>
        </div>

        {{-- End of Section Title --}}

        {{-- Form Section --}}

        <form action="/item/add" method="POST" id="saveItemData" class="row form-card mt-3 needs-validation"
            novalidate>
            @csrf
            <div class="col-12 col-lg-6">
                <div class="row">
                    {{-- Item Code --}}
                    {{-- <div class="col-5 col-md-6 col-xl-4 mb-3">
                        <label for="itemCode" class="form-label cust-label">Item Code</label>
                        <input type="text" class="form-control cust-input-box" id="itemCode" name="ItemCode" value="{{$id}}" disabled>
                    </div> --}}
                    {{-- Item Name --}}
                    <div class="col-12 col-xl-6 mb-3">
                        <label for="itemName" class="form-label cust-label">Item Name</label>
                        <input type="text" class="form-control cust-input-box" id="cItemName" name="ItemName"
                            value="" required>
                        <div class="invalid-feedback">
                            Please fill item name.
                        </div>
                        <x-formerror name="ItemName"></x-formerror>
                    </div>
                    {{-- Discontinued --}}
                    <div class="col-2 mb-3">
                        <label class="cust-label form-label text-end" for="discontinued">Is Active</label>
                        <div class="col-sm-8 form-check form-switch ms-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="cDiscontinued"
                                name="Discontinued" checked>
                            <x-formerror name="Discontinued"></x-formerror>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Category Name --}}
                    <div class="col-12 col-xl-6 mb-3">
                        <label for="selectCategory" class="form-label cust-label">Category Name</label>
                        <select name="ItemCategoryCode" class="form-select" id="cSelectCategory" required>
                            <option value="" selected disabled>Choose</option>
                            @forelse ($categories as $category)
                                <option value="{{ $category->ItemCategoryCode }}">{{ $category->ItemCategoryName }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        <div class="invalid-feedback">
                            Please fill category Name.
                        </div>
                        <x-formerror name="ItemCategoryCode"></x-formerror>
                    </div>
                    {{-- Base Unit --}}
                    <div class="col-6 mb-3">
                        <label for="custNRC" class="form-label cust-label">Base Unit</label>
                        <select class="mb-3 form-select" id="cSelectUnit" name="BaseUnit" required>
                            <option value="" selected disabled>Choose</option>
                            @forelse ($units as $unit)
                                <option value="{{ $unit->UnitCode }}">{{ $unit->UnitDesc }}</option>
                            @empty
                            @endforelse
                        </select>
                        <div class="invalid-feedback">
                            Please fill base unit.
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Default Sale Unit --}}
                    <div class="col-6 col-lg-6 mb-3">
                        <label for="defSalesUnit" class="form-label cust-label cust-label text-end">Default Sales
                            Unit</label>
                        <select class="mb-3 form-select" id="cDefSalesUnit" name="DefSalesUnit" required>
                            <option value="" selected disabled>Choose</option>
                            @forelse ($units as $unit)
                                <option value="{{ $unit->UnitCode }}">{{ $unit->UnitDesc }}</option>
                            @empty
                            @endforelse
                        </select>
                        <div class="invalid-feedback">
                            Please fill default sales unit.
                        </div>
                    </div>
                    {{-- Default Purchase Unit --}}
                    <div class="col-6 col-lg-6 mb-3">
                        <label for="defPurUnit" class="form-label cust-label text-end">Default Purchase Unit</label>
                        <select class="mb-3 form-select" id="cDefPurUnit" name="DefPurUnit" required>
                            <option value="" selected disabled>Choose</option>
                            @forelse ($units as $unit)
                                <option value="{{ $unit->UnitCode }}">{{ $unit->UnitDesc }}</option>
                            @empty
                            @endforelse
                        </select>
                        <div class="invalid-feedback">
                            Please fill default purchase unit.
                        </div>
                    </div>

                </div>
                <div class="row">
                    {{-- Unit Price --}}
                    <div class="col-6 mb-3">
                        <label for="unitPrice" class="form-label cust-label">Unit Price</label>
                        <input type="number" class="form-control cust-input-box" id="cUnitPrice" name="UnitPrice"
                            value="0" onfocus="AutoSelectValue(event)" onblur="CheckNumber(event)" required>
                        <div class="invalid-feedback">
                            Please fill unit price.
                        </div>
                    </div>
                    {{-- Weight By Price --}}
                    <div class="col-6 mb-3">
                        <label for="weightByPrice" class="form-label cust-label">Weight By Price</label>
                        <input type="number" class="form-control cust-input-box" id="cWeightByPrice"
                            name="WeightByPrice" value="1" required>
                        <div class="invalid-feedback">
                            Please fill weight by price.
                        </div>
                    </div>
                    {{-- Last Purchase Unit --}}
                    <div class="col-6 mb-3">
                        <label for="lastPurchaseUnit" class="form-label cust-label text-end">Last Purchase Price</label>
                        <input type="number" class="form-control cust-input-box" id="cLastPurchasePrice"
                            name="LastPurPrice" onfocus="AutoSelectValue(event)" onblur="CheckNumber(event)"
                            value="0" required>
                        <div class="invalid-feedback">
                            Please fill last purchase price.
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="row">
                    {{-- Remark --}}
                    <div class="col-12 mb-3">
                        <label for="itemRemark" class="form-label cust-label text-end">Remark</label>
                        <textarea type="email" class="form-control cust-textarea" id="cItemRemark" name="Remark" rows="3"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2">
                        <table class="table stockList">
                            <thead>
                                <tr>
                                    <th style="width: 350px;">Warehouse Name</th>
                                    <th style="width: 180px;">Stock Qty (ပိဿချိန်)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($warehouses as $warehouse)
                                    <tr>
                                        <td class="px-2 pb-0 pt-2">
                                            <input value="{{$warehouse->WarehouseCode}}" id="stockWHCode" hidden />
                                            {{ $warehouse->WarehouseName }}
                                        </td>
                                        <td class="px-0 py-0">
                                            <input type="number" class="text-end"  id="{{$warehouse->WarehouseCode}}" onfocus="AutoSelectValue(event)" onblur="AddStock(event, this.id)"
                                                value="0">
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
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
        </form>

        {{-- End of Form Section --}}

    </div>

</x-layout>

<script>

    let stockList = @json($warehouseList);

    dselect(document.querySelector("#cSelectCategory"), config);

    dselect(document.querySelector("#cSelectUnit"), config);

    dselect(document.querySelector("#cDefSalesUnit"), config);

    dselect(document.querySelector("#cDefPurUnit"), config);

    function AddStock(event, warehouseCode) {

        stockList.forEach(element => {
            
            if (warehouseCode == element.WarehouseCode) {

                element.StockQty = event.target.value;
                
            }

        });

    }

    $("#saveItemData").on('submit', (event) => {

        event.preventDefault();

        let data = {
            ItemName : $("#cItemName").val(),
            ItemCategoryCode : $("#cSelectCategory").val(),
            BaseUnit : $("#cSelectUnit").val(),
            UnitPrice : $("#cUnitPrice").val(),
            LastPurPrice : $("#cLastPurchasePrice").val(),
            WeightByPrice : $("#cWeightByPrice").val(),
            DefSalesUnit : $("#cDefSalesUnit").val(),
            DefPurUnit : $("#cDefPurUnit").val(),
            Remark : $("#cItemRemark").val(),
            Discontinued : document.getElementById("cDiscontinued").checked ? 'on' : 'off',
            StockInWarehouses : stockList,
        };

        data = JSON.stringify(data);

        console.log(data);

        $.ajaxSetup({

            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        });

        $.ajax({
            url: '/item/add',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {

                if (response.message == "good") {

                    sessionStorage.setItem('save', 'success');

                    window.location.href = "/item/index";

                }

            },
            error: function(error) {
                console.log('no');
                console.log(error.responseText);
                res = JSON.parse(error.responseText);
                console.log(res);
            }
        });

    });
</script>