<?php
namespace frontend\modules\hr\models;

use Yii;
use yii\base\Model;
use yii\db\Expression;

/**
 * Login form
 */
class ApprovalFlowContext
{
    private $wfInstance;
    private $wfStep;
   
    
   
  // Methods
  function setWfInstance($instance) {
    $this->wfInstance = $instance;
  }
  function getWfInstance() {
    return $this->wfInstance;
  }
   
   // Methods
  function setWfStep($step) {
    $this->wfStep = $step;
  }
  function getWfStep() {
    return $this->wfStep;
  }
  
  

}
