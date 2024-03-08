<?php

namespace frontend\modules\assets0;
use Yii;
use common\models\User;

/**
 * Assets module definition class
 */
class Assets extends \yii\base\Module
{
    
  public  $allowedPositions=array();
  public  $allowedRoles=array();  
  public $allowedUsers=array();
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\assets0\controllers';

    /**
     * {@inheritdoc}
     */
  
       public function init()
    {
    
     /**
     * @ prevents yii2 defaults assets conflicting tree assets(bootstrap 4)
     */    
        
        \Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapAsset'] = [
        'css' => []
    ];
    
     \Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapPluginAsset'] = [
        'js' => []
    ];
        parent::init();
        $this->layout = 'main';
        // custom initialization code goes here
        $this->setAllowedPositions();
        $this->setAllowedRoles();
        $this->setAllowedUsers();
    }
    
    public function setAllowedPositions(){
        
    $this->allowedPositions=['ITTEC','MD'];    
        
    }
    
     public function setAllowedRoles(){
        
    $this->allowedRoles=[User::ROLE_ADMIN];    
        
    }
    
    public function setAllowedUsers(){
        
    $this->allowedUsers=[175];    
        
    }
    
    public function canView($user){
   
     $_user=is_object($user)? $user : User::findIdentity($user);
     if(empty( $_user))
     return false;
     
     $pos=Yii::$app->muser->getPosInfo( $_user->user_id);
     return (in_array($pos->position_code, $this->allowedPositions) || in_array($_user->user_level, $this->allowedRoles) || in_array($_user->user_id, $this->allowedUsers))? true : false;
     
    
    
    }
}
