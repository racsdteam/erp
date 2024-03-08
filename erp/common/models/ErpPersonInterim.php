<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_person_interim".
 *
 * @property int $id
 * @property int $person_in_interim
 * @property int $person_interim_for
 * @property string $date_from
 * @property string $date_to
 * @property int $interim_creator
 * @property string $timestamp
 */
class ErpPersonInterim extends \yii\db\ActiveRecord
{
    
 public $position;
 
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_person_interim';
    }
    
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['person_in_interim', 'person_interim_for', 'date_from', 'date_to', 'interim_creator'], 'required'],
            [['person_in_interim', 'person_interim_for', 'interim_creator'], 'integer'],
            [['status'],'string'],
            [['date_from', 'date_to', 'timestamp','position'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'person_in_interim' => 'Person In Interim',
            'person_interim_for' => 'Person Interim For',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'interim_creator' => 'Interim Creator',
            'timestamp' => 'Timestamp',
        ];
    }
    
    public function getActingUser(){
     
      return $this->hasOne(User::className(), ['user_id' => 'person_in_interim'])->one();
 
 }
   public function getUserOnLeave(){
     
      return $this->hasOne(User::className(), ['user_id' => 'person_interim_for'])->one();
 
 }
 
 
}
