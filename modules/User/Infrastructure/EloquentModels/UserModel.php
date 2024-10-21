<?php

namespace Modules\User\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Modules\Shared\Infrastructure\EloquentModels\Model;
use Modules\User\Domain\Entities\UserEntity;
use Illuminate\Auth\Authenticatable;
use Modules\User\Domain\ValueObjects\Email;
use Modules\User\Domain\ValueObjects\Name;
use Modules\Shared\Domain\Exceptions\IncorrectEmailFormatException;
use Modules\Shared\Domain\Exceptions\ValueRequiredException;

class UserModel extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Authenticatable;

    protected $table = 'users';

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

    /**
     * @return UserEntity
     * @throws IncorrectEmailFormatException
     * @throws ValueRequiredException
     */
    public function toEntity(): UserEntity
    {
        return new UserEntity(
            $this->getAttribute('id'),
            new Name($this->getAttribute('name')),
            new Email($this->getAttribute('email')),
        );
    }
}
