<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;


use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;

class DownloadController extends Controller
{
    public function index(Request $request){
        $user = $request->id;
        $type = $request->type;

        $user = User::find($user);
        if($type = 1){
            $storelist = $user->stores()->orderBy('store')->get();
            $writer = WriterFactory::create(Type::CSV); // for CSV files
            $writer->openToBrowser('stores.csv'); // stream data directly to the browser
            // $header = array('store_code', 'store', 'grade_matrix_id', 'audit_template_id');
            // $writer->addRow($header); // add multiple rows at a time
            foreach ($storelist as $store) {
                $data[0] = $store->store_code;
                $data[1] = $store->store;
                $data[2] = $store->grade_matrix_id;
                $data[3] = $store->audit_template_id;
                // dd($data);
                $writer->addRow($data); // add multiple rows at a time
            }

            $writer->close();
        }
        
    }
}
