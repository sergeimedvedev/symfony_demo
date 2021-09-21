<?php

declare(strict_types=1);

namespace App\Model\Service;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface ProfileDataCheckingServiceInterface
{
    /**
     * @param string $partnerId
     * @param string $searchRequestId
     * @param array $params
     * @return array
     * @throws NotFoundHttpException
     */
    public function getCheckingResult(string $partnerId, string $searchRequestId, array $params): array;
}
