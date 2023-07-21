<x-layout title="Item">

    <div class="container-fluid mt-3 content-body">

    {{-- Section Title --}}

        <div class="row justify-content-between">
            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Item Lists</h3>
            </div>
    
            {{-- Create New Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/item/add" class="btn main-btn" type="button">
                        <span class="me-1"><i class="bi bi-plus-circle"></i></span>New
                </a>
            </div>
        </div>

    {{-- End of Section Title --}}

    {{-- Item List --}}

        <div class="row mt-3 justify-content-center">
            <div class="table-card">
                <table id="itemList" class="table table-striped nowrap">
                    <thead>
                        <tr>
                            <th style="width: 150px;">Item Code</th>
                            <th style="width: 200px;">Item Name</th>
                            <th style="width: 150px;">Category Code</th>
                            <th class="text-center" style="width: 150px;">Base Unit</th>
                            <th class="text-end" style="width: 150px;">Unit Price</th>
                            <th class="text-end" style="width: 150px;">Weight By Price</th>
                            <th class="text-center" style="width: 150px;">Sales Unit</th>
                            <th class="text-center" style="width: 150px;">Purchase Unit</th>
                            <th class="text-end" style="width: 150px;">Purchase Price</th>
                            <th style="width: 150px;">Created By</th>
                            <th style="width: 150px;">Created Date</th>
                            <th style="width: 150px;">Modified By</th>
                            <th style="width: 150px;">Modified Date</th>
                            <th style="width: 300px;">Remark</th>
                            <th style="width: 50px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td>
                                    @if ($item->Discontinued == 1 && $stockLevels[$item->ItemCode] == "Low")
                                        <span class="badge text-bg-success ">{{$item->ItemCode}} </span> <i class="bi bi-exclamation-circle-fill text-warning fs-6 ms-3"></i>
                                    @elseif ($item->Discontinued == 1 && $stockLevels[$item->ItemCode] == 'High')
                                        <span class="badge text-bg-success ">{{$item->ItemCode}} </span>
                                    @else
                                        <span class="badge text-bg-danger ">{{$item->ItemCode}}</span>
                                    @endif
                                </td>
                                <td>{{$item->ItemName}}</td>
                                <td>{{$item->ItemCategoryCode}}</td>
                                <td class="text-center">{{$item->UnitDesc}}</td>
                                <td class="text-end">{{number_format($item->UnitPrice)}}</td>
                                <td class="text-end">{{$item->WeightByPrice}}</td>
                                <td class="text-center">{{$item->DefSalesUnit}}</td>
                                <td class="text-center">{{$item->DefPurUnit}}</td>
                                <td class="text-end">{{number_format($item->LastPurPrice)}}</td>
                                <td>{{$item->CreatedBy}}</td>
                                <td>{{$item->CreatedDate}}</td>
                                <td>{{$item->ModifiedBy}}</td>
                                <td>{{$item->ModifiedDate}}</td>
                                <td>{{$item->Remark}}</td>
                                <td class="text-center">
                                    <a href="/item/edit/{{$item->ItemCode}}" class="btn btn-primary py-0 px-1 me-2">
                                            <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <button class="btn delete-btn py-0 px-1" id="{{$item->ItemCode}}" onclick="PassItemCode(this.id);" data-bs-toggle="modal" data-bs-target="#itemDeleteModal">
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

    {{-- End of Item List --}}

    {{-- Item Delete Modal --}}

        <div class="modal fade" id="itemDeleteModal" aria-labelledby="itemDeleteModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body" style="background-color: aliceblue">
                        <h1 class="text-center" style="color: #ff0000;"><i class="bi bi-exclamation-diamond-fill"></i></h1>
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