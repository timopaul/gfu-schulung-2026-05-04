<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractModel extends Model
{
    public function save(array $options = []): bool
    {
        $this->fireCustomEvent('saving');
        $res = parent::save($options);
        $this->fireCustomEvent($res ? 'saved' : 'failed');
        return $res;
    }

    protected function fireCustomEvent(string $event): void
    {
        $event = $this->determineEvent($event);
        if (class_exists($event)) {
            event(new $event($this));
        }
    }

    protected function determineEvent(string $event): string
    {
        return $event . ucfirst(class_basename($this));
    }
}
