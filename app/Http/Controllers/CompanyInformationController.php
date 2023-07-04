<?php

namespace App\Http\Controllers;

use App\Models\CompanyInformation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CompanyInformationController extends Controller
{
    protected $datetime;

    public function __construct()
    {

        $this->datetime = Date('Y-m-d H:i:s');

    }

    public function index(){
        $companyinformations = CompanyInformation::all()->sortByDesc('CreatedDate');

        return view('setup.companyinformation.index',[
            'companyinformations' => $companyinformations
        ]);
    }

    public function create(){

        return view('setup.companyinformation.add');

    }

    public function store(){
        
        $formData = request()->validate([
            'CompanyCode' => ['required'],
            'CompanyName'=>['required'],
            'CompanyLogo' => ['required','image','mimes:jpeg,png,jpg,svg,max:2048'],
            'Street' => ['required'],
            'City' => ['required'],
            'OfficeNo' => ['required'],
            'HotLineNo' => ['required']

        ]);

        if($file = request()->file('CompanyLogo')){
            
            $imageName= time().'_'.$file->getClientOriginalName();
            $ext = strtolower($file->getClientOriginalExtension());
            $image_full_name = $imageName.'.'.$ext;
            $firstpath = './assets/images/';

            $path = $firstpath;
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            
            $image_url = $firstpath . $image_full_name;
            $file->move($firstpath, $image_full_name);
            $formData['CompanyLogo'] = $image_url;
        
        }

        $formData['CreatedBy'] = 'aungaung';
        $formData['ModifiedDate'] = null;


        try{
            $newcompanyinformation = CompanyInformation::create($formData);

            return redirect()->route('addcompanyinformation')->with('success','Company Information Create Successful');

        }catch(QueryException $e){

            return back()->with(['error' => $e->getMessage()]);

        }
    }

    public function show(CompanyInformation $company){

        return view('setup.companyinformation.edit',[

            'companyinformation' => $company

        ]);
    }

    public function update(CompanyInformation $company){
        
            $formData = request()->validate([
               
                'CompanyName'=>['required'],
                'CompanyLogo' => ['nullable','image','mimes:jpeg,png,jpg,svg,max:2048'],
                'Street' => ['required'],
                'City' => ['required'],
                'OfficeNo' => ['required'],
                'HotLineNo' => ['required']
                

            ]);

          $formData['CompanyCode'] = $company->CompanyCode;

            if($file = request()->file('CompanyLogo')){
            
                $imageName= time().'_'.$file->getClientOriginalName();
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $imageName.'.'.$ext;
                $firstpath = './assets/images/';
    
          
    
                if(File::exists(public_path().$company->CompanyLogo)){
                    File::delete(public_path().$company->CompanyLogo);
                }
                
                
                $image_url = $firstpath . $image_full_name;
                $file->move($firstpath, $image_full_name);
                $formData['CompanyLogo'] = $image_url;
            
            }

            $formData['ModifiedBy'] = 'htoohtoo';
            $formData['ModifiedDate'] = $this->datetime;

            try{

                $updatecompanyinformation = CompanyInformation::where('CompanyCode',$company->CompanyCode)->update($formData);

                return redirect()->route('companyinformation.edit', $company->CompanyCode)->with('success','company information update successful');

            }catch(QueryException $e) {

                return back()->with(['error' => $e->getMessage()]);

            }
    }

    public function destory(CompanyInformation $company){

        try {

            $deletecompanyinformation =  CompanyInformation::where('CompanyCode',$company->CompanyCode)->delete();

            if($deletecompanyinformation){

                if(File::exists(public_path().$company->CompanyLogo)){

                    File::delete(public_path().$company->CompanyLogo);

                }

            }
            
            
            return redirect()->route('companyinformation')->with('success','Delete Company Information Successful');

        } catch (QueryException $e) {

            if ($e->errorInfo[1] == 1451) {

                return back()->with(['error' => 'Cannot delete this record because it is referenced by another table.']);

            } else {

                return back()->with(['error' => $e->getMessage()]);
                
            }
        }
    }
}
