<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Project extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'initials',
        'scope',
        'product_limits',
        'client_institution',
        'developer_institution',
        'acronym_definitions',
        'start_date',
        'end_date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'context_diagram',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function setAttributes($arr)
    {
        $this->user = auth()->user()->id;
        $this->initials = $arr['initials'];
        $this->scope = $arr['scope'];
        $this->product_limits = $arr['product_limits'];
        $this->client_institution = $arr['client_institution'];
        $this->developer_institution = $arr['developer_institution'];
        $this->acronym_definitions = $arr['acronym_definitions'];
        $this->start_date = $arr['start_date'];
        $this->end_date = $arr['end_date'];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    // public static function boot()
    // {
    //     dd('oi');
    // }
}
