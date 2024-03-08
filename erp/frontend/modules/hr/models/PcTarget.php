<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "pa_target".
 *
 * @property int $id
 * @property int $pa_id
 * @property float $kpi_weight
 * @property string $output
 * @property string $indacator
 * @property string $type
 * @property string $timestamp
 *
 * @property PerformanceAppraisal $pa
 * @property PaTargetEvaluation[] $paTargetEvaluations
 */
class PcTarget extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
     
    const companyTargetLevel= "organisation level";
    const departmentTargetLevel= "department level";
    const employeeTargetLevel= "employee level";
    public static function tableName()
    {
        return 'pc_target';
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
            [['pa_id', 'output', 'indicator', 'type'], 'required'],
            [['pa_id'], 'integer'],
            [['output', 'indicator', 'type'], 'string'],
            [['pa_id'], 'exist', 'skipOnError' => true, 'targetClass' => PerformanceContract::className(), 'targetAttribute' => ['pa_id' => 'id']],
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
            'output' => 'Output',
            'indicator' => 'Indicator',
            'kpi_weight' => 'kpi weight',
            'type' => 'Type',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPa()
    {
        return $this->hasOne(PerformanceContract::className(), ['id' => 'pa_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaTargetEvaluations()
    {
        return $this->hasMany(PcTargetEvaluation::className(), ['eval_id' => 'id']);
    }
}
