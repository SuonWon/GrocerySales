<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use App\Models\WalletTransaction;

class WalletTransactionController extends Controller
{
  protected $datetime;

  public function __construct()
  {
    $this->datetime = Date('Y-m-d H:i:s');
  }

  public function index(Request $request) {
    
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    $date_filter = "";
    if($start_date != null && $end_date != null) {
      $date_filter = " WHERE [Date] BETWEEN " . $start_date ." AND ". $end_date;
    }
    else if($start_date != null) {
      $date_filter = " WHERE [Date] >= " . $start_date;
    }

    $transactions = DB::select("SELECT Id, [Date], c.CustomerCode, c.CustomerName, CashType, Amount, Remark, [Status], t.CreatedBy, t.CreatedDate, t.ModifiedDate, t.ModifiedBy, t.DeletedBy, t.DeletedDate FROM transactions AS t
    LEFT JOIN Customer AS c
    ON t.CustomerCode = c.CustomerCode ". $date_filter
    . "ORDER BY t.CreatedDate");

    return view('transaction.index', [
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
      "Remark",
      "Status"
    ]);

    $formData["Id"] = Str::uuid()->toString();
    $formData["Date"] = request('Date');
    $formData["CustomerCode"] = request('CustomerCode');
    $formData["CashType"] = request('CashType');
    $formData["Amount"] = request('Amount');
    $formData["Remark"] = request('Remark');
    $formData["Status"] = request('Status');
    $formData['CreatedBy'] = auth()->user()->Username;
    $formData['ModifiedDate'] = null;
    

    try{
      WalletTransaction::create($formData);

      // return redirect('/transaction/add')->with('success', 'Wallet Transaction Create Sucessfully');

      return response()->json([
        "status" => true,
        "message" => 'Wallet Transaction Create Sucessfully'
      ]);
    }
    catch(QueryException $e){

      return back()->with(['error' => $e->getMessage()]);
    }
  }

  public function showEdit(Request $id)
  {
    $getWalletTrasaction = DB::select("SELECT Id, [Date], c.CustomerCode, c.CustomerName, CashType, Amount, Remark, [Status], t.CreatedBy, t.CreatedDate, t.ModifiedDate, t.ModifiedBy, t.DeletedBy, t.DeletedDate FROM transactions WHERE Id = ". $id);

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

  public function update(WalletTransaction $transaction)
  {
    $formData = request()->validate([
      "Date" => ['required'],
      "CustomerCode" => ['required'],
      "CashType" => ['required'],
      "Amount" => ['required'],
      "Remark" => ['required'],
      "Status" => ['required']
    ]);

    $formData["Id"] = $transaction['Id'];
    $formData["Date"] = $transaction['Date'];
    $formData["CustomerCode"] = $transaction['CustomerCode'];
    $formData["CashType"] = $transaction['CashType'];
    $formData["Amount"] = $transaction['Amount'];
    $formData["Remark"] = $transaction['Remark'];
    $formData["Status"] = $transaction['Status'];
    $formData['ModifiedBy'] = auth()->user()->Username;
    $formData['ModifiedDate'] = $this->datetime;

    try {
      WalletTransaction::where('Id', '=', request('Id'))->update($formData);
      return response()->json([
        'status' => true,
        'message' => 'Date is updated successfully!'
      ]);
    }
    catch(QueryException $e){

      return back()->with(['error' => $e->getMessage()]);
    }
  }

  public function destroy(WalletTransaction $transaction)
  { 
    $data = [];
    $data['DeletedBy'] = auth()->user()->Username;
    $data['Id'] = $transaction->Id;
    $data['DeletedDate'] = $this->datetime;
    $data['Status'] = 'D';

    try {
      WalletTransaction::where('Id', '=', request('Id'))->update($data);
      return redirect()->route('wallettransaction')->with('success', 'Delete wallet transaction is successful');

    } catch (QueryException $e) {

      // return response()->json(['message' => $e->getMessage()]);

      return back()->with(['error' => $e->getMessage()]);
    }
  }
}