<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\File;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;

class FileUpload extends Controller
{
    public function file_upload(Request $req){
   
        $req->validate([
        'file' => 'required|mimes:csv,txt,xlx,xls,pdf,jpg,png|max:2048'
        ]);
        $fileModel = new File;

        if($req->file()) {
            $fileName = $req->file->getClientOriginalName();
            $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');
            $title = $req->input('category_file');
            $fileModel->name = $req->file->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->user_id = auth()->id();
            $fileModel->category_file = $title;
            $fileModel->save();
            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
        }

      
   }

   public function downloadFile(Request $request)
{

    $userId = auth()->id();

    $category = $request->input('category_file');
   
    $file = DB::table('files')->where('user_id', $userId)->where('category_file', $category)->first();

    if ($file) {
       
    

    $path = storage_path('app/public' . str_replace('/storage', '', $file->file_path));
    $headers = [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="' . $file->name . '"',
    ];

    return response()->download($path, $file->name, $headers);
    }
    else{
        abort(404, 'File not found.');
    }
}

public function checkingFile($category) {
    $userId = auth()->id();



    $file = File::where('user_id', $userId)
                ->where('category_file', $category)
                ->first();
    // $files = DB::table('files')
    // ->where('user_id', $teacherId)
    // ->where('category_file', $category)
    // ->first();

    if ($file) {
        return "true";
    } else {
        abort(404, 'File not found.');
        return false;
    }
}
}
// time().'_'.