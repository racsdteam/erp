<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "pc_target_achieved_result".
 *
 * @property int $id
 * @property int $target_id
 * @property string $deliverable
 * @property string $indicator
 * @property int $emp_id
 * @property int $emp_pos
 * @property string $status
 * @property string $timestamp
 *
 * @property PcTarget $target
 */
class PcTargetAchievedResult extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pc_target_achieved_result';
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
            [['pc_evaluation_id','target_id', 'deliverable', 'indicator', 'emp_id', 'emp_pos', 'status'], 'required'],
            [['target_id', 'emp_id'], 'integer'],
            [['deliverable', 'indicator', 'status','emp_pos'], 'string'],
            [['target_id'], 'exist', 'skipOnError' => true, 'targetClass' => PcTarget::className(), 'targetAttribute' => ['target_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'target_id' => 'Target ID',
            'deliverable' => 'Deliverable',
            'indicator' => 'Indicator',
            'emp_id' => 'Emp ID',
            'emp_pos' => 'Emp Pos',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarget()
    {
        return $this->hasOne(PcTarget::className(), ['id' => 'target_id']);
    }
}
