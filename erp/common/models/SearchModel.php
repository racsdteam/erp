<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\Expression;

/**
 * Login form
 */
class SearchModel extends Model
{
    public $org;
    public $date_from;
    public $date_to;
    public $meal;
    public $month;
    public $year;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          
           [['org','date_from','date_to','meal','year','month'],'string'],
            
        ];
    }

    

   
}
