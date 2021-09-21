<?php

declare(strict_types=1);

namespace App\Model\Service;

use App\Model\ApiSchema\Profile\ProfileFieldDescription;
use App\Model\ApiSchema\Profile\ProfileList;
use App\Model\Entity\FieldInterface;
use App\Util\ConstHelper;
use InvalidArgumentException;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProfileConvertService implements ProfileConvertServiceInterface
{
    protected TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param array $fields
     * @return ProfileList
     * @throws InvalidArgumentException
     */
    public function toProfileList(array $fields): ProfileList
    {
        $profileList = new ProfileList();
        $profileList->items = [];
        foreach ($fields as $field) {
            $profileList->items[] = $this->toProfileFieldDescription($field);
        }
        return $profileList;
    }

    /**
     * @param FieldInterface $field
     * @return ProfileFieldDescription
     * @throws InvalidArgumentException
     */
    public function toProfileFieldDescription(FieldInterface $field): ProfileFieldDescription
    {
        $profileFieldDescription = new ProfileFieldDescription();
        $profileFieldDescription->name = $field->getName();
        $profileFieldDescription->description = $this->translator->trans(
            $field->getName(),
            [],
            'profile',
            ConstHelper::DEFAULT_LOCALE
        );
        $profileFieldDescription->type = $field->getType();
        $profileFieldDescription->validationRule = $field->getValidation();
        $profileFieldDescription->type = $field->getType();
        $profileFieldDescription->sortGroup = $field->getGroupType();
        $profileFieldDescription->step = $field->getStep();
        $profileFieldDescription->sortOrder = $field->getSortOrder();
        return $profileFieldDescription;
    }
}
