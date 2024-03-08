<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_memo".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $created_by
 * @property string $created_at
 */
class MemoForm extends Model
{

    public $title;
    public $type;
    public $description;
    public $expiration_date;
   
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title','type', 'description'], 'required'],
            [['description','memo_code','status'], 'string'],
            [['created_by','type','is_new','user_position'], 'integer'],
            [['created_at','expiration_date'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'type'=>'Memo For',
            'expiration_date'=>'Expiration Date (Set your Memo to expire automatically if they are not approved)'
        ];
    }
}
