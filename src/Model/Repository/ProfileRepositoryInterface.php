<?php

declare(strict_types=1);

namespace App\Model\Repository;

use App\Model\Entity\ProfileInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * @method ProfileInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfileInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfileInterface[]    findAll()
 * @method ProfileInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface ProfileRepositoryInterface
{
    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(): void;
}
