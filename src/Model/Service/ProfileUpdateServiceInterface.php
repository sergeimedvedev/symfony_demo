<?php

declare(strict_types=1);

namespace App\Model\Service;

use App\Model\DTO\ProfileDtoInterface;
use App\Model\Entity\ProfileInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use JMS\Serializer\Exception\RuntimeException;

interface ProfileUpdateServiceInterface
{
    /**
     * @param string $partnerId
     * @param string $searchRequestId
     * @param array $params
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws RuntimeException
     */
    public function updateParamsByPartnersSearchRequest(
        string $partnerId,
        string $searchRequestId,
        array $params
    ): bool;

    /**
     * @param ProfileInterface $profile
     * @param ProfileDtoInterface $profileDto
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws RuntimeException
     */
    public function updateProfileByDto(ProfileInterface $profile, ProfileDtoInterface $profileDto): void;
}
