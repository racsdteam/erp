<?php

namespace frontend\modules\hr\models;

use Yii;
use yii\helpers\ArrayHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;
use alhimik1986\PhpExcelTemplator\PhpExcelTemplator;
use alhimik1986\PhpExcelTemplator\params\ExcelParam;
use alhimik1986\PhpExcelTemplator\params\CallbackParam;
use alhimik1986\PhpExcelTemplator\setters\CellSetterArrayValueSpecial;
use alhimik1986\PhpExcelTemplator\setters\CellSetterArrayValue;
use frontend\modules\hr\models\EmpBankDetails;
use frontend\modules\hr\models\EmpPaySplits;
use frontend\modules\hr\models\Banks;

define('SPECIAL_ARRAY_TYPE', CellSetterArrayValueSpecial::class); 
define('ARRAY_TYPE', CellSetterArrayValue::class);
 
class BankListReportExporter implements IReportExporter
{
 public $report;

 
 function __construct($report) {
    $this->report = $report;
   
   
  }



public function exportToExcel() {

$rows=$this->report->generate()->reportData();
$pay_type=ArrayHelper::getValue($this->report->getParams(), 'pay_type');
$period_month=ArrayHelper::getValue($this->report->getParams(), 'period_month');
$period_year=ArrayHelper::getValue($this->report->getParams(), 'period_year');

$splitArr=array();
$snArr=array();
$i=1;
 foreach ($rows as $key => $r) {
            
            $bk_account=EmpBankDetails::findByEmpAndRef($r['employee_id'],$pay_type);
            $rows[$key]["bank_name"] =empty($bk_account)?"":$bk_account->bank->sort_code." - ".$bk_account->bank->name;
            $rows[$key]["bank_account"] =empty($bk_account)?"": $bk_account->bank_account;
            
           
            if(!empty($pay_splits=EmpPaySplits::findActiveSplits($r['employee_id'],$period_year,$period_month))){
                 
                 foreach($pay_splits as $key2=>$s){
                 
                 $pay_splits[$key2]->split_value=$s->calcAmount($r['crAmount']);
                  }   
                 $tot_split  = array_reduce(ArrayHelper::getColumn(ArrayHelper::toArray($pay_splits), 'split_value'), function ($previous, $current) {
                              return $previous + $current;
   
                              });
             $rows[$key]["crAmount"] =round($r['crAmount']-$tot_split); 
             
             $splitArr=array_merge($splitArr,$pay_splits);
                
            }else{
                
             $rows[$key]["crAmount"] =round($r['crAmount']);    
             }
            
            $rows[$key]["pay_ref"] =$this->report->reference();
            array_push($snArr, $i++);
            
          
} 
$newRows=array();

foreach($splitArr as $key=>$split){
    
 $newRow['name']=$split->acc_holder_name;
 $newRow["bank_name"] =empty($split->bank)?"":$split->bank->sort_code." - ".$split->bank->name;
 $newRow["bank_account"] =empty($split->bank)?"": $split->acc_number;
 $newRow["crAmount"]=round($split->split_value);
 $newRow["pay_ref"] =$this->report->reference();
 $newRow["rec_acc"] =ArrayHelper::getValue($rows[0], 'rec_acc');
 $newRows[]=$newRow;
 array_push($snArr, $i++);
 }
$rows=array_merge($rows,$newRows);
ArrayHelper::multisort($rows, ['bank_name', 'crAmount'], [SORT_ASC, SORT_DESC]);

$total  = array_reduce(ArrayHelper::getColumn($rows, 'crAmount'), function ($previous, $current) {
    return round($previous) + round($current);
   
});

//append one space for excel number to text formating

$bankAccounts=array_map(function($val){
     
   return sprintf("%s ",$val);  
  },ArrayHelper::getColumn($rows, 'bank_account'));

$quoteCallBack=function($val){
     
   return sprintf("'%s",$val);  
  };

$params = [
        
    '[sn]' =>new ExcelParam(SPECIAL_ARRAY_TYPE,$snArr),//disabled excel backgr error check to work as special array type
	'[emp_name]' => new ExcelParam(SPECIAL_ARRAY_TYPE,ArrayHelper::getColumn($rows, 'name')),
	'[emp_bank]' => new ExcelParam(SPECIAL_ARRAY_TYPE, ArrayHelper::getColumn($rows, 'bank_name'),function(CallbackParam $param) {
		$sheet = $param->sheet;
		$row_index = $param->row_index;
		$col_index = $param->col_index;
		$cell_coordinate = $param->coordinate;
		$val = $param->param[$row_index][$col_index];
	  	$objValidation = $sheet->getCell($cell_coordinate)->getDataValidation();  
		$objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
	
$objValidation->setAllowBlank(false);
$objValidation->setShowInputMessage(true);
$objValidation->setShowErrorMessage(true);
$objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
$objValidation->setShowDropDown(true);
$objValidation->setErrorTitle('Input error');
$objValidation->setError('Please choose from dropdown list');
//$objValidation->setPromptTitle('Allowed input');
$objValidation->setFormula1('\'Banks + Branches\'!$A$2:$A$19'); 
	}),
	'[emp_acc]' => new ExcelParam(SPECIAL_ARRAY_TYPE, $bankAccounts,function(CallbackParam $param) {
		$sheet = $param->sheet;
		$row_index = $param->row_index;
		$col_index = $param->col_index;
		$cell_coordinate = $param->coordinate;
		$val = $param->param[$row_index][$col_index];
		$sheet->getStyle($cell_coordinate)->getNumberFormat()->setFormatCode('#');//format to text
	    $sheet->getStyle($cell_coordinate)->setQuotePrefix(true);
	    $sheet->getStyle($cell_coordinate)->getAlignment()->setHorizontal('left');
	    
    
	}),
	'[amount]' => new ExcelParam(SPECIAL_ARRAY_TYPE,ArrayHelper::getColumn($rows, 'crAmount'),function(CallbackParam $param) {
		$sheet = $param->sheet;
		$row_index = $param->row_index;
		$col_index = $param->col_index;
		$cell_coordinate = $param->coordinate;
		$val = $param->param[$row_index][$col_index];
	    $sheet->getStyle($cell_coordinate)->getNumberFormat()->setFormatCode('#,##0');
    
     
    
	}),
	'[ref]' =>new ExcelParam(SPECIAL_ARRAY_TYPE,ArrayHelper::getColumn($rows, 'pay_ref')),
    '[rec_acc]'=>new ExcelParam(SPECIAL_ARRAY_TYPE,ArrayHelper::getColumn($rows, 'rec_acc')),
	'{tot}' => $total,
	'{title}' =>$this->report->rpt_desc,
];

 $temp_file='templates/bank_list.xlsx';
 $export_file='templates/'.$this->report->rpt_desc.'.xlsx';
 PhpExcelTemplator::outputToFile($temp_file, $export_file, $params );

exit;
       
  }
  public function exportToPDF() {
    var_dump(sprintf("exporting...PDF%s",$this->report->rpt_desc));
  }
  

 
}
