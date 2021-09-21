<?php

declare(strict_types=1);

namespace App\Model\Service;

use App\Model\Entity\ProfileInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface ProfileByPartnersSearchRequestServiceInterface
{
    /**
     * @param string $partnerId
     * @param string $searchRequestId
     * @return ProfileInterface
     * @throws NotFoundHttpException
     */
    public function get(string $partnerId, string $searchRequestId): ProfileInterface;
}
