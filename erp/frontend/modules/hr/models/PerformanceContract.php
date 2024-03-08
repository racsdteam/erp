<?php

namespace frontend\modules\hr\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "performance_contract".
 *
 * @property int $id
 * @property int $user_id
 * @property int $emp_pos
 * @property string $financial_year
 * @property string $status
 * @property string $created
 * @property string $timestamp
 *
 * @property PaEvaluation[] $paEvaluations
 * @property PaFinalEvaluationDetail[] $paFinalEvaluationDetails
 * @property PaTarget[] $paTargets
 * @property Employees $emp
 */
class PerformanceContract extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'performance_contract';
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
            [['user_id', 'emp_pos', 'financial_year', 'created'], 'required'],
            [['user_id'], 'integer'],
            [['financial_year'], 'string', 'max' => 16],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'emp_pos' => 'Emp Pos',
            'financial_year' => 'Financial Year',
            'status' => 'Status',
            'created' => 'Created',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaEvaluations()
    {
        return $this->hasMany(PaEvaluation::className(), ['pa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaFinalEvaluationDetails()
    {
        return $this->hasMany(PaFinalEvaluationDetail::className(), ['pa_id' => 'id']);
    }
        public function getWfInstance()
{
    return $this->hasOne(PcApprovalRequestInstances::className(), ['entity_record' => 'id'])->andOnCondition(['entity_type' =>$this->formName()]);
} 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaTargets()
    {
        return $this->hasMany(PaTarget::className(), ['pa_id' => 'id']);
    }
      public function getRequester()
{
    return $this->hasOne(User ::className(), ['user_id' => 'user_id']);
} 
    public  function isSubmitted(){
 return $this->getWfInstance() != null;   
    
}
}
