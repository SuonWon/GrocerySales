<x-layout title="Update Item">

    @php
        $stockInWarehouse = [];
    @endphp

    @foreach ($stockitemsqty as $key => $stockitem)
        @php
            $stockInWarehouse[] = [
                'WarehouseCode' => $stockitem->WarehouseCode,
                'StockQty' => $stockitem->StockQty,
            ];
        @endphp
    @endforeach

    <div class="container-fluid content-body mt-3">
        
        {{-- Section Title --}}

        <div class="row justify-content-between">
            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Update Item</h3>
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

        <form action="/item/update/{{ $item->ItemCode }}" id="updateItemData" method="POST" enctype="multipart/form-data"
            class="row form-card mt-3 needs-validation" novalidate>
            @csrf
            <div class="col-12 col-lg-6">
                <input type="hidden" value="{{ $item->ItemCode }}" name="ItemCode">
                <div class="row">


                    {{-- Item Code --}}
                    <div class="col-5 col-md-6 col-xl-4 mb-3">
                        <label for="eItemCode" class="form-label cust-label">Item Code</label>
                        <input type="text" class="form-control cust-input-box" id="eItemCode" name="ItemCode"
                            value="{{ $item->ItemCode }}" disabled>
                    </div>
                    {{-- Discontinued --}}
                    <div class="col-2 mb-3">
                        <label class="cust-label form-label text-end" for="eDiscontinued">Is Active</label>
                        <div class="col-sm-8 form-check form-switch ms-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="eDiscontinued"
                                name="Discontinued" {{ $item->Discontinued == 'on' ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Item Name --}}
                    <div class="col-12 col-xl-6 mb-3">
                        <label for="eItemName" class="form-label cust-label">Item Name</label>
                        <input type="text" class="form-control cust-input-box" id="eItemName" name="ItemName"
                            value="{{ $item->ItemName }}" required>
                        <div class="invalid-feedback">
                            Please fill item name.
                        </div>
                    </div>
                    {{-- Category Name --}}
                    <div class="col-12 col-xl-6 mb-3">
                        <label for="eSelectCategory" class="form-label cust-label">Category Name</label>
                        <select name="ItemCategoryCode" class="form-select" id="eSelectCategory" required>
                            @forelse ($categories as $category)
                                @if ($item->ItemCategoryCode == $category->ItemCategoryCode)
                                    <option selected value="{{ $category->ItemCategoryCode }}">
                                        {{ $category->ItemCategoryName }}</option>
                                @else
                                    <option value="{{ $category->ItemCategoryCode }}">{{ $category->ItemCategoryName }}
                                    </option>
                                @endif
                            @empty
                            @endforelse
                        </select>
                        <div class="invalid-feedback">
                            Please fill category name.
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Base Unit --}}
                    <div class="col-6 mb-3">
                        <label for="eSelectUnit" class="form-label cust-label">Base Unit</label>
                        <select class="mb-3 form-select" id="eSelectUnit" name="BaseUnit" required>
                            @forelse ($units as $unit)
                                @if ($item->BaseUnit == $unit->UnitCode)
                                    <option selected value="{{ $unit->UnitCode }}">{{ $unit->UnitDesc }}</option>
                                @else
                                    <option value="{{ $unit->UnitCode }}">{{ $unit->UnitDesc }}</option>
                                @endif

                            @empty
                            @endforelse
                        </select>
                        <div class="invalid-feedback">
                            Please fill base unit.
                        </div>
                    </div>
                    {{-- Default Sales Unit --}}
                    <div class="col-6 col-lg-6 mb-3">
                        <label for="eDefSalesUnit" class="form-label cust-label cust-label text-end">Default Sales
                            Unit</label>
                        <select class="mb-3 form-select" id="eDefSalesUnit" name="DefSalesUnit" required>
                            @forelse ($units as $unit)
                                @if ($item->DefSalesUnit == $unit->UnitCode)
                                    <option selected value="{{ $unit->UnitCode }}">{{ $unit->UnitDesc }}</option>
                                @else
                                    <option value="{{ $unit->UnitCode }}">{{ $unit->UnitDesc }}</option>
                                @endif

                            @empty
                            @endforelse
                        </select>
                        <div class="invalid-feedback">
                            Please fill default sales unit.
                        </div>
                    </div>
                    {{-- Default Purchase Unit --}}
                    <div class="col-6 col-lg-6 mb-3">
                        <label for="eDefPurUnit" class="form-label cust-label text-end">Default Purchase Unit</label>
                        <select class="mb-3 form-select" id="eDefPurUnit" name="DefPurUnit" required>
                            @forelse ($units as $unit)
                                @if ($item->DefPurUnit == $unit->UnitCode)
                                    <option selected value="{{ $unit->UnitCode }}">{{ $unit->UnitDesc }}</option>
                                @else
                                    <option value="{{ $unit->UnitCode }}">{{ $unit->UnitDesc }}</option>
                                @endif

                            @empty
                            @endforelse
                        </select>
                        <div class="invalid-feedback">
                            Please fill default purchase unit.
                        </div>
                    </div>
                    {{-- Unit Price --}}
                    <div class="col-6 mb-3">
                        <label for="eUnitPrice" class="form-label cust-label">Unit Price</label>
                        <input type="text" class="form-control cust-input-box text-end" id="eUnitPrice"
                            name="UnitPrice" value="{{ $item->UnitPrice ? number_format($item->UnitPrice) : 0 }}"
                            onfocus="AutoSelectValue(event)" onblur="CheckNumber(event)" required>
                        <div class="invalid-feedback">
                            Please fill unit price.
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Weight By Price --}}
                    <div class="col-6 mb-3">
                        <label for="eWeightByPrice" class="form-label cust-label">Weight By Price</label>
                        <input type="number" class="form-control cust-input-box" id="eWeightByPrice"
                            name="WeightByPrice"
                            value="{{ $item->WeightByPrice ? number_format($item->WeightByPrice, 0, '.', '') : 1 }}"
                            onfocus="AutoSelectValue(event)" required>
                        <div class="invalid-feedback">
                            Please fill weight by price.
                        </div>
                    </div>
                    {{-- Last Purchase Unit --}}
                    <div class="col-6 mb-3">
                        <label for="eLastPurchasePrice" class="form-label cust-label text-end">Last Purchase
                            Price</label>
                        <input type="text" class="form-control cust-input-box text-end" id="eLastPurchasePrice"
                            name="LastPurPrice"
                            value="{{ $item->LastPurPrice ? number_format($item->LastPurPrice) : 0 }}"
                            onfocus="AutoSelectValue(event)" onblur="CheckNumber(event)" required>
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
                        <label for="eItemRemark" class="form-label cust-label text-end">Remark</label>
                        <textarea type="email" class="form-control cust-textarea" id="eItemRemark" name="Remark" rows="3"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2">
                        <table class="table stockList">
                            <thead>
                                <tr>
                                    <th style="width: 350px;">Warehouse Name</th>
                                    <th style="width: 180px;">Stock Qty (ပိဿချိန်)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockitemsqty as $key => $stockitem)
                                    <tr>
                                        <td class="px-2 pb-0 pt-2">
                                            @foreach ($warehouses as $warehouse)
                                                @if ($stockitem->WarehouseCode == $warehouse->WarehouseCode)
                                                    {{ $warehouse->WarehouseName }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="px-0 py-0">
                                            <input type="number" class="text-end" WhCode="{{$stockitem->WarehouseCode}}" id="row_{{ $key }}" value="{{ $stockitem->StockQty }}" onblur="AddStock(event)" disabled>
                                        </td>
                                        <td class="text-center px-0 pt-0 pb-1">
                                            <button type="button" class="btn btn-primary py-0 mt-1 px-1"
                                                onclick="AddStockQty(this.id)" id="{{ $key }}"
                                                {{ $stockitem->Status == 'O' ? 'disabled' : '' }}>
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
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
                    {{-- Update Button --}}
                    <button type="submit" class="btn btn-success">
                        <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Update
                    </button>
                    {{-- Delete Button --}}
                    <button type="button" id="{{ $item->ItemCode }}" class="btn btn-danger"
                        onclick="PassItemCode(this.id);" data-bs-toggle="modal" data-bs-target="#itemDeleteModal">
                        <span class="me-2"><i class="bi bi-trash-fill"></i></span> Delete
                    </button>
                </div>
            </div>
        </form>

        {{-- End of Form Section --}}

        {{-- Item Delete Modal --}}

        <div class="modal fade" id="itemDeleteModal" aria-labelledby="itemDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i
                                class="bi bi-exclamation-diamond-fill"></i></h1>
                        <p class="text-center">Are you sure?</p>
                        <div class="text-center">
                            <button class="btn btn-secondary py-1" data-bs-dismiss="modal">Cancel</button>
                            <a href="" id="deleteItemBtn" class="btn btn-primary py-1">Sure</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- End of Item Delete Modal --}}

    </div>



