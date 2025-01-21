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

    'accepted'             => ':attribute必须接受',
    'active_url'           => ':attribute必须是一个合法的 URL',
    'after'                => ':attribute 必须是 :date 之后的一个日期',
    'after_or_equal'       => ':attribute 必须是 :date 之后或相同的一个日期',
    'alpha'                => ':attribute只能包含字母',
    'alpha_dash'           => ':attribute只能包含字母、数字、中划线或下划线',
    'alpha_num'            => ':attribute只能包含字母和数字',
    'array'                => ':attribute必须是一个数组',
    'before'               => ':attribute 必须是 :date 之前的一个日期',
    'before_or_equal'      => ':attribute 必须是 :date 之前或相同的一个日期',
    'between'              => [
        'numeric' => ':attribute 必须在 :min 到 :max 之间',
        'file'    => ':attribute 必须在 :min 到 :max KB 之间',
        'string'  => ':attribute 必须在 :min 到 :max 个字符之间',
        'array'   => ':attribute 必须在 :min 到 :max 项之间',
    ],
    'boolean'              => ':attribute字符必须是 true 或false, 1 或 0 ',
    'confirmed'            => ':attribute 二次确认不匹配',
    'date'                 => ':attribute 必须是一个合法的日期',
    'date_format'          => ':attribute 与给定的格式 :format 不符合',
    'different'            => ':attribute 必须不同于 :other',
    'digits'               => ':attribute必须是 :digits 位.',
    'digits_between'       => ':attribute 必须在 :min 和 :max 位之间',
    'dimensions'           => ':attribute具有无效的图片尺寸',
    'distinct'             => ':attribute字段具有重复值',
    'email'                => ':attribute必须是一个合法的电子邮件地址',
    'exists'               => '选定的 :attribute 是无效的.',
    'file'                 => ':attribute必须是一个文件',
    'filled'               => ':attribute的字段是必填的',
    'image'                => ':attribute必须是 jpeg, png, bmp 或者 gif 格式的图片',
    'in'                   => '选定的 :attribute 是无效的',
    'in_array'             => ':attribute 字段不存在于 :other',
    'integer'              => ':attribute 必须是个整数',
    'ip'                   => ':attribute必须是一个合法的 IP 地址。',
    'json'                 => ':attribute必须是一个合法的 JSON 字符串',
    'max'                  => [
        'numeric' => ':attribute 的最大长度为 :max 位',
        'file'    => ':attribute 的最大为 :max',
        'string'  => ':attribute 的最大长度为 :max 字符',
        'array'   => ':attribute 的最大个数为 :max 个.',
    ],
    'mimes'                => ':attribute 的文件类型必须是 :values',
    'min'                  => [
        'numeric' => ':attribute 的最小长度为 :min 位',
        'file'    => ':attribute 大小至少为 :min KB',
        'string'  => ':attribute 的最小长度为 :min 字符',
        'array'   => ':attribute 至少有 :min 项',
    ],
    'not_in'               => '选定的 :attribute 是无效的',
    'numeric'              => ':attribute 必须是数字',
    'present'              => ':attribute 字段必须存在',
    'regex'                => ':attribute 格式是无效的',
    'required'             => ':attribute 字段是必须的',
    'required_if'          => ':attribute 字段是必须的当 :other 是 :value',
    'required_unless'      => ':attribute 字段是必须的，除非 :other 是在 :values 中',
    'required_with'        => ':attribute 字段是必须的当 :values 是存在的',
    'required_with_all'    => ':attribute 字段是必须的当 :values 是存在的',
    'required_without'     => ':attribute 字段是必须的当 :values 是不存在的',
    'required_without_all' => ':attribute 字段是必须的当 没有一个 :values 是存在的',
    'same'                 => ':attribute和:other必须匹配',
    'size'                 => [
        'numeric' => ':attribute 必须是 :size 位',
        'file'    => ':attribute 必须是 :size KB',
        'string'  => ':attribute 必须是 :size 个字符',
        'array'   => ':attribute 必须包括 :size 项',
    ],
    'string'               => ':attribute 必须是一个字符串',
    'timezone'             => ':attribute 必须是个有效的时区.',
    'unique'               => ':attribute 已存在',
    'url'                  => ':attribute 无效的格式',

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

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        // 'name'         => '名字',
        // 'age'         => '年龄',
    ],

    'otc' => [
        '商家otc挂单不存在' => '商家otc掛單不存在',
        '交易数量不能小于' => '交易數量不能小於:min_number',
        '商家不存在'=>'商家不存在',
        '您不能和自己交易'=>'您不能和自己交易',
        '商家挂单交易状态异常'=>'商家掛單交易狀態异常',
        '商家挂单可交易数量为空'=>'商家掛單可交易數量為空',
        '商家挂单可交易数量不足,当前剩余'=>'商家掛單可交易數量不足，當前剩餘',
        '商家发布挂单价格有变化,请刷新后重试'=>'商家發佈掛單價格有變化，請重繪後重試',
        '请先设置收付款信息'=>'請先設定收付款資訊',
        '您的收付款信息与商家挂单不匹配,无法交易'=>'您的收付款資訊與商家掛單不匹配，無法交易',
        '您与该商家有交易未完成,请先完成再操作'=>'您與該商家有交易未完成，請先完成再操作',
        '交易数量只能是'=>'交易數量只能是',
        '交易数量不能超过'=>'交易數量不能超過:max_number',
    ],

];
