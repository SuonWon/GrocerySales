<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use App\Models\WalletTransaction;
use Carbon\Carbon;

class WalletTransactionController extends Controller
{
  protected $datetime;

  public function __construct()
  {
    $this->datetime = Date('Y-m-d H:i:s');
  }

  public function index(Request $request) {

    $currentDate = Carbon::now()->format('Y-m-d');

    $customers = Customer::where('IsActive', '=', 1)->get();
    
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    $date_filter = "";
    if($start_date != null && $end_date != null) {
      $date_filter = " WHERE [Date] BETWEEN " . $start_date ." AND ". $end_date;
    }
    else if($start_date != null) {
      $date_filter = " WHERE [Date] >= " . $start_date;
    }

    $transactions = DB::select("SELECT Id, `Date`, c.CustomerCode, c.CustomerName, CashType, Amount, `Status`, t.Remark, t.CreatedBy, t.CreatedDate, t.ModifiedDate, t.ModifiedBy, t.DeletedBy, t.DeletedDate FROM wallet_transaction AS t
    LEFT JOIN customers AS c
    ON t.CustomerCode = c.CustomerCode ". $date_filter
    . "ORDER BY t.CreatedDate");

    return view('transaction.index', [
      "todayDate" => $currentDate,
      "customers" => $customers,
      "transactions" => $transactions
    ]);
  }

  public function store() 
  {
    $formData = request()->validate([
      "Date",
      "CustomerCode",
      "CashType",
      "Amount",
      "Remark"
    ]);

    $formData["Id"] = Str::uuid()->toString();
    $formData["Date"] = request('Date');
    $formData["CustomerCode"] = request('CustomerCode');
    $formData["CashType"] = request('CashType');
    $formData["Amount"] = request('Amount');
    $formData["Remark"] = request('Remark');
    $formData["Status"] = "O";
    $formData['CreatedBy'] = auth()->user()->Username;
    $formData['ModifiedDate'] = null;

    try{
      WalletTransaction::create($formData);

      return redirect('/walletTransaction/index')->with('success', 'Wallet Transaction Create Successfully');

      // return response()->json([
      //   "status" => true,
      //   "message" => 'Wallet Transaction Create Successfully'
      // ]);
    }
    catch(QueryException $e){

      return back()->with(['error' => $e->getMessage()]);
    }
  }

  public function showEdit(Request $id)
  {
    $getWalletTrasaction = DB::select("SELECT Id, `Date`, c.CustomerCode, c.CustomerName, CashType, Amount, Remark, `Status`, t.CreatedBy, t.CreatedDate, t.ModifiedDate, t.ModifiedBy, t.DeletedBy, t.DeletedDate FROM wallet_transaction WHERE Id = ". $id);

    // $customers = Customer::where('IsActive', '=', 1)->get();

    // return view('transaction.edit', [
    //   "walletTransaction" => $getWalletTrasaction,
    //   "customers" => $customers
    // ]);
    return response()->json([
      "status" => true,
      "walletTransaction" => $getWalletTrasaction,
    ]);
  }

  public function update($id)
  {
    //dd($id);
    $formData = request()->validate([
      "Date" => ['required'],
      "CustomerCode" => ['required'],
      "CashType" => ['required'],
      "Amount" => ['required'],
      "Remark" => ['required'],
    ]);

    $formData["Id"] = $id;
    $formData["Date"] = request('Date');
    $formData["CustomerCode"] = request('CustomerCode');
    $formData["CashType"] = request('CashType');
    $formData["Amount"] = request('Amount');
    $formData["Remark"] = request('Remark');
    $formData["Status"] = "O";
    $formData['ModifiedBy'] = auth()->user()->Username;
    $formData['ModifiedDate'] = $this->datetime;
    //dd($formData);
    

    try {
      WalletTransaction::where('Id', '=', $id)->update($formData);
      return redirect('/walletTransaction/index')->with('success', 'Wallet Transaction updated Successfully');
      // return response()->json([
      //   'status' => true,
      //   'message' => 'Date is updated successfully!'
      // ]);
    }
    catch(QueryException $e){

      return back()->with(['error' => $e->getMessage()]);
    }
  }

  public function destroy(WalletTransaction $id)
  { 
    //dd("Hello World!");
    $data = [];
    $data['DeletedBy'] = auth()->user()->Username;
    $data['Id'] = $id -> Id;
    $data['DeletedDate'] = $this->datetime;
    $data['Status'] = 'D';

    try {
      WalletTransaction::where('Id', '=', $id->Id)->update($data);
      return redirect('/walletTransaction/index')->with('success', 'Delete wallet transaction is successful');

    } catch (QueryException $e) {

      // return response()->json(['message' => $e->getMessage()]);

      return back()->with(['error' => $e->getMessage()]);
    }
  }
}