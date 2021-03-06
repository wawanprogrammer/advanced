<?php

namespace lukisongroup\purchasing\models\stck;

use Yii;

/**
 * This is the model class for table "p0005".
 *
 * @property integer $ID
 * @property string $TYPE_PARENT
 * @property string $TYPE_KAT
 * @property integer $TYPE_ID
 * @property string $TYPE_NAME
 * @property string $NOTE
 */
class TipeStock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p0005';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TYPE_ID'], 'integer'],
            [['NOTE'], 'string'],
            [['TYPE_PARENT'], 'string', 'max' => 1],
            [['TYPE_KAT'], 'string', 'max' => 3],
            [['TYPE_NAME'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'TYPE_PARENT' => Yii::t('app', 'TYPE_PARENT'),
            'TYPE_KAT' => Yii::t('app', 'TYPE_KAT'),
            'TYPE_ID' => Yii::t('app', 'TYPE_ID'),
            'TYPE_NAME' => Yii::t('app', 'TYPE_NAME'),
            'NOTE' => Yii::t('app', 'NOTE'),
        ];
    }
}
