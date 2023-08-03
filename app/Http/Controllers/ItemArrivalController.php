<?php

namespace App\Http\Controllers;

use App\Models\CompanyInformation;
use App\Models\GenerateId;
use App\Models\ItemArrival;
use App\Models\Supplier;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ItemArrivalController extends Controller
{
    protected $datetime;

    public function __construct()
    {


        $this->datetime = Date('Y-m-d H:i:s');
    }

    public function index(Request $request)
    {
        $itemarrivals = ItemArrival::orderBy('CreatedDate', 'desc')->where('Status', 'N')->orwhere('Status', 'O')->get();

        return view('purchase.itemarrival.index', [
            'itemarrivals' => $itemarrivals
        ]);
    }

    public function create()
    {
        $suppliers = Supplier::where('IsActive', 1)->get();
        $todayDate = Carbon::now()->format('Y-m-d');
        return view('purchase.itemarrival.add', [
            'suppliers' => $suppliers,
            'todayDate' => $todayDate
        ]);
    }

    public function store()
    {
        $formData = request()->validate([

            'ArrivalDate' => ['required'],
            'PlateNo' => ['nullable'],
            'SupplierCode' => ['required'],
            'ChargesPerBag' => ['required'],
            'TotalBags' => ['required'],
            'OtherCharges' => ['required'],
            'TotalCharges' => ['required'],
            'Remark' => ['nullable']
        ]);


        $formData['ArrivalCode'] = GenerateId::generatePrimaryKeyId('item_arrivals', 'ArrivalCode', 'IA-', false, true);
        $formData['TotalViss'] = request('TotalViss');
        $formData['IsBag'] = request('IsBag');
        if ($formData['IsBag'] == 'on') {
            $formData['IsBag'] = 'T';
        } else {
            $formData['IsBag'] = 'F';
        }
        $formData['CreatedBy'] = auth()->user()->Username;
        $formData['ModifiedDate'] = null;



        try {
            $newitemarrival = ItemArrival::create($formData);

            return redirect()->route('additemarrival')->with('success', 'Create Item Arrival Successful');
        } catch (QueryException $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function show(ItemArrival $itemarrival)
    {
        $suppliers = Supplier::where('IsActive', 1)->get();
        return view('purchase.itemarrival.edit', [
            'suppliers' => $suppliers,
            'itemarrival' => $itemarrival
        ]);
    }

    public function update(ItemArrival $itemarrival)
    {
        $formData = request()->validate([

            'ArrivalDate' => ['required'],
            'PlateNo' => ['nullable'],
            'SupplierCode' => ['required'],
            'ChargesPerBag' => ['required'],
            'TotalBags' => ['required'],
            'OtherCharges' => ['required'],
            'TotalCharges' => ['required'],
            'Remark' => ['nullable']
        ]);

        $formData['TotalViss'] = request('TotalViss');
        $formData['IsBag'] = request('IsBag');
        if ($formData['IsBag'] == 'on') {
            $formData['IsBag'] = 'T';
        } else {
            $formData['IsBag'] = 'F';
        }
        $formData['ModifiedDate'] = $this->datetime;
        $formData['ModifiedBy'] = auth()->user()->Username;

        try {
            $updateitemarrival = ItemArrival::where('ArrivalCode', $itemarrival->ArrivalCode)->update($formData);

            return redirect()->route('itemarrivals')->with('success', 'Update Item Arrival Successfully');
        } catch (QueryException $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destory(ItemArrival $itemarrival)
    {
        try {
            // ItemArrival::where('ArrivalCode',$itemarrival->ArrivalCode)->delete();


            if ($itemarrival->Status == 'O') {
                return back()->with(['error' => 'Cannot delete this record it is referenced by another table..']);
            }

            $data = [];
            $data['Status'] = 'D';
            $data['DeletedBy'] = auth()->user()->Username;
            $data['DeletedDate'] = $this->datetime;

            ItemArrival::where('ArrivalCode', $itemarrival->ArrivalCode)->update($data);

            return redirect()->route('itemarrivals')->with('success', 'Delete ItemArrival Successfully');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with(['error' => 'Cannot delete this record because it is referenced by another table.']);
            } else {
                return back()->with(['error' => $e->getMessage()]);
            }
        }
    }

    //Item Arrival  Report

    public function itemarrivalreports()
    {
        $itemarrivals = ItemArrival::orderBy('CreatedDate', 'desc')
            ->join('suppliers', 'item_arrivals.SupplierCode', '=', 'suppliers.SupplierCode')
            ->select('item_arrivals.*', 'suppliers.SupplierCode', 'suppliers.SupplierName')
            ->get();
        $companyinfo = CompanyInformation::first();

        return view('reports.itemarrivalreports', [
            'itemarrivals' => $itemarrivals,
            'companyinfo' => $companyinfo,
        ]);
    }
}
