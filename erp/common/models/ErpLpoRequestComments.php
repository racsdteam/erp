<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_lpo_request_comments".
 *
 * @property int $id
 * @property int $author
 * @property string $date
 * @property string $time
 * @property string $comment
 */
class ErpLpoRequestComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_lpo_request_comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author', 'date', 'time', 'comment','lpo_request'], 'required'],
            [['author','lpo_request'], 'integer'],
            [['date', 'time'], 'safe'],
            [['comment'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => 'Author',
            'date' => 'Date',
            'time' => 'Time',
            'comment' => 'Comment',
        ];
    }
}
