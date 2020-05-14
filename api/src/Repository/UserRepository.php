<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByEmail(string $email): User
    {
        $user = $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();

        if ($user) {
            return $user;
        }

        throw new BadRequestHttpException("User not found");
    }

    /**
     * @return User[]|array
     */
    public function findALlIncludingDeleted(): array
    {
        $this->_em->getFilters()->disable('softdeleteable');

        return $this->findAll();
    }

    public function findOneIncludingDeleted(string $id): User
    {
        $this->_em->getFilters()->disable('softdeleteable');

        return $this->find($id);
    }
}
