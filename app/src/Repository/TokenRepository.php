<?php

namespace App\Repository;

use App\Entity\Token;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @method Token|null find($id, $lockMode = null, $lockVersion = null)
 * @method Token|null findOneBy(array $criteria, array $orderBy = null)
 * @method Token[]    findAll()
 * @method Token[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TokenRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Token::class);
    }

    public function findByRefreshToken(string $refreshToken): Token
    {
        $now = new DateTime();
        $token = $this->createQueryBuilder('t')
            ->select('t, u')
            ->join('t.user', 'u')
            ->andWhere('t.refreshToken = :refreshToken')
            ->andWhere('t.expiresAt > :now')
            ->setParameter('refreshToken', $refreshToken)
            ->setParameter('now', $now)
            ->getQuery()
            ->getOneOrNullResult();

        if ($token) {
            return $token;
        }

        throw new BadRequestHttpException("Token not found");
    }
}
