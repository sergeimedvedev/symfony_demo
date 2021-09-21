<?php

declare(strict_types=1);

namespace App\Model\Entity;

interface ProfileInterface
{
    public function getId(): string;

    public function getSearchRequest(): SearchRequestInterface;

    public function setSearchRequest(SearchRequestInterface $searchRequest): ProfileInterface;

    public function getData(): array;

    public function setData(array $data): ProfileInterface;
}
