<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property text $checklist
 * @property text $items
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class Templates extends Model
{
    protected $table = 'templates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'checklist',
        'items',
    ];
}
