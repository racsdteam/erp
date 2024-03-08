<?php

namespace frontend\modules\hr\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "pc_report".
 *
 * @property int $id
 * @property string $type
 * @property int $emp_id
 * @property int $emp_pos
 * @property string $timestamp
 *
 * @property PcTargetAchievedResult[] $pcTargetAchievedResults
 */
class PcReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pc_report';
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
            [['type', 'emp_id', 'emp_pos'], 'required'],
            [['type', 'emp_pos','financial_year'], 'string'],
            [['emp_id'], 'integer'],
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
            'emp_id' => 'Emp ID',
            'emp_pos' => 'Emp Pos',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPcTargetAchievedResults()
    {
        return $this->hasMany(PcTargetAchievedResult::className(), ['pc_report_id' => 'id']);
    }
         public function User()
{
   
    $_user =User::find()->where(['user_id'=>$this->emp_id])->One();
   
    return $_user;
}
}
