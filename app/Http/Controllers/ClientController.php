<?php

namespace App\Http\Controllers;

use App\Client;
use App\DataTables\ClientDatatable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $data['addby'] = Auth::user()->id;
        Client::create($data);
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
        if ($request['f_call']){
            unset($request['statu']);
            $client = Client::find($id);
            $request['f_calls'] = $client['f_calls'] + 1;
            if (!empty($client['f_calls_rec']))
                $f_calls_rec = json_decode($client['f_calls_rec']);
            $f_calls_rec[] = [Carbon::now()->toDateTimeString(), Auth::user()->id];
            $request['f_calls_rec'] = json_encode($f_calls_rec);
        }else{
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

        if ($client['statu'] == 0) {

            if ($request['statu'] == 1) {
                $request['init']      = Carbon::now()->toDateTimeString();
                $request['respon_id'] = Auth::user()->id;
            }elseif($request['statu'] == 2){
                if (!empty($client['tries']))
                    $trying = json_decode($client['tries']);
                $trying[] = [['n', 'a'], [Carbon::now()->toDateTimeString()], [Auth::user()->id], $request['try_note']];
                $request['tries'] = json_encode($trying);
            }elseif($request['statu'] == 3){
                if (!empty($client['tries']))
                    $trying = json_decode($client['tries']);
                $trying[] = [['n', 'f'], [Carbon::now()->toDateTimeString()], [Auth::user()->id], $request['try_note']];
                $request['tries'] = json_encode($trying);
            }elseif($request['statu'] == 4){
                if (!empty($client['tries']))
                    $trying = json_decode($client['tries']);
                $trying[] = [['n', 's'], [Carbon::now()->toDateTimeString()], [Auth::user()->id], $request['try_note']];
                $request['tries'] = json_encode($trying);
            }

        } elseif ($client['statu'] == 1) {

            if ($request['statu'] == 0) {
                $request['init']      = null;
                $request['respon_id'] = null;
            }elseif($request['statu'] == 2){
                if (!empty($client['tries']))
                    $trying = json_decode($client['tries']);
                $trying[] = [['p', 'a'], [$client['init'], Carbon::now()->toDateTimeString()], [$client['respon_id'], Auth::user()->id], $request['try_note']];
                $request['tries'] = json_encode($trying);
                $request['init']      = null;
                $request['respon_id'] = null;
            }elseif($request['statu'] == 3){
                if (!empty($client['tries']))
                    $trying = json_decode($client['tries']);
                $trying[] = [['p', 'f'], [$client['init'], Carbon::now()->toDateTimeString()], [$client['respon_id'], Auth::user()->id], $request['try_note']];
                $request['tries'] = json_encode($trying);
                $request['init']      = null;
                $request['respon_id'] = null;
            }elseif($request['statu'] == 4){
                if (!empty($client['tries']))
                    $trying = json_decode($client['tries']);
                $trying[] = [['p', 's'], [$client['init'], Carbon::now()->toDateTimeString()], [$client['respon_id'], Auth::user()->id], $request['try_note']];
                $request['tries'] = json_encode($trying);
                $request['init']      = null;
                $request['respon_id'] = null;
            }

        } elseif ($client['statu'] == 2) {
            
            if ($request['statu'] == 0) {

            }elseif($request['statu'] == 1){
                $request['init']      = Carbon::now()->toDateTimeString();
                $request['respon_id'] = Auth::user()->id;
            }elseif($request['statu'] == 3){
                if (!empty($client['tries']))
                    $trying = json_decode($client['tries']);
                $trying[] = [['a', 'f'], [Carbon::now()->toDateTimeString()], [Auth::user()->id], $request['try_note']];
                $request['tries'] = json_encode($trying);
            }elseif($request['statu'] == 4){
                if (!empty($client['tries']))
                    $trying = json_decode($client['tries']);
                $trying[] = [['a', 's'], [Carbon::now()->toDateTimeString()], [Auth::user()->id], $request['try_note']];
                $request['tries'] = json_encode($trying);
            }

        } elseif ($client['statu'] == 3) {
            
            if ($request['statu'] == 0) {
                
            }elseif($request['statu'] == 1){
                $request['init']      = Carbon::now()->toDateTimeString();
                $request['respon_id'] = Auth::user()->id;
            }elseif($request['statu'] == 2){
                if (!empty($client['tries']))
                    $trying = json_decode($client['tries']);
                $trying[] = [['f', 'a'], [Carbon::now()->toDateTimeString()], [Auth::user()->id], $request['try_note']];
                $request['tries'] = json_encode($trying);
            }elseif($request['statu'] == 4){
                if (!empty($client['tries']))
                    $trying = json_decode($client['tries']);
                $trying[] = [['f', 's'], [Carbon::now()->toDateTimeString()], [Auth::user()->id], $request['try_note']];
                $request['tries'] = json_encode($trying);
            }

        } elseif ($client['statu'] == 4) {

            if ($request['statu'] == 0) {
                
            }elseif($request['statu'] == 1){
                $request['init']      = Carbon::now()->toDateTimeString();
                $request['respon_id'] = Auth::user()->id;
            }elseif($request['statu'] == 2){
                if (!empty($client['tries']))
                    $trying = json_decode($client['tries']);
                $trying[] = [['s', 'a'], [Carbon::now()->toDateTimeString()], [Auth::user()->id], $request['try_note']];
                $request['tries'] = json_encode($trying);
            }elseif($request['statu'] == 3){
                if (!empty($client['tries']))
                    $trying = json_decode($client['tries']);
                $trying[] = [['s', 'f'], [Carbon::now()->toDateTimeString()], [Auth::user()->id], $request['try_note']];
                $request['tries'] = json_encode($trying);
            }

        }
    }
}
