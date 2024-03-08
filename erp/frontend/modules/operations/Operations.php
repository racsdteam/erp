<?php

namespace frontend\modules\operations;

/**
 * operations module definition class
 */
class Operations extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\operations\controllers';

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
}
