<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\UuidInterface;

/**
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\Entity(repositoryClass="App\Repository\TokenRepository")
 */
class Token
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private UuidInterface $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true, nullable=false)
     */
    private string $refreshToken;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private DateTime $expiresAt;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tokens")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $expiresAt = new DateTime();
        $this->expiresAt = $expiresAt->modify('+7 days');
        $this->refreshToken = bin2hex(openssl_random_pseudo_bytes(50));
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function getExpiresAt(): DateTime
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(DateTime $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    public function updateExpiresAt()
    {
        $expiresAt = new DateTime();
        $this->setExpiresAt($expiresAt->modify('+7 days'));
    }

    public function getUser(): User
    {
        return $this->user;
    }
}