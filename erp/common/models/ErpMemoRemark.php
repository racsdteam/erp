<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_memo_remark".
 *
 * @property int $id
 * @property string $remark
 * @property int $memo
 * @property string $timestamp
 * @property int $author
 */
class ErpMemoRemark extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_memo_remark';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['remark', 'memo', 'author'], 'required'],
            [['remark'], 'string'],
            [['memo', 'author'], 'integer'],
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
            'remark' => 'Remark',
            'memo' => 'Memo',
            'timestamp' => 'Timestamp',
            'author' => 'Author',
        ];
    }
}
