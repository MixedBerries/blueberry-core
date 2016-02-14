<?php

namespace Blueberry\Core\Model;

use illuminate\Database\Eloquent\Model;

/**
 *
 */
class Role extends Model
{
  /**
     * The fields that can be mass assigned
     *
     * @var array
     */
  protected $fillable = ['rolename', 'description'];
  /**
     * The table associated with the model.
     *
     * @var string
     */
  protected $table = 'core_roles';

  public function scopes()
  {
    return $this->belongsToMany('Blueberry\Core\Model\Scope');
  }

  public function users()
  {
    return $this->belongsToMany('Blueberry\Core\Model\User');
  }
}
