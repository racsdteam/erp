<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "pc_report_comments".
 *
 * @property int $id
 * @property int $report_id
 * @property int $user_id
 * @property string $user_position_code
 * @property string $comment
 * @property string $timestamp
 *
 * @property PcReport $report
 */
class PcEvaluationComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pc_evaluation_comments';
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
            [['pc_evaluation_id', 'user_id', 'user_position_code', 'comment'], 'required'],
            [['pc_evaluation_id', 'user_id'], 'integer'],
            [['comment'], 'string'],
            [['timestamp'], 'safe'],
            [['user_position_code'], 'string', 'max' => 8],
            [['pc_evaluation_id'], 'exist', 'skipOnError' => true, 'targetClass' => PcEvaluation::className(), 'targetAttribute' => ['pc_evaluation_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pc_evaluation_id' => 'Evaluation ID',
            'user_id' => 'User ID',
            'user_position_code' => 'User Position Code',
            'comment' => 'Comment',
            'timestamp' => 'Timestamp',
        ];
    }

 
}
