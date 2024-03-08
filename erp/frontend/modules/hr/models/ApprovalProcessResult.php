<?php
namespace frontend\modules\hr\models;

use Yii;
use yii\base\Model;
use yii\db\Expression;

/**
 * Login form
 */
class ApprovalProcessResult 
{
    private $instance;
    private $status;
     private $errors=[];
    
   
  // Methods
  function setInstance($instance) {
    $this->instance = $instance;
  }
  function getInstance() {
    return $this->instance;
  }
   
   public function setStatus($status) {
    $this->status = $status;
  } 
  public function getStatus() {
    return $this->status;
  }
   
  public function setErros($errors) {
    $this->errors = $errors;
  } 
  public function getErrors() {
    return $this->errors;
  }
  
  public function isSuccess(){
    
 return $this->status==1?true:false;
  }

}
