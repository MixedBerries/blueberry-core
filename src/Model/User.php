<?php

namespace Blueberry\Core\Model;

use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class User extends Model
{
  /**
   * The fields that can be mass assigned
   *
   * @var array
   */
  protected $fillable = ['username', 'firstname', 'lastname', 'email'];
  /**
   * The fields that are hidden from end users
   * @var array
   */
  protected $hidden = ['salt', 'password'];
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'core_users';
  /**
   * Users don't having an auto_incrementing id
   *
   * @var bool
   */
  public $incrementing = false;

  public function roles()
  {
    return $this->belongsToMany('Blueberry\Core\Model\Role');
  }

  public function scopes()
  {
    return $this->hasManyThrough('Blueberry\Core\Model\Scope', 'Blueberry\Core\Model\Role');
  }

  public function files()
  {
    return $this->hasMany('Blueberry\Core\Model\File');
  }
  /**
   * Override of the create function, to incorporate a salt for password generation
   *
   * @param array attributes[];
   */
  public static function create(array $attributes = [])
  {
    if (self::isUnguarded())
    {
      $attributes['password'] = password_hash($attributes['password'], PASSWORD_BCRYPT);
      $model = parent::create($attributes);
      return $model;
    }
  }

  public static function login($credential, $password)
  {
    $user = $this::where($this->credential, $credential)->get();
    if (password_verify($password, $user->password))
    {
      return $user;
    }
  }

  /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        /**
         * Attach to the 'creating' Model Event to provide a UUID
         * for the `id` field (provided by $model->getKeyName())
         */
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = uniqid();
        });
    }
}
