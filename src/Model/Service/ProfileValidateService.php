<?php

declare(strict_types=1);

namespace App\Model\Service;

use App\Model\ApiSchema\Profile\ProfileValidation;
use App\Model\Repository\FieldValueRepositoryInterface;
use App\Util\ConstHelper;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use TypeError;

class ProfileValidateService implements ProfileValidateServiceInterface
{
    private ValidatorInterface $validator;
    private FieldValueRepositoryInterface $fieldValueRepository;

    public function __construct(ValidatorInterface $validator, FieldValueRepositoryInterface $fieldValueRepository)
    {
        $this->validator = $validator;
        $this->fieldValueRepository = $fieldValueRepository;
    }

    public function validate(array $data): array
    {
        $profileValidation = new ProfileValidation($this->fieldValueRepository);
        $errors = [];
        foreach ($data as $fieldName => $value) {
            if (!property_exists($profileValidation, $fieldName)) {
                $errors[] = [
                    'field'   => $fieldName,
                    'message' => ConstHelper::MESSAGE_FIELD_IS_MISSING,
                ];
                continue;
            }
            try {
                $profileValidation->$fieldName = $value;
            } catch (TypeError $exception) {
                $errors[] = [
                    'field'   => $fieldName,
                    'message' => ConstHelper::MESSAGE_INCORRECT_DATA_TYPE,
                ];
            }
        }
        $violations = $this->validator->validate($profileValidation);
        $classErrors = $this->violationListToArray($violations);
        return array_merge($errors, $classErrors);
    }

    private function violationListToArray(ConstraintViolationListInterface $violationList): array
    {
        $errors = [];
        foreach ($violationList as $violation) {
            $errors[] = [
                'field'   => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
            ];
        }
        return $errors;
    }
}
