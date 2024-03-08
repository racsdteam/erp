<?php

namespace frontend\modules\racdms;

/**
 * dms module definition class
 */
class Module extends \yii\base\Module
{
    
     /**
     * @var string Alias to data directory
     */
    public $dataDir = '@app/data/dms';
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\racdms\controllers';

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
