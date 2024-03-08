<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_transmission_slip_comments".
 *
 * @property int $id
 * @property int $trans_slip
 * @property int $author
 * @property string $timestamp
 * @property string $comment
 */
class ErpTransmissionSlipComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_transmission_slip_comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_slip', 'author', 'comment'], 'required'],
            [['trans_slip', 'author'], 'integer'],
            [['timestamp'], 'safe'],
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
            'trans_slip' => 'Trans Slip',
            'author' => 'Author',
            'timestamp' => 'Timestamp',
            'comment' => 'Comment',
        ];
    }
}
