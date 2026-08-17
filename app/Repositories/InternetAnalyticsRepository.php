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

    public function getLksVcBilling()
    {
        $phones = DB::table('int_billings')
            ->select('telefon')
            ->union(
                DB::table('gh8_lks')
                    ->select('NOTEL')
                    ->whereIn('KODISH', [5, 6])
            );

        $lks = DB::table('gh8_lks')
            ->select(
                'NOTEL',
                'ABONENT',
                DB::raw('SUM(SUMMA) as lks_summa')
            )->whereIn('KODISH', [5, 6])
            ->groupBy('NOTEL', 'ABONENT');

        return DB::query()
            ->fromSub($phones, 'p')
            ->leftJoin('int_billings as b', 'p.telefon', '=', 'b.telefon')
            ->leftJoinSub($lks, 'lks', function ($join) {
                $join->on('p.telefon', '=', 'lks.NOTEL');
            })
            ->select(
                'p.telefon',
                'b.nov',
                'lks.ABONENT',
                DB::raw('COALESCE(lks.lks_summa,0) as lks_summa'),
                DB::raw('COALESCE(b.abune,0) as bill_summa'),
                DB::raw('COALESCE(lks.lks_summa,0) - COALESCE(b.abune,0) as lks_bill_ferq'),
                DB::raw("
                CASE WHEN lks.ABONENT IS NOT NULL THEN
                    CASE lks.ABONENT
                        WHEN 1 THEN 'Mənzil'
                        WHEN 2 THEN 'İdarə'
                        ELSE 'Naməlum'
                    END 
                    WHEN b.nov IS NOT NULL THEN
                        CASE b.nov
                            WHEN 1 THEN 'Mənzil'
                            WHEN 2 THEN 'İdarə'
                         
                            ELSE 'Naməlum'
                    END 
                        ELSE 'Kateqoriya yoxdur'
                 END as kateqoriya                        
                ")
            )
            ->havingRaw('ABS(lks_bill_ferq) > 1')
            ->orderBy('lks_bill_ferq', 'desc')
            ->get();
    }


    public function getMhmVcLks()
    {
        $phones = DB::table('mhm_hesablamas')
            ->select('telefon')
            ->where('kod', 793)
            ->union(
                DB::table('gh8_lks')
                    ->select('NOTEL')
                    ->whereIn('KODISH', [5, 6])
            );

        $mhm = DB::table('mhm_hesablamas')
            ->select(
                'telefon',
                'abonent',
                DB::raw('SUM(summa) as mhm_summa')
            )
            ->where('kod', 793)
            ->groupBy('telefon', 'abonent');

        $lks = DB::table('gh8_lks')
            ->select(
                'NOTEL',
                'ABONENT',
                DB::raw('SUM(SUMMA) as lks_summa')
            )->whereIn('KODISH', [5, 6])
            ->groupBy('NOTEL', 'ABONENT');


        return DB::query()
            ->fromSub($phones, 'p')
            //->leftJoin('gh8_lks as lks', 'p.telefon', '=', 'lks.NOTEL')
            ->leftJoinSub($lks, 'lks', function ($join) {
                $join->on('p.telefon', '=', 'lks.NOTEL');
            })
            ->leftJoinSub($mhm, 'mhm', function ($join) {
                $join->on('p.telefon', '=', 'mhm.telefon');
            })
            ->select(
                'p.telefon',
                'mhm.abonent',
                'lks.ABONENT',
                DB::raw('COALESCE(mhm.mhm_summa,0) as mhm_summa'),
                DB::raw('COALESCE(lks.lks_summa,0) as lks_summa'),
                DB::raw('COALESCE(lks.lks_summa,0) - COALESCE(mhm.mhm_summa,0) as lks_mhm_ferq'),
                DB::raw("
                CASE WHEN mhm.abonent IS NOT NULL THEN
                    CASE mhm.abonent
                        WHEN 1 THEN 'Mənzil'
                        WHEN 2 THEN 'İdarə'
                        ELSE 'Naməlum'
                    END 
                    WHEN lks.ABONENT IS NOT NULL THEN
                        CASE lks.ABONENT
                            WHEN 1 THEN 'Mənzil'
                            WHEN 2 THEN 'İdarə'
                         
                            ELSE 'Naməlum'
                    END 
                        ELSE 'Kateqoriya yoxdur'
                 END as kateqoriya             
    
                 
                ")


            )
            ->havingRaw('ABS(lks_mhm_ferq) > 1')
            ->orderBy('lks_mhm_ferq', 'desc')
            ->get();
    }


    public function getMhmVcBilling()
    {
        $phones = DB::table('int_billings')
            ->select('telefon')
            ->union(
                DB::table('mhm_hesablamas')
                    ->select('telefon')
                    ->where('kod', '793')
            );

        $mhm = DB::table('mhm_hesablamas')
            ->select(
                'telefon',
                'abonent',
                DB::raw('SUM(summa) as mhm_summa')
            )
            ->where('kod', 793)
            ->groupBy('telefon', 'abonent');

        return DB::query()
            ->fromSub($phones, 'p')
            ->leftJoin('int_billings as b', 'p.telefon', '=', 'b.telefon')
            ->leftJoinSub($mhm, 'mhm', function ($join) {
                $join->on('p.telefon', '=', 'mhm.telefon');
            })
            ->select(

                'p.telefon',
                'mhm.abonent',
                'b.nov',
                DB::raw('COALESCE(b.abune,0) as bill_summa'),
                DB::raw('COALESCE(mhm.mhm_summa,0) as mhm_summa'),
                DB::raw('COALESCE(b.abune,0) - COALESCE(mhm.mhm_summa,0) as bill_mhm_ferq'),
                DB::raw("
                CASE WHEN mhm.abonent IS NOT NULL THEN
                    CASE mhm.abonent
                        WHEN 1 THEN 'Mənzil'
                        WHEN 2 THEN 'İdarə'
                        ELSE 'Naməlum'
                    END 
                    WHEN b.nov IS NOT NULL THEN
                        CASE b.nov
                            WHEN 1 THEN 'Mənzil'
                            WHEN 2 THEN 'İdarə'
                            WHEN 4 THEN 'İdarə'
                            ELSE 'Naməlum'
                    END 
                        ELSE 'Kateqoriya yoxdur'
                 END as kateqoriya             
    
                 
                ")
            )
            ->havingRaw('ABS(bill_mhm_ferq) > 1')
            ->orderBy('bill_mhm_ferq', 'desc')
            ->get();
    }



    public function getBillingReport()
    {
        $phones = DB::table('int_billings')
            ->select('telefon')
            ->union(
                DB::table('mhm_hesablamas')
                    ->select('telefon')
                    ->where('kod', 793)
            )
            ->union(
                DB::table('gh8_lks')
                    ->select('NOTEL as telefon')
                    ->whereIn('KODISH', [5, 6])
            );

        $mhm = DB::table('mhm_hesablamas')
            ->select(
                'telefon',
                'abonent',
                DB::raw('SUM(summa) as mhm_summa')
            )
            ->where('kod', 793)
            ->groupBy('telefon', 'abonent');

        $gh8 = DB::table('gh8_lks')
            ->select(
                'NOTEL',
                DB::raw('SUM(SUMMA) as gh8_summa')
            )
            ->whereIn('KODISH', [5, 6])
            ->groupBy('NOTEL');

        return DB::query()
            ->fromSub($phones, 'p')
            ->leftJoin('int_billings as b', 'p.telefon', '=', 'b.telefon')
            ->leftJoinSub($mhm, 'mhm', function ($join) {
                $join->on('p.telefon', '=', 'mhm.telefon');
            })
            ->leftJoinSub($gh8, 'gh8', function ($join) {
                $join->on('p.telefon', '=', 'gh8.NOTEL');
            })
            ->select(
                'p.telefon',
                'mhm.abonent',
                DB::raw('COALESCE(b.abune,0) as bill_summa'),
                DB::raw('COALESCE(mhm.mhm_summa,0) as mhm_summa'),
                DB::raw('COALESCE(gh8.gh8_summa,0) as lks_summa'),

                DB::raw('COALESCE(b.abune,0) - COALESCE(mhm.mhm_summa,0) as bill_mhm_ferq'),
                DB::raw('COALESCE(b.abune,0) - COALESCE(gh8.gh8_summa,0) as bill_lks_ferq')

            )
            ->havingRaw('ABS(bill_mhm_ferq) > 1')
            ->orderBy('bill_mhm_ferq', 'desc')
            ->get();
    }
}
