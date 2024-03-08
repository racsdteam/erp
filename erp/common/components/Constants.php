<?php
namespace common\components;

use Yii;
use yii\base\Component;




class Constants {
     
     const STATE_DRAFT = 'drafting';
     const STATE_PENDING = 'pending';
     const STATE_APPROVED = 'approved';
      const STATE_ARCHIVED = 'archived';
      const STATE_COMPLETED = 'completed';
      const STATE_RETURNED = 'returned';
      const STATE_FINAL_APPROVAL ='final';
      const STATE_EXPIRED = 'expired';
      const STATE_NEW =1 ;
      
      const SEVERITY_NORMAL=1;
      const SEVERITY_CRITICAL=2;
      const SEVERITY_URGENT=3;
      
      const MEMO_TYPE_PR='PR';
      const MEMO_TYPE_TR='TR';
      const MEMO_TYPE_RFP='RFP';
      const MEMO_TYPE_OTHER='O';
      
      const LPO_REQUEST_TYPE_PR='PR';
      const LPO_REQUEST_TYPE_TT='TT';
      const LPO_REQUEST_TYPE_OTHER='O';
      
      const NAV_URL_DOC='/doc';
      const NAV_URL_DMS='/racdms';
      const NAV_URL_HR='/hr';
      const NAV_URL_USER='/user';
      const NAV_URL_LOGISTIC='/logistic';
      
      const MEMO_INVALID_POST='Invalid Memo Data Submission';
      
      const UNIT_LEVEL_OFFICE='O';
      const UNIT_LEVEL_UNIT='U';
      const UNIT_LEVEL_DEPARTMENT='D';
     
   /*  
    public static  function getConstants()
  {
    $reflectionClass = new \ReflectionClass($this);
    return $reflectionClass->getConstants();
  }*/

}

?>