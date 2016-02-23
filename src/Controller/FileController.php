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
    $uri = $request->getUri();
    $files = $request->getUploadedFiles()['files'];
    $collection = new Illuminate\Database\Eloquent\Collection();
    foreach ($files as $file) {
      if ($file->getError() === UPLOAD_ERR_OK)
      {
        $file = File::create([
          'name' => ucfirst($file->getClientFilename()),
          'filename' => $file->getClientFilename(),
          'filetype' => $file->getClientMediaType(),
          'filesize' => $file->getSize(),
          'url' => $uri->getScheme().'://'.$uri->getHost().'/media/'.$file->getClientFilename();
        ]);
        $collection->push($file);

        $file->moveTo($this->mediaDir.$file->getClientFilename());
      }
    }
    $return $response->write($collection->toJson());
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
}
