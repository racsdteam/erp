<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_suspensions".
 *
 * @property int $id
 * @property int $employee
 * @property string $susp_from
 * @property string $susp_to
 * @property string $last_day last day of employement
 * @property int $susp_reason
 * @property string $susp_note
 * @property int $user
 * @property string $timestamp
 */
class EmpSuspensions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_suspensions';
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
            [['employee', 'susp_from', 'susp_reason', 'user'], 'required'],
            [['employee', 'susp_reason', 'user'], 'integer'],
            [['susp_from', 'susp_to', 'last_day', 'timestamp'], 'safe'],
            [['susp_note'], 'string'],
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
            'susp_from' => 'Suspended From',
            'susp_to' => 'Suspended To',
            'last_day' => 'Last Day',
            'susp_reason' => 'Suspension Reason',
            'susp_note' => 'Suspension Note',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
    function getEmployeeDetails(){
//-----------------------------all employees on group----------------------------------------

return $this->hasOne(Employees::className(), ['id' => 'employee']) ;

}

 public static function findByEmp($e){
      
     return  self::find()->where(['employee'=>$e])->orderBy(['susp_from'=>SORT_DESC])->one();   
  } 
  
  public function beforeSave($insert) {
    
    $fromDateTime = \DateTime::createFromFormat('d/m/Y',$this->susp_from); 
    $this->susp_from=$fromDateTime->format('Y-m-d');
    if(!empty($this->susp_to)){
        $toDateTime = \DateTime::createFromFormat('d/m/Y',$this->susp_to); 
        $this->susp_to=$toDateTime->format('Y-m-d');
    }
    

    return parent::beforeSave($insert);
}
   
}
