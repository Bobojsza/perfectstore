<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StoreAudit;
use App\StoreAuditDetail;
use App\StoreAuditSummary;

use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;

class AuditReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $audits = StoreAudit::orderBy('updated_at', 'desc')->get();
        return view('auditreport.index',compact('audits'));
    }

    public function details($id){
        $store_audit = StoreAudit::findOrFail($id);
        $details = StoreAuditDetail::getDetails($store_audit->id);

        foreach ($details as $key => $value) {
            $img = explode(".", $value->answer);
            if((isset($img[1])) && (strtolower($img[1]) == "jpg")){
                $link = url('api/auditimage/'.$id.'/'.$value->answer);
                $value->answer = $link;
            }
            
        }
        
        \Excel::create($store_audit->store_name . ' - '. $store_audit->template_name, function($excel) use ($details) {
            $excel->sheet('Sheet1', function($sheet) use ($details) {
                $sheet->fromModel($details,null, 'A1', true);
            })->download('xls');

        });
    }

    public function summary($id){
        $store_audit = StoreAudit::findOrFail($id);
        $summaries = StoreAuditSummary::where('store_audit_id',$id)->get();
        $categories = StoreAuditSummary::getUniqueCategory($id);
        $groups = StoreAuditSummary::getUniqueGroup($id);


        \Excel::create($store_audit->store_name . ' - '. $store_audit->template_name, function($excel) use ($summaries, $categories, $groups) {
            $excel->sheet('Sheet1', function($sheet) use ($summaries, $categories, $groups) {
                $sheet->row(1, array('ENROLLMENT TYPE', 'AREA', 'STORE CODE', 'STORE NAME', 'KPI'));
                $col = 5;
                $x = array();
                foreach ($categories as $category) {
                    $sheet->setCellValueByColumnAndRow($col,1, $category->category);
                    $x[$category->category] = $col;
                    $col++;
                }

                $sheet->setCellValueByColumnAndRow($col,1, 'PS SCORE');

                $row = 2;
                $y = array();
                foreach ($groups as $group) {
                    $sheet->setCellValueByColumnAndRow(4,$row, $group->group);
                    $y[$group->group] = $row;
                    for ($i=5; $i < 8; $i++) { 
                        $sheet->setCellValueByColumnAndRow($i,$row,'N/A');

                    }

                    // add ps score
                    $ps_code = '=IF(COUNTIF('.\PHPExcel_Cell::stringFromColumnIndex(5).$row.':'.\PHPExcel_Cell::stringFromColumnIndex($col-1).$row.',0),0,IF(COUNTIF('.\PHPExcel_Cell::stringFromColumnIndex(5).$row.':'.\PHPExcel_Cell::stringFromColumnIndex($col-1).$row.',1),1,"N/A"))';
                    $sheet->setCellValueByColumnAndRow($col,$row, $ps_code);
                    $row++;        
                }

                $sheet->setCellValueByColumnAndRow(4,$row, 'Perfect Store Summary');

                $col = 5;
                $first_row = 2;
                $last_row = $row-1;
                foreach ($categories as $category) {
                    $cat_ps_code = '=IF(COUNTIF('.\PHPExcel_Cell::stringFromColumnIndex($col).$first_row.':'.\PHPExcel_Cell::stringFromColumnIndex($col).$last_row.',0),0,IF(COUNTIF('.\PHPExcel_Cell::stringFromColumnIndex($col).$first_row.':'.\PHPExcel_Cell::stringFromColumnIndex($col).$last_row.',1),1,"N/A"))';
                    $sheet->setCellValueByColumnAndRow($col,$row, $cat_ps_code);
                    $col++;
                }

                $cat_ps_code = '=IF(COUNTIF('.\PHPExcel_Cell::stringFromColumnIndex($col).$first_row.':'.\PHPExcel_Cell::stringFromColumnIndex($col).$last_row.',0),0,IF(COUNTIF('.\PHPExcel_Cell::stringFromColumnIndex($col).$first_row.':'.\PHPExcel_Cell::stringFromColumnIndex($col).$last_row.',1),1,"N/A"))';
                $sheet->setCellValueByColumnAndRow($col,$row, $cat_ps_code);
                // echo '<pre>';
                // print_r($x);
                // print_r($y);
                //  echo '</pre>';
                // dd(1);
                foreach ($summaries as $summary) {
                    $x_point = $x[$summary->category];
                    $y_point = $y[$summary->group];
                    $sheet->setCellValueByColumnAndRow($x_point ,$y_point , $summary->passed);
                }





            })->download('xls');

        });
    }
}
