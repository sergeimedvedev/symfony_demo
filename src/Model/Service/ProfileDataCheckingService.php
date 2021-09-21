<?php

declare(strict_types=1);

namespace App\Model\Service;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProfileDataCheckingService implements ProfileDataCheckingServiceInterface
{
    private ProfileValidateServiceInterface $profileValidateService;
    private ProfileFieldDuplicateCheckService $profileFieldDublicatesCheckService;

    public function __construct(
        ProfileValidateServiceInterface $profileValidateService,
        ProfileFieldDuplicateCheckService $profileFieldDublicatesCheckService
    ) {
        $this->profileValidateService = $profileValidateService;
        $this->profileFieldDublicatesCheckService = $profileFieldDublicatesCheckService;
    }

    /**
     * @param string $partnerId
     * @param string $searchRequestId
     * @param array $params
     * @return array
     * @throws NotFoundHttpException
     */
    public function getCheckingResult(string $partnerId, string $searchRequestId, array $params): array
    {
        $violationList = $this->profileValidateService->validate($params);
        $fieldDublicatesList = $this->profileFieldDublicatesCheckService->getFieldDuplicates(
            $partnerId,
            $searchRequestId,
            $params
        );
        return array_merge($violationList, $fieldDublicatesList);
    }
}
