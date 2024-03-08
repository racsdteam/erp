<?php

namespace frontend\modules\auction;
use Yii;
use common\models\User;
/**
 * userModule module definition class
 */
class auctionModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\auction\controllers';

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
    }
    
    public function canView($_user){
     $muser=Yii::$app->muser;
     $user=Yii::$app->user->identity;
     $userID=is_object($_user)?$_user->user_id:$_user;
    
     if(($pos=$muser->getPosInfo( $userID))==null){
         return false;
     }
     if($pos->position_code=='MD' || $pos->position_code=='MGRCC' || $user->user_level==User::ROLE_ADMIN ){
         
         return true;
     }
     
    
    
    }
}
