<?php
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Employer extends Authenticatable {
    use Notifiable;
    public $table = "employers";
    protected $guard = 'employer';
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token',];
}
