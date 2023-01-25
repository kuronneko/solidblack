<?php

namespace App\Http\Controllers;

use App\Exports\LoggersExport;
use App\Imports\LoggersImport;
use App\Models\Logger;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Jenssegers\Agent\Facades\Agent;
use Stevebauman\Location\Facades\Location;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class LoggerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getNetwork(){
        try {
            if(env('APP_ENV') == 'local'){
                $ip = '200.86.155.87';
            }else if(env('APP_ENV') == 'production'){
                $ip = getenv('HTTP_CLIENT_IP')?:
                getenv('HTTP_X_FORWARDED_FOR')?:
                getenv('HTTP_X_FORWARDED')?:
                getenv('HTTP_FORWARDED_FOR')?:
                getenv('HTTP_FORWARDED')?:
                getenv('REMOTE_ADDR');
            }
            $uuid = Request::route('uuid');
            $logger = new Logger();
            $logger->user_id = Setting::where('uuid', $uuid)->first()->user->id;
            $logger->ip = $ip;
            $logger->country = Location::get($ip)->countryName;
            $logger->city = Location::get($ip)->cityName;
            $logger->browser = Agent::browser();
            $logger->browser_version = Agent::version(Agent::browser());
            $logger->platform = Agent::platform();
            $logger->platform_version = Agent::version(Agent::platform());
            $logger->agent = Request::header('user-agent');
            $logger->host = gethostbyaddr($ip);
            $logger->save();

            if($logger->user->setting->silence_mode == 1){
                return response()->json(['success' => 'Connection successfully']);
            }else if($logger->user->setting->silence_mode == 0 && $logger->user->setting->redirect !== null){
                return Redirect::away($logger->user->setting->redirect);
            }

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $loggers = Logger::where('user_id', Auth::user()->id)->orderBy("created_at", 'desc');
        $search = "";
        if (request()->has("search")) {
            $search = request("search");
            $loggers = $loggers->where(DB::raw('concat(country, city)'), 'like', '%' . str_replace(',', '', str_replace(' ', '', $search)) . '%')
            ->orWhere('ip', 'like', '%' . str_replace(',', '', str_replace(' ', '', $search)) . '%')->where('user_id', Auth::user()->id);
        }
        $loggers = $loggers->paginate(10)->appends(request()->except("page"));
        return Inertia::render('Logger/Index', compact('loggers','search'));
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
    public function show(Logger $logger)
    {
        return Inertia::render('Logger/Index', compact('logger'));
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
    public function deleteAllLogs()
    {
            if(Hash::check(request('password'), auth()->user()->password)){
                try {
                    $user = User::findOrFail(auth()->user()->id);
                    $logger = Logger::where('user_id', $user->id);
                    $logger->delete();
                    return redirect()->back()->with('message', 'All Logs was deleted successfully');
                } catch (\Throwable $th) {
                    return response()->json(['error' => $th->getMessage()]);
                }
            }else{
                throw ValidationException::withMessages([
                    'password' => __('The password is incorrect.'),
                ]);
            }
    }

    public function export()
    {
        try {
            return Excel::download(new LoggersExport, 'loggers '. Date::now() .'.xlsx');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([
                'error' => $th->getMessage()
            ]);
        }
    }

    public function import()
    {
        try {
            Excel::import(new LoggersImport, request()->file('file'));
            return redirect()->back()->with('message', 'Logger uploaded successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([
                'error' => 'Invalid file type format or ' . $th->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logger $logger)
    {
        try {
            if(auth()->user()->id == $logger->user->id){
                $logger->delete();
                return redirect()->back()->with('message', 'Logger deleted');
            }else{
                return response()->json(['error' => 'Access deny']);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
