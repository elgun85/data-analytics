<?php

namespace App\Services;

use App\Repositories\InternetAnalyticsRepository;

class InternetAnalyticsService
{
 protected $analyticsRepo;


    public function __construct(InternetAnalyticsRepository $analyticsRepo)
    {
        $this->analyticsRepo=$analyticsRepo;
    }

    public function getProcessedData()
    {
         return   $billing  = $this->analyticsRepo->getBillingReport();


    }

}
