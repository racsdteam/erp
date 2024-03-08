<?php
    namespace common\models;
    use Yii;
    use yii\base\InvalidParamException;
    use yii\base\Model;
    use common\models\User;
     
    /**
     * Change password form for current user only
     */
    class Status 
    { 
        const STATUS_DRAFTING = 'drafting';
        const STATUS_IN_PROGRESS = 'in progress';
        const STATUS_RUNNING = 'running';
        const STATUS_PROCESSING = 'processing';
        const STATUS_EXEC = 'executing';
        const STATUS_PENDING = 'pending';
        const STATUS_PENDING_APP = 'pending approval';
        const STATUS_NOT_STARTED = 'not started';
        
         
        const STATUS_STARTED = 'started';
        const STATUS_COMPLETED = 'completed';
        const STATUS_APPROVED = 'approved';
        const STATUS_REVIEWED = 'reviewed';
        const STATUS_REJECTED = 'rejected';
        const STATUS_CANCELLED = 'cancelled';
        
        
        public static function badgeStyle($status){
           $badge='';
           
            switch(strtolower($status)){
                   
                       case  Status::STATUS_DRAFTING :
                       case  Status::STATUS_IN_PROGRESS : 
                       case  Status::STATUS_RUNNING :
                       case  Status::STATUS_PROCESSING :
                       case  Status::STATUS_PENDING : 
                       case  Status::STATUS_PENDING_APP :
                      
                        $badge='badge badge-danger';
                          break;
                       case Status::STATUS_STARTED :
                       case Status::STATUS_EXEC :
                         $badge='badge badge-info';
                          
                         break;
                     case  Status::STATUS_APPROVED :
                     case  Status::STATUS_REVIEWED :
                     case  Status::STATUS_COMPLETED :    
                       $badge='badge badge-success';
                         break;
                     case  Status::STATUS_REJECTED :
                     case Status::STATUS_NOT_STARTED :
                     case Status::STATUS_CANCELLED :
                       $badge='badge badge-danger';
                         break; 
                     default:
                           $badge='badge badge-secondary';
                        
                }  
            
          return $badge;  
            
        }
        
    }