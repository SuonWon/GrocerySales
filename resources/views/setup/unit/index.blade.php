<x-layout title="Unit of Measurement">

    <div class="container-fluid mt-3 content-body">

    {{-- Section Title --}}

        <div class="row justify-content-between">

            {{-- Title --}}
            <div class="col-8 col-md-6 p-0">
                <h3 class="section-title">Unit Lists</h3>
            </div>

            {{-- Create New Button --}}
            <div class="col-4 p-0 text-end">
                <a href="/unit/add" class="btn main-btn" type="button">
                    <span class="me-1"><i class="bi bi-plus-circle"></i></span>New
                </a>
            </div>
        </div>

    {{-- End of Section Title --}}

    {{-- Unit List --}}

        <div class="row mt-3 justify-content-center">
            <div class="table-card">
                <table id="unitList" class="table table-striped nowrap">
                    <thead>
                        <tr>
                            <th style="width: 120px">Unit Code</th>
                            <th style="width: 200px">Unit Name</th>
                            <th style="width: 200px">Created By</th>
                            <th style="width: 200px">Created Date</th>
                            <th style="width: 200px">Modified By</th>
                            <th style="width: 200px">Modified Date</th>
                            <th style="width: 300px">Remark</th>
                            <th style="width: 50px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($units as $unit)
                            <tr>
                                <td>
                                    @if ($unit->IsActive == 1)
                                        <span class="badge text-bg-success">{{$unit->UnitCode}}</span>
                                    @else
                                        <span class="badge text-bg-danger">{{$unit->UnitCode}}</span>
                                    @endif
                                </td>
                                <td>{{$unit->UnitDesc}}</td>
                                <td>{{$unit->CreatedBy}}</td>
                                <td>{{$unit->CreatedDate}}</td>
                                <td>{{$unit->ModifiedBy}}</td>
                                <td>{{$unit->ModifiedDate}}</td>
                                <td>{{$unit->Remark}}</td>
                                <td class="text-center">
                                    <a href="/unit/edit/{{$unit->UnitCode}}" class="btn btn-primary py-0 px-1 me-2">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <button class="btn delete-btn py-0 px-1" id="{{$unit->UnitCode}}" onclick="PassUnitCode(this.id);" data-bs-toggle="modal" data-bs-target="#unitDeleteModal">
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

    {{-- End of Unit List --}}

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