<?php

namespace App\Services;

use App\Repositories\InternetAnalyticsRepository;

class InternetAnalyticsService
{
    protected $analyticsRepo;


    public function __construct(InternetAnalyticsRepository $analyticsRepo)
    {
        $this->analyticsRepo = $analyticsRepo;
    }

    public function getProcessedData()
    {
        return   $billing  = $this->analyticsRepo->getBillingReport();
    }

    public function getExcelData()
    {
        return $this->analyticsRepo->getBillingReport();
    }


    public function getMhmVcBilling()
    {
        return $this->analyticsRepo->getMhmVcBilling();
    }

    public function getMhmVcBillingExport()
    {
        return $this->analyticsRepo->getMhmVcBilling();
    }


    public function lksVcBilling()
    {
        return $this->analyticsRepo->getLksVcBilling();
    }

        public function lksVcBillingExport()
    {
        return $this->analyticsRepo->getLksVcBilling();
    }

    public function getMhmVcLks()
    {
        return $this->analyticsRepo->getMhmVcLks();
    }

    public function getMhmVcLksExport()
    {
        return $this->analyticsRepo->getMhmVcLks();
    }
}
