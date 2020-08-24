<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Call;
use ApiResponseHelper;
use Validator;
use DB;

class FileController extends Controller
{
    public function csv_file(Request $request)
    {
        DB::beginTransaction();
        try {
            $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');

            if(!in_array($_FILES['file']['type'], $mimes)){
                return ApiResponseHelper::fail('Please provide valid csv file.');
            }

            $file = $request->file('file');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads', $fileName);

            $storage_file_path = Storage::disk('local')->path($path);


            $data = array_map('str_getcsv', file($storage_file_path));
            $csv_data = array_slice($data, 1);
            foreach ($csv_data as $key => $data) {
                $user = User::firstOrCreate(['name' => $data[0]]);
                $call = new Call;
                $call->user_id = $user->id;
                $call->client_name = $data[1];
                $call->client_type = $data[2];
                $call->date = $data[3];
                $call->duration = $data[4];
                $call->call_type = $data[5];
                $call->call_score = $data[6];
                $call->touch();
                $call->save();
            }
            DB::commit();
            return ApiResponseHelper::success();

        } catch (\Exception $e) {
            return ApiResponseHelper::fail($e->getMessage());
        }
    }
}
