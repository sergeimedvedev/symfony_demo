<?php

declare(strict_types=1);

namespace App\Model\Service;

use App\Model\DTO\ProfileDtoInterface;
use App\Model\Entity\ProfileInterface;
use App\Model\Entity\SearchRequestInterface;
use App\Model\Exception\PropertyDoesNotExistException;
use App\Model\Exception\PropertyTypeMismatchException;
use App\Model\Repository\ProfileRepositoryInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use JMS\Serializer\Exception\RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProfileUpdateService implements ProfileUpdateServiceInterface
{
    private ProfileRepositoryInterface $profileRepository;
    private SearchRequestByPartnerService $searchRequestByPartnerService;
    private DtoToArrayServiceInterface $dtoToArrayService;
    private ProfileDtoServiceInterface $profileDtoService;
    private ProfileByPartnersSearchRequestServiceInterface $profileByPartnersSearchRequestService;

    public function __construct(
        ProfileRepositoryInterface $profileRepository,
        SearchRequestByPartnerService $searchRequestByPartnerService,
        DtoToArrayServiceInterface $dtoToArrayService,
        ProfileDtoServiceInterface $profileDtoService,
        ProfileByPartnersSearchRequestServiceInterface $profileByPartnersSearchRequestService
    ) {
        $this->profileRepository = $profileRepository;
        $this->searchRequestByPartnerService = $searchRequestByPartnerService;
        $this->dtoToArrayService = $dtoToArrayService;
        $this->profileDtoService = $profileDtoService;
        $this->profileByPartnersSearchRequestService = $profileByPartnersSearchRequestService;
    }

    /**
     * @param string $partnerId
     * @param string $searchRequestId
     * @param array $params
     * @return bool
     * @throws NotFoundHttpException
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws RuntimeException
     * @throws PropertyDoesNotExistException
     * @throws PropertyTypeMismatchException
     */
    public function updateParamsByPartnersSearchRequest(string $partnerId, string $searchRequestId, array $params): bool
    {
        $result = false;
        if ($this->isProfileUpdatingAvailable($partnerId, $searchRequestId)) {
            $profile = $this->profileByPartnersSearchRequestService->get($partnerId, $searchRequestId);
            $profileDto = $this->profileDtoService->getDto($params);
            $this->updateProfileByDto($profile, $profileDto);
            $result = true;
        }
        return $result;
    }

    /**
     * @param ProfileInterface $profile
     * @param ProfileDtoInterface $profileDto
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws RuntimeException
     */
    public function updateProfileByDto(ProfileInterface $profile, ProfileDtoInterface $profileDto): void
    {
        $newFields = $this->dtoToArrayService->convert($profileDto);
        $profileData = $profile->getData() ?? [];
        $profile->setData(array_merge($profileData, $newFields));
        $this->profileRepository->save();
    }

    /**
     * @param string $partnerId
     * @param string $searchRequestId
     * @return bool
     * @throws NotFoundHttpException
     */
    private function isProfileUpdatingAvailable(string $partnerId, string $searchRequestId): bool
    {
        $searchRequest = $this->searchRequestByPartnerService->getByIds($partnerId, $searchRequestId);
        switch ($searchRequest->getStatus()) {
            case SearchRequestInterface::STATUS_NEW:
            case SearchRequestInterface::STATUS_OFFER_NEED_DATA:
                $result = true;
                break;
            default:
                $result = false;
        }
        return $result;
    }
}
