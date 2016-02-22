<?php

namespace Blueberry\Core\Controller;

use Blueberry\Core\Model\File;
use Slim\Http\UploadedFile;

/**
 *
 */
class FileController extends BaseController;
{

  protected function index($request, $response, $args)
  {
    $files = ::all();

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
    $files = $request->getUploadedFiles();
    $collection = new Illuminate\Database\Eloquent\Collection();
    array_walk_recursive($files, 'upload', $collection);
    $file = File::create($data);

    $return $response->write($file->toJson());
  }

  protected function update($request, $response, $args)
  {
    $data = $request->getParsedBody();
    $file = File::findOrFail($args['id']);
    $file = $this->object_array_merge($file, $data);

    return $response->write($file->toJson());
  }

  protected function destroy($request, $response, $args)
  {
    File::destroy($args['id']);

    return $response;
  }

  private function upload($item, $key, &$collection)
  {
    if ($item instanceof UploadedFile)
    {
      $file = File::create([
        'filename' =>  $file->getClientFilename(),
        'filetype' => $file->getClientMediaType(),
        'filesize' => $file->getSize(),
      ]);
      $collection->push($file);
    }
  }
}
