<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'companys';
    protected $fillable = [
        'company_name', 'apikey', 'status', 'company_shortname','created_by', 'updated_by', 'deleted_by'
    ];
    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->belongsToMany('App\Models\User','company_id');
    }
}
