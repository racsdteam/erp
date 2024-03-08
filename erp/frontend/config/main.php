<?php

use yii\helpers\Url;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    //need for adminlte to work
    'aliases' => [
		'@adminlte/widgets'=>'@vendor/adminlte/yii2-widgets',
		'@report_views_dir' => '@frontend/modules/hr/views/report-templates/',
    	],
    	//----------------------setting landin page
   
    'components' => [
        
          'i18n' => [
        'translations' => [
            'kvtree*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@frontend/modules/dms/messages',
                'sourceLanguage' => 'en-US',
               
            ],
        ],
    ],
        
        
        'request' => [
            'csrfParam' => '_csrf-frontend',
           
            'baseURL'=>'/erp',
           
           
        ],
        
   //---------------------------update cached assets----------------------------------------------------     
        'assetManager' => [
            'appendTimestamp' => true,
          
        ],
    
        'user' => [
            'identityClass' => 'common\models\User',
             'authTimeout' =>3600*4,//4 hours
             'loginUrl' => ['site/login'],
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
             'enableAutoLogin' => false
            
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'erp_advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl'=>'/erp',
            'rules' => [
            ],
        ],
        //-----------------------------------state components-------------------------
                        
   
       'doc' => [
                    'class' => 'common\components\DocComponent'
                    
                    ],
       'memo' => [
                    'class' => 'common\components\MemoComponent'
                    ],
        'requisition' => [
                    'class' => 'common\components\RequisitionComponent'
                    ],
         'lpoRequest' => [
                    'class' => 'common\components\LpoRequestComponent'
                    ],
         'lpo' => [
                    'class' => 'common\components\LpoComponent'
                    ],
                    
        'travelRequest' => [
                    'class' => 'common\components\TravelRequestComponent'
                    ],
         'leave' => [
                    'class' => 'common\components\LeaveComponent'
                    ],
          'muser' => [
                    'class' => 'common\components\UserComponent'
                    ],
        'auction' => [
                    'class' => 'common\components\AuctionComponent'
                    ],
        'logistic' => [
                    'class' => 'common\components\LogisticComponent'
                    ],
        'empUtil' => [
                    'class' => 'frontend\modules\hr\components\EmployeeUtil'
                    ],
         'payroll' => [
                    'class' => 'frontend\modules\hr\components\PayrollCalculator'
                    ],
                    
         'payslip' => [
                    'class' => 'frontend\modules\hr\components\PaySlipCalculator'
                    ],
         'prlUtil' => [
                    'class' => 'frontend\modules\hr\components\PayrollUtil'
                    ], 
                    
          'procUtil' => [
                    'class' => 'frontend\modules\procurement\components\ProcurementUtil'
                    ],           
         'unit' => [
                    'class' => 'frontend\modules\hr\components\UnitComponent'
                    ],         
        'erp' => [
                    'class' => 'common\components\ErpComponent'
                    ],
         'alert' => [
                    'class' => 'common\components\AlertComponent'
                    ],  
                    
          'wfManager' => [
                    'class' => 'common\components\WorkflowManager'
                    ],
           'imihigoUtil' => [
                    'class' => 'frontend\modules\hr\utilities\ImihigoUtil'
                    ],
         'assetUtil' => [
                    'class' => 'frontend\modules\assets0\utils\AssetUtil'
                    ],         
    ],
    
    //-----------------------------check if user is logged i---------------------------------
        'as beforeRequest' => [  //if guest user access site so, redirect to login page.
    'class' => 'yii\filters\AccessControl',
    'rules' => [
        [
            'actions' => ['login','signup','forgot-password','reset-password','pdf-data','get-employee-names','annotations-handler',
            'populate-positions','ver-token' ,'error','get-passenger-manifest','get-desko-gates','get-desko-status','get-desko-locations','create-desko','events-public',
            'create-passenger-manifest','last-report','check-last-report'],
            'allow' => true,
        ],
        [
            'allow' => true,
            'roles' => ['@'],
        ],
    ],
    
    //'class' => 'frontend\components\CorsBehavior'
],
    'modules'=>[
        'pdfjs' => [
             'class' => '\yii2assets\pdfjs\Module',
         ],
          'doc' => [
            'class' => 'frontend\modules\documents\docModule',
        ],
        'user' => [
            'class' => 'frontend\modules\user\userModule',
        ],
        'operations' => [
            'class' => 'frontend\modules\operations\Operations',
        ],
         'logistic' => [
            'class' => 'frontend\modules\logistic\Logistic',
        ],
        'racdms' => [
            'class' => 'frontend\modules\racdms\Module',
             'dataDir'=> "@app/data/dms",
           
        ],
        
         'hr' => [
            'class' => 'frontend\modules\hr\Hr',
        ],
         'auction' => [
            'class' => 'frontend\modules\auction\auctionModule',
        ],
         'assets0' => [
            'class' => 'frontend\modules\assets0\Assets',
        ],
        'treemanager' =>  [
        'class' => '\kartik\tree\Module',
   
    ],
     'procurement' => [
            'class' => 'frontend\modules\procurement\Procurement',
        ],
    'sms' => [
            'class' => 'frontend\modules\sms\Sms',
        ],
      ],
    'params' => $params,
];
