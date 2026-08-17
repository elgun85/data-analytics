<?php

namespace App\Exports;

use App\Services\InternetAnalyticsService;
use App\Services\PhoneAnalyticsService;


class BaseCsvExport
{
    protected PhoneAnalyticsService $phoneAnalyticsService;
    protected InternetAnalyticsService $analyticsService;

    public function __construct(PhoneAnalyticsService $phoneAnalyticsService, InternetAnalyticsService $analyticsService)
    {
        $this->phoneAnalyticsService = $phoneAnalyticsService;
        $this->analyticsService = $analyticsService;
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
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            // fwrite($file,"sep=:\n");
            fputcsv($file, ['Telefon',  'MHM', 'LKŞ', 'Fərq', 'Kateqoriya'], ',');
            $data = $this->phoneAnalyticsService->getCvcData();
            foreach ($data as $item) {
                fputcsv($file, [
                    $item->telefon,
                    $item->mhm_summa,
                    $item->lks_summa,
                    $item->ferq,
                    $item->abonent

                ], ',');
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function lksVcBillingExport()
    {
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=lks_bill_int.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () {

            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['Telefon',  'LKŞ', 'Billing', 'Lkş_Billing_fərqi', 'Kateqoriya'], ',');
            $data = $this->analyticsService->lksVcBillingExport();
            foreach ($data as $item) {
                fputcsv($file, [
                    $item->telefon,
                    $item->lks_summa,
                    $item->bill_summa,
                    $item->lks_bill_ferq,
                    $item->kateqoriya

                ], ',');
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
    public function mhmVcLksExport()
    {
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=mhm_lks_int.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () {

            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['Telefon',  'MHM', 'LKŞ', 'Mhm_Lkş fərqi', 'Kateqoriya'], ',');
            $data = $this->analyticsService->getMhmVcLksExport();
            foreach ($data as $item) {
                fputcsv($file, [
                    $item->telefon,
                    $item->mhm_summa,
                    $item->lks_summa,
                    $item->lks_mhm_ferq,
                    $item->kateqoriya

                ], ',');
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function mhmVcBillingExport()
    {
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=mhm_billing.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () {

            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['Telefon',  'MHM', 'Billing', 'Bill_Mhm Fərqi', 'Kateqoriya'], ',');
            $data = $this->analyticsService->getMhmVcBillingExport();
            foreach ($data as $item) {
                fputcsv($file, [
                    $item->telefon,
                    $item->mhm_summa,
                    $item->bill_summa,
                    $item->bill_mhm_ferq,
                    $item->kateqoriya

                ], ',');
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
