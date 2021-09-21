<?php

declare(strict_types=1);

namespace App\Model\Service;

use App\Model\ApiSchema\Profile\ProfileList;

interface ProfileFullServiceInterface
{
    public function getAll(): ProfileList;
}
