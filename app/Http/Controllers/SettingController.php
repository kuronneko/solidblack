<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;


class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function silenceToggle(User $user){
        try {
            if(auth()->user()->id == $user->id){
                //$setting = Setting::where('user_id', auth()->user()->id)->first();
                if($user->setting->silence_mode == 1){
                    $user->setting->silence_mode = 0;
                }else{
                    $user->setting->silence_mode = 1;
                }
                if($user->setting->redirect === null){
                    $user->setting->redirect = 'https://www.google.com';
                }
                $user->setting->save();
                return redirect()->back();
                //return Inertia::render('Dashboard', compact('user'));
            }else{
                return response()->json(['error' => 'Access deny']);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function generateSlug(User $user){
        try {
            if(auth()->user()->id == $user->id && $user->setting->slug === null){
                    $user->setting->slug = Str::random(6);
                    $user->setting->save();
                    return redirect()->back();
            }else{
                return response()->json(['error' => 'Access deny']);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function saveRedirect(){
        $user = User::findOrFail(request('user'));
        try {
            if(auth()->user()->id == $user->id){
                if(request('redirect') != '' && $user->setting->silence_mode == 0){
                    $user->setting->redirect = request('redirect');
                    $user->setting->save();
                    return redirect()->back();
                }else{
                    return response()->json(['error' => 'Access deny']);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
