<?php

namespace frontend\modules\hr\models;

use Yii;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
/**
 * This is the model class for table "payslips".
 *
 * @property int $id
 * @property int $employee
 * @property string $base_pay
 * @property int $pay_period
 * @property int $org_unit
 * @property int $position
 * @property int $user
 * @property string $timestamp
 *
 * @property PayslipItems[] $payslipItems
 * @property Employees $employee0
 * @property Payrolls $payPeriod
 */
class Payslips extends \yii\db\ActiveRecord
{
    
    
     public $employee_no;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payslips';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db4');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee', 'base_pay', 'pay_period', 'user'], 'required'],
            [['employee', 'pay_period', 'org_unit', 'position', 'user'], 'integer'],
            [['base_pay'], 'number'],
            [['timestamp'], 'safe'],
            [ ['employee_no'],'string'],
            [['employee'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['employee' => 'id']],
            [['pay_period'], 'exist', 'skipOnError' => true, 'targetClass' => Payrolls::className(), 'targetAttribute' => ['pay_period' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee' => 'Employee',
            'base_pay' => 'Base Pay',
            'pay_period' => 'Pay Period',
            'org_unit' => 'Org Unit',
            'position' => 'Position',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayslipItems()
    {
        return $this->hasMany(PayslipItems::className(), ['pay_slip' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee0()
    {
        return $this->hasOne(Employees::className(), ['id' => 'employee']);
    }
        public function getEmpUnit()
    {
        return $this->hasOne(ErpOrgUnits::className(), ['id' => 'org_unit']);
    }
    
  
     public function getEmpPosition()
    {
        return $this->hasOne(ErpOrgPositions::className(), ['id' => 'position']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayPeriod()
    {
        return $this->hasOne(Payrolls::className(), ['id' => 'pay_period']);
    }
    
    public function setPaySlipItems($payslipItems){
       
     
         foreach($payslipItems as $payLine){
       
                    $item = new PayslipItems();
                    $item->pay_slip = $this->id;
                    $item->item = $payLine->item;
                    $item->amount = $payLine->amount;
                    $item->user=Yii::$app->user->identity->user_id;
                    $this->link('payslipItems', $item);
       
   }
     
     
    }
    
   
}
