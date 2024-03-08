<?php

namespace frontend\modules\logistic;

/**
 * logistic module definition class
 */
class Logistic extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
      public static function allowedDomains() {
    return [
        '*',                        // star allows all domains
        
    ];
}


public function behaviors() {
    return array_merge(parent::behaviors(), [

        // For cross-domain AJAX request
        'corsFilter'  => [
            'class' => \yii\filters\Cors::className(),
            'cors'  => [
                // restrict access to domains:
                //'Origin'                           => static::allowedDomains(),
                'Origin'                           => static::allowedDomains(),
                'Access-Control-Request-Method'    => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Allow-Credentials' =>false,
                'Access-Control-Max-Age'           => 3600, // Cache (seconds)
                'Access-Control-Allow-Headers' => ['Range'],
                'Access-Control-Request-Headers' => ['*']
            ],
        ],

    ]);
}
    public $controllerNamespace = 'frontend\modules\logistic\controllers';

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
    }
}
