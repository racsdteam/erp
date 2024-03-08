<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "pc_report_comments_viewer".
 *
 * @property int $id
 * @property int $pc_report_comment_id
 * @property int $viewer
 */
class PcEvaluationCommentsViewer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pc_evaluation_comments_viewer';
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
            [['pc_evaluation_comment_id', 'viewer'], 'required'],
            [['pc_evaluation_comment_id', 'viewer'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pc_evaluation_comment_id' => 'Pc Report Comment ID',
            'viewer' => 'Viewer',
        ];
    }
}
