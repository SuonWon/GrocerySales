<?php

namespace App\Http\Controllers;

use App\Models\CompanyInformation;
use App\Models\SystemRole;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SystemRoleController extends Controller
{
    protected $datetime;

    public function __construct()
    {


        $this->datetime = Date('Y-m-d H:i:s');
    }

    public function index()
    {
        $systemroles = SystemRole::all();

        return view('setup.systemrole.index', [
            'systemroles' => $systemroles
        ]);
    }

    public function create()
    {
        return view('setup.systemrole.add');
    }

    public function store()
    {


        $formData = request()->validate([
            'RoleDesc' => ['required'],
            'rolepermissions' => ['required', 'array', 'max:255'],
            'Remark' => ['nullable', 'max:200'],
        ]);

        $formData['CreatedBy'] = auth()->user()->Username;
        $formData['ModifiedDate'] = null;
        $formData['RolePermissions'] = implode(',', $formData['rolepermissions']);

        unset($formData['rolepermissions']);

        try {

            $newrole = SystemRole::create($formData);

            return redirect('/systemrole/index')->with('success', 'role created successful');
        } catch (QueryException $e) {

            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function show(SystemRole $role)
    {

        $role->RolePermissions = explode(',', $role->RolePermissions);

        return view('setup.systemrole.edit', [

            'systemrole' => $role,

        ]);
    }

    public function update(SystemRole $role)
    {

        $formData = request()->validate([
            'RoleDesc' => ['required'],
            'rolepermissions' => ['required', 'array', 'max:255'],
            'Remark' => ['nullable', 'max:200'],

        ]);

        $formData['RolePermissions'] = implode(',', $formData['rolepermissions']);
        $formData['ModifiedDate'] = $this->datetime;
        $formData['ModifiedBy'] = auth()->user()->Username;
        unset($formData['roleperimssions']);

        try {

            $roleupdate = SystemRole::where('RoleId', $role->RoleId)->update($formData);

            return redirect('/systemrole/index')->with('success', 'update success');
        } catch (QueryException $e) {

            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destory(SystemRole $role)
    {
        try {

            $destorysystemrole = SystemRole::where('RoleId', $role->RoleId)->delete();

            return redirect('/systemrole/index')->with('success', 'delete success');
        } catch (QueryException $e) {

            if ($e->errorInfo[1] == 1451) {

                return back()->with(['error' => 'Cannot delete this record because it is referenced by another table.']);
                // return back()->with('success','error occusr');

            } else {

                return back()->with(['error' => $e->getMessage()]);
            }
        }
    }

    //System Role Report

    public function systemrolereports()
    {
        $systemroles = SystemRole::all();
        $companyinfo = CompanyInformation::first();

        return view('reports.systemrolereports', [
            'systemroles' => $systemroles,
            'companyinfo' => $companyinfo,
        ]);
    }
}
