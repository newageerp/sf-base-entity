<?php
namespace Newageerp\SfBaseEntity\Interface;

interface IBaseEntity
{
    public function getCreatedAt(): ?\DateTime;

    public function getUpdatedAt(): ?\DateTime;

    public function getDoer(): ?IUser;

    public function getCreator(): ?IUser;

    public function isSkipValidation(): bool;
}