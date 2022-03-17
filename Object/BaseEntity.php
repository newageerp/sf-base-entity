<?php

namespace Newageerp\SfBaseEntity\Object;

use Newageerp\SfBaseEntity\Interface\IBaseEntity;
use Newageerp\SfBaseEntity\Interface\IUser;
use OpenApi\Annotations as OA;
use Doctrine\ORM\Mapping as ORM;

class BaseEntity implements IBaseEntity
{
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @OA\Property(type="string", format="datetime")
     */
    protected ?\DateTime $createdAt = null;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @OA\Property(type="string", format="datetime")
     */
    protected ?\DateTime $updatedAt = null;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected ?IUser $doer = null;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected ?IUser $creator = null;
    protected bool $skipValidation = false;

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime|null $createdAt
     */
    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime|null $updatedAt
     */
    public function setUpdatedAt(?\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return IUser|null
     */
    public function getDoer(): ?IUser
    {
        return $this->doer;
    }

    /**
     * @param IUser|null $doer
     */
    public function setDoer(?IUser $doer): void
    {
        $this->doer = $doer;
    }

    /**
     * @return IUser|null
     */
    public function getCreator(): ?IUser
    {
        return $this->creator;
    }

    /**
     * @param IUser|null $creator
     */
    public function setCreator(?IUser $creator): void
    {
        $this->creator = $creator;
    }

    /**
     * @return bool
     */
    public function isSkipValidation(): bool
    {
        return $this->skipValidation;
    }

    /**
     * @param bool $skipValidation
     */
    public function setSkipValidation(bool $skipValidation): void
    {
        $this->skipValidation = $skipValidation;
    }
}