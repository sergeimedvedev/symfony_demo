<?php

declare(strict_types=1);

namespace App\Model\Service;

use App\Model\Exception\PropertyDoesNotExistException;
use App\Model\Exception\PropertyTypeMismatchException;
use JMS\Serializer\Exception\RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProfileDataService implements ProfileDataServiceInterface
{
    private DtoToArrayServiceInterface $dtoToArrayService;
    private ProfileDtoServiceInterface $profileDtoService;
    private ProfileByPartnersSearchRequestServiceInterface $profileByPartnersSearchRequestService;

    public function __construct(
        DtoToArrayServiceInterface $dtoToArrayService,
        ProfileDtoServiceInterface $profileDtoService,
        ProfileByPartnersSearchRequestServiceInterface $profileByPartnersSearchRequestService
    ) {
        $this->dtoToArrayService = $dtoToArrayService;
        $this->profileDtoService = $profileDtoService;
        $this->profileByPartnersSearchRequestService = $profileByPartnersSearchRequestService;
    }

    /**
     * @param string $partnerId
     * @param string $searchRequestId
     * @return array
     * @throws PropertyDoesNotExistException
     * @throws PropertyTypeMismatchException
     * @throws RuntimeException
     * @throws NotFoundHttpException
     */
    public function getByPartnersSearchRerquest(string $partnerId, string $searchRequestId): array
    {
        $profile = $this->profileByPartnersSearchRequestService->get($partnerId, $searchRequestId);
        $profileData = $profile->getData();
        $profileDto = $this->profileDtoService->getDto($profileData);
        return $this->dtoToArrayService->convert($profileDto);
    }
}
