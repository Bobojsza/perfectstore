<?php

namespace App\Http\Controllers\Api;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\Style\Color;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

use App\StoreAudit;



class UploadController extends Controller
{
	public function storeaudit(Request $request)
	{
		// dd($request->all());
		$destinationPath = storage_path().'/uploads/audit/';
		$fileName = $request->file('data')->getClientOriginalName();
		$request->file('data')->move($destinationPath, $fileName);

		$filePath = storage_path().'/uploads/audit/' . $fileName;

		$filename_data = explode("_", $fileName);
		$user_id = $filename_data[0];
		$store_code = $filename_data[1];
	   

		DB::beginTransaction();
		try {
			
		    $reader = ReaderFactory::create(Type::CSV); // for XLSX files
		    $reader->setFieldDelimiter('|');
		    $reader->open($filePath);

		    $first_row = true;

		    foreach ($reader->getSheetIterator() as $sheet) {
		        foreach ($sheet->getRowIterator() as $row) {
		        	// dd($row);
		            if($first_row){
		            	$audit = StoreAudit::where('user_id',$row[0])
		            		->where('store_code', $row[2])
		            		->where('start_date', date_format(date_create($row[4]),"Y-m-d"))
		            		->where('end_date', date_format(date_create($row[5]),"Y-m-d"))
		            		->first();
		            	if(!empty($audit)){
		            		$audit->user_id = $row[0];
			                $audit->user_name = $row[1];
			                $audit->store_code = $row[2];
			                $audit->store_name = $row[3];
			                $audit->start_date = date_format(date_create($row[4]),"Y-m-d");
			                $audit->end_date = date_format(date_create($row[5]),"Y-m-d");
			                $audit->template_name = $row[6];
			                $audit->passed = 1;
			                $audit->update();
		            	}else{
		            		$audit = new StoreAudit;
			                $audit->user_id = $row[0];
			                $audit->user_name = $row[1];
			                $audit->store_code = $row[2];
			                $audit->store_name = $row[3];
			                $audit->start_date = date_format(date_create($row[4]),"Y-m-d");
			                $audit->end_date = date_format(date_create($row[5]),"Y-m-d");
			                $audit->template_name = $row[6];
			                $audit->passed = $row[7];
			                $audit->save();
		            	}
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
