<?php
namespace lukisongroup\widget\models;

class ChatTest extends \yii\redis\ActiveRecord
{
    /**
     * @return array the list of attributes for this record
     */
    public function attributes()
    {
        return ['id', 'name', 'message', 'date','emp_id','image_profile'];
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name','date','emp_id','image_profile'], 'safe'],
            [['name','message'], 'string', 'max' => 255]
        ];
    }

   
}


?>