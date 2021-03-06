<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Exception;

use Exception;

class AmountValidationException extends Exception implements ExceptionInterface
{
    /**
     * @var string|null
     */
    protected $message;

    /**
     * AmountValidationException constructor.
     * @param $message
     */
    public function __construct($message) {
        $this->message = $message;
        parent::__construct();
    }

    /**
     * @return string|null
     */
    public function __toString() {
        return $this->message;
    }
}
