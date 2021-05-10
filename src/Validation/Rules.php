<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Validation;

interface Rules
{
    public function __construct(float $value);

    public function rules(): bool;
}