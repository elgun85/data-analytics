<?php

namespace App\Http\Controllers;

use App\Services\InternetAnalyticsService;

class InternetAnalyticsController extends Controller
{
    protected $analyticsService;
    public function __construct(InternetAnalyticsService $analyticsService)
    {
        $this->analyticsService=$analyticsService;
    }

    public function index()
    {
        $data=$this->analyticsService->getProcessedData();
        dd($data);
        return view('internet_analytics',compact('data'));

    }
}
