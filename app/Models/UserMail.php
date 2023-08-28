<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserMail
 *
 * @property int $id
 * @property int $user_id
 * @property string $mail_type
 * @property string $subject
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\UserMailFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UserMail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMail query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMail whereMailType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMail whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMail whereUserId($value)
 * @mixin \Eloquent
 */
class UserMail extends Model
{
    use HasFactory;
}
