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

    'accepted'             => ':attribute must be accepted',
    'active_url'           => ':attribute must be a legal URL',
    'after'                => ':attribute  must be a date after :date',
    'after_or_equal'       => ':attribute must be a date after or the same as :date',
    'alpha'                => ':attribute can only contain letters',
    'alpha_dash'           => ':attribute can only contain letters, numbers, underscores or underscores',
    'alpha_num'            => ':attribute can only contain letters and numbers',
    'array'                => ':attribute must be an array',
    'before'               => ':attribute must be a date before :date',
    'before_or_equal'      => ':attribute must be a date before or the same as :date',
    'between'              => [
        'numeric' => ':attribute must be between :min and :max',
        'file'    => ':attribute must be between :min and :max KB',
        'string'  => ':attribute must be between :min and :max characters',
        'array'   => ':attribute must be between :min and :max',
    ],
    'boolean'              => ':attribute character must be true or false, 1 or 0 ',
    'confirmed'            => ':attribute secondary confirmation does not match',
    'date'                 => ':attribute must be a valid date',
    'date_format'          => ':attribute does not match the given format :format',
    'different'            => ':attribute must be different from :other',
    'digits'               => ':attribute must be :digits digits.',
    'digits_between'       => ':attribute must be between :min and :max digits',
    'dimensions'           => ':attribute has invalid picture size',
    'distinct'             => ':attribute field has duplicate values',
    'email'                => ':attribute must be a legal email address',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => ':attribute must be a file',
    'filled'               => ':attribute field is required',
    'image'                => ':attribute must be an image in jpeg, png, bmp or gif format',
    'in'                   => 'The selected :attribute is invalid',
    'in_array'             => ':attribute field does not exist in :other',
    'integer'              => ':attribute must be an integer',
    'ip'                   => ':attribute must be a legal IP address',
    'json'                 => ':attribute must be a valid JSON string',
    'max'                  => [
        'numeric' => 'The maximum length of:attribute is :max bits',
        'file'    => 'The maximum of:attribute is :max',
        'string'  => 'The maximum length of:attribute is :max characters',
        'array'   => 'The maximum number of :attribute is :max.',
    ],
    'mimes'                => ':attribute file type must be :values',
    'min'                  => [
        'numeric' => 'The minimum length of:attribute is :min bits',
        'file'    => ':attribute size is at least :min KB',
        'string'  => 'The minimum length of:attribute is :min characters',
        'array'   => ':attribute has at least :min items',
    ],
    'not_in'               => 'The selected :attribute is invalid',
    'numeric'              => ':attribute must be a number',
    'present'              => ':attribute field must exist',
    'regex'                => ':attribute format is invalid',
    'required'             => ':attribute field is required',
    'required_if'          => ':attribute field is required when :other is :value',
    'required_unless'      => ':attribute field is required, unless :other is in :values',
    'required_with'        => ':attribute field is required when :values is present',
    'required_with_all'    => ':attribute field is required when :values is present',
    'required_without'     => ':attribute field is required when :values does not exist',
    'required_without_all' => 'The :attribute field is required when none of the :values exist',
    'same'                 => ':attribute and :other must match',
    'size'                 => [
        'numeric' => ':attribute must be :size bits',
        'file'    => ':attribute must be :size KB',
        'string'  => ':attribute must be :size characters',
        'array'   => ':attribute must include :size items',
    ],
    'string'               => ':attribute must be a string',
    'timezone'             => ':attribute must be a valid time zone.',
    'unique'               => ':attribute already exists',
    'url'                  => ':attribute invalid format',
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],




    'date_equals' => 'The :attribute must be a date equal to :date.',
    'ends_with' => 'The :attribute must end with one of the following: :values',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],

    'mimetypes' => 'The :attribute must be a file of type: :values.',

    'not_regex' => 'The :attribute format is invalid.',

    'starts_with' => 'The :attribute must start with one of the following: :values',

    'uploaded' => 'The :attribute failed to upload.',
    'uuid' => 'The :attribute must be a valid UUID.',

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
        '商家otc挂单不存在' => 'Merchant otc pending order does not exist',
        '交易数量不能小于' => 'The number of transactions cannot be less than :min_number',
        '商家不存在' => 'Business does not exist',
        '您不能和自己交易' => 'You cannot trade with yourself',
        '商家挂单交易状态异常' => 'Merchant pending order transaction status is abnormal',
        '商家挂单可交易数量为空'=>'The tradable quantity of the merchant\'s pending order is empty',
        '商家挂单可交易数量不足,当前剩余'=>'The merchant\'s pending order can be traded is insufficient, the current remaining',
        '商家发布挂单价格有变化,请刷新后重试'=>'The price of the pending order posted by the merchant has changed, please refresh and try again',
        '请先设置收付款信息'=>'Please set the receipt and payment information first',
        '您的收付款信息与商家挂单不匹配,无法交易'=>'Your receipt and payment information does not match the merchant\'s pending order and cannot be traded',
        '您与该商家有交易未完成,请先完成再操作'=>'Your transaction with this merchant has not been completed, please complete before operating',
        '交易数量只能是'=>'the number of transactions can only be',
        '交易数量不能超过'=>'The number of transactions cannot exceed :max_number'
    ],

];
