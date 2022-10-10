<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPUnit\Framework\MockObject\Builder\Stub;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Panoscape\History\HasOperations;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasOperations, SoftDeletes;

    /*
    public function getModelLabel()
    {
        return $this->name;
    }
    */

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'status',
        'disabled'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function branch()
    {
        return $this->hasMany(Branch::class, 'manager_id', 'id');
    }


    public static function findByName($fullname)
    {
        return static::where('name', $fullname)->first();
    }

    public function details()
    {
        $type = $this->type;

        if ($type == 'Employee') {
            return [
                'employee' => Employee::where('user_id', $this->id)->first(),
            ];
        }

        if ($type == 'Student') {
            /*
            $student = Student::where('user_id', $this->id)->firstOr(function(){

            });
            */
            $student = Student::where('user_id', $this->id)->first();

            /*
            $student->parent = Cparent::where('id', $student->cparent_id)->first();
            $student->school = School::where('id', $student->school_id)->first();
            return $student;
            */

            $parent = Cparent::where('id', $student->cparent_id)->first();
            $school = School::where('id', $student->school_id)->first();

            return [
                'student' => $student,
                'parent' => $parent,
                'school' => $school,
            ];
        }

        if ($type == 'Parent') {
            $parent = Cparent::where('user_id', $this->id)->first();
            $students = Student::where('cparent_id', $parent->id)->get();

            //return Cparent::where('user_id', $this->id)->get();

            return [
                'parent' => $parent,
                'students' => $students
            ];
        }

        return [];
    }
}
