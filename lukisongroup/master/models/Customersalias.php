<?php

namespace lukisongroup\master\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "c0002".
 *
 * @property integer $ID
 * @property string $KD_CUSTOMERS
 * @property string $KD_ALIAS
 * @property string $KD_DISTRIBUTOR
 * @property integer $KD_PARENT
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_BY
 * @property string $UPDATED_AT
 */
class Customersalias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'c0002';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

    public function getCus()
    {
        return $this->hasOne(Customers::className(), ['CUST_KD' => 'KD_CUSTOMERS']);
    }
    public function getCustnm()
    {
      # code...
      return $this->cus->CUST_NM;
    }

    public function getDis()
    {
        return $this->hasOne(Distributor::className(), ['KD_DISTRIBUTOR' => 'KD_DISTRIBUTOR']);
    }

    public function getDisnm()
    {
      # code...
      return $this->dis->NM_DISTRIBUTOR;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_PARENT'], 'integer'],
            [['CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['KD_CUSTOMERS', 'KD_ALIAS'], 'string', 'max' => 30],
            [['KD_ALIAS'], 'cekalias'],
            [['KD_DISTRIBUTOR'], 'string', 'max' => 50],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100]
        ];
    }

    public function data($data,$to,$from)
    {
      # code...
      return ArrayHelper::map($data, $to, $from);
    }

    public function cekalias($model)
    {
      # code...
       $kondisiTrue = Customersalias::find()->where("KD_ALIAS='".$this->KD_ALIAS. "' AND KD_DISTRIBUTOR='".$this->KD_DISTRIBUTOR."'")->one();
       if($kondisiTrue)
       {
           $this->addError($model, 'Duplicated code because the code already exists in this distributor !, attention  change name distributor or change code ');
       }
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_CUSTOMERS' => 'Kd  Customers',
            'KD_ALIAS' => 'Kd  Alias',
            'KD_DISTRIBUTOR' => 'Kd  Distributor',
            'KD_PARENT' => 'Kd  Parent',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_AT' => 'Updated  At',
        ];
    }
}
