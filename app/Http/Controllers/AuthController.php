<?php

namespace App\Http\Controllers;

use App\Models\SystemRole;
use App\Models\User;
use App\Models\CompanyInformation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $datetime;

    protected $redirectTo = '/';


    public function __construct()
    {


        $this->datetime = Date('Y-m-d H:i:s');
    }


    //User Login 
    public function login()
    {
        return view('index');
    }

    public function postLogin(Request $request)
    {



        $formData = $request->validate([
            'Username' => ['required', 'string'],
            'password' => ['required', 'min:8', 'max:255']
        ], [

            'password.min' => 'Password should be more than 8 characters'
        ]);



        $remember = $request->has('remember');

        if (Auth::attempt($formData, $remember)) {

            $user = auth()->user();


            if ($user->IsActive == 0) {
                return redirect('/');
            } else {
                if ($user->systemrole->RoleDesc == "admin") {
                    return redirect('dashboard');
                } else {
                    return redirect('/salesinvoices/index');
                }
            }
        } else {
            $user = User::where('Username', $formData['Username'])->first();

            if (!$user) {
                return back()->with([
                    'Username' => 'The provided username is incorrect.',
                ]);
            }

            return back()->with([
                'password' => 'The provided password is incorrect.',
            ]);
        }
    }

    //louout   


    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Good bye');
    }



    //For System User

    public function index()
    {


        $users = User::orderBy('users.CreatedDate')->join('system_roles', 'system_roles.RoleId', '=', 'users.SystemRole')
            ->select('users.*', 'system_roles.RoleId', 'system_roles.RoleDesc')->get();

        return view('setup.user.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        $systemroles = SystemRole::all();
        return view('setup.user.add', [
            'systemroles' => $systemroles
        ]);
    }

    public function store()
    {
        $formData = request()->validate([
            'Username' => ['required'],
            'Fullname' => ['required'],
            'Password' => ['required', 'min:8', 'max:255'],
            'SystemRole' => ['required'],
            'Remark' => ['nullable', 'max:200'],
        ]);



        $formData['Password'] = Hash::make($formData['Password']);

        $formData['IsActive'] = request('IsActive');
        if ($formData['IsActive'] == "on") {
            $formData['IsActive'] = 1;
        } else {
            $formData['IsActive'] = 0;
        }

        $formData['CreatedBy'] = auth()->user()->Username;


        try {

            $newuser = User::create($formData);

            return redirect()->route('users')->with('success', 'User Create Successfully');
        } catch (QueryException $e) {

            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function show(User $user)
    {

        $systemroles = SystemRole::all();

        return view('setup.user.edit', [

            'user' => $user,
            'systemroles' => $systemroles

        ]);
    }

    public function update(User $user)
    {

        // dd(request()->all());

        $formData = request()->validate([
            'Username' => ['required'],
            'Fullname' => ['required'],
            'Password' => ['nullable', 'min:8', 'max:255'],
            'SystemRole' => ['required'],
            'Remark' => ['nullable', 'max:200'],
        ]);

        // dd($formData);

        $formData['IsActive'] = request('IsActive');
        if ($formData['IsActive'] == "on") {

            $formData['IsActive'] = 1;
        } else {
            $formData['IsActive'] = 0;
        }
        $formData['ModifiedDate'] = $this->datetime;
        $formData['ModifiedBy'] = auth()->user()->Username;

        if ($formData['Password'] == null) {
            unset($formData['Password']);
        } else {
            $password = $formData['Password'];
            $formData['Password'] = Hash::make($password);
        }



        try {

            $updateuser = User::where('Username', $user->Username)->update($formData);

            return redirect('/user/index')->with('success', 'update successful');
        } catch (QueryException $e) {

            return back()->with(['error' => $e->getMessage()]);
        }
    }

    //Check Password
    // if (Hash::check($password, $hashedPassword)) {
    //     // Password is correct
    // } else {
    //     // Password is incorrect
    // }


    public function destory(User $user)
    {

        try {

            $destoryuser = User::where('Username', $user->Username)->delete();

            return redirect('/user/index')->with('success', 'Delete successful');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {

                return back()->with(['error' => 'Cannot delete this user because it is referenced by another table.']);
                // return back()->with('success','error occusr');

            } else {

                // Handle other query exceptions as needed.
                return back()->with(['error' => $e->getMessage()]);
            }
        }
    }

    //User Report

    public function userreports()
    {

        $users = User::orderBy('users.CreatedDate')->join('system_roles', 'system_roles.RoleId', '=', 'users.SystemRole')
            ->select('users.*', 'system_roles.RoleId', 'system_roles.RoleDesc')->get();
        $companyinfo = CompanyInformation::first();

        return view('reports.userreports', [
            'users' => $users,
            'companyinfo' => $companyinfo,
        ]);
    }
}
