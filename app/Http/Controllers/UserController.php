<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(){
      $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Gate::denies('is_admin',Auth::user()))
	    	return redirect()->action('DashboardController@index');

        $users = UserService::listUser([

        ]);

        return view('dashboard.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('is_admin',Auth::user()))
	    	return redirect()->action('DashboardController@index');
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('is_admin',Auth::user()))
	    	return redirect()->action('DashboardController@index');
      $input = $request->all();
    //dd($input);
    //$app->end();

    $validate = UserService::validate($input);

    if ($validate->fails()) {
        return redirect()->action('UserController@create')
            ->withErrors($validate)->withInput($input)->with('message', $validate->errors()->first())->with('alert-class','alert-danger');

    }

    if (UserService::create($input)) {
        return redirect()->action('UserController@index')
            ->with('message', trans('labels.create_success'));
    }

    return redirect()->action('UserController@index')
        ->with('error', trans('labels.create_false'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('is_admin',Auth::user()))
	    	return redirect()->action('DashboardController@index');
      $roles = UserService::getRoles();
      $user = User::find($id);
      return view('dashboard.users.edit', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('is_admin',Auth::user()))
	    	return redirect()->action('DashboardController@index');
      $user = User::find($id);
      return view('dashboard.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Gate::denies('is_admin',Auth::user()))
	    	return redirect()->action('DashboardController@index');
      $user = User::find($id);
        if (!$user) {
            return redirect()->action('UserController@index')
                ->with('error', trans('labels.update_false'));
        }

        $input = $request->all();
        $validate = UserService::validate($input, $user);
        if ($validate->fails()) {
            return redirect()->action('UserController@edit', $user->id)
                ->withErrors($validate)->withInput($input);
        }

        if (UserService::update($input, $user)) {
            return redirect()->action('UserController@index')
                ->with('message', trans('labels.update_success'));
        }

        return redirect()->action('UsersController@edit')
            ->with('error', trans('labels.update_false'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('is_admin',Auth::user()))
	    	return redirect()->action('DashboardController@index');
      $user = User::find($id);
      if (UserService::delete($user)) {
          return back()->with('message', trans('labels.delete_success'));
      }

      return back()->with('error', trans('labels.integrity_constraint_violation'));
    }
}
