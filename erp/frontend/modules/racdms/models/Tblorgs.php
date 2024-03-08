<?php

namespace frontend\modules\racdms\models;

use Yii;
use frontend\modules\racdms\models\Tblorgpositions;

/**
 * This is the model class for table "tblorgs".
 *
 * @property int $id
 * @property int $name
 * @property string $address
 * @property string $contact
 */
class Tblorgs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tblorgs';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db3');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','user'], 'required'],
            [['name'], 'string'],
            [['user'], 'integer'],
            [['timestamp'], 'safe'],
            [['address'], 'string'],
            [['contact'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'contact' => 'Contact',
        ];
    }
     
     public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord) {
                
                $this->user=Yii::$app->user->identity->user_id;
               
            }
            return true;
        } else {
            return false;
        }
    }
    
    public function addPosition($data){
    
    $position=new Tblorgpositions();
    $position->attributes=$data;
    $position->user=Yii::$app->user->identity->user_id;
    
    if(!$position->save()){
         $this->addErrors($position->getFirstErrors());
         return false;
    }
     
     return true;   
    }
    
      
    public function getPositions(){
    
    return Tblorgpositions::find()->where(['org'=>$this->id])->all(); 
    }
}
