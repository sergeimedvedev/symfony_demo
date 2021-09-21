<?php

declare(strict_types=1);

namespace App\Model\ApiSchema\Profile;

use App\Model\Entity\FieldInterface;
use App\Model\Repository\FieldValueRepositoryInterface;
use Symfony\Component\Validator\Constraints as Assert;

use function in_array;

class ProfileValidation
{
    protected FieldValueRepositoryInterface $fieldValueRepository;

    public function __construct(FieldValueRepositoryInterface $fieldValueRepository)
    {
        $this->fieldValueRepository = $fieldValueRepository;
    }

    /**
     * @Assert\Type(type="string")
     * @Assert\Expression("this.checkValueByDictionary(value, 'gender')")
     */
    public string $gender;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank(allowNull=true)
     */
    public string $name;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank(allowNull=true)
     */
    public string $surname;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank(allowNull=true)
     */
    public string $middleName;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank(allowNull=true)
     * @Assert\DateTime(format="Y-m-d")
     */
    public string $dateOfBirthday;

    /**
     * @Assert\Type(type="string")
     * @Assert\Expression("this.checkValueByDictionary(value, 'countryOfBirth')")
     */
    public string $countryOfBirth;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank(allowNull=true)
     * @Assert\Email()
     */
    public string $email;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank(allowNull=true)
     * @Assert\Regex("/^[6|7][\d]{8}+$/s")
     */
    public string $mobilePhone;

    /**
     * @Assert\Type(type="string")
     * @Assert\Expression("this.checkValueByDictionary(value, 'mobilePackage')")
     */
    public string $mobilePackage;

    /**
     * @Assert\Type(type="string")
     * @Assert\Expression("this.checkValueByDictionary(value, 'familyStatus')")
     */
    public string $familyStatus;

    /**
     * @Assert\Type(type="string")
     * @Assert\Expression("this.checkValueByDictionary(value, 'regionEs')")
     */
    public string $regionEs;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank(allowNull=true)
     */
    public string $city;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank(allowNull=true)
     * @Assert\Regex("/^\d+$/")
     */
    public string $zipCode;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank(allowNull=true)
     */
    public string $street;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank(allowNull=true)
     */
    public string $buildingNumber;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank(allowNull=true)
     */
    public string $floorAndLetter;

    /**
     * @Assert\Type(type="string")
     * @Assert\Expression("this.checkValueByDictionary(value, 'typeOfProperty')")
     */
    public string $typeOfProperty;

    /**
     * @Assert\Type(type="string")
     * @Assert\Expression("this.checkValueByDictionary(value, 'typeOfWork')")
     */
    public string $typeOfWork;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank(allowNull=true)
     */
    public string $companyName;

    /**
     * @Assert\Type(type="integer")
     * @Assert\Regex("/^\d+$/")
     */
    public int $netMonthlySalary;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank(allowNull=true)
     * @Assert\DateTime(format="Y-m-d")
     */
    public string $dateSalary;

    /**
     * @Assert\Type(type="string")
     * @Assert\Expression("this.checkDocumentTypeById()")
     */
    public string $documentType;

    /**
     * @Assert\Type(type="string")
     * @Assert\Expression("this.checkDocumentIdByType()")
     */
    public string $documentId;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank(allowNull=true)
     * @Assert\Regex("/^[ES]+\d{22}$/is")
     */
    public string $accountNumber;

    /**
     * @Assert\Type(type="string")
     * @Assert\Expression("this.checkValueByDictionary(value, 'loanPurpose')")
     */
    public string $loanPurpose;

    /**
     * @Assert\Type(type="boolean")
     */
    public bool $asnef = false;

    public function checkValueByDictionary($value, $dictionaryName): bool
    {
        $result = true;
        if ($value === null) {
            return $result;
        }
        $dictionary = $this->fieldValueRepository->getValuesByFieldName($dictionaryName);
        return in_array($value, $dictionary, true);
    }

    public function checkDocumentIdByType(): bool
    {
        $documentId = $this->documentId ?? null;
        $documentType = $this->documentType ?? null;
        $result = false;
        if ($this->isDocumentTypeAndIdNotExist($documentType, $documentId)) {
            $result = true;
        } elseif ($documentId !== null) {
            $result = $this->isDocumentIdCorrect($documentType, $documentId);
        }
        return $result;
    }

    public function checkDocumentTypeById(): bool
    {
        $documentType = $this->documentType ?? null;
        $documentId = $this->documentId ?? null;
        if ($this->isDocumentTypeAndIdNotExist($documentType, $documentId)) {
            $result = true;
        } else {
            $result = in_array($documentType, FieldInterface::DOCUMENT_TYPES, true);
        }
        return $result;
    }

    private function isDocumentTypeAndIdNotExist(?string $documentType, ?string $documentId): bool
    {
        return $documentType === null && $documentId === null;
    }

    private function isDocumentIdCorrect(?string $documentType, string $documentId): bool
    {
        switch ($documentType) {
            case FieldInterface::DOCUMENT_TYPE_DNI:
                $result = (bool)preg_match(FieldInterface::REGEX_DOCUMENT_TYPE_DNI, $documentId);
                break;
            case FieldInterface::DOCUMENT_TYPE_NIE:
                $result = (bool)preg_match(FieldInterface::REGEX_DOCUMENT_TYPE_NIE, $documentId);
                break;
            default:
                $result = false;
                break;
        }
        return $result;
    }
}
