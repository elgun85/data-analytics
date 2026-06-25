<?php

namespace App\Http\Controllers;

use App\Services\InternetAnalyticsService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InternetAnalyticsController extends Controller
{
    protected $analyticsService;
    public function __construct(InternetAnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    public function index()
    {
        $data = $this->analyticsService->getProcessedData();
        return view('internet_analytics', compact('data'));
    }



    public function exportExcel(): StreamedResponse
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
            fputcsv($file, ['Telefon', 'Billing', 'MHM', 'LKŞ', 'Bill_Mhm Fərqi', 'Bill_LKŞ Fərqi'], ';');
            //Data gelir
            $data = $this->analyticsService->getExcelData();
            foreach ($data as $item) {
                fputcsv($file, [
                    $item->telefon,
                    $item->bill_summa,
                    $item->mhm_summa,
                    $item->lks_summa,
                    $item->bill_mhm_ferq,
                    $item->bill_lks_ferq
                ], ';');
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
