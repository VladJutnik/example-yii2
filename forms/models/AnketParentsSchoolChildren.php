<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "anket_parents_school_children".
 *
 * @property int $id
 * @property int $federal_district_id
 * @property int $region_id
 * @property string $place_residence Место проживания
 * @property string $school Школа
 * @property int $class Класс
 * @property int $age Возраст Вашего ребенка
 * @property int $sex Пол Вашего ребенка
 * @property int $body_weight Масса тела Вашего ребенка (кг)
 * @property int $body_length Длина тела Вашего ребенка (см)
 * @property int $obtain_information 1. Откуда Вы получаете или можете получить информацию о питании Вашего ребенка?
 * @property int $obtain_information_otther Другое
 * @property int $delicious_food 2.1 Еда вкусная
 * @property int $enough_time_eat 2.2 Ребенку достаточно времени на прием пищи
 * @property int $menu_quite_diverse 2.3 Меню достаточно разнообразно
 * @property int $choice_dishes 2.4 Есть возможность самостоятельного выбора блюд
 * @property int $clean_dishes 2.5 Всегда чистая посуда
 * @property int $comfort_food_children 2.6 Столовая обладает достаточной площадью для комфортного питания детей
 * @property int $not_delicious_food 3.1 Еда невкусная
 * @property int $not_enough_time_eat 3.2 Ребенку недостаточно времени на прием пищи
 * @property int $not_menu_quite_diverse 3.3 Меню однообразно
 * @property int $not_choice_dishes 3.4 Нет возможности самостоятельного выбора блюд
 * @property int $not_clean_dishes 3.5 Грязная со сколами посуда
 * @property int $not_comfort_food_children 3.6 Столовая маленькая, недостаточно места для комфортного размещения детей
 * @property int $rate_overall_satisfaction 4. Оцените общую удовлетворенность питанием в школьной столовой по шкале (1 – минимум; 10 – максимум)
 * @property string $offers Ваши предложения по улучшению качества питания в школе
 * @property string $created_at Дата заполнения
 */
class AnketParentsSchoolChildren extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anket_parents_school_children';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['federal_district_id', 'region_id', 'municipality_id', 'class', 'age', 'sex', 'place_residence', 'school','body_weight', 'body_length', 'obtain_information', 'delicious_food', 'enough_time_eat', 'menu_quite_diverse', 'choice_dishes', 'clean_dishes', 'comfort_food_children', 'not_delicious_food', 'not_enough_time_eat', 'not_menu_quite_diverse', 'not_choice_dishes', 'not_clean_dishes', 'not_comfort_food_children', 'respiratory', 'digestive_system', 'circulations', 'diabetes', 'celiac', 'food_allergy', 'rate_overall_satisfaction'], 'required'],
            [['federal_district_id', 'region_id', 'class', 'age', 'sex', 'body_weight', 'body_length', 'obtain_information', 'obtain_information_otther', 'delicious_food', 'enough_time_eat', 'menu_quite_diverse', 'choice_dishes', 'clean_dishes', 'comfort_food_children', 'not_delicious_food', 'not_enough_time_eat', 'not_menu_quite_diverse', 'not_choice_dishes', 'not_clean_dishes', 'not_comfort_food_children', 'rate_overall_satisfaction'], 'integer'],
            [['offers', 'obtain_information_otther'], 'string'],
            [['body_weight'], 'integer', 'min' => 20, 'max' => 150],
            [['body_length'], 'integer', 'min' => 20, 'max' => 220],
            [['citrus','nuts','egg','milk','chocolate','fish','other_allergy','other_allergy_year', 'created_at'], 'safe'],
            [['place_residence', 'school'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            //'id' => 'ID',
            'federal_district_id' => 'Федеральный округ',
            'region_id' => 'Область',
            'municipality_id' => 'Муниципальное образование',
            'place_residence' => 'Место проживания',
            'school' => 'Школа',
            'class' => 'Класс',
            'age' => 'Возраст Вашего ребенка',
            'sex' => 'Пол Вашего ребенка',
            'body_weight' => 'Масса тела Вашего ребенка (кг)',
            'body_length' => 'Длина тела Вашего ребенка (см)',
            'obtain_information' => '1. Откуда Вы получаете или можете получить информацию о питании Вашего ребенка?',
            'obtain_information_otther' => 'Другое',
            'delicious_food' => '2.1 Еда вкусная',
            'enough_time_eat' => '2.2 Ребенку достаточно времени на прием пищи',
            'menu_quite_diverse' => '2.3 Меню достаточно разнообразно',
            'choice_dishes' => '2.4 Есть возможность самостоятельного выбора блюд',
            'clean_dishes' => '2.5 Всегда чистая посуда',
            'comfort_food_children' => '2.6 Столовая обладает достаточной площадью для комфортного питания детей',
            'not_delicious_food' => '3.1 Еда невкусная',
            'not_enough_time_eat' => '3.2 Ребенку недостаточно времени на прием пищи',
            'not_menu_quite_diverse' => '3.3 Меню однообразно',
            'not_choice_dishes' => '3.4 Нет возможности самостоятельного выбора блюд',
            'not_clean_dishes' => '3.5 Грязная со сколами посуда',
            'not_comfort_food_children' => '3.6 Столовая маленькая, недостаточно места для комфортного размещения детей',

            'respiratory' => 'Заболевания органов дыхания',
            'digestive_system' => 'Заболевания органов пищеварения',
            'circulations' => 'Болезни системы кровообращения',
            'diabetes' => 'Сахарный диабет',
            'celiac' => 'Целиакия',
            'food_allergy' => 'Пищевая аллергия',
            'citrus' => 'Цитрусовые',
            'nuts' => 'Орехи',
            'egg' => 'Яйцо',
            'milk' => 'Молоко и молочные продукты',
            'chocolate' => 'Шоколад',
            'fish' => 'Рыба',
            'other_allergy' => 'Иное',
            'other_allergy_year' => 'С какого возраста',

            'rate_overall_satisfaction' => '5. Оцените, насколько Вы удовлетворены питанием ребенка в школе? Оцените по 10-бальной системе (1 – минимум, 10 – максимум)',
            'offers' => 'Ваши предложения по улучшению качества питания в школе',
            'created_at' => 'Created At',
        ];
    }
    public function get_district_id($id){
        $fd = FederalDistrict::findOne($id);
        return $fd;
    }
    public function get_region_id($id){
        $rg = Region::findOne($id);
        return $rg;
    }

    public function terrain($id = false)
    {
        $terrain_item =['городская','сельская'];
        if (!is_bool($id))
        {
            // echo 'есть id='. $id;
            return $terrain_item[$id];
        }
        else  {
            //echo 'нет id';
            return $terrain_item;
        }
    }
}
