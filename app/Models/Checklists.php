<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $object_domain
 * @property string $object_id
 * @property string $description
 * @property bool $is_completed
 * @property string $updated_by
 * @property integer $due
 * @property integer $urgency
 * @property \DateTime $completed_at
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class Checklists extends Model
{
    protected $table = 'checklists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'object_domain',
        'object_id',
        'description',
        'is_completed',
        'updated_by',
        'due',
        'urgency',
        'completed_at',
    ];
}
