<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;

    /* 
    public function users()
    {
        // return $this->belongsTo(Post::class);
        return $this->hasMany(User::class, 'foreign_key', 'id');
    }
    */

    //  

    public function permissions()
    {
        // DB::table('')

        return DB::table('role_has_permissions')->where('role_id', $this->id)->get();

        // return $this->hasMany(Permission::class);
    }

    public function users()
    {
        $user_arr = DB::table('model_has_roles')->where('role_id', $this->id)->get();
        $users = $user_arr->map(function ($a) {
            return User::find($a->model_id);
        });

        /* 
        $users = array_map(function ($a) {
            return User::find($a->model_id);
        }, $user_arr);
        */

        return $users;
    }
}
