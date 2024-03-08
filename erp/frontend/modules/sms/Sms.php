<?php

namespace frontend\modules\sms;

/**
 * procurement module definition class
 */
class Sms extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\sms\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->layout = 'main';

        // custom initialization code goes here
    }
}
