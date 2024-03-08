<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "pc_target_level_score".
 *
 * @property int $id
 * @property int $pc_id
 * @property double $score_percentage
 * @property string $timestamp
 */
class PcTargetLevelScore extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
     
     const companyTargetLevel= "organisation level";
    const departmentTargetLevel= "department level";
    const employeeTargetLevel= "employee level";
    
    
    public static function tableName()
    {
        return 'pc_target_level_score';
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
            [['pc_id', 'score_percentage'], 'required'],
            [['pc_id'], 'integer'],
            [['score_percentage'], 'number'],
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
            'pc_id' => 'Pc ID',
            'score_percentage' => 'Score Percentage',
            'timestamp' => 'Timestamp',
        ];
    }
}
