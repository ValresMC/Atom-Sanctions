<?php

declare(strict_types=1);

namespace Valres\AtomSanctions\managers;

interface ArraySerializable
{
    public function toArray(): array;
    public static function fromArray(array $data): self;
}