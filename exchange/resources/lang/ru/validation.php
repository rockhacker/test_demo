<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute должен быть принят',
    'active_url'           => ':attribute должен быть законным URL-адресом',
    'after'                => ':attribute должно быть датой после :date',
    'after_or_equal'       => ':attribute должен быть датой после или совпадать с :date',
    'alpha'                => ':attribute может содержать только буквы',
    'alpha_dash'           => ':attribute может содержать только буквы, цифры, подчеркивания',
    'alpha_num'            => ':attribute может содержать только буквы и цифры',
    'array'                => ':attribute должен быть массивом',
    'before'               => ':attribute должна быть датой до :date',
    'before_or_equal'      => ':attribute должен быть датой до или совпадать с :date',
    'between'              => [
        'numeric' => ':attribute должно быть от :min до :max',
        'file'    => 'Размер :attribute должен составлять от :min до :max КБ',
        'string'  => ':attribute должен содержать от :min до :max символов',
        'array'   => ':attribute должен быть между :min и :max',
    ],
    'boolean'              => ':attribute Символ ZXC должен быть true или false, 1 или 0 ',
    'confirmed'            => 'Вторичное подтверждение :attribute не соответствует',
    'date'                 => ':attribute должна быть действительной датой',
    'date_format'          => ':attribute не соответствует заданному формату :format',
    'different'            => ':attribute должен отличаться от :other',
    'digits'               => ':attribute должен состоять из :digits цифр.',
    'digits_between'       => ':attribute должен содержать от :min до :max цифр',
    'dimensions'           => ':attribute имеет недопустимый размер изображения',
    'distinct'             => 'Поле :attribute имеет повторяющиеся значения',
    'email'                => ':attribute должен быть законным адресом электронной почты',
    'exists'               => 'Выбранный :attribute недействителен.',
    'file'                 => ':attribute должен быть файлом',
    'filled'               => 'Поле :attribute обязательно для заполнения',
    'image'                => ':attribute должно быть изображением в формате jpeg, png, bmp или gif',
    'in'                   => 'Выбранный :attribute недействителен',
    'in_array'             => 'Поле :attribute не существует в :other',
    'integer'              => ':attribute должно быть целым числом',
    'ip'                   => ':attribute должен быть законным IP-адресом',
    'json'                 => ':attribute должен быть допустимой строкой JSON',
    'max'                  => [
        'numeric' => 'Максимальная длина :attribute составляет :max бита',
        'file'    => 'Максимальное значение :attribute составляет :max',
        'string'  => 'Максимальная длина :attribute составляет :max символа',
        'array'   => 'Максимальное количество :attribute равно :max.',
    ],
    'mimes'                => 'Тип файла :attribute должен быть :values',
    'min'                  => [
        'numeric' => 'Минимальная длина :attribute составляет :min бита',
        'file'    => ' Размер :attribute составляет не менее :min КБ',
        'string'  => 'Минимальная длина :attribute составляет :min символа',
        'array'   => 'В :attribute есть как минимум :min элемента',
    ],
    'not_in'               => 'Выбранный :attribute недействителен',
    'numeric'              => ':attribute должно быть числом',
    'present'              => 'Поле :attribute должно существовать',
    'regex'                => 'Формат :attribute недопустим',
    'required'             => 'Поле :attribute обязательно для заполнения',
    'required_if'          => 'Поле :attribute является обязательным, если :other равно :value',
    'required_unless'      => 'Поле :attribute является обязательным, если только :other не находится в :values',
    'required_with'        => 'Поле :attribute является обязательным, если присутствует :values',
    'required_with_all'    => 'Поле :attribute является обязательным, если присутствует :values',
    'required_without'     => 'Поле :attribute является обязательным, если :values не существует',
    'required_without_all' => 'Поле :attribute является обязательным, если ни один из :values не существует',
    'same'                 => ':attribute и :other должны совпадать',
    'size'                 => [
        'numeric' => ':attribute должен быть :size битным',
        'file'    => ':attribute должен быть размером :size КБ',
        'string'  => ':attribute должен состоять из :size символов',
        'array'   => ':attribute должен включать :size элемента',
    ],
    'string'               => ':attribute должен быть строкой',
    'timezone'             => ':attribute должен быть действительным часовым поясом.',
    'unique'               => ':attribute уже существует',
    'url'                  => 'Недопустимый формат :attribute',
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],




    'date_equals' => ':attribute должен быть датой, равной :date.',
    'ends_with' => ':attribute должен заканчиваться одним из следующих: :values',
    'gt' => [
        'numeric' => ':attribute должен быть больше :value.',
        'file' => 'Размер :attribute должен превышать :value килобайта.',
        'string' => ':attribute должен содержать более :value символов.',
        'array' => 'В :attribute должно быть более :value элементов.',
    ],
    'gte' => [
        'numeric' => ':attribute должен быть больше или равен :value.',
        'file' => ':attribute должен быть больше или равен :value килобайтам.',
        'string' => ':attribute должен быть больше или равен :value символам.',
        'array' => 'В :attribute должно быть :value элемента или более.',
    ],
    'ipv4' => ':attribute должен быть действительным IPv4-адресом.',
    'ipv6' => ':attribute должен быть действительным IPv6-адресом.',
    'lt' => [
        'numeric' => ':attribute должен быть меньше :value.',
        'file' => ':attribute должен быть меньше :value килобайт.',
        'string' => ':attribute должен содержать менее :value символов.',
        'array' => 'В :attribute должно быть менее :value элементов.',
    ],
    'lte' => [
        'numeric' => ':attribute должен быть меньше или равен :value.',
        'file' => 'Размер :attribute должен быть меньше или равен :value килобайтам.',
        'string' => ':attribute должен быть меньше или равен :value символам.',
        'array' => 'В :attribute не должно быть более :value элементов.',
    ],

    'mimetypes' => ':attribute должен быть файлом типа: :values.',

    'not_regex' => 'Формат :attribute недопустим.',

    'starts_with' => ':attribute должен начинаться с одного из следующих: :values',

    'uploaded' => ':attribute не удалось загрузить.',
    'uuid' => ':attribute должен быть действительным UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

    'otc' => [
        '商家otc挂单不存在' => 'Внебиржевой отложенный ордер продавца не существует',
        '交易数量不能小于' => 'Количество транзакций не может быть меньше :min_number',
        '商家不存在' => 'Бизнеса не существует',
        '您不能和自己交易' => 'Вы не можете торговать с самим собой',
        '商家挂单交易状态异常' => 'Статус транзакции с отложенным ордером продавца является ненормальным',
        '商家挂单可交易数量为空'=>'Торгуемое количество отложенного ордера продавца пусто',
        '商家挂单可交易数量不足,当前剩余'=>'Отложенный ордер продавца, которым можно торговать, недостаточен, текущий оставшийся',
        '商家发布挂单价格有变化,请刷新后重试'=>'Цена отложенного ордера, размещенного продавцом, изменилась, пожалуйста, обновите и повторите попытку',
        '请先设置收付款信息'=>'Пожалуйста, сначала укажите информацию о квитанции и оплате',
        '您的收付款信息与商家挂单不匹配,无法交易'=>'Ваша квитанция и платежная информация не соответствуют отложенному заказу продавца и не могут быть проданы',
        '您与该商家有交易未完成,请先完成再操作'=>'Ваша транзакция с этим продавцом не была завершена, пожалуйста, завершите ее перед началом работы',
        '交易数量只能是'=>'количество транзакций может быть только',
        '交易数量不能超过'=>'Количество транзакций не может превышать :max_number'
    ],

];
