<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "pa_competency_evaluation".
 *
 * @property int $id
 * @property int $kc_id
 * @property int $eval_id
 * @property double $mark
 * @property string $remark
 * @property string $timestamp
 *
 * @property PaEvaluation $eval
 * @property KeyCompetencies $kc
 */
class PaCompetencyEvaluation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pc_competency_evaluation';
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
            [['kc_id', 'eval_id', 'mark', 'remark'], 'required'],
            [['kc_id', 'eval_id'], 'integer'],
            [['mark'], 'number'],
            [['remark'], 'string'],
            [['timestamp'], 'safe'],
            [['eval_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaEvaluation::className(), 'targetAttribute' => ['eval_id' => 'id']],
            [['kc_id'], 'exist', 'skipOnError' => true, 'targetClass' => KeyCompetencies::className(), 'targetAttribute' => ['kc_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kc_id' => 'Kc ID',
            'eval_id' => 'Eval ID',
            'mark' => 'Mark',
            'remark' => 'Remark',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEval()
    {
        return $this->hasOne(PaEvaluation::className(), ['id' => 'eval_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKc()
    {
        return $this->hasOne(KeyCompetencies::className(), ['id' => 'kc_id']);
    }
}
