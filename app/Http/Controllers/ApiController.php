<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Illuminate\Http\UploadedFile;
use File;

class ApiController extends Controller
{
    public function file_upload(Request $request)
  {   
      $validator = \Validator::make($request->all(), [

          'file' => 'required|mimes:jpg,png,doc,docx,pdf,xls,xlsx,zip,m4v,avi,flv,mp4,mov',

      ]);

      if ($validator->fails()) {
          return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
      }

      $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
      if ($receiver->isUploaded() === false) {
          throw new UploadMissingFileException();
      }
      $save = $receiver->receive();
      if ($save->isFinished()) {
          $response =  $this->saveFile($save->getFile());

          File::deleteDirectory(storage_path('app/chunks/'));

          //your data insert code

          return response()->json([
              'status' => true,
              'link' => url($response['link']),
              'message' => 'File successfully uploaded.'
          ]);
      }
      $handler = $save->handler();
  }

  /**
 * Saves the file
 *
 * @param UploadedFile $file
 *
 * @return \Illuminate\Http\JsonResponse
 */
protected function saveFile(UploadedFile $file)
{
    $fileName = $this->createFilename($file);
    $mime = str_replace('/', '-', $file->getMimeType());
    $filePath = "public/uploads/chunk_uploads/";
    $file->move(base_path($filePath), $fileName);

    return [
        'link' => $filePath . $fileName,
        'mime_type' => $mime
    ];
}
/**
 * Create unique filename for uploaded file
 * @param UploadedFile $file
 * @return string
 */
protected function createFilename(UploadedFile $file)
{
    $extension = $file->getClientOriginalExtension();
    $filename =  rand() . time() . "." . $extension;
    return $filename;
}
public function downloadFile(){
    return response()->download(public_path())
}
}
