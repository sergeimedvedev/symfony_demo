<?php

declare(strict_types=1);

namespace App\Model\Service;

interface ProfileDataServiceInterface
{
    public function getByPartnersSearchRerquest(string $partnerId, string $searchRequestId);
}
