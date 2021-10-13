<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "anket_school_children_kaz".
 *
 * @property int $id ID
 * @property string $federal_district_id
 * @property string $region_id
 * @property string $municipality_id
 * @property string $school
 * @property string $class
 * @property string $class_a_b
 * @property string $change_training
 * @property string $fio 7.	Имя и первая буква фамилии
 * @property string $age
 * @property string $sex
 * @property string $weight 10.	Укажите массу тела (кг)
 * @property string|null $length 10.1	Укажите длину тела в см
 * @property string|null $field1
 * @property string|null $field2
 * @property string|null $field3
 * @property string|null $field4
 * @property string|null $field5
 * @property string|null $field6
 * @property string|null $field7
 * @property string|null $field8
 * @property string|null $field9
 * @property string|null $field10
 * @property string|null $field11
 * @property string|null $field12
 * @property string|null $field13
 * @property string|null $field14
 * @property string|null $field15
 * @property string|null $field16
 * @property string|null $field17
 * @property string|null $field18
 * @property string|null $field19
 * @property string|null $field20
 * @property string|null $field21
 * @property string|null $field22
 * @property string|null $field23
 * @property string|null $field24
 * @property string|null $field25
 * @property string|null $field26
 * @property string|null $field27
 * @property string|null $field28
 * @property string|null $field29
 * @property string|null $field30
 * @property string|null $field31
 * @property string|null $field32
 * @property string|null $field33
 * @property string|null $field34
 * @property string|null $field35
 * @property string|null $field36
 * @property string|null $field37
 * @property string|null $field38
 * @property string|null $field39
 * @property string|null $field40
 * @property string|null $field41
 * @property string|null $field42
 * @property string|null $field43
 * @property string|null $field44
 * @property string|null $field45
 * @property string|null $field46
 * @property string|null $field47
 * @property string|null $field48
 * @property string|null $field49
 * @property string|null $field50
 * @property string|null $field51
 * @property string|null $field52
 * @property string|null $field53
 * @property string|null $field54
 * @property string|null $field55
 * @property string|null $field56
 * @property string|null $field57
 * @property string|null $field58
 * @property string|null $field59
 * @property string|null $field60
 * @property string|null $field61
 * @property string|null $field62
 * @property string|null $field63
 * @property string|null $field64
 * @property string|null $field65
 * @property string|null $field66
 * @property string|null $field67
 * @property string|null $field68
 * @property string|null $field69
 * @property string|null $field70
 * @property string|null $field71
 * @property string|null $field72
 * @property string|null $field73
 * @property string|null $field74
 * @property string|null $field75
 * @property string|null $field76
 * @property string|null $field77
 * @property string|null $field78
 * @property string|null $field79
 * @property string|null $field80
 * @property string|null $field81
 * @property string|null $field82
 * @property string|null $field83
 * @property string|null $field84
 * @property string|null $field85
 * @property string|null $field86
 * @property string|null $field87
 * @property string|null $field88
 * @property string|null $field89
 * @property string|null $field90
 * @property string|null $field91
 * @property string|null $field92
 * @property string|null $field93
 * @property string|null $field94
 * @property string|null $field95
 * @property string|null $field96
 * @property string|null $field97
 * @property string|null $field98
 * @property string|null $field99
 * @property string|null $field100
 * @property string|null $field101
 * @property string|null $field102
 * @property string|null $field103
 * @property string|null $field104
 * @property string|null $field105
 * @property string|null $field106
 * @property string|null $field107
 * @property string|null $field108
 * @property string|null $field109
 * @property string|null $field110
 * @property string|null $field111
 * @property string|null $field112
 * @property string|null $field113
 * @property string|null $field114
 * @property string|null $field115
 * @property string|null $field116
 * @property string|null $field117
 * @property string|null $field118
 * @property string|null $field119
 * @property string|null $field120
 * @property string $creat_at
 */
