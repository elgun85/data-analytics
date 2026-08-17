<?php

namespace App\Http\Controllers;

use App\Services\PhoneAnalyticsService;
use App\Exports\BaseCsvExport;
use Symfony\Component\HttpFoundation\StreamedResponse;



class PhoneAnalyticsController extends Controller
{


    public function __construct(
        protected PhoneAnalyticsService $analyticsPhones,
        protected BaseCsvExport $export
    ) {}



    public function index()
    {
        $data = $this->analyticsPhones->getProcessedPhone();
        return view('phone_analytics', compact('data'));
    }

    public function exportCvc(): StreamedResponse
    {
        return $this->export->exportPhoneData();
    }
}
