<?php

namespace App\Exports;

use App\Services\PhoneAnalyticsService;


class BaseCsvExport
{
    protected PhoneAnalyticsService $phoneAnalyticsService;

    public function __construct(PhoneAnalyticsService $phoneAnalyticsService)
    {
        $this->phoneAnalyticsService = $phoneAnalyticsService;
    }

    public  function exportPhoneData()
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
            fputcsv($file, ['Telefon',  'MHM', 'LKŞ', 'Fərq', 'Kateqoriya'], ';');
            //Data gelir
            $data = $this->phoneAnalyticsService->getCvcData();
            foreach ($data as $item) {
                fputcsv($file, [
                    $item->telefon,
                    $item->mhm_summa,
                    $item->lks_summa,
                    $item->ferq,
                    $item->abonent

                ], ';');
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
