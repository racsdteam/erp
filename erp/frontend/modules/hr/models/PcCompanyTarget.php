<?php

namespace frontend\modules\hr\models;

use Yii;

use Yii\base\Model;

class PcCompanyTarget extends Model
{

public  $output;
public  $indicator;
public   $PKI;

    public function rules()
    {
        return [
            [['output', 'indicator','PKI'], 'required'],
            [['output', 'indicator', 'type'], 'string'],
            [['PKI'], 'number'],
             ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'output' => 'Output',
            'indacator' => 'Indacator',
            'PKI' => 'PKI Weght',
           
        ];
    }

}
