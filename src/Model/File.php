<?php

namespace Blueberry\Core\Model;

use illuminate\Database\Eloquent\Model;

/**
 *
 */
class File extends Model
{
  /**
     * The fields that can be mass assigned
     *
     * @var array
     */
  protected $fillable = ['name', 'filename', 'filetype', 'filesize', 'url', 'download'];
  /**
     * The table associated with the model.
     *
     * @var string
     */
  protected $table = 'core_files';

  public function user()
  {
    return $this->belongsTo('Blueberry\Core\Model\User');
  }

}
