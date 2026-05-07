<?php

namespace App\Data\Attributes\Validation;

use Attribute;
use Closure;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Exists as BaseExists;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Support\Validation\Constraints\DatabaseConstraint;
use Spatie\LaravelData\Support\Validation\References\ExternalReference;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class ModelExists extends Exists
{
    /**
     * @throws Exception
     */
    public function __construct(
        protected null|string|ExternalReference $table = null,
        protected null|string|ExternalReference $column = 'NULL',
        protected null|string|ExternalReference $connection = null,
        protected bool|ExternalReference $withoutTrashed = false,
        protected string|ExternalReference $deletedAtColumn = 'deleted_at',
        protected null|DatabaseConstraint|array|Closure $where = null,
        protected BaseExists|null $rule = null,
    ) {
        /** @var Model $model */
        $model = new $table;

        parent::__construct(
            table: $model->getTable(),
            column: 'NULL' !== $this->column ? $this->column : $model->getKeyName(),
        );
    }
}