class AnketSchoolChildrenKaz extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anket_school_children_kaz';
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

                'class',
                'class_a_b',
                'change_training',
                'fio',
                'age',
                'sex',
                'weight',
                'length',

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
                'field20',
                'field23',
                'field27',
                'field28',
                'field29',
                'field30',
                'field31',
                'field32',
                'field33',
                'field34',

                'field41',
                'field42',
                'field43',
                'field44',
                'field45',
                'field46',
                'field47',
                'field48',
                'field49',
                'field50',
                'field51',
                'field52',

                'field54',

                'field56',

                'field58',

                'field96',


                'field106',
                'field110',
                'field112',
                'field113',
                'field114',
                'school',

            ], 'required'],
            [['weight'], 'number', 'max' => 120, 'min' => 15],
            [['length'], 'number', 'max' => 200, 'min' => 35],

            [[

                'creat_at',
                'field17',
                'field18',
                'field19',
                'field21',
                'field22',
                'field24',
                'field25',
                'field26',
                'field60',
                'field62',
                'field64',
                'field66',
                'field68',
                'field70',
                'field72',
                'field74',
                'field76',
                'field78',
                'field80',
                'field82',
                'field84',
                'field86',
                'field88',
                'field90',
                'field92',
                'field94',
                'field95',
                'field53',
                'field55',
                'field57',
                'field59',
                'field35',
                'field36',
                'field37',
                'field38',
                'field39',
                'field40',
            ], 'safe'],
            [['field18', 'field22', 'field25'], 'number', 'max' => 240, 'min' => 20],
            [['field61','field63','field65','field67','field69',
                'field71','field73','field75',
                'field77','field79','field81',
                'field83','field85','field87',
                'field89','field91','field93',], 'number', 'max' => 180, 'min' => 5],





            [['school'], 'string', 'max' => 250],
            [['class', 'class_a_b', 'change_training', 'sex', 'length'], 'string', 'max' => 25],
            [['fio'], 'string', 'max' => 55],


            [['field1', 'field2', 'field3', 'field4', 'field5', 'field6', 'field7', 'field8', 'field9', 'field10', 'field11', 'field12', 'field13', 'field14', 'field15', 'field16', 'field17', 'field18', 'field19', 'field20', 'field21', 'field22', 'field23', 'field24', 'field25', 'field26', 'field27', 'field28', 'field29', 'field30', 'field31', 'field32', 'field33', 'field34', 'field35', 'field36', 'field37', 'field38', 'field39', 'field40', 'field41', 'field42', 'field43', 'field44', 'field45', 'field46', 'field47', 'field48', 'field49', 'field50', 'field51', 'field52', 'field53', 'field54', 'field55', 'field56', 'field57', 'field58', 'field59', 'field60', 'field61', 'field62', 'field63', 'field64', 'field65', 'field66', 'field67', 'field68', 'field69', 'field70', 'field71', 'field72', 'field73', 'field74', 'field75', 'field76', 'field77', 'field78', 'field79', 'field80', 'field81', 'field82', 'field83', 'field84', 'field85', 'field86', 'field87', 'field88', 'field89', 'field90', 'field91', 'field92', 'field93', 'field94', 'field95', 'field96', 'field97', 'field98', 'field99', 'field100', 'field101', 'field102', 'field103', 'field104', 'field105', 'field106', 'field107', 'field108', 'field109', 'field110', 'field111', 'field112', 'field113', 'field114', 'field115', 'field116', 'field117', 'field118', 'field119',
                'field120',
                'field121',
                'field122',
                'field123',
                'field124',
                'field125',
                'field126',
                'field127',
                'field128',
                'field129',
                'field107',
                'field108',
                'field109',
                ], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'federal_district_id' => '1. Федеральный округ',
            'region_id' => '2. Субъект Федерации',
            'municipality_id' => '3. Муниципальное образование',
            'school' => '4. Номер (название) школы',
            'class' => '5. Класс',
            'class_a_b' => '5.1 Буква/номер класса',
            'change_training' => '6. Смена обучения',
            'fio' => '7. Имя и первая буква фамилии',
            'age' => '8. Количество полных лет (6-17) ',
            'sex' => '9. Пол',
            'weight' => '10. Укажите массу тела (кг)',
            'length' => '10.1 Укажите длину тела в см',
            'field1' => '11.1. Завтракаете ли Вы дома перед выходом в школу?',
            'field2' => '11.2. Обедаете ли вы дома перед выходом в школу?',
            'field3' => '12. Сколько в среднем раз в день Вы кушаете?',
            'field4' => '12.1. в том числе в школе',
            'field5' => '13. Через какое время Вы ложитесь спать после последнего приема пищи? ',
            'field6' => '14. Досаливаете ли Вы пищу (обычно):',
            'field14' => '16. Как часто вы посещаете организации быстрого питания (KfC, МАКДОНАЛДС, БУРГЕР КИНГ и иные аналогичные организации)? ',
            'field15' => '17. Сколько ложек сахара Вы добавляете в чашку чая: ',


            'field106' => '18. Укажите кушаете ли Вы в школьной столовой ежедневно (в учебные дни)? ',
            'field107' => '18.1. выберите количество организованных (со всем классом) приемов пищи: ',
            'field108' => '18.1.1. если один раз: ',
            'field109' => '18.1.2 если два и более раза: ',
            'field110' => '19. Приобретаете ли Вы блюда в столовой на линии раздачи? ',
            'field111' => '19.1. Укажите приоритетное блюда Вашего выбора:',
            'field112' => '20. Укажите что Вам больше всего НРАВИТСЯ в школьной столовой (выберите один ответ):',
            'field113' => '21. Укажите что Вам больше всего НЕ НРАВИТСЯ в школьной столовой (выберите один ответ):',




            'field16' => '22. Посещаете ли Вы кружки, студии дополнительного образования?',
            'field17' => '22.1.	Сколько кружков (студий) Вы посещаете?',
            'field18' => '22.2.	Продолжительность 1-го занятия (в минутах)',
            'field19' => '22.3.	Сколько дней в неделю вы посещаете кружки (студии)?',
            'field20' => '23. Занимаетесь ли Вы с репетитором?',
            'field21' => '23.1.	Сколько раз в неделю?',
            'field22' => '23.2.	Продолжительность одного занятия с репетитором (в минутах)',
            'field23' => '24. Посещаете ли Вы спортивные секции?',
            'field24' => '24.1.	Сколько спортивных секций Вы посещаете?',
            'field25' => '24.2.	Продолжительность 1-го занятия (в минутах)',
            'field26' => '24.3.	Сколько дней в неделю вы посещаете спортивные секции?',
            'field27' => '25. Сколько времени Вы тратите в среднем в учебный день на выполнение домашних заданий?',
            'field41' => '28. Легко ли Вы засыпаете?',
            'field42' => '29. Легко ли Вы просыпаетесь?',
            'field43' => '30. Делаете ли Вы ежедневно утреннюю гимнастику?',
            'field44' => '31. Знаете ли вы упражнения для дыхательной гимнастики?',
            'field45' => '32. Делаете ли Вы ежедневно дыхательную гимнастику?',
            'field46' => '33. Знаете ли вы упражнения гимнастики для глаз?',
            'field47' => '34. Делаете ли Вы ежедневно гимнастику для глаз?',
            'field48' => '35. Знаете ли вы упражнения для снятия напряжения мышц спины и шеи?',
            'field49' => '36. Делаете ли Вы ежедневно гимнастику для мышц шеи и спины для снятия статического напряжения мышц?',
            'field94' => '39. Считаете ли Вы свою образовательную нагрузку (занятия в школе и вне школы) слишком большой для Вас? ',
            'field95' => '40. Что на Ваш взгляд, нужно изменить, чтобы она была меньше? - нужно выбрать ОДИН из предложенных вариантов наиболее подходящий',
            'field96' => '41. Занимались ли Вы в 2020-2021 учебном году в дистанционном формате?',
            'field97' => '42. Изменился ли в этот период Ваш обычный режим дня?',
            'field53' => '',
            'field55' => '',
            'field57' => '',
            'field59' => '',


            'field103' => 'школа если казань ',
            'field104' => 'имт цира!',
            'field105' => 'имт значение!',

            //пустые!!!!!
            'field114' => '9.1. Занимаетесь ли Вы спортом?',
            'field115' => 'Field115',
            'field116' => 'Field116',
            'field117' => 'Field117',
            'field118' => 'Field118',
            'field119' => 'Field119',

            'field120' => 'Field120',
            'field121' => 'Field120',
            'field122' => 'Field120',
            'field123' => 'Field120',
            'field124' => 'Field120',
            'field125' => 'Field120',
            'field126' => 'Field120',
            'field127' => 'Field120',
            'field128' => 'Field120',
            'field129' => 'Field120',
            'field130' => 'Field120',
            'creat_at' => 'Creat At',
        ];
    }

    public function get_imt2($heightVal, $massVal, $typeKidsVal, $sexVal, $birthVal, $status)
    {
        if ($heightVal == 0) return '';

        $imt_arrayVal = [
            'Дефицит массы тела',
            'Нормальный вес',
            'Избыточная масса тела',
            'Ожирение'
        ];
        $imt_boys_preschoolers = [
            1 => [14.5, 18.1, 18.5],
            2 => [14.5, 18.1, 18.5],
            3 => [14, 17.5, 17.8],
            4 => [13.9, 17, 17.3],
            5 => [13.8, 16.9, 17.2],
            6 => [13.5, 17, 17.5],
            7 => [13.6, 17.5, 18]
        ];
        $imt_boys_school = [
            6 => [13.5, 17, 17.5],
            7 => [13.6, 17.5, 18],
            8 => [13.8, 18, 18.5],
            9 => [13.9, 18.5, 19.5],
            10 => [14, 19.2, 20.4],
            11 => [14.3, 20, 21.3],
            12 => [14.7, 21, 22.1],
            13 => [15.1, 21.8, 23],
            14 => [15.6, 22.5, 23.9],
            15 => [16.3, 23.5, 24.7],
            16 => [16.9, 24, 25.4],
            17 => [17.3, 25, 26.1],
            18 => [17.9, 25.6, 26.9]
        ];
        $imt_boys_student = [
            17 => [17.3, 25, 26.1],
            18 => [17.9, 25.6, 26.9],
            19 => [18.2, 26.2, 27.8],
            20 => [18.6, 27, 28.4],
            21 => [18.6, 27, 28.4],
            22 => [18.6, 27, 28.4],
            23 => [18.6, 27, 28.4],
            24 => [18.6, 27, 28.4],
            25 => [18.6, 27, 28.4],
            26 => [18.6, 27, 28.4]
        ];
        $imt_boys_else = [
            1 => [14.5, 18.1, 18.5],
            2 => [14.5, 18.1, 18.5],
            3 => [14, 17.5, 17.8],
            4 => [13.9, 17, 17.3],
            5 => [13.8, 16.9, 17.2],
            6 => [13.5, 17, 17.5],
            7 => [13.6, 17.5, 18],
            8 => [13.8, 18, 18.5],
            9 => [13.9, 18.5, 19.5],
            10 => [14, 19.2, 20.4],
            11 => [14.3, 20, 21.3],
            12 => [14.7, 21, 22.1],
            13 => [15.1, 21.8, 23],
            14 => [15.6, 22.5, 23.9],
            15 => [16.3, 23.5, 24.7],
            16 => [16.9, 24, 25.4],
            17 => [17.3, 25, 26.1],
            18 => [17.9, 25.6, 26.9],
            19 => [18.2, 26.2, 27.8],
            20 => [18.6, 27, 28.4],
            21 => [18.6, 27, 28.4],
            22 => [18.6, 27, 28.4],
            23 => [18.6, 27, 28.4],
            24 => [18.6, 27, 28.4],
            25 => [18.6, 27, 28.4],
            26 => [18.6, 27, 28.4]
        ];
        $imt_girls_preschoolers = [
            1 => [14, 18, 18.2],
            2 => [14, 18, 18.2],
            3 => [13.8, 17.2, 17.4],
            4 => [13.5, 16.8, 17.1],
            5 => [13.3, 16.9, 17.2],
            6 => [13.2, 17, 17.3],
            7 => [13.2, 17.9, 18.4]
        ];
        $imt_girls_school = [
            6 => [13.2, 17, 17.3],
            7 => [13.2, 17.9, 18.4],
            8 => [13.2, 18.5, 18.7],
            9 => [13.5, 19, 19.6],
            10 => [13.9, 20, 21],
            11 => [14, 21, 22],
            12 => [14.5, 21.6, 23],
            13 => [15, 22.5, 24],
            14 => [15.5, 23.5, 24.8],
            15 => [16, 24, 25.5],
            16 => [16.5, 24.8, 26],
            17 => [16.9, 25.1, 26.8],
            18 => [17, 25.8, 27.3]
        ];
        $imt_girls_student = [
            17 => [16.9, 25.1, 26.8],
            18 => [17, 25.8, 27.3],
            19 => [17.2, 25.8, 27.8],
            20 => [17.5, 25.5, 28.2],
            21 => [17.5, 25.5, 28.2],
            22 => [17.5, 25.5, 28.2],
            23 => [17.5, 25.5, 28.2],
            24 => [17.5, 25.5, 28.2],
            25 => [17.5, 25.5, 28.2],
            26 => [17.5, 25.5, 28.2]
        ];
        $imt_girls_else = [
            1 => [14, 18, 18.2],
            2 => [14, 18, 18.2],
            3 => [13.8, 17.2, 17.4],
            4 => [13.5, 16.8, 17.1],
            5 => [13.3, 16.9, 17.2],
            6 => [13.2, 17, 17.3],
            7 => [13.2, 17.9, 18.4],
            8 => [13.2, 18.5, 18.7],
            9 => [13.5, 19, 19.6],
            10 => [13.9, 20, 21],
            11 => [14, 21, 22],
            12 => [14.5, 21.6, 23],
            13 => [15, 22.5, 24],
            14 => [15.5, 23.5, 24.8],
            15 => [16, 24, 25.5],
            16 => [16.5, 24.8, 26],
            17 => [16.9, 25.1, 26.8],
            18 => [17, 25.8, 27.3],
            19 => [17.2, 25.8, 27.8],
            20 => [17.5, 25.5, 28.2],
            21 => [17.5, 25.5, 28.2],
            22 => [17.5, 25.5, 28.2],
            23 => [17.5, 25.5, 28.2],
            24 => [17.5, 25.5, 28.2],
            25 => [17.5, 25.5, 28.2],
            26 => [17.5, 25.5, 28.2]
        ];

        $queteletIndexVal = $massVal / (pow($heightVal / 100, 2));


        if ($typeKidsVal == 1)
        {
            if ($sexVal == 0)
            {
                $arrayChild_temp = $imt_boys_preschoolers;
            }
            else $arrayChild_temp = $imt_girls_preschoolers;
        }
        if ($typeKidsVal == 2)
        {
            if ($sexVal == 0)
            {
                $arrayChild_temp = $imt_boys_school;
            }
            else $arrayChild_temp = $imt_girls_school;
        }
        if ($typeKidsVal == 3)
        {
            if ($sexVal == 0)
            {
                $arrayChild_temp = $imt_boys_student;
            }
            else $arrayChild_temp = $imt_girls_student;
        }
        if ($typeKidsVal == 4)
        {
            if ($sexVal == 0)
            {
                $arrayChild_temp = $imt_boys_else;
            }
            else $arrayChild_temp = $imt_girls_else;
        }

        if ($queteletIndexVal<$arrayChild_temp[$birthVal][0]) $arrayChildNum = 0;
        else if ($queteletIndexVal>=$arrayChild_temp[$birthVal][0]&& $queteletIndexVal <= $arrayChild_temp[$birthVal][1]) $arrayChildNum = 1;
        else if ($queteletIndexVal>$arrayChild_temp[$birthVal][1]&& $queteletIndexVal <= $arrayChild_temp[$birthVal][2]) $arrayChildNum = 2;
        else if ($queteletIndexVal>$arrayChild_temp[$birthVal][2]) $arrayChildNum = 3;

        if ($status == 1)
        {
            return $imt_arrayVal[$arrayChildNum];
        }
        if ($status == 2)
        {
            $minRecBodyMass = $arrayChild_temp[$birthVal][0] * (pow($heightVal / 100, 2));
            return round($minRecBodyMass,1);
        }
        if ($status == 3)
        {
            $maxRecBodyMass = $arrayChild_temp[$birthVal][1] * (pow($heightVal / 100, 2));
            return round($maxRecBodyMass,1);
        }
    }
}
