<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "street".
 *
 * @property string $ref
 * @property string $name
 * @property string $city_ref
 *
 * @property City $cityRef
 */
class Street extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'street';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ref', 'name', 'city_ref'], 'required'],
            [['ref', 'city_ref'], 'string', 'max' => 36],
            [['name'], 'string', 'max' => 255],
            [['ref'], 'unique'],
            [['city_ref'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_ref' => 'ref']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ref' => 'Ref',
            'name' => 'Name',
            'city_ref' => 'City Ref',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['ref' => 'city_ref']);
    }
}
