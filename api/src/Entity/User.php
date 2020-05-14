<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"default"}},
 *     collectionOperations={
 *            "post"={"denormalization_context"={"groups"={"signup"}}},
 *            "get"={"normalization_context"={"groups"={"default"}}}
 *      },
 * )
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    public const ROLES = [
        self::ROLE_USER,
        self::ROLE_ADMIN,
    ];

    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @Groups({"default"})
     */
    private UuidInterface $id;

    /**
     * @Assert\Email()
     * @Assert\NotBlank()
     * @Groups({"signup", "response", "default"})
     * @ORM\Column(type="string", length=180, unique=true, nullable=false)
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     * @Groups("default")
     */
    private array $roles = [self::ROLE_USER];

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", nullable=false)
     * @Groups("signup")
     */
    private string $password;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Groups("default")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Groups("default")
     */
    protected $updatedAt;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     * @Groups("default")
     */
    protected $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity="Token", mappedBy="user", cascade={"persist"})
     * @var Collection|Token[]
     */
    private Collection $tokens;

    public function __construct()
    {
        $this->tokens = new ArrayCollection();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole(string $role)
    {
        if (in_array($role, self::ROLES, true)) {
            $this->roles[] = $role;
        }
    }

    public function createNewToken(): Token
    {
        $token = new Token($this);
        $this->tokens->add($token);

        return $token;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId()->toString(),
            'email' => $this->getEmail()
        ];
    }

    /**
     * @return Collection|ArrayCollection|Token[]
     */
    private function getTokens(): Collection
    {
        return $this->tokens;
    }

    public function getValidToken(): ?Token
    {
        $now = new DateTime();
        $criteria = Criteria::create()
            ->where(Criteria::expr()->gt('expiresAt', $now));

        $tokens = $this->getTokens()->matching($criteria);

        $token = $tokens->first();

        if($token) {
            $token->updateExpiresAt();
        } else {
            $token = $this->createNewToken();
        }

        return $token;
    }
}
