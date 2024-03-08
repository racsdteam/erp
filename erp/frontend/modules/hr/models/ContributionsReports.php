<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "contributions_reports".
 *
 * @property int $id
 * @property string $description
 * @property int $contribution
 * @property string $pay_period_year
 * @property string $pay_period_month
 * @property string $status
 * @property int $user
 * @property string $timestamp
 */
class ContributionsReports extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contributions_reports';
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
            [['description', 'contribution', 'pay_period_year', 'pay_period_month',  'user'], 'required'],
            [['contribution', 'user','pay_group'], 'integer'],
            [['status'], 'string'],
            [['timestamp'], 'safe'],
            [['description', 'pay_period_year', 'pay_period_month'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'contribution' => 'Contribution',
            'pay_period_year' => 'Pay Period Year',
            'pay_period_month' => 'Pay Period Month',
            'status' => 'Status',
            'user' => 'User',
            'pay_group' => 'Employee Group',
            'timestamp' => 'Timestamp',
        ];
    }
      public function getContributionType()
    {
        return $this->hasOne(CompanyContributions::className(), ['id' => 'contribution']);
    }
    public function getReportData(){
    $contr=$this->contributionType;
    $query=new \yii\db\Query(); 
           $rows=$query->select(['e.*','ec.*','slip_ec.*',
           'slip_d.item as ee','slip_d.amount as ee_amount','p.pay_period_start','p.pay_period_end']) 
          ->from('emp_pay_slip_contributions  as slip_ec')//1
          ->innerJoin(['slip'=>'emp_pay_slips'],'`slip`.`id` = `slip_ec`.`pay_slip`')
          ->innerJoin(['p'=>'payrolls'],'`p`.`id` = `slip`.`pay_period`')
          ->innerJoin(['ec'=>'company_contributions'],'`ec`.`id` = `slip_ec`.`ec`')
          ->innerJoin(['e'=>'employees'],'`e`.`id` = `slip`.`employee`')
          ->innerJoin(['slip_d'=>'emp_pay_slip_details'],'`slip_d`.`pay_slip` = `slip`.`id`')
          ->where(['p.pay_period_year'=>$this->pay_period_year,'p.pay_period_month'=>$this->pay_period_month,
           'slip_ec.ec'=>$this->contribution,'slip_d.item'=> $contr->deduction])
           ->all(\Yii::$app->db4);  
          
           return $rows;
        
        
    }
}
