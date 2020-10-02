<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TaskList;

class Task extends Model
{
    protected $primaryKey = 't_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        't_title',
        't_description',
        't_order',
        'u_id',
        't_status',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'u_id');
    }

    public function lists()
    {
        return $this->hasMany(TaskList::class, 't_id')->orderBy('tl_order');
    }
}
