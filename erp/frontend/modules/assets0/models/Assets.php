<?php

namespace frontend\modules\assets0\models;

use Yii;
use yii\base\UserException;
use common\models\User;

/**
 * This is the model class for table "assets".
 *
 * @property int $id
 * @property string $type
 * @property string $name
 * @property string $manufacturer
 * @property string $model
 * @property string $serialNo
 * @property string $tagNo
 * @property string $acq_date
 * @property string $ass_cond
 * @property string $life_span
 * @property string $location
 * @property string $status
 * @property int $created_by
 * @property string $created
 */
class Assets extends \yii\db\ActiveRecord
{
    public $image0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assets';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db7');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'name', 'manufacturer', 'model', 'serialNo', 'tagNo', 'life_span','ass_cond', 'status','po_no','supplier', 'created_by'], 'required'],
            [['acq_date', 'created'], 'safe'],
            [['ass_cond'], 'string'],
            [['created_by'], 'integer'],
            [['type', 'life_span', 'status'], 'string', 'max' => 11],
            
            [['name', 'manufacturer', 'model', 'serialNo', 'tagNo', 'image','po_no','supplier'], 'string', 'max' => 255],
            [['image0'], 'file', 'extensions'=>'jpg,png,svg','skipOnEmpty'=>true],//validating inputfile
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'manufacturer' => 'Manufacturer',
            'model' => 'Model',
            'serialNo' => 'Serial No',
            'tagNo' => 'Tag No',
            'acq_date' => 'Acq Date',
            'ass_cond' => 'Ass Cond',
            'life_span' => 'Life Span',
            'location' => 'Location',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created' => 'Created',
        ];
    }
 
 public function getType0()
    {
        return $this->hasOne(AssetTypes::className(), ['code' => 'type']);
    }
    
    public function getCondition()
    {
        return $this->hasOne(AssetConditions::className(), ['code' => 'ass_cond']);
    } 
    
    public function getStatus0()
    {
        return $this->hasOne(AssetStatuses::className(), ['code' => 'status']);
    } 
    
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['user_id' => 'created_by']);
    } 
    
     public function getAllocation()
    {
        return $this->hasOne(AssetAllocations::className(), ['asset' => 'id'])->onCondition(['active'=>1]);
    } 
    
     public function getSecurity()
    {
        return $this->hasMany(AssetSecDetails::className(), ['asset' => 'id'])->orderBy(['id' => SORT_DESC]);
    } 
    
     public function getDisposal()
    {
        return $this->hasOne(AssetDispositions::className(), ['asset' => 'id']);
    } 
    
    
     public function beforeValidate()
{
    if (parent::beforeValidate()) {
        
         if(empty($this->created_by))
         $this->created_by=Yii::$app->user->identity->user_id; 
         
        
        
        return true;
    }
    return false;
}

public function changeStatus($status){
 $this->status=$status;
 return $this->status=='DSPL'? $this->save(false) && $this->disableAlloc() : $this->save(false);

 
}
public function disableAlloc(){
 $alloc=$this->allocation;
 $alloc->active=0;
 $alloc->save(false);
 
}
}
