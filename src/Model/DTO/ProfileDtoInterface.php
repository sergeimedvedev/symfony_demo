<?php

declare(strict_types=1);

namespace App\Model\DTO;

interface ProfileDtoInterface
{
    public function getGender(): ?string;

    public function getName(): ?string;

    public function getSurname(): ?string;

    public function getMiddleName(): ?string;

    public function getDateOfBirthday(): ?string;

    public function getCountryOfBirth(): ?string;

    public function getEmail(): ?string;

    public function getMobilePhone(): ?string;

    public function getMobilePackage(): ?string;

    public function getFamilyStatus(): ?string;

    public function getRegionEs(): ?string;

    public function getCity(): ?string;

    public function getZipCode(): ?string;

    public function getStreet(): ?string;

    public function getBuildingNumber(): ?string;

    public function getFloorAndLetter(): ?string;

    public function getTypeOfProperty(): ?string;

    public function getTypeOfWork(): ?string;

    public function getCompanyName(): ?string;

    public function getNetMonthlySalary(): ?int;

    public function getDateSalary(): ?string;

    public function getDocumentType(): ?string;

    public function getDocumentId(): ?string;

    public function getAccountNumber(): ?string;

    public function getLoanPurpose(): ?string;

    public function getAsnef(): ?bool;
}
