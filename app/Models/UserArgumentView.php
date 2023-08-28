<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserArgumentView
 *
 * @property int $id
 * @property int $user_id
 * @property int $argument_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\UserArgumentViewFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UserArgumentView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserArgumentView newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserArgumentView query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserArgumentView whereArgumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserArgumentView whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserArgumentView whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserArgumentView whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserArgumentView whereUserId($value)
 * @mixin \Eloquent
 */
class UserArgumentView extends Model
{
    use HasFactory;
}
