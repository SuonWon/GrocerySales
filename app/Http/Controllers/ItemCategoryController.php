<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use App\Models\CompanyInformation;
use Illuminate\Http\Request;
use App\Models\GenerateId;
use Illuminate\Database\QueryException;

class ItemCategoryController extends Controller
{
    protected $datetime;

    public function __construct()
    {


        $this->datetime = Date('Y-m-d H:i:s');

    }

    // show customers page 
    public function index(){
        $itemcategories = ItemCategory::all()->sortByDesc('CreatedDate');

       return view('setup.category.index',[
        'itemcategories' => $itemcategories
       ]);
       
    }

    public function create(){
        return view('setup.category.add');
    }

    public function store(){


        $formData = request()->validate([
           
            'ItemCategoryName'=>['required'],
          
            

        ]);

        $formData['ItemCategoryCode'] = GenerateId::generatePrimaryKeyId('item_categories','ItemCategoryCode','CT-');
    
        $formData['Remark'] = request('Remark');
        $formData['ModifiedDate'] = null;
        $formData['CreatedBy'] = auth()->user()->Username;
      

        // dd($formData);
        try {

            $newcategory = ItemCategory::create($formData);

            return redirect('/category/add')->with('success','Category Create Successfully');

        } catch(QueryException $e){

            return back()->with(['error' => $e->getMessage()]);

        }

    }

    public function show(ItemCategory $category){


        return view('setup.category.edit',[
            'itemCategory' => $category
        ]);
    }

    public function update(ItemCategory $category){
        $formData = request()->validate([
          
            'ItemCategoryName'=>['required'],
          
        ]);
        $formData['Remark'] = request('Remark');
        $formData['ModifiedDate'] = $this->datetime;
        $formData['Modifiedby'] = auth()->user()->Username;
        
        try {
            $updatecategory = ItemCategory::where('ItemCategoryCode',$category->ItemCategoryCode)->update($formData);

            return redirect('/category/index')->with('success','Category Update Successfully');

        } catch (QueryException $e) {

            if ($e->errorInfo[1] == 1451) {

                return back()->with(['error' => 'Cannot update this record because it is referenced by another table.']);

            } else {

                return back()->with(['error' => $e->getMessage()]);

            }
        }
    }

    //delete category
    public function destory(ItemCategory $category){

        try {

            $itemcategory =  ItemCategory::where('ItemCategoryCode',$category->ItemCategoryCode)->delete();

            return redirect('/category/index');

        } catch (QueryException $e) {

            if ($e->errorInfo[1] == 1451) {

                return back()->with(['error' => 'Cannot delete this record because it is referenced by another table.']);
                
            } else {

                return back()->with(['error' => $e->getMessage()]);

            }

        }
    }

    //Category Report

    public function categoryreports(){

        $itemcategories = ItemCategory::all()->sortByDesc('CreatedDate');

        $companyinfo = CompanyInformation::first();

        return view('reports.categoryreports',[
            'itemcategories' => $itemcategories,
            'companyinfo' => $companyinfo,
        ]);

    }
}
