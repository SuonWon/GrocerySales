<x-layout title="Update Item">

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

          <form action="/item/update/{{$item->ItemCode}}" method="POST" enctype="multipart/form-data" class="row form-card mt-3 needs-validation" novalidate>
             @csrf
               <div class="col-12 col-lg-6">
                    <input type="hidden" value="{{$item->ItemCode}}" name="ItemCode">
                    <div class="row">
                         {{-- Item Code --}}
                         <div class="col-5 col-md-6 col-xl-4 mb-3">
                              <label for="itemCode" class="form-label cust-label">Item Code</label>
                              <input type="text" class="form-control cust-input-box" id="itemCode" name="ItemCode" value="{{$item->ItemCode}}" disabled>
                         </div>
                         {{-- Discontinued --}}
                         <div class="col-2 mb-3">
                              <label class="cust-label form-label text-end" for="discontinued">Discontinued</label>
                              <div class="col-sm-8 form-check form-switch ms-3">
                              <input class="form-check-input" type="checkbox" role="switch" id="discontinued" name="Discontinued" {{$item->Discontinued == "on" ? "checked" : ''}}>
                              </div>
                         </div>
                    </div>
                    <div class="row">
                         {{-- Item Name --}}
                         <div class="col-12 col-xl-6 mb-3">
                              <label for="itemName" class="form-label cust-label">Item Name</label>
                              <input type="text" class="form-control cust-input-box" id="itemName" name="ItemName" value="{{$item->ItemName}}" required>
                              <div class="invalid-feedback">
                              Please fill item name.
                              </div>
                         </div>
                         {{-- Category Name --}}
                         <div class="col-12 col-xl-6 mb-3">
                              <label for="selectCategory" class="form-label cust-label">Category Name</label>
                              <select name="ItemCategoryCode" class="form-select" id="selectCategory" required>
                                   @forelse ($categories as $category)
                                   @if ($item->ItemCategoryCode == $category->ItemCategoryCode)
                                        <option selected value="{{$category->ItemCategoryCode}}">{{$category->ItemCategoryName}}</option>
                                   @else
                                        <option value="{{$category->ItemCategoryCode}}">{{$category->ItemCategoryName}}</option>
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
                              <label for="baseUnit" class="form-label cust-label">Base Unit</label>
                              <select class="mb-3 form-select" id="selectUnit" name="BaseUnit" required>
                                   @forelse ($units as $unit)
               
                                   @if ($item->BaseUnit == $unit->UnitCode)
                                        <option selected value="{{$unit->UnitCode}}">{{$unit->UnitDesc}}</option>
                                   @else
                                        <option value="{{$unit->UnitCode}}">{{$unit->UnitDesc}}</option>
                                   @endif
                                   
                                   @empty
                                        
                                   @endforelse
                              </select>
                              <div class="invalid-feedback">
                                   Please fill base unit.
                              </div>
                         </div>
                         {{-- Unit Price --}}
                         <div class="col-6 mb-3">
                              <label for="unitPrice" class="form-label cust-label">Unit Price</label>
                              <input type="number" class="form-control cust-input-box" id="unitPrice" name="UnitPrice" value="{{$item->UnitPrice}}" onfocus="AutoSelectValue(event)" onblur="CheckNumber(event)" required>
                              <div class="invalid-feedback">
                              Please fill unit price.
                              </div>
                         </div>
                    </div>
                    <div class="row">
                         {{-- Weight By Price --}}
                         <div class="col-6 mb-3">
                              <label for="weightByPrice" class="form-label cust-label">Weight By Price</label>
                              <input type="number" class="form-control cust-input-box" id="weightByPrice" name="WeightByPrice" value="{{$item->WeightByPrice}}" required>
                              <div class="invalid-feedback">
                              Please fill weight by price.
                              </div>
                         </div>
                         {{-- Default Sales Unit --}}
                         <div class="col-6 col-lg-6 mb-3">
                              <label for="defSalesUnit" class="form-label cust-label cust-label text-end">Default Sales Unit</label>
                              <select class="mb-3 form-select" id="defSalesUnit" name="DefSalesUnit" required>
                                   @forelse ($units as $unit)
               
                                   @if ($item->DefSalesUnit == $unit->UnitCode)
                                        <option selected value="{{$unit->UnitCode}}">{{$unit->UnitDesc}}</option>
                                   @else
                                        <option value="{{$unit->UnitCode}}">{{$unit->UnitDesc}}</option>
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
                              <label for="defPurUnit" class="form-label cust-label text-end">Default Purchase Unit</label>
                              <select class="mb-3 form-select" id="defPurUnit" name="DefPurUnit" required>
                                   @forelse ($units as $unit)
               
                                   @if ($item->DefPurUnit == $unit->UnitCode)
                                        <option selected value="{{$unit->UnitCode}}">{{$unit->UnitDesc}}</option>
                                   @else
                                        <option value="{{$unit->UnitCode}}">{{$unit->UnitDesc}}</option>
                                   @endif
                                   
                              @empty
                                   
                              @endforelse
                              </select>
                              <div class="invalid-feedback">
                                   Please fill default purchase unit.
                              </div>
                         </div>
                    </div>
               </div>
               <div class="col-12 col-lg-6">
                    <div class="row">
                         {{-- Last Purchase Unit --}}
                         <div class="col-6 mb-3">
                              <label for="lastPurchaseUnit" class="form-label cust-label text-end">Last Purchase Price</label>
                              <input type="number" class="form-control cust-input-box" id="lastPurchaseUnit" name="LastPurPrice" value="{{$item->LastPurPrice}}" onfocus="AutoSelectValue(event)" onblur="CheckNumber(event)" required>
                              <div class="invalid-feedback">
                                   Please fill last purchase price.
                              </div>
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
                    <div class="col-12 px-0 text-end">
                         {{-- Update Button --}}
                         <button type="submit" class="btn btn-success">
                              <span class="me-2"><i class="fa fa-floppy-disk"></i></span> Update
                         </button>
                         {{-- Delete Button --}}
                         <button type="button" id="{{$item->ItemCode}}" class="btn btn-danger" onclick="PassItemCode(this.id);" data-bs-toggle="modal" data-bs-target="#itemDeleteModal">
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

 <script>

     dselect(document.querySelector("#selectCategory"), config);

     dselect(document.querySelector("#selectUnit"), config);

     dselect(document.querySelector("#defSalesUnit"), config);

     dselect(document.querySelector("#defPurUnit"), config);
     
 </script>