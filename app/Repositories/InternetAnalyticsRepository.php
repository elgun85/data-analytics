<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class InternetAnalyticsRepository
{

    public function getBilling()
    {
        return DB::table('int_billings')
            ->select(
                'telefon',
                'abune as summa'
            )
            ->take(20)
            ->get();
    }

    public function getMhmInternet()
    {
        return DB::table('mhm_hesablamas')
            ->select(
                'telefon',
                DB::raw('SUM(summa) as summa')
            )
            ->where('kod', 793)
            ->groupBy('telefon')
            ->take(10)
            ->get();
    }

    public function getMhmPhone()
    {
        return DB::table('mhm_hesablamas')
            ->select(
                'telefon',
                DB::raw('SUM(summa) as summa')
            )
            ->where('kod', 792)
            ->groupBy('telefon')
            ->take(10)
            ->get();
    }

    public function getGH8Internet()
    {
        return DB::table('gh8_lks')
            ->select(
                'NOTEL as telefon',
                DB::raw('SUM(SUMMA) as summa')
            )
            ->whereIn('KODISH', [5, 6])
            ->groupBy('telefon')
            ->take(1110)
            ->get();
    }

    public function getBillingReport()
    {
        $mhm = DB::table('mhm_hesablamas')
            ->select(
                'telefon',
                DB::raw('SUM(summa) as mhm_summa')
            )
            ->where('kod', 793)
            ->groupBy('telefon');

        $gh8 = DB::table('gh8_lks')
            ->select(
                'NOTEL',
                DB::raw('SUM(SUMMA) as gh8_summa')
            )
            ->whereIn('KODISH', [5, 6])
            ->groupBy('NOTEL');

        return DB::table('int_billings as b')
            ->leftJoinSub($mhm, 'mhm', function ($join) {
                $join->on('b.telefon', '=', 'mhm.telefon');
            })
            ->leftJoinSub($gh8, 'gh8', function ($join) {
                $join->on('b.telefon', '=', 'gh8.NOTEL');
            })
            ->select(
                'b.telefon',
                'b.abune as bill_summa',
                DB::raw('COALESCE(mhm.mhm_summa,0) as mhm_summa'),
                DB::raw('COALESCE(gh8.gh8_summa,0) as gh8_summa'),
                DB::raw('(
        COALESCE(b.abune,0) -
        COALESCE(mhm.mhm_summa,0)
    ) as bill_mhm_ferq'),

                DB::raw('(
        COALESCE(b.abune,0) -
        COALESCE(gh8.gh8_summa,0)
    ) as bill_lks_ferq')
            )
            ->havingRaw('ABS(bill_mhm_ferq) > 1')
            ->get();
    }
}
