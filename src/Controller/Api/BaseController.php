<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Model\Entity\PartnerInterface;
use App\Security\ApiUserInterface;
use App\Util\ConstHelper;
use LogicException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

abstract class BaseController extends AbstractController
{
    abstract protected function getLogger(): LoggerInterface;

    /**
     * @return string
     * @throws AccessDeniedException
     * @throws LogicException
     */
    public function getCurrentPartnerId(): string
    {
        $partnerId = null;
        $partner = $this->getCurrentPartner();
        return $partner->getId();
    }

    /**
     * @return PartnerInterface
     * @throws AccessDeniedException
     * @throws LogicException
     */
    public function getCurrentPartner(): PartnerInterface
    {
        $user = $this->getUser();
        if ($user instanceof ApiUserInterface) {
            return $user->getPartner();
        }

        $errorMessage = ConstHelper::MESSAGE_NOT_AUTHORIZED;
        $this->getLogger()->error(
            $errorMessage,
            [
                'category' => 'api.base',
                'userName' => $user->getUsername(),
            ]
        );
        throw new AccessDeniedException($errorMessage);
    }
}
