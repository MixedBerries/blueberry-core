<?php

namespace Blueberry\Core\Model;

use illuminate\Database\Eloquent\Model;

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
  protected $fillable = ['username', 'firstname', 'lastname', 'email', 'salt', 'password'];
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
  public function roles()
  {
    return $this->belongsToMany('Blueberry\Core\Model\Role');
  }
  /**
   * Override of the create function, to incorporate a salt for password generation
   *
   * @param array attributes[];
   */
  public static function create(array $atttibutes = [])
  {
    $attributes['salt'] = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
    $atttibutes['password'] = password_hash($atttibutes['password'], PASSWORD_BCRYPT, ['salt' => $attributes['salt']]);
    parent::create($atttibutes);
  }

  public static function login($credential, $password)
  {
    $user = $this::where($this->credential, $credential)->get();
    if (password_verify($password, $user->password))
    {
      return $user;
    }
  }
}
