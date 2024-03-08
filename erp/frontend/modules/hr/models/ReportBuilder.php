<?php

namespace frontend\modules\hr\models;

use Yii;

class ReportBuilder{
 public $model;

function __construct($model){
    
    $this->model=$model;
    $this->settings();
    $this->dbData();
    
    
  }



 
public  function settings(){
    
 
}

public  function dbData(){
    
 
}

public  function  getReport(){
    
 return $this->model;
} 


    
}


?>