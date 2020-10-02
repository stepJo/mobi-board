<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class TaskList extends Model
{
    protected $primaryKey = 'tl_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        't_id', 
        'tl_title',
        'tl_description',
        'tl_order',
        'tl_status',
        'created_at',
        'updated_at'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 't_id');
    }
}
