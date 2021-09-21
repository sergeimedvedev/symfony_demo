<?php

declare(strict_types=1);

namespace App\Model\DTO;

use App\Model\Exception\PropertyDoesNotExistException;
use App\Model\Exception\PropertyTypeMismatchException;
use TypeError;

final class ProfileDto implements ProfileDtoInterface
{
    private ?string $gender = null;

    private ?string $name = null;

    private ?string $surname = null;

    private ?string $middleName = null;

    private ?string $dateOfBirthday = null;

    private ?string $countryOfBirth = null;

    private ?string $email = null;

    private ?string $mobilePhone = null;

    private ?string $mobilePackage = null;

    private ?string $familyStatus = null;

    private ?string $regionEs = null;

    private ?string $city = null;

    private ?string $zipCode = null;

    private ?string $street = null;

    private ?string $buildingNumber = null;

    private ?string $floorAndLetter = null;

    private ?string $typeOfProperty = null;

    private ?string $typeOfWork = null;

    private ?string $companyName = null;

    private ?int $netMonthlySalary = null;

    private ?string $dateSalary = null;

    private ?string $documentType = null;

    private ?string $documentId = null;

    private ?string $accountNumber = null;

    private ?string $loanPurpose = null;

    private ?bool $asnef = null;

    /**
     * ProfileDto constructor.
     * @param array $data
     * @throws PropertyDoesNotExistException
     * @throws PropertyTypeMismatchException
     */
    public function __construct(array $data)
    {
        foreach ($data as $fieldName => $value) {
            if (property_exists($this, $fieldName)) {
                try {
                    $this->$fieldName = $value;
                } catch (TypeError $exception) {
                    throw new PropertyTypeMismatchException("Property $fieldName type missmatch.");
                }
            } else {
                throw new PropertyDoesNotExistException('Property does not exist.');
            }
        }
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function getDateOfBirthday(): ?string
    {
        return $this->dateOfBirthday;
    }

    public function getCountryOfBirth(): ?string
    {
        return $this->countryOfBirth;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getMobilePhone(): ?string
    {
        return $this->mobilePhone;
    }

    public function getMobilePackage(): ?string
    {
        return $this->mobilePackage;
    }

    public function getFamilyStatus(): ?string
    {
        return $this->familyStatus;
    }

    public function getRegionEs(): ?string
    {
        return $this->regionEs;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function getBuildingNumber(): ?string
    {
        return $this->buildingNumber;
    }

    public function getFloorAndLetter(): ?string
    {
        return $this->floorAndLetter;
    }

    public function getTypeOfProperty(): ?string
    {
        return $this->typeOfProperty;
    }

    public function getTypeOfWork(): ?string
    {
        return $this->typeOfWork;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function getNetMonthlySalary(): ?int
    {
        return $this->netMonthlySalary;
    }

    public function getDateSalary(): ?string
    {
        return $this->dateSalary;
    }

    public function getDocumentType(): ?string
    {
        return $this->documentType;
    }

    public function getDocumentId(): ?string
    {
        return $this->documentId;
    }

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    public function getLoanPurpose(): ?string
    {
        return $this->loanPurpose;
    }

    public function getAsnef(): ?bool
    {
        return $this->asnef;
    }
}
