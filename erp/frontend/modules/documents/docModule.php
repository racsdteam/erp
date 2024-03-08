<?php

namespace frontend\modules\documents;

/**
 * doc module definition class
 */
class docModule extends \yii\base\Module
{
   
   
    public static function allowedDomains() {
    return [
        '*',                        // star allows all domains
        
    ];
}

/**
 * @inheritdoc
 */
/*public function behaviors() {
    return array_merge(parent::behaviors(), [

        // For cross-domain AJAX request
        'corsFilter'  => [
            'class' => \yii\filters\Cors::className(),
            'cors'  => [
                // restrict access to domains:
                 'Origin'                           => static::allowedDomains(),
                'Origin'                           => static::allowedDomains(),
                'Access-Control-Request-Method'    => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Allow-Credentials' =>false,
                'Access-Control-Max-Age'           => 3600, // Cache (seconds)
                'Access-Control-Allow-Headers' => ['Range'],
                'Access-Control-Request-Headers' => ['*']
            ],
        ],

    ]);
}*/
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\documents\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
         \Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapAsset'] = [
        'css' => []
    ];
    
     \Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapPluginAsset'] = [
        'js' => []
    ];
        $this->layout = 'main';

        // custom initialization code goes here
    }
}
