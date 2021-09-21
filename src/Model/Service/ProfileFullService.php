<?php

declare(strict_types=1);

namespace App\Model\Service;

use App\Model\ApiSchema\Profile\ProfileList;
use App\Model\Repository\FieldRepositoryInterface;

class ProfileFullService implements ProfileFullServiceInterface
{
    private FieldRepositoryInterface $fieldRepository;
    private ProfileConvertServiceInterface $profileConvertService;

    public function __construct(
        FieldRepositoryInterface $fieldRepository,
        ProfileConvertServiceInterface $profileConvertService
    ) {
        $this->fieldRepository = $fieldRepository;
        $this->profileConvertService = $profileConvertService;
    }

    public function getAll(): ProfileList
    {
        $fields = $this->fieldRepository->getAllSorted();
        return $this->profileConvertService->toProfileList($fields);
    }
}
