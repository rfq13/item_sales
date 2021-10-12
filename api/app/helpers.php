<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

if (! function_exists('str_random')) {
    function str_random($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (! function_exists('upload_file')) {
    function upload_file($file, $path, $name=null) {
        $ext = $file->extension();
        $item = ($name ?? str_random(16)).".$ext";
        $file->move(storage_path("app/public/$path"), $item);
        return "$path/$item";
    }
}

if (! function_exists('remove_file')) {
    function remove_file($path) {
        $file = storage_path("app/public/$path");
        if(file_exists($file)){
            return unlink($file);
        };
        return false;
    }
}

if (! function_exists('validation_request')) {
     function validation_request($request, $rules) {
        $errors = array('errors' => '', 'success'=>false);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $reformatMessages = [];
            $messages = $validator->getMessageBag()->getMessages();
            foreach ($messages as $key => $errorMessages) {
                foreach ($errorMessages as $i => $msg) {
                    array_push($reformatMessages,['param'=>$key,'msg'=>$msg]);
                }
            }
            $errors['errors'] = $reformatMessages;
        }else $errors['success'] = true;

        return (object)$errors;
     }
 }