<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "anket_employment_children_june".
 *
 * @property int $id
 * @property string $federal_district_id
 * @property string $region_id
 * @property string $municipality_id
 * @property string $age
 * @property string|null $field1 4.	Посещали ли вы стационарный загородный лагерь
 * @property string|null $field2 4.1.	Уехали на отдых с родителями
 * @property string|null $field3 4.2.	Работали
 * @property string|null $field4 4.3.	Посещали кружки: 
 * @property string|null $field5 4.4.	Посещали спортивные секции: 
 * @property string|null $field6 4.5.	Занимались с репетитором: 
 * @property string|null $field7 4.6.	Посещали лагерь с дневным пребыванием: 
 * @property string|null $field8 5.1.	Прогулки на свежем воздухе 
 * @property string|null $field9 5.2.	Подвижные игры, езда на самокате, велосипеде и т.д. 
 * @property string|null $field10 5.3.	Беседы и совместные занятия с родителями 
 * @property string|null $field11 5.4.	Чтение книг 
 * @property string|null $field12 5.5.	Занятия с компьютером, сотовым телефоном и иными гаджетами
 * @property string|null $field13 5.6.	Просмотр телевизора и прослушивание музыки, аудио- книг 
 * @property string|null $field14 5.7.	Уборка помещений, застилание постели, мытье посуды и т.д. 
 * @property string|null $field15 5.8.	Утренняя гимнастика
 * @property string|null $field16
 * @property string|null $field17
 * @property string|null $field18
 * @property string|null $field19
 * @property string|null $field20
 * @property string|null $field21
 * @property string|null $field22
 * @property string $created_at
 */
class AnketEmploymentChildrenJune extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anket_employment_children_june';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[
                'federal_district_id',
                'region_id',
                'municipality_id',
                'age',
                'field1',
                'field8',
                'field9',
                'field10',
                'field11',
                'field12',
                'field13',
                'field14',
                'field15',
            ], 'required'],
            [[
                'field2',
                'field3',
                'field4',
                'field5',
                'field6',
                'field7',
                'created_at'
            ], 'safe'],
            [[
                'field2',
                'field3',
                'field4',
                'field5',
                'field6',
                'field7',
                'field17',
            ],'required', 'when' => function($model) {
                return $model->field1 == 'нет';
            }, 'whenClient' => "function (attribute, value) {
                return $('#anketemploymentchildrenjune-field1').val() == 'нет';
            }"],
            [[
                'federal_district_id',
                'region_id',
                'municipality_id',
                'age',
                'field1',
                'field8',
                'field9',
                'field10',
                'field11',
                'field12',
                'field13',
                'field14',
                'field15',
            ], 'string', 'max' => 50],

            ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'federal_district_id' => '1. Федеральный округ: ',
            'region_id' => '2. Субъект Федерации: ',
            'municipality_id' => '3. Муниципальное образование: ',
            'age' => '4. Возраст ',
            'field1' => '5.	Посещали ли вы стационарный загородный лагерь: ',
            'field2' => '5.1. Уехали на отдых: ',
            'field3' => '5.2. Работали: ',
            'field4' => '5.3. Посещали кружки: ',
            'field5' => '5.4. Посещали спортивные секции: ',
            'field6' => '5.5. Занимались с репетитором: ',
            'field7' => '5.6. Посещали лагерь с дневным пребыванием: ',
            'field8' => '6.1. Прогулки на свежем воздухе: ',
            'field9' => '6.2. Подвижные игры, езда на самокате, велосипеде и т.д.: ',
            'field10' =>'6.3. Беседы и совместные занятия с родителями (в т.ч. бабушками и дедушками): ',
            'field11' =>'6.4. Чтение книг: ',
            'field12' =>'6.5. Занятия с компьютером, сотовым телефоном и иными гаджетами: ',
            'field13' =>'6.6. Просмотр телевизора и прослушивание музыки, аудио- книг: ',
            'field14' =>'6.7. Уборка помещений, застилание постели, мытье посуды и т.д.: ',
            'field15' =>'6.8. Утренняя гимнастика: ',
            'field17' => '5.7. Количество приемов пищи в день: ',
            'field18' => 'Field18',
            'field19' => 'Field19',
            'field20' => 'Field20',
            'field21' => 'Field21',
            'field22' => 'Field22',
            'created_at' => 'Created At',
        ];
    }
}
