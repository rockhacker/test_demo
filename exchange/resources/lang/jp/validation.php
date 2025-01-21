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
    'accepted'             => ':attributeアクセプトしなければなりません',
    'active_url'           => ':attribute有効なURL必要があります',
    'after'                => ':attribute :dateの次の日付でなければなりません',
    'after_or_equal'       => ':attribute :dateの次の日付または同じ日付でなければなりません',
    'alpha'                => ':attribute 文字のみを含めることができます',
    'alpha_dash'           => ':attribute 文字、数字、アンダースコア、またはアンダースコアのみを含めることができます',
    'alpha_num'            => ':attribute 文字と数字のみを含めることができます',
    'array'                => ':attribute アレイでなければなりません',
    'before'               => ':attribute :dateの前の日付でなければなりません',
    'before_or_equal'      => ':attribute :dateの前の日付または同じ日付でなければなりません',
    'between'              => [
        'numeric' => ':attribute :minから:maxまでの間でなければなりません',
        'file'    => ':attribute :minKBから:maxKBの間でなければなりません',
        'string'  => ':attribute :min文字から:max文字の間でなければなりません',
        'array'   => ':attribute :min項番から:max項番の間でなければなりません',
    ],
    'boolean'              => ':attributeキャラクターはtrueまたはfalse、1または0でなければなりません ',
    'confirmed'            => ':attribute 二回目の確認が不一致です',
    'date'                 => ':attribute 合法的な日付でなければなりません',
    'date_format'          => ':attribute 許可するフォーマット:formatと一致しません',
    'different'            => ':attribute :otherとは違うものでなければならない',
    'digits'               => ':attribute :digits桁でなければならない.',
    'digits_between'       => ':attribute :min桁から:max桁の間でなければなりません',
    'dimensions'           => ':attribute 無効な画像サイズです',
    'distinct'             => ':attributeフィールドには重複値があります',
    'email'                => ':attribute有効なメールアドレスでなければなりません',
    'exists'               => '選択した:attribute は無効.',
    'file'                 => ':attributeはファイルでなければなりません',
    'filled'               => ':attributeのフィールドは入力必須です',
    'image'                => ':attributeの拡張子はjpeg、png、bmpまたはgifでなければなりません',
    'in'                   => '選択した :attribute は無効',
    'in_array'             => ':attributeフィールドは:otherに存在しません',
    'integer'              => ':attributeは整数でなければなりません',
    'ip'                   => ':attributeは有効なIPアドレスでなければならない。',
    'json'                 => ':attributeは有効なJSON文字列でなければなりません',
    'max'                  => [
        'numeric' => ':attribute 長さの最大値は :max 桁',
        'file'    => ':attribute サイズの最大値は:max',
        'string'  => ':attribute 長さの最大値は :max 文字',
        'array'   => ':attribute 項数の最大値は :max　項.',
    ],
    'mimes'                => ':attribute ファイルタイプは :valuesでなければなりません',
    'min'                  => [
        'numeric' => ':attribute 長さの最小値は :min 桁',
        'file'    => ':attribute サイズの最小値は :min KB',
        'string'  => ':attribute 長さの最小値は:min 文字',
        'array'   => ':attribute 項数の最小値は :min 項',
    ],


    'not_in'               => '選択した :attribute は無効',
    'numeric'              => ':attribute は数字でなければならない',
    'present'              => ':attribute フィールドは存在しなければならない',
    'regex'                => ':attribute フォーマットは無効です',
    'required'             => ':attribute フィールドは必須です',
    'required_if'          => ':otherが:valueである場合、:attribute フィールドは必須です',
    'required_unless'      => ':valuesに:otherが含まれている場合以外、:attribute フィールドは必須です',
    'required_with'        => ':valuesが存在する場合、:attributeフィールドは必須です',
    'required_with_all'    => ':valuesが存在する場合、:attributeフィールドは必須です',
    'required_without'     => ':valuesが存在しない場合、:attributeフィールドは必須です',
    'required_without_all' => ':valuesが1つも存在しない場合、:attributeフィールドは必須です',
    'same'                 => ':attributeと:otherは必ずマッチします',
    'size'                 => [
        'numeric' => ':attribute :size 桁でなければならない',
        'file'    => ':attribute :size KBでなければならない',
        'string'  => ':attribute :size つ文字でなければならない',
        'array'   => ':attribute :size 項が含まれている必要があります',
    ],
    'string'               => ':attribute は文字列でなければなりません',
    'timezone'             => ':attribute 有効なタイムゾーンでなければならない.',
    'unique'               => ':attribute は既に存在します',
    'url'                  => ':attribute は無効なフォーマットです',

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
        '商家otc挂单不存在' => '売り手の指値注文が存在しません',
        '交易数量不能小于' => '取引数量は:min_number以下にしてはいけません',
        '商家不存在' => '売り手は存在しません',
        '您不能和自己交易' => '自分と取引することはできません',
        '商家挂单交易状态异常' => '売り手の指値注文取引の状態は異常です',
        '商家挂单可交易数量为空'=>'売り手の指値注文に取引できる数量がない',
        '商家挂单可交易数量不足,当前剩余'=>'売り手の指値注文に取引できる数量が足りなくて,現在残っている数は',
        '商家发布挂单价格有变化,请刷新后重试'=>'売り手は発行した指値注文の価格に変化があります。更新してもう一度試してください。',
        '请先设置收付款信息'=>'先に出入金の情報を設定してください',
        '您的收付款信息与商家挂单不匹配,无法交易'=>'出入金の情報は売り手の指値注文と一致せず、取引できません',
        '您与该商家有交易未完成,请先完成再操作'=>'この売り手との取引が未完了で、先に完了してから操作してください',
        '交易数量只能是'=>'取引の数量はだけです',
        '交易数量不能超过'=>'取引数量は:max_numberを超えてはいけません'
    ],
];
