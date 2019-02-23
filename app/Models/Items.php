<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $description
 * @property bool $is_completed
 * @property \DateTime $completed_at
 * @property \DateTime $due
 * @property integer $urgency
 * @property integer $updated_by
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class Items extends Model
{
    protected $table = 'items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'is_completed',
        'completed_at',
        'due',
        'urgency',
        'updated_by',
    ];
}
