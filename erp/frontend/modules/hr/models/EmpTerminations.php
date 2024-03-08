<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_terminations".
 *
 * @property int $id
 * @property int $employee
 * @property string $term_date
 * @property string $last_date last day of employement
 * @property int $term_reason
 * @property string $term_note
 * @property int $user
 * @property string $timestamp
 */
class EmpTerminations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_terminations';
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
            [['employee', 'term_date', 'term_reason', 'user'], 'required'],
            [['employee', 'term_reason', 'user'], 'integer'],
            [['term_date', 'last_date', 'timestamp'], 'safe'],
            [['term_note'], 'string'],
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
            'term_date' => 'Term Date',
            'last_date' => 'Last Date',
            'term_reason' => 'Term Reason',
            'term_note' => 'Comment',
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
    public function getTermReason()
    {
        return $this->hasOne(TermReasons::className(), ['id' => 'term_reason']);
    }
  
    public function getAttachments()
    {
        return $this->hasMany(EmpTermAttachments::className(), ['term' => 'id']);
    }
 

public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
           $this->term_date=date('Y-m-d',strtotime($this->term_date));
           $this->last_date=date('Y-m-d',strtotime($this->last_date));
           
            return true;
        } else {
            return false;
        }
    }
  
  public static function findByEmp($e){
      
     return  self::find()->where(['employee'=>$e])->orderBy(['term_date'=>SORT_DESC])->one();   
  }  
    
}
