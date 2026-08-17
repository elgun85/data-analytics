<?php

namespace App\Http\Controllers;

use App\Exports\BaseCsvExport;
use App\Services\InternetAnalyticsService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InternetAnalyticsController extends Controller
{
    protected $analyticsService;
    protected $baseCsvExport;
    public function __construct(InternetAnalyticsService $analyticsService, BaseCsvExport $baseCsvExport)
    {
        $this->analyticsService = $analyticsService;
        $this->baseCsvExport = $baseCsvExport;
    }


    public function lksVcBilling()
    {
        $data = $this->analyticsService->lksVcBilling();
        $total = $data->count();
        return view('lksVcBilling', compact('data','total'));
    }

    public function lksVcBillingExport()
    {
        return $this->baseCsvExport->lksVcBillingExport();
    }

    public function mhmVcBilling()
    {
        $data = $this->analyticsService->getMhmVcBilling();
        $total = $data->count();
        return view('mhmVcBilling', compact('data','total'));
    }

    public function mhmVcBillingExport(): StreamedResponse
    {
        return $this->baseCsvExport->mhmVcBillingExport();
    }

    public function mhmVcLks()
    {
        $data = $this->analyticsService->getMhmVcLks();
        $total = $data->count();
        return view('mhmVcLks', compact('data','total'));
    }

    public function mhmVcLksExport(): StreamedResponse
    {
        return $this->baseCsvExport->mhmVcLksExport();
    }

    /*     public function index()
    {
        $data = $this->analyticsService->getProcessedData();
        return view('internet_analytics', compact('data'));
    } */


    /*     public function exportExcel(): StreamedResponse
    {
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=billing_report.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () {

            $file = fopen('php://output', 'w');
            // Excel-də Azərbaycan şriftlərinin (ö, ç, ş, ı...) düzgün görünməsi üçün BOM əlavə edirik
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            // Sütun başlığı (Excel-in sütunlara düzgün ayırması üçün separator olaraq vergül istifadə edirik)
            fputcsv($file, ['Telefon',  'MHM', 'Billing', 'Bill_Mhm Fərqi', 'Kateqoriya'], ',');
            //Data gelir
            $data = $this->analyticsService->getExcelData();
            foreach ($data as $item) {
                fputcsv($file, [
                    $item->telefon,
                    $item->mhm_summa,
                    $item->bill_summa,
                    $item->bill_mhm_ferq,
                    $item->abonent

                ], ',');
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    } */
}
