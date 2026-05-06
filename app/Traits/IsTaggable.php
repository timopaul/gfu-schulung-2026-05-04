<?php

namespace App\Traits;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @template TModel of Model
 *
 * @mixin Model
 */
trait IsTaggable
{
    const string RELATION_TAGS = 'tags';

    /**
     * @return MorphToMany<TModel>
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(
            Tag::class,
            'taggable',
        );
    }
}
