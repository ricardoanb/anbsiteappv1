<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PasswordToken extends Model
{
	use HasFactory;

	protected $table = 'password_reset_tokens';

	protected $fillable = [
		'correo',
		'token',
	];

	public $timestamps = false;
}
