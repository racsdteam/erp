<?php

namespace frontend\modules\procurement\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "tender_stages".
 *
 * @property int $id
 * @property string $Name
 * @property string $code
 * @property string $procurement_methods_code
 * @property string $procurement_categories_code
 * @property int $user_id
 * @property int $is_active
 * @property string $timestamp
 */
class TenderStages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tender_stages';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db8');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name','code', 'procurement_methods_code', 'procurement_categories_code', 'user_id'], 'required'],
            [['user_id', 'is_active'], 'integer'],
            [['timestamp'], 'safe'],
            [['Name'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Name' => 'Name',
            'Code' => 'Code',
            'procurement_methods_code' => 'Procurement Methods Code',
            'procurement_categories_code' => 'Procurement Categories Code',
            'user_id' => 'User ID',
            'is_active' => 'Is Active',
            'timestamp' => 'Timestamp',
        ];
    }
    
                 public function User()
{
   
    $_user =User::find()->where(['user_id'=>$this->user_id])->One();
   
    return $_user;
}
public function getStageSequencies()
{
 return $this->hasMany(TenderStageSequenceSettings::class, ['tender_stage_code' => 'code']);
}
}
