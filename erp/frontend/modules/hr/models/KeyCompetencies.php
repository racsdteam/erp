<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "key_competencies".
 *
 * @property int $id
 * @property int $Competency
 * @property string $type
 * @property string $status
 * @property string $timestamp
 *
 * @property PaCompetencyEvaluation[] $paCompetencyEvaluations
 */
class KeyCompetencies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'key_competencies';
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
            [['Competency', 'type', 'status'], 'required'],
            [['Competency'], 'integer'],
            [['type', 'status'], 'string'],
            [['timestamp'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Competency' => 'Competency',
            'type' => 'Type',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaCompetencyEvaluations()
    {
        return $this->hasMany(PaCompetencyEvaluation::className(), ['kc_id' => 'id']);
    }
}
