<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property string $ref
 * @property string $name
 *
 * @property Street[] $streets
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ref', 'name'], 'required'],
            [['ref'], 'string', 'max' => 36],
            [['name'], 'string', 'max' => 255],
            [['ref'], 'unique'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStreets()
    {
        return $this->hasMany(Street::className(), ['city_ref' => 'ref']);
    }
}
