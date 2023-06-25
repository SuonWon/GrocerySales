<?php

namespace App\Http\Controllers;

use App\Models\UnitMeasurement;
use App\Models\CompanyInformation;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use function GuzzleHttp\Promise\all;

class UnitMeasurementController extends Controller
{
    protected $datetime;

    public function __construct()
    {
        $this->datetime = Date('Y-m-d H:i:s');
    }

    // show unit measurement page 
    public function index()
    {
        $units = UnitMeasurement::all()->sortByDesc('CreatedDate');

        return view('setup.unit.index', [
            'units' => $units
        ]);
    }

    public function create()
    {
        return view('setup.unit.add');
    }

    public function store()
    {
        $formData = request()->validate([
            'UnitCode' => ['required'],
            'UnitDesc' => ['required'],
        ]);

        $formData['ModifiedDate'] = null;
        $formData['CreatedBy'] = auth()->user()->Username;
        // dd($formData);
        try{

            $newunit = UnitMeasurement::create($formData);

            return redirect('/unit/add')->with('success','Create Unit Successfully');
    
        } catch(QueryException $e) {

            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function show(UnitMeasurement $unit)
    {


        return view('setup.unit.edit', [
            'unit' => $unit
        ]);
    }

    public function update(UnitMeasurement $unit)
    {
        $formData = request()->validate([

            'UnitCode' => ['required'],
            'UnitDesc' => ['required']
        ]);

        $formData['ModifiedDate'] = $this->datetime;
        $formData['Modifiedby'] = auth()->user()->Username;

        try{

            $newunit = UnitMeasurement::where('UnitCode',$unit->UnitCode)->update($formData);

            return redirect('/unit/index')->with('success','Update Unit Successfully');
    
        } catch(QueryException $e){

            return back()->with(['error' => $e->getMessage()]);

        }
    }

    //delete category
    public function destory(UnitMeasurement $unit)
    {

        try {

            $destoryunit = UnitMeasurement::where('UnitCode',$unit->UnitCode)->delete();

            return redirect('/unit/index')->with('success','Delete Unit Successfully');

        } catch (QueryException $e) {

            if ($e->errorInfo[1] == 1451) {

                return back()->with(['error' => 'Cannot delete this record because it is referenced by another table.']);
                // return back()->with('success','error occusr');

            } else {

                return back()->with(['error' => $e->getMessage()]);

            }
            // return back()->withErrors(['error'=>$e->getMessage()]);
        }
        
    }

    //Unit Report

    public function unitmeasurementreports()
    {
        $units = UnitMeasurement::all()->sortByDesc('CreatedDate');
        $companyinfo = CompanyInformation::first();

        return view('reports.unitmeasurementreports', [
            'units' => $units,
            'companyinfo' => $companyinfo,
        ]);
    }
}
