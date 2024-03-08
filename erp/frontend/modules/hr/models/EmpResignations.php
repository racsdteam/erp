<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_Resignations".
 *
 * @property int $id
 * @property int $employee
 * @property string $resig_date
 * @property string $last_date last day of employement
 * @property int $resig_reason
 * @property string $resig_note
 * @property int $user
 * @property string $timestamp
 */
class EmpResignations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_resignations';
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
            [['employee', 'resig_date', 'resig_reason', 'user'], 'required'],
            [['employee', 'resig_reason', 'user'], 'integer'],
            [['resig_date', 'last_date', 'timestamp'], 'safe'],
            [['resig_note'], 'string'],
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
            'resig_date' => 'resig Date',
            'last_date' => 'Last Date',
            'resig_reason' => 'resig Reason',
            'resig_note' => 'Comment',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee0()
    {
        return $this->hasOne(Employees::className(), ['id' => 'employee']);
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getResigReason()
    {
        return $this->hasOne(ResigReasons::className(), ['id' => 'resig_reason']);
    }
  
    public function getAttachments()
    {
        return $this->hasMany(EmpResigAttachments::className(), ['resig' => 'id']);
    }
 

public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
           $this->resig_date=date('Y-m-d',strtotime($this->resig_date));
           $this->last_date=date('Y-m-d',strtotime($this->last_date));
           
            return true;
        } else {
            return false;
        }
    }
  
  public static function findByEmp($e){
      
     return  self::find()->where(['employee'=>$e])->orderBy(['resig_date'=>SORT_DESC])->one();   
  }  
    
}
