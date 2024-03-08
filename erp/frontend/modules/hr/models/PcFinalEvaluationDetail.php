<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "pa_final_evaluation_detail".
 *
 * @property int $id
 * @property int $pa_id
 * @property string $action_to_take
 * @property string $employee_comment
 * @property string $timestamp
 *
 * @property PerformanceAppraisal $pa
 */
class PcFinalEvaluationDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pc_final_evaluation_detail';
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
            [['pa_id', 'action_to_take', 'employee_comment'], 'required'],
            [['pa_id'], 'integer'],
            [['action_to_take', 'employee_comment'], 'string'],
            [['timestamp'], 'safe'],
            [['pa_id'], 'exist', 'skipOnError' => true, 'targetClass' => PerformanceAppraisal::className(), 'targetAttribute' => ['pa_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pa_id' => 'Pa ID',
            'action_to_take' => 'Action To Take',
            'employee_comment' => 'Employee Comment',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPa()
    {
        return $this->hasOne(PerformanceAppraisal::className(), ['id' => 'pa_id']);
    }
}
