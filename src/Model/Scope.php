<?php

namespace Blueberry\Core\Model;

use illuminate\Database\Eloquent\Model;

/**
 *
 */
class Scope extends Model
{
  /**
     * The fields that can be mass assigned
     *
     * @var array
     */
  protected $fillable = ['description'];
  /**
     * The table associated with the model.
     *
     * @var string
     */
  protected $table = 'core_oauth_scopes';

  public function roles()
  {
    return $this->belongsToMany('Blueberry\Core\Model\Role');
  }
}
