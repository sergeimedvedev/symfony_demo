<?php

declare(strict_types=1);

namespace App\Model\Service;

use Symfony\Component\Validator\ConstraintViolationListInterface;

interface ProfileValidateServiceInterface
{
    /**
     * @param array $data
     * @return ConstraintViolationListInterface[]
     */
    public function validate(array $data): array;
}
