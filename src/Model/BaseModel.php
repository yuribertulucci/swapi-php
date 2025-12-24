<?php

namespace App\Model;

use Exception;

abstract class BaseModel implements ModelInterface
{
    protected string $table;
    protected string $idColumn = 'id';
    protected ?string $identifier = null;

    /**
     * @throws Exception
     */
    public function save(): bool
    {
        throw new Exception('Method save() must be implemented in the subclass.');
    }
}