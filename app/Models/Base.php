<?php

namespace App\Models;

use App\Events\ModelCreatedEvent;
use App\Events\ModelDeletedEvent;
use App\Events\ModelUpdatedEvent;

use Illuminate\Notifications\Notifiable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Base extends Model implements Transformable
{
    use Notifiable;
    use TransformableTrait;

    public const CREATED_AT = 'create_time';
    public const UPDATED_AT = 'update_time';

    protected $dateFormat = 'U';

    protected $dispatchesEvents = [
        'created' => ModelCreatedEvent::class,
        'updated' => ModelUpdatedEvent::class,
        'deleted' => ModelDeletedEvent::class,
    ];

    public static function scopeAffiliate($aff_id = null)
    {
        if(!$aff_id) $aff_id = Auth()->id();
        $model = (new static);
        $table = $model->getTable();
        return $model->where($table.'.affiliate_id', $aff_id);
    }

}
