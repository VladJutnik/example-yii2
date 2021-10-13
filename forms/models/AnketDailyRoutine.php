<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "anket_daily_routine".
 *
 * @property int $id ID
 * @property string $login кто заполнил
 * @property string $federal_district_id Выдали ли тебе при заселении три полотенца (для лица, ног, банное)?
 * @property string $region_id Выдали ли тебе при заселении три полотенца (для лица, ног, банное)?
 * @property string $municipality_id Выдали ли тебе при заселении три полотенца (для лица, ног, банное)?
 * @property string $school Выдали ли тебе при заселении три полотенца (для лица, ног, банное)?
 * @property string $sex Выдали ли тебе при заселении три полотенца (для лица, ног, банное)?
 * @property string $class Выдали ли тебе при заселении три полотенца (для лица, ног, банное)?
 * @property string $change_training Выдали ли тебе при заселении три полотенца (для лица, ног, банное)?
 * @property string $field1 Во сколько заканчиваются занятия (для первой смены)
 * @property string $field2 Во сколько начинаются занятия (для первой смены)
 * @property string $field3 8.	Посещаете ли Вы кружки, студии дополнительного образования (да/нет)
 * @property string $field4 8.1.	Сколько кружков (студий) Вы посещаете? 1,2,3 более трех
 * @property string $field5 8.2.	Время начала занятий в кружках?
 * @property string $field6 8.3.	Время окончания занятий в кружках? 
 * @property string $field7 8.4.	Продолжительность занятий (в минутах)
 * @property string $field8 8.5.	Сколько дней в неделю вы посещаете кружки (студии) 1,2,3,4,5,6,7
 * @property string $field9 8.6.	Нравятся ли вам занятия – оцените по 10 бальной шкале (0- нет, 10 – очень нравится, т.е. максимальная оценка) 
 * @property string $field10 9.	Посещаете ли Вы спортивные секции (да/нет)
 * @property string $field11 9.1.	Сколько спортивных секций Вы посещаете
 * @property string $field12 9.2.	Время начала занятий в спортивной секции
 * @property string $field13 9.3.	Время окончания
 * @property string $field14 9.4.	Продолжительность занятий
 * @property string $field15 9.5.	Продолжительность занятий (в минутах)
 * @property string $field16 9.6.	Нравятся ли вам занятия – оцените по 10 бальной шкале (0- нет, 10 – очень нравится, т.е. максимальная оценка), 
 * @property string $field17 10.	Сколько времени Вы тратите в среднем в учебный день на выполнение домашних заданий?
 * @property string $field18 11.	Сколько времени в учебный день вы гуляете на улице? 
 * @property string $field19 12.	Сколько времени в среднем в день вы тратите на работу и досуг с компьютером, планшетом, ноутбуком?
 * @property string $field20 13.	Сколько времени в среднем в день вы тратите на работу и досуг с сотовым телефоном? (не занимаюсь вообще / до 1 часа/1-2 ч./2-3 ч/3-4 ч./ 4-5 ч. /5 ч и более)
 * @property string $field21 14.	За сколько часов до сна ужинаете? (прямо перед сном/за 30 минут до сна; за 1 час 
 * @property string $field22 15.	Во сколько встаете в обычный учебный день: до 7.00, с 7.00 до 7.59, с 8.00 до 8.59, после 9.00
 * @property string $field23 16.	Во сколько ложитесь спать в обычный учебный день до 21.00. с 21.00 до 21.59, с 22.00 до 22.59., после 23.00. 
 * @property string $field24
 * @property string $field25
 * @property string $field26
 * @property string $field27
 * @property string $field28
 * @property string $field29
 * @property string $field30
 * @property string $creat_at
 */
class AnketDailyRoutine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anket_daily_routine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[
                'login',
                'federal_district_id',
                'region_id',
                'municipality_id',
                'school',
                'sex',
                'class',
                'change_training',
                'field1',
                'field2',
                'field3',
                'field4',
                'field5',
                'field6',
                'field7',
                'field8',
                'field9',
                'field10',
                'field11',
                'field12',
                'field13',
                'field14',
                'field15',
                'field16',
                'field17',
                'field18',
                'field19',
                'field20',
                'field21',
                'field22',
                'field23',
                'field24',
                'field25',
                'field26',
                'field27',
                'field28',
                'field29',
                'field30',
                'creat_at'
            ], 'safe'],
            [[
                'federal_district_id',
                'region_id',
                'municipality_id',
                'sex',
                'class',
                'change_training',
                'field3',
                'field10',
                'field17',
                'field18',
                'field19',
                'field20',
                'field21',
                'field22',
                'field23',
                'field24',

            ], 'required'],

            [['field7', 'field14', 'field26' ], 'integer', 'min' => 20, 'max' => 180],
            [['field5', 'field6', 'field12', 'field13'], 'match', 'pattern' => '/^([0-0][0-9]|[1-1][0-9]|]|[2-2][0-3])\:([0-5][0-9])/', 'message' => 'Укажите время в правильном формате'],
            [['field1', 'field2'], 'match', 'pattern' => '/^([1-1][2-2]|[1-1][2-5]|])\:([0-5][0-9])/', 'message' => 'Укажите время в правильном формате'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'federal_district_id' => '1. Федеральный округ',
            'region_id' => '2. Субъект Федерации',
            'municipality_id' => '3. Муниципальное образование',
            'school' => '4. Общеобразовательная организация (не обязательно)',
            'sex' => '5. Пол',
            'class' => '6. Класс ',
            'change_training' => '7. Смена обучения ',
            'field1' => 'Во сколько заканчиваются занятия',
            'field2' => 'Во сколько начинаются занятия',
            'field3' => '8. Посещаете ли Вы кружки, студии дополнительного образования ',
            'field4' => '8.1. Сколько кружков (студий) Вы посещаете? ',
            'field5' => '8.2. Время начала занятий в кружках?',
            'field6' => '8.3. Время окончания занятий в кружках? ',
            'field7' => '8.4. Продолжительность занятий (в минутах)',
            'field8' => '8.5. Сколько дней в неделю вы посещаете кружки (студии) ',
            'field9' => '8.6. Нравятся ли вам занятия – оцените по 10 бальной шкале ',
            'field10' => '10. Посещаете ли Вы спортивные секции ',
            'field11' => '10.1. Сколько спортивных секций Вы посещаете;',
            'field12' => '10.2. Время начала занятий в спортивной секции',
            'field13' => '10.3. Время окончания',
            'field14' => '10.4. Продолжительность занятий (в минутах)',
            'field15' => '10.5. Сколько дней в неделю вы посещаете спортивные секции ',
            'field16' => '10.6. Нравятся ли вам занятия – оцените по 10 бальной шкале ',
            'field17' => '11. Сколько времени Вы тратите в среднем в учебный день на выполнение домашних заданий? ',
            'field18' => '12. Сколько времени в учебный день вы гуляете на улице? ',
            'field19' => '13. Сколько времени в среднем в день вы тратите на учебу и досуг с компьютером, планшетом, ноутбуком? ',
            'field20' => '14. Сколько времени в среднем в день вы тратите на учебу и досуг с сотовым телефоном? ',
            'field21' => '15. За сколько часов до сна ужинаете? ',
            'field22' => '16. Во сколько встаете в обычный учебный день: ',
            'field23' => '17. Во сколько ложитесь спать в обычный учебный день ',
            'field24' => '9. Занимаетесь ли Вы с репетитором?',
            'field25' => '9.1. Сколько раз в неделю?',
            'field26' => '9.1. Продолжительность занятия с репетитором (в минутах)',
            'field27' => 'Field27',
            'field28' => 'Field28',
            'field29' => 'Field29',
            'field30' => 'Field30',
            'creat_at' => 'Creat At',
        ];
    }
}
