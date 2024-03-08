<?php
namespace common\components;

use Yii;
use yii\base\Component;



class ErpComponent extends Component {
     
  
   
    public function getDate($datetime){
  
   $temp_date = strtotime($datetime);
  $date = date("Y-m-d", $temp_date);
     return $date ;      
    
   }
   
   public function getTime($datetime){
  
   $temp_date = strtotime($datetime);
  $time = date("H:i:s", $temp_date);
     return $time ;      
    
   }
   
   

}

?>