<?php

namespace App\Http\Controllers;

use App\Client;
use App\DataTables\ClientDatatable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\Gate;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ClientDatatable $client)
    {
        // return view('admin.index');
        // dd(Client::get());
        return $client->render('admin.clients', ['title' => trans('admin.adminpanel')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create', ['title' => trans('admin.add_new')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate(request(),
            [
                'name'   => 'required',
                'gender' => 'required',
                'email'  => 'nullable|email|unique:clients',
            ], [], [
                'name'   => trans('admin.name'),
                'gender' => trans('admin.gender'),
                'email'  => trans('admin.email'),
            ]
        );
        $request['addby'] = Auth::user()->id;
        Client::create($request->except(['_token', '_method']));
        session()->flash('success', trans('admin.admin_added'));
        return redirect(aurl('clients'));
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
        $client = Client::find($id);
        $title  = trans('admin.edit');
        return view('admin.edit', compact('title', 'client'));
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

        if (Auth::user()->cant('update', Client::find($id))) {
            return back()->withErrors(['Current logged in user is not allowed to Edit this']);
        }

        $data = $this->validate(request(),
            [
                'name'   => 'required',
                'gender' => 'required',
                'email'  => 'nullable|email|unique:clients,email,' . $id,
                'statu'  => 'required',
            ], [], [
                'name'   => trans('admin.name'),
                'gender' => trans('admin.gender'),
                'email'  => trans('admin.email'),
                'statu'  => trans('admin.statu'),
            ]
        );
        // dd($request->all());
        // unset($request['gender']);
        // dd($request->only(
        // 'email', 'name', 'gender', 'token'
        // ));
        if ($request['f_call']) {
            unset($request['statu']);
            $client             = Client::find($id);
            $request['f_calls'] = $client['f_calls'] + 1;
            if (!empty($client['f_calls_rec'])) {
                $f_calls_rec = json_decode($client['f_calls_rec']);
            }

            $f_calls_rec[]          = [Carbon::now()->toDateTimeString(), Auth::user()->id];
            $request['f_calls_rec'] = json_encode($f_calls_rec);
        } else {
            $this->check_statu($request, $id);
        }
        Client::where('id', $id)->update($request->except(['_token', '_method', 'addby', 'f_call', 'try_note']));
        session()->flash('success', trans('admin.admin_updated'));
        return redirect(aurl('clients'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->cant('delete', Client::find($id))) {
            return back()->withErrors(['Current logged in user is not allowed to Delete this']);
        }
        Client::find($id)->delete();
        session()->flash('success', trans('admin.deleted'));
        return redirect(aurl('clients'));
    }

    protected function check_statu($request, $id)
    {
        // dd(json_encode($arr_med));
        // dd(json_decode($foqjson));

        $client = Client::find($id);

        if (!isset($request['statu']) || $request['statu'] == $client['statu']) {
            return;
        }

        if ($client['statu'] == 'n') {

            if ($request['statu'] == 'p') {
                $request['init']      = Carbon::now()->toDateTimeString();
                $request['respon_id'] = Auth::user()->id;
            } elseif ($request['statu'] == 'a') {
                $trying = !empty($client['tries']) ? json_decode($client['tries']) : array();
                array_unshift($trying, [['n', 'a'], [Carbon::now()->toDateTimeString()], [Auth::user()->id], $request['try_note']]);
                $request['tries'] = json_encode($trying);
            } elseif ($request['statu'] == 'f') {
                $trying = !empty($client['tries']) ? json_decode($client['tries']) : array();
                array_unshift($trying, [['n', 'f'], [Carbon::now()->toDateTimeString()], [Auth::user()->id], $request['try_note']]);
                $request['tries'] = json_encode($trying);
            } elseif ($request['statu'] == 's') {
                $trying = !empty($client['tries']) ? json_decode($client['tries']) : array();
                array_unshift($trying, [['n', 's'], [Carbon::now()->toDateTimeString()], [Auth::user()->id], $request['try_note']]);
                $request['tries'] = json_encode($trying);
            }

        } elseif ($client['statu'] == 'p') {

            if ($request['statu'] == 'n') {
                $request['init']      = null;
                $request['respon_id'] = null;
            } elseif ($request['statu'] == 'a') {
                $trying = !empty($client['tries']) ? json_decode($client['tries']) : array();
                array_unshift($trying, [['p', 'a'], [$client['init'], Carbon::now()->toDateTimeString()], [(int) ($client['respon_id']), Auth::user()->id], $request['try_note']]);
                $request['tries']     = json_encode($trying);
                $request['init']      = null;
                $request['respon_id'] = null;
            } elseif ($request['statu'] == 'f') {
                $trying = !empty($client['tries']) ? json_decode($client['tries']) : array();
                array_unshift($trying, [['p', 'f'], [$client['init'], Carbon::now()->toDateTimeString()], [(int) ($client['respon_id']), Auth::user()->id], $request['try_note']]);
                $request['tries']     = json_encode($trying);
                $request['init']      = null;
                $request['respon_id'] = null;
            } elseif ($request['statu'] == 's') {
                $trying = !empty($client['tries']) ? json_decode($client['tries']) : array();
                array_unshift($trying, [['p', 's'], [$client['init'], Carbon::now()->toDateTimeString()], [(int) ($client['respon_id']), Auth::user()->id], $request['try_note']]);
                $request['tries']     = json_encode($trying);
                $request['init']      = null;
                $request['respon_id'] = null;
            }

        } elseif ($client['statu'] == 'a') {

            if ($request['statu'] == 'n') {

            } elseif ($request['statu'] == 'p') {
                $request['init']      = Carbon::now()->toDateTimeString();
                $request['respon_id'] = Auth::user()->id;
            } elseif ($request['statu'] == 'f') {
                $trying = !empty($client['tries']) ? json_decode($client['tries']) : array();
                array_unshift($trying, [['a', 'f'], [Carbon::now()->toDateTimeString()], [Auth::user()->id], $request['try_note']]);
                $request['tries'] = json_encode($trying);
            } elseif ($request['statu'] == 's') {
                $trying = !empty($client['tries']) ? json_decode($client['tries']) : array();
                array_unshift($trying, [['a', 's'], [Carbon::now()->toDateTimeString()], [Auth::user()->id], $request['try_note']]);
                $request['tries'] = json_encode($trying);
            }

        } elseif ($client['statu'] == 'f') {

            if ($request['statu'] == 'n') {

            } elseif ($request['statu'] == 'p') {
                $request['init']      = Carbon::now()->toDateTimeString();
                $request['respon_id'] = Auth::user()->id;
            } elseif ($request['statu'] == 'a') {
                $trying = !empty($client['tries']) ? json_decode($client['tries']) : array();
                array_unshift($trying, [['f', 'a'], [Carbon::now()->toDateTimeString()], [Auth::user()->id], $request['try_note']]);
                $request['tries'] = json_encode($trying);
            } elseif ($request['statu'] == 's') {
                $trying = !empty($client['tries']) ? json_decode($client['tries']) : array();
                array_unshift($trying, [['f', 's'], [Carbon::now()->toDateTimeString()], [Auth::user()->id], $request['try_note']]);
                $request['tries'] = json_encode($trying);
            }

        } elseif ($client['statu'] == 's') {

            if ($request['statu'] == 'n') {

            } elseif ($request['statu'] == 'p') {
                $request['init']      = Carbon::now()->toDateTimeString();
                $request['respon_id'] = Auth::user()->id;
            } elseif ($request['statu'] == 'a') {
                $trying = !empty($client['tries']) ? json_decode($client['tries']) : array();
                array_unshift($trying, [['s', 'a'], [Carbon::now()->toDateTimeString()], [Auth::user()->id], $request['try_note']]);
                $request['tries'] = json_encode($trying);
            } elseif ($request['statu'] == 'f') {
                $trying = !empty($client['tries']) ? json_decode($client['tries']) : array();
                array_unshift($trying, [['s', 'f'], [Carbon::now()->toDateTimeString()], [Auth::user()->id], $request['try_note']]);
                $request['tries'] = json_encode($trying);
            }

        }
    }
}
