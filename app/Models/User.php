<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPUnit\Framework\MockObject\Builder\Stub;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public static function findByName($fullname)
    {
        return static::where('name', $fullname)->first();
    }

    public function details()
    {
        $type = $this->type;

        if ($type == 'Employee') {
            return Employee::where('users_id', $this->id)->get();
        }

        if ($type == 'Student') {
            /*
            $student = Student::where('users_id', $this->id)->firstOr(function(){

            });
            */
            $student = Student::where('users_id', $this->id)->first();

            /*
            $student->parent = Cparent::where('id', $student->cparents_id)->first();
            $student->school = School::where('id', $student->schools_id)->first();
            return $student;
            */

            $parent = Cparent::where('id', $student->cparents_id)->first();
            $school = School::where('id', $student->schools_id)->first();

            return [
                'student' => $student,
                'parent' => $parent,
                'school' => $school,
            ];
        }

        if ($type == 'Parent') {
            $parent = Cparent::where('users_id', $this->id)->first();

            $students = Student::where('cparents_id', $parent->id)->get();
            //return Cparent::where('users_id', $this->id)->get();

            return [
                'parent' => $parent,
                'students' => $students
            ];
        }
    }
}
