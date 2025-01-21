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

    'accepted'             => ':attribute가 허용되어야합니다.',
    'active_url'           => ':attribute는 합법적 인 URL이어야합니다.',
    'after'                => ':attribute는 :data 이후의 날짜 여야합니다.',
    'after_or_equal'       => ':attribute는 :data 이후 또는 같은 날짜 여야합니다.',
    'alpha'                => ':attribute는 문자 만 포함 할 수 있습니다.',
    'alpha_dash'           => ':attribute는 문자, 숫자, 밑줄 또는 밑줄 만 포함 할 수 있습니다.',
    'alpha_num'            => ':attribute는 문자와 숫자 만 포함 할 수 있습니다.',
    'array'                => ':attribute는 배열이어야합니다.',
    'before'               => ':attribute는 :data 이전 날짜 여야합니다.',
    'before_or_equal'      => ':attribute는 :data 같거나 이전 날짜 여야합니다.',
    'between'              => [
        'numeric' => ':attribute는 :min과 :max 사이 여야합니다.',
        'file'    => ':attribute는 :minKB에서 :maxKB 사이 여야합니다.',
        'string'  => ':attribute는 :min ~ :max 자 여야합니다.',
        'array'   => ':attribute는 :min과 :max 사이 여야합니다.',
    ],
    'boolean'              => ':attribute 문자는 참 또는 거짓, 1 또는 0이어야합니다.',
    'confirmed'            => ':attribute 보조 확인이 일치하지 않습니다.',
    'date'                 => ':attribute는 유효한 날짜 여야합니다.',
    'date_format'          => ':attribute가 주어진 형식 :format과 일치하지 않습니다.',
    'different'            => ':attribute는 :other와 달라야합니다. ',
    'digits'               => ':attribute는 :digits 자리 여야합니다.',
    'digits_between'       => ':attribute는 :min 자리에서 :max 자리 사이 여야합니다.',
    'dimensions'           => ':attribute에 잘못된 사진 크기가 있습니다.',
    'distinct'             => ':attribute 필드에 중복 된 값이 있습니다.',
    'email'                => ':attribute는 법적 이메일 주소 여야합니다.',
    'exists'               => '선택한 :attribute가 잘못되었습니다.',
    'file'                 => ':attribute는 파일이어야합니다.',
    'filled'               => ':attribute 필드는 필수입니다.',
    'image'                => ':attribute는 jpeg, png, bmp 또는 gif 형식의 이미지 여야합니다.',
    'in'                   => '선택한 :attribute가 잘못되었습니다.',
    'in_array'             => ':attribute 필드는 :order에 존재하지 않습니다.',
    'integer'              => ':attribute는 정수 여야합니다.',
    'ip'                   => ':attribute는 합법적 인 IP 주소 여야합니다.',
    'json'                 => ':attribute는 유효한 JSON 문자열이어야합니다.',
    'max'                  => [
        'numeric' => ':attribute의 최대 길이는 :max 비트입니다.',
        'file'    => ':attribute의 최대 값은 :max입니다.',
        'string'  => 'attribute의 최대 길이는 :max 자입니다.',
        'array'   => ':attribute의 최대 수는 :max입니다.',
    ],
    'mimes'                => ':attribute파일 형식은 :values이어야합니다.',
    'min'                  => [
        'numeric' => ':attribute의 최소 길이는 :min 비트입니다.',
        'file'    => ':attribute 크기는 최소 :minKB입니다.',
        'string'  => ':attribute의 최소 길이는 :min 자입니다.',
        'array'   => ':attribute에는 최소 :min 개의 항목이 있습니다.',
    ],
    'not_in'               => '선택한 :attribute가 잘못되었습니다.',
    'numeric'              => ':attribute는 숫자 여야합니다.',
    'present'              => ':attribute  필드가 있어야합니다.',
    'regex'                => ':attribute 형식이 잘못되었습니다.',
    'required'             => ':attribute 필드는 필수입니다.',
    'required_if'          => ':other가 :value 인 경우 :attribute 필드가 필요합니다.',
    'required_unless'      => ':other이 :values에없는 경우 :attribute 필드는 필수입니다.',
    'required_with'        => ':values이있는 경우 :attribute 필드가 필요합니다.',
    'required_with_all'    => ':values이있는 경우 :attribute 필드가 필요합니다.',
    'required_without'     => ':attribute 필드는 :values이 존재하지 않을 때 필요합니다.',
    'required_without_all' => ':values이없는 경우 :attribute 필드가 필요합니다.',
    'same'                 => ':attribute와 :other은 일치해야합니다.',
    'size'                 => [
        'numeric' => ':attribute는 :size 비트 여야합니다.',
        'file'    => ':attributee는 :sizeKB 여야합니다.',
        'string'  => ':attribute는 :size 자 여야합니다.',
        'array'   => ':attribute에는 :size 개의 항목이 포함되어야합니다.',
    ],
    'string'               => ':attribute는 문자열이어야합니다.',
    'timezone'             => ':attribute는 유효한 시간대 여야합니다.',
    'unique'               => ':attribute가 이미 있습니다.',
    'url'                  => ':attribute 잘못된 형식',
    'custom' => [
        'attribute-name' => [
                'rule-name' => '맞춤 메시지',
        ],
    ],




    'date_equals' => ':attribute는 :date과 같은 날짜 여야합니다.',
    'ends_with' => ':attribute는 다음 중 하나로 끝나야합니다. ::values',
    'gt' => [
        'numeric' => ':attribute는 :value보다 커야합니다.',
        'file' => ':attribute는 :valueKB보다 커야합니다.',
        'string' => ':attribute는 :value 자 이상이어야합니다.',
        'array' => ':attribute에는 :value 개 이상의 항목이 있어야합니다.',
    ],
    'gte' => [
        'numeric' => ':attribute는 :value 이상이어야합니다.',
        'file' => ':attribute는 :valueKB 이상이어야합니다.',
        'string' => ':attribute는 :value 자 이상이어야합니다.',
        'array' => ':attribute에는 :value 개 이상의 항목이 있어야합니다.',
    ],
    'ipv4' => ':attribute 은 유효한 IPv4 주소 여야합니다.',
    'ipv6' => ':attribute 은 유효한 IPv6 주소 여야합니다.',
    'lt' => [
        'numeric' => ':attribute는 :value보다 작아야합니다.',
        'file' => ':attribute는 :valueKB 미만이어야합니다.',
        'string' => ':attribute는 :value 자 미만이어야합니다.',
        'array' => ':attribute에는 :value 개 미만의 항목이 있어야합니다.',
    ],
    'lte' => [
        'numeric' => ':attribute는 :value보다 작거나 같아야합니다.',
        'file' => ':attribute는 :valueKB 이하 여야합니다.',
        'string' => ':attribute는 :value 자 이하 여야합니다.',
        'array' => ':attribute에는 항목이 :value 개를 초과 할 수 없습니다.',
    ],

    'mimetypes' => ':attribute는 :values 유형의 파일이어야합니다.',

    'not_regex' => ':attribute 형식이 잘못되었습니다.',

    'starts_with' => ':attribute는 다음 중 하나로 시작해야합니다. :values',

    'uploaded' => ':attribute가 업로드에 실패했습니다.',
    'uuid' => ':attribute는 유효한 UUID 여야합니다.',

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
        '商家otc挂单不存在' => '판매자 OTC 보류중인 주문이 없습니다.',
        '交易数量不能小于' => '거래 수는 :min_number 개 미만일 수 없습니다.',
        '商家不存在' => '비즈니스가 존재하지 않습니다',
        '您不能和自己交易' => '자신과 거래 할 수 없습니다.',
        '商家挂单交易状态异常' => '판매자 보류 주문 거래 상태가 비정상입니다.',
        '商家挂单可交易数量为空'=>'판매자의 보류중인 주문의 거래 가능한 수량이 비어 있습니다.',
        '商家挂单可交易数量不足,当前剩余'=>'가맹점의 보류중인 주문이 충분하지 않고 현재 남아있는 주문이 거래 될 수 있습니다.',
        '商家发布挂单价格有变化,请刷新后重试'=>'판매자가 게시 한 보류중인 주문의 가격이 변경되었습니다. 새로 고침하고 다시 시도하세요.',
        '请先设置收付款信息'=>'먼저 영수증 및 결제 정보를 설정하세요.',
        '您的收付款信息与商家挂单不匹配,无法交易'=>'영수증 및 결제 정보가 판매자의 보류중인 주문과 일치하지 않아 거래 할 수 없습니다.',
        '您与该商家有交易未完成,请先完成再操作'=>'이 판매자와의 거래가 완료되지 않았습니다. 운영하기 전에 완료하세요.',
        '交易数量只能是'=>'거래 수는',
        '交易数量不能超过'=>'거래 수는 다음을 초과 할 수 없습니다:max_number'
    ],

];
