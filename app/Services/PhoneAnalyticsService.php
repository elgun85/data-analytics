<?php

namespace App\Services;

use App\Repositories\PhoneAnalyticsRepository;

class PhoneAnalyticsService
{

    protected $analyticsPhone;
    public function __construct(PhoneAnalyticsRepository $analyticsPhone)
    {
        $this->analyticsPhone = $analyticsPhone;
    }

    public function getProcessedPhone()
    {
        return $this->analyticsPhone->GetAnalyticsPhone();
    }

    public function getCvcData()
    {
        return    $this->analyticsPhone->GetAnalyticsPhone();
    }
}
