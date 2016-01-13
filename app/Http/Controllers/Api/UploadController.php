<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\StoreAudit;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;

class UploadController extends Controller
{
    public function storeaudit(Request $request)
    {

        $destinationPath = storage_path().'/uploads/pcount/';
        $fileName = $request->file('data')->getClientOriginalName();
        $request->file('data')->move($destinationPath, $fileName);

        $filePath = storage_path().'/uploads/pcount/' . $fileName;

        $filename_data = explode("-", $fileName);
        $user_id = $filename_data[0];
        $store_code = $filename_data[1];
       

        DB::beginTransaction();
        try {
            
            $reader = ReaderFactory::create(Type::CSV); // for XLSX files
            $reader->setFieldDelimiter(';');
            $reader->open($filePath);

            $first_row = true;

            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $row) {
                    if($first_row){
                        $audit = new StoreAudit;
                        $audit->user_id = $row[0];
                        $audit->user_name = $row[1];
                        $audit->store_code = $row[2];
                        $audit->store_name = $row[3];
                        $audit->start_date = $row[4];
                        $audit->end_date = $row[5];
                        $audit->end_date = $row[6];
                        $audit->template_name = $row[7];
                        $audit->passed = $row[8];
                        $audit->save;
                        $first_row = false;
                    }
                }
            }
           
            $reader->close();

            
            DB::commit();
           
            return response()->json(array('msg' => 'file uploaded', 'status' => 0));
            
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(array('msg' => 'file uploaded error', 'status' => 1));
        }
        
    }
}
