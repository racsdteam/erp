<?php
namespace frontend\modules\hr\models;

use Yii;
use yii\base\Model;
use yii\db\Expression;

/**
 * Login form
 */
class PayrollRunReportParams extends Model implements \JsonSerializable
{
    public $period_month;
    public $period_year;
    public $pay_group;
    public $pay_type;
    public $paye_basis;
  
   


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['period_month', 'period_year','pay_group'], 'required'],
            [['paye_basis','pay_type'], 'string'],
            [['pay_group'], 'safe'],
            [['period_month', 'period_year'], 'string', 'max' => 255],
            [['paye_basis'], 'required', 
        
        'when' => function ($model)//----------validation on server side
        {
        return $model->rpt_type ==ReportTemplates::TYPE_CODE_PAYE;
        }, 
        'whenClient' => "payeReportSelect" //-----------valiadtion function on client side
    
    ],  [['pay_type'], 'required', 
        
        'when' => function ($model)//----------validation on server side
        {
        return $model->rpt_type ==ReportTemplates::TYPE_CODE_BL;
        }, 
        'whenClient' => "bankListReportSelect" //-----------valiadtion function on client side
    
    ],
        ];
    }

     public function attributeLabels()
    {
        return [
           
            'period_month' => 'Period Month',
            'period_year' => 'Period Year',
            'pay_group' => 'Pay Group',
            'paye_basis' => 'Paye Basis',
            'paye_type' => 'Payment Type',
           
        ];
    }
    
     public function jsonSerialize() {
        
        return array_filter($this->attributes);
    }

}