</x-layout>

<script>

     let stockQtyList = @json($stockInWarehouse);

     dselect(document.querySelector("#eSelectCategory"), config);

     dselect(document.querySelector("#eSelectUnit"), config);

     dselect(document.querySelector("#eDefSalesUnit"), config);

     dselect(document.querySelector("#eDefPurUnit"), config);

     function AddStockQty(inputId) {

          event.preventDefault();

          console.log(inputId);

          inputBox = document.querySelector("#row_" + inputId);

          inputBox.removeAttribute('disabled');

          inputBox.select();

     }

     function AddStock(event) {

          let warehouseCode = event.target.getAttribute('WhCode');

          stockQtyList.forEach(element => {

               if (warehouseCode == element.WarehouseCode) {

                    element.StockQty = event.target.value;

                    console.log(element.StockQty)

               }

          })

     }

     $("#updateItemData").on('submit', (event) => {

          event.preventDefault();

          let data = {
               ItemName: $("#eItemName").val(),
               ItemCategoryCode: $("#eSelectCategory").val(),
               BaseUnit: $("#eSelectUnit").val(),
               UnitPrice: $("#eUnitPrice").val().replace(/,/,''),
               LastPurPrice: $("#eLastPurchasePrice").val().replace(/,/,''),
               WeightByPrice: $("#eWeightByPrice").val(),
               DefSalesUnit: $("#eDefSalesUnit").val(),
               DefPurUnit: $("#eDefPurUnit").val(),
               Remark: $("#eItemRemark").val(),
               Discontinued: document.getElementById("eDiscontinued").checked ? 'on' : 'off',
               StockInWarehouses: stockQtyList,
          };

          data = JSON.stringify(data);

          console.log(data);

          $.ajaxSetup({

               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }

          });

          let url = $("#updateItemData").attr("action")

          $.ajax({
               url: url,
               type: 'POST',
               data: data,
               dataType: 'json',
               success: function(response) {

                    console.log(response.message);

                    if (response.message == "good") {

                         sessionStorage.setItem('update', 'success');

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
