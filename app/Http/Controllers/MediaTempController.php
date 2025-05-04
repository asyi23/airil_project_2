<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\AdsTemp;
use App\Models\CustomMedia;
use App\Models\MediaTemp;
use Illuminate\Http\Request;

class MediaTempController extends Controller
{
    public function ajax_upload_media_temp(Request $request){
        $status = 400;
        $data = [];

        if ($request->has($request->input('collection','file'))) {

            $file = $request->file($request->input('collection','file'));

            if($request->input('encrypt') == md5($request->input('id') . ENV('ENCRYPTION_CODE'))){
                $media_temp = MediaTemp::query()
                ->find(1);

                if($media_temp){
                    $temp_file = $media_temp->addMedia($file)->toMediaCollection('temp-'.$request->input('collection','file'));
                    $status = 200;
                    $data['temp_file_id'] = $temp_file->id;
                }

            }else{
                $data['error'] = 'Mismatch Token';
            }
        }else{
            $data['error'] = 'No File';
        }

        return response($data, $status);
    }

    public function ajax_revert_media(Request $request){
        $media = CustomMedia::find($request->getContent());
        if($media){
            $media->delete();
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);
    }
}
