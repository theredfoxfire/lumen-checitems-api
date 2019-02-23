<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property integer $priority
 * @property string $location
 * @property \DateTime $start_time
 * @property bool $completed
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class Todo extends Model
{
    protected $table = 'todo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'priority',
        'location',
        'start_time',
        'completed',
    ];
}