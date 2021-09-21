<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Profile;
use App\Model\Repository\ProfileRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use LogicException;

/**
 * @method Profile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profile[]    findAll()
 * @method Profile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileRepository extends BaseRepository implements ProfileRepositoryInterface
{
    /**
     * ProfileRepository constructor.
     * @param ManagerRegistry $registry
     * @throws LogicException
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profile::class);
    }
}
