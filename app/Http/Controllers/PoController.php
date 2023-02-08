<?php

namespace App\Http\Controllers;
use Validator;

use Illuminate\Http\Request;

class PoController extends Controller
{
    public function upload_file(Request $request)
    {
        $validator = Validator::make(
            [
                'file'      => $request->import_file,
                'extension' => strtolower($request->import_file->getClientOriginalExtension()),
            ],
            [
                'file'          => 'required',
                'extension'      => 'required|in:xlsx,xls',
            ]
          
          );

            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'message' => $validator->errors()->first(),
                ], 422);

            } else {
                //if(Input::hasFile('import_file')){
                    //$uploadedFileMimeType = Input::file('import_file')->getMimeType();
                
                    $mimes = array('application/excel','application/vnd.ms-excel','application/vnd.msexcel');
                
                    if(in_array($_FILES['import_file']['type'], $mimes)){
                        return response()->json([
                            'type' => 'success',
                            'message' => "File Suskes Upload",
                        ], 200);
                    } else{
                        return response()->json([
                            'type' => 'error',
                            'message' => "Please select Only Excel File",
                        ], 422);
                        //return redirect()->back()->withInput()->withFlashDanger("Please select Only Excel File");
                
                    }
                //}
            }
    }
}
