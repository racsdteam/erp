<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "pa_target_evaluation".
 *
 * @property int $id
 * @property int $eval_id
 * @property int $target_id
 * @property string $progress
 * @property string $indicator
 * @property double $mark
 * @property string $remark
 * @property string $created_at
 * @property string $timestamp
 *
 * @property PaTarget $eval
 */
class PcTargetEvaluation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pc_target_evaluation';
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
            [['eval_id', 'target_id', 'progress', 'indicator', 'created_at'], 'required'],
            [['eval_id', 'target_id'], 'integer'],
            [['progress', 'indicator', 'remark'], 'string'],
            [['mark'], 'number'],
            [['created_at', 'timestamp'], 'safe'],
            [['eval_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaTarget::className(), 'targetAttribute' => ['eval_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'eval_id' => 'Eval ID',
            'target_id' => 'Target ID',
            'progress' => 'Progress',
            'indicator' => 'Indicator',
            'mark' => 'Mark',
            'remark' => 'Remark',
            'created_at' => 'Created At',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEval()
    {
        return $this->hasOne(PaTarget::className(), ['id' => 'eval_id']);
    }
}
