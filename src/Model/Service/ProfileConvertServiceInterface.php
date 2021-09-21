<?php

declare(strict_types=1);

namespace App\Model\Service;

use App\Model\ApiSchema\Profile\ProfileFieldDescription;
use App\Model\ApiSchema\Profile\ProfileList;
use App\Model\Entity\FieldInterface;

interface ProfileConvertServiceInterface
{
    public function toProfileFieldDescription(FieldInterface $field): ProfileFieldDescription;

    public function toProfileList(array $fields): ProfileList;
}
