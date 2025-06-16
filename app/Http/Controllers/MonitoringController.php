<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        // Dummy data (bisa diganti ambil dari database atau API)
        $electricCurrentLabels = ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '23:59'];
        $electricCurrentData = [8.2, 7.5, 12.4, 15.7, 18.2, 14.5, 9.8];
        $electricForecastData = [7.8, 8.1, 11.9, 16.2, 17.8, 15.1, 10.2];

        return view('monitoring.index', compact(
            'electricCurrentLabels',
            'electricCurrentData',
            'electricForecastData'
        ));
    }
}
