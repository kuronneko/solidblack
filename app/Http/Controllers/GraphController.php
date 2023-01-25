<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Logger;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Chart;
use Carbon\Carbon;

class GraphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Graph/Index');
    }


    public function getTotal(){

        $type = request('type');
        $date = request('date');

        if($date == 'all'){
            $visits = Logger::where('user_id', Auth::user()->id)->selectRaw(''.$type.', COUNT(*) as total')
            ->groupBy($type)
            ->orderBy('total', 'desc')
            ->get();
        }else if($date == 'day'){
            $visits = Logger::where('user_id', Auth::user()->id)->where('created_at', '>=', Carbon::now()->subDay())->selectRaw(''.$type.', COUNT(*) as total')
            ->groupBy($type)
            ->orderBy('total', 'desc')
            ->get();
        }else if($date == 'week'){
            $visits = Logger::where('user_id', Auth::user()->id)->where('created_at', '>=', Carbon::now()->subWeek())->selectRaw(''.$type.', COUNT(*) as total')
            ->groupBy($type)
            ->orderBy('total', 'desc')
            ->get();
        }else if($date == 'month'){
            $visits = Logger::where('user_id', Auth::user()->id)->where('created_at', '>=', Carbon::now()->subMonth())->selectRaw(''.$type.', COUNT(*) as total')
            ->groupBy($type)
            ->orderBy('total', 'desc')
            ->get();
        }else if($date == 'year'){
            $visits = Logger::where('user_id', Auth::user()->id)->where('created_at', '>=', Carbon::now()->subYear())->selectRaw(''.$type.', COUNT(*) as total')
            ->groupBy($type)
            ->orderBy('total', 'desc')
            ->get();
        }
        $customChart = new Chart;
        $customChart->title = $type;
        $customChart->labels = $visits->pluck($type);
        $customChart->dataset = $visits->pluck('total');

        return $customChart;
    }

/*     public function getCountryTotal(){
        $visits = Logger::selectRaw('country, COUNT(*) as total')
                ->groupBy('country')
                ->orderBy('total', 'desc')
                ->get();

        $customChart = new Chart;
        $customChart->labels = $visits->pluck('country');
        $customChart->dataset = $visits->pluck('total');

        return $customChart;
    }

    public function getPlatformTotal(){
        $visits = Logger::selectRaw('platform, COUNT(*) as total')
                ->groupBy('platform')
                ->orderBy('total', 'desc')
                ->get();

        $customChart = new Chart;
        $customChart->labels = $visits->pluck('platform');
        $customChart->dataset = $visits->pluck('total');

        return $customChart;
    }

    public function getBrowserTotal(){
        $visits = Logger::selectRaw('browser, COUNT(*) as total')
                ->groupBy('browser')
                ->orderBy('total', 'desc')
                ->get();

        $customChart = new Chart;
        $customChart->labels = $visits->pluck('browser');
        $customChart->dataset = $visits->pluck('total');

        return $customChart;
    } */
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
