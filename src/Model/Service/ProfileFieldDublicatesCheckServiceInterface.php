<?php

declare(strict_types=1);

namespace App\Model\Service;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface ProfileFieldDublicatesCheckServiceInterface
{
    /**
     * @param string $partnerId
     * @param string $searchRequestId
     * @param array $params
     * @return array
     * @throws NotFoundHttpException
     */
    public function getFieldDuplicates(string $partnerId, string $searchRequestId, array $params): array;
}
