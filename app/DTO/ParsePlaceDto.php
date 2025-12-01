<?php

namespace App\DTO;

final class ParsePlaceDto
{
    public function __construct(
        public readonly int $userId,
        public readonly string $url,
    )
    {}
}
