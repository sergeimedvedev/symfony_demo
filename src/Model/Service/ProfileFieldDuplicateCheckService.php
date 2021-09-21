<?php

declare(strict_types=1);

namespace App\Model\Service;

use App\Util\ConstHelper;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProfileFieldDuplicateCheckService implements ProfileFieldDublicatesCheckServiceInterface
{
    private ProfileByPartnersSearchRequestServiceInterface $profileByPartnersSearchRequestService;

    public function __construct(ProfileByPartnersSearchRequestServiceInterface $profileByPartnersSearchRequestService)
    {
        $this->profileByPartnersSearchRequestService = $profileByPartnersSearchRequestService;
    }

    /**
     * @param string $partnerId
     * @param string $searchRequestId
     * @param array $params
     * @return array
     * @throws NotFoundHttpException
     */
    public function getFieldDuplicates(string $partnerId, string $searchRequestId, array $params): array
    {
        $profile = $this->profileByPartnersSearchRequestService->get($partnerId, $searchRequestId);
        $profileData = $profile->getData();
        $duplicates = array_intersect_key($profileData, $params);
        $result = [];
        foreach ($duplicates as $fieldName => $fieldValue) {
            $result[] = [
                'field'   => $fieldName,
                'message' => ConstHelper::MESSAGE_FIELD_ALREADY_EXISTS,
            ];
        }
        return $result;
    }
}
