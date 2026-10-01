<?php

namespace App\Services\VatChanges;

use RuntimeException;

class InvalidLedgerException extends RuntimeException
{
    /**
     * @param  list<string>  $errors
     */
    public function __construct(public readonly array $errors)
    {
        parent::__construct('The VAT change ledger is invalid: '.implode(' | ', $errors));
    }
}
