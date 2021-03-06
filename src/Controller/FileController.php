<?php

namespace Blueberry\Core\Controller;

use Blueberry\Core\Model\File;
use Slim\Http\UploadedFile;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 */
class FileController extends BaseController
{

  protected function index($request, $response, $args)
  {
    $files = File::all();

    return $response->write($files->toJson());
  }

  protected function show($request, $response, $args)
  {
    $file = File::findOrFail($args['id']);

    return $response->write($file->toJson());
  }

  protected function create($request, $response, $args)
  {
    $data = $request->getParsedBody();
    $uri = $request->getUri();
    $files = $request->getUploadedFiles();
    array_walk_recursive($files, function($v, $k) use ($files)
    {
      if ($v instanceof UploadedFile)
      {
        $files[] = $v;
      }
    });
    $collection = new Collection();
    foreach ($files as $file)
    {
      if ($file->getError() === UPLOAD_ERR_OK)
      {
        $f = File::create([
          'name' => ucfirst($file->getClientFilename()),
          'filename' => $file->getClientFilename(),
          'filetype' => $file->getClientMediaType(),
          'filesize' => $file->getSize(),
          'url' => $uri->getScheme().'://'.$uri->getHost().'/media/'.$file->getClientFilename(),
          'download' => false
        ]);
        $collection->push($f);

        $file->moveTo($this->settings['mediaDir'].$file->getClientFilename());
      }
    }
    return $response->write($collection->toJson());
  }

  protected function update($request, $response, $args)
  {
    $data = $request->getParsedBody();
    $file = File::findOrFail($args['id']);
    $file = $this->object_array_merge($file, $data);
    $file->save();
    return $response->write($file->toJson());
  }

  protected function destroy($request, $response, $args)
  {
    File::destroy($args['id']);

    return $response;
  }

  private function getFiles($files)
  {

  }
}
