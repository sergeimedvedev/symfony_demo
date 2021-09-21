<?php

declare(strict_types=1);

namespace App\Model\Service;

use App\Model\Entity\ProfileInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProfileByPartnersSearchRequestService implements ProfileByPartnersSearchRequestServiceInterface
{
    private SearchRequestByPartnerServiceInterface $searchRequestByPartnerService;

    public function __construct(SearchRequestByPartnerServiceInterface $searchRequestByPartnerService)
    {
        $this->searchRequestByPartnerService = $searchRequestByPartnerService;
    }

    /**
     * @param string $partnerId
     * @param string $searchRequestId
     * @return ProfileInterface
     * @throws NotFoundHttpException
     */
    public function get(string $partnerId, string $searchRequestId): ProfileInterface
    {
        $searchRequest = $this->searchRequestByPartnerService->getByIds($partnerId, $searchRequestId);
        return $searchRequest->getProfile();
    }
}
