<?php

namespace App\Http\Controllers;

use App\User;
use App\DataTables\UserDatatable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDatatable $user)
    {
        if (Auth::user()->cant('view', User::class)) {
            return back()->withErrors(['Current logged in user is not allowed to View users']);
        }
        // return view('admin.index');
        // dd(Client::get());
        return $user->render('admin.clients', ['title' => trans('admin.adminpanel')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user  = User::find($id);
        if (Auth::user()->cant('update', $user)) {
            return back()->withErrors(['Current logged in user is not allowed to Edit or Update this']);
        }
        $title = trans('admin.edit');
        return view('auth.edit', compact('title', 'user'));
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
        $user  = User::find($id);
        if (Auth::user()->cant('update', $user)) {
            return back()->withErrors(['Current logged in user is not allowed to Edit or Update this']);
        }

        if ($user->lvl == 1){
            $lvl_val = 'nullable|numeric';
        } else {
            $lvl_val = 'nullable|numeric|not_in:1';
        }

        $data = $this->validate(request(), [
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:20|alpha_dash|unique:users,username,'.$id,
            'email'    => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'sometimes|nullable|string|min:6|confirmed',
            'lvl'      => $lvl_val,
        ]);

        if (request()->password) {
			$data['password'] = bcrypt(request('password'));
            $user->update($data);
        } else {
            $user->update($request->except('password', '_token', '_method', 'password_confirmation'));;
        }
        
        session()->flash('success', trans('admin.admin_updated'));
        return redirect(aurl('users'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (Auth::user()->cant('delete', $user)) {
            return back()->withErrors(['Current logged in user is not allowed to Delete this']);
        }
        $user->delete();
        session()->flash('success', trans('admin.deleted'));
        return redirect(aurl('users'));
    }
}
