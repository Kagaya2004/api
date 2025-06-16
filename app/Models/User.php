<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'ativo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'updated_at',
        'created_at',
        'deleted_at',
        'ativo',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function autor()
    {
        $this->hasOne(Autor::class);
    }

    // Static: Faz com que o sistema já cria, deixando na memória
    // Dinamic: Apenas é criada quando se cria um Objeto
    public static function sendVerificationEmail($user)
    {
        $activateCode = bcrypt(Str::random(40));
        $user->remember_token = $activateCode;
        $user->save();
        $viewData['Nome'] = $user->name;
        $emailCode = $user->remember_token;
        logger("Token: " . $emailCode);
        $viewData['link'] = asset('/api/verify_account?token'.$emailCode);

        Mail::send('layouts.email_verification',
            $viewData, function ($m) use ($user) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
                $m->to($user->email, $user->name)->subject('Email de confimação de registro');
        });
    }

    public static function sendEmailUserActivated($user)
    {
        $viewData['Nome'] = $user->name;
        $viewData['link'] = asset('http://localhost:3000/login');
        Mail::send('layouts.email_verification',
            $viewData, function ($m) use ($user) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
                $m->to($user->email, $user->name)->subject('Usuário devidamente registrado e liberado para acesso');
        });
    }

    public static function sendEmailUserActivatedFailed($user)
    {
        $viewData['Nome'] = $user ? $user->name : 'Usuário';
        Mail::send('layouts.email_verification',
            $viewData, function ($m) use ($user) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
                $m->to($user ? $user->email : env('MAIL_FROM_ADDRESS'), $user ? $user->name : 'Usuário')->subject('Usuário já ativado ou Link expirado');
        });
    }
}
