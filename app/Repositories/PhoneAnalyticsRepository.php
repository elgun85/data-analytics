<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class PhoneAnalyticsRepository
{
    public function GetAnalyticsPhone()
    {
        $phones = DB::table('mhm_hesablamas')
            ->select('telefon')
            ->where('kod', 792)
            ->union(
                DB::table('gh8_lks')
                    ->select('NOTEL as telefon')
                    ->whereIn('KODISH', [1, 4, 7, 9, 10])
            );

        $mhm = DB::table('mhm_hesablamas')
            ->select(
                'telefon',
                'abonent',
                DB::raw('SUM(summa) as mhm_summa')
            )
            ->where('kod', 792)
            ->groupBy('telefon', 'abonent');

        $gh8 = DB::table('gh8_lks')
            ->select(
                'NOTEL',
                DB::raw('SUM(SUMMA) as lks_summa')
            )
            ->whereIn('KODISH', [1, 4, 7, 9, 10])
            ->groupBy('NOTEL');

        return    DB::query()
            ->fromSub($phones, 'p')
            ->leftJoinSub($mhm, 'mhm', function ($join) {
                $join->on('p.telefon', '=', 'mhm.telefon');
            })
            ->leftJoinSub($gh8, 'lks', function ($join) {
                $join->on('p.telefon', '=', 'lks.NOTEL');
            })
            ->select(
                'p.telefon',
                'mhm.abonent',
                DB::raw("CASE WHEN  COALESCE(mhm.abonent,0) = 1 THEN 'Mənzil' ELSE 'Qeyri-əhali' END as abonent"),

                DB::raw('COALESCE(mhm.mhm_summa,0) as mhm_summa'),
                DB::raw('COALESCE(lks.lks_summa,0) as lks_summa'),
                DB::raw('COALESCE(mhm.mhm_summa,0) - COALESCE(lks.lks_summa,0) as ferq'),
            )
            ->havingRaw('ABS(ferq) > 0.1')
            ->orderBy('ferq', 'desc')
            ->get()
        ;
    }
}
