<?php

namespace frontend\modules\procurement\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "tender_stage_settings".
 *
 * @property int $id
 * @property string $stage_name
 * @property string $code
 * @property int $min_period
 * @property int $max_period
 * @property string $stage_outcome
 * @property string $color_code
 * @property int $user_id
 * @property string $timestamp
 */
class TenderStageSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tender_stage_settings';
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
            [['name', 'code', 'min_period', 'max_period', 'stage_outcome', 'color_code', 'user_id'], 'required'],
            [['min_period', 'max_period', 'user_id'], 'integer'],
            [['timestamp'], 'safe'],
            [['name', 'stage_outcome'], 'string', 'max' => 1000],
            [['code'], 'string', 'max' => 8],
            [['color_code'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Stage Name',
            'code' => ' Code',
            'min_period' => 'Min Period',
            'max_period' => 'Max Period',
            'stage_outcome' => 'Stage Outcome',
            'color_code' => 'Color Code',
            'user_id' => 'User ID',
            'timestamp' => 'Timestamp',
        ];
    }
         public function User()
{
   
    $_user =User::find()->where(['user_id'=>$this->user_id])->One();
   
    return $_user;
}
}
