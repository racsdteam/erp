<?php

namespace frontend\modules\hr\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "pa_evaluation".
 *
 * @property int $id
 * @property int $pa_id
 * @property int $user_id
 * @property int $emp_pos
 * @property string $type
 * @property int $supervisor_1
 * @property int $supervisor_2
 * @property string $timestamp
 *
 * @property PaApproval[] $paApprovals
 * @property PaApprovalFlow[] $paApprovalFlows
 * @property PaCompetencyEvaluation[] $paCompetencyEvaluations
 * @property PerformanceAppraisal $pa
 */
class PcEvaluation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pc_evaluation';
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
            [['pa_id', 'user_id', 'emp_pos', 'evaluation_period', ], 'required'],
            [['pa_id', 'user_id'], 'integer'],
            [['evaluation_period'], 'string'],
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
            'pa_id' => 'PC ID',
            'user_id' => 'User ID',
            'emp_pos' => 'Emp Pos',
            'evaluation_period' => 'Evaluation Period',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaApprovals()
    {
        return $this->hasMany(PaApproval::className(), ['request' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaApprovalFlows()
    {
        return $this->hasMany(PaApprovalFlow::className(), ['request' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaCompetencyEvaluations()
    {
        return $this->hasMany(PaCompetencyEvaluation::className(), ['eval_id' => 'id']);
    }
      public function getUser()
{
    return $this->hasOne(User ::className(), ['user_id' => 'user_id']);
} 
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPa()
    {
        return $this->hasOne(PerformanceContract::className(), ['id' => 'pa_id']);
    }
}
