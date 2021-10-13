<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "thermometry_camp".
 *
 * @property int $id
 * @property int $organization_id
 * @property int $kids_id
 * @property string $date_surveys
 * @property string $normal_temperature
 * @property string $no_normal_temperature
 * @property string $create_at
 */
class ThermometryCamp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'thermometry_camp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_id', 'kids_id', 'date_surveys',], 'required'],
            [['organization_id', 'kids_id'], 'integer'],
            [['date_surveys','normal_temperature_morning','normal_temperature_evening', 'create_at'], 'safe'],
            [['no_normal_temperature_morning', 'no_normal_evening'], 'number', 'min' => '37.1', 'max' => '41.2'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'organization_id' => 'Organization ID',
            'kids_id' => 'Kids ID',
            'date_surveys' => 'Дата замера',
            'normal_temperature_morning' => 'УТРО: нормальная температура ниже 37.1',
            'no_normal_temperature_morning' => 'УТРО: Температура выше 37.1',
            'normal_temperature_evening' => 'ВЕЧЕР: нормальная температура ниже 37.1',
            'no_normal_evening' => 'ВЕЧЕР: Температура выше 37.1',
            'create_at' => 'Create At',
        ];
    }
}
