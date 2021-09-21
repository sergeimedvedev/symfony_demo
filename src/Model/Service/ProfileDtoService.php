<?php

declare(strict_types=1);

namespace App\Model\Service;

use App\Model\DTO\ProfileDto;
use App\Model\DTO\ProfileDtoInterface;
use App\Model\Exception\PropertyDoesNotExistException;
use App\Model\Exception\PropertyTypeMismatchException;

class ProfileDtoService implements ProfileDtoServiceInterface
{
    /**
     * @param array $params
     * @return ProfileDtoInterface
     * @throws PropertyDoesNotExistException
     * @throws PropertyTypeMismatchException
     */
    public function getDto(array $params): ProfileDtoInterface
    {
        return new ProfileDto($params);
    }
}
