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

    'accepted'             => ':attribute kabul etmeli',
    'active_url'           => ':attribute yasal bir URL olmalıdır',
    'after'                => ':attribute :date den sonraki bir tarih olmalıdır',
    'after_or_equal'       => ':attribute :date den veya aynı tarihten sonra olmalıdır',
    'alpha'                => ':attribute yalnızca harfler içerebilir',
    'alpha_dash'           => ':attribute yalnızca harfler, sayılar, alt çizgiler veya alt çizgiler içerebilir',
    'alpha_num'            => ':attribute yalnızca harf ve sayı içerebilir',
    'array'                => ':attribute bir dizi olmalı',
    'before'               => ':attribute :date den önceki bir tarih olmalıdır',
    'before_or_equal'      => ':attribute :date den önceki veya ac ile aynı bir tarih olmalıdır',
    'between'              => [
        'numeric' => ':attribute :min ile :max arasında olmalıdır',
        'file'    => ':attribute  :min ile :max KB arasında olmalıdır',
        'string'  => ':attribute :min ile :max karakter arasında olmalıdır',
        'array'   => ':attribute :min ile :max madde arasında olmalıdır',
    ],
    'boolean'              => ':attribute karakteri doğru veya yanlış, 1 veya 0 olmalıdır ',
    'confirmed'            => ':attribute ikinci onayı eşleşmiyor',
    'date'                 => ':attribute yasal bir tarih olmalı',
    'date_format'          => ':attribute verilen :format biçimiyle eşleşmiyor',
    'different'            => ':attribute :other den farklı olmalıdır',
    'digits'               => ':attribute :digits basamaklı olmalıdır.',
    'digits_between'       => ':attribute :min ile :max basamak arasında olmalıdır',
    'dimensions'           => ':attribute nin geçersiz bir resim boyutu var',
    'distinct'             => ':attribute alanı yinelenen değerlere sahiptir',
    'email'                => ':attribute yasal bir e-posta adresi olmalıdır',
    'exists'               => 'Seçilen :attribute geçersiz.',
    'file'                 => ':attribute bir dosya olmalı',
    'filled'               => ':attribute alanı gereklidir',
    'image'                => ':attribute jpeg, png, bmp veya gıf formatında bir resim olmalıdır',
    'in'                   => 'Seçilen :attribute geçersiz',
    'in_array'             => ':attribute alanı :other de mevcut değil',
    'integer'              => ':attribute bir tamsayı olmalıdır',
    'ip'                   => ':attribute yasal bir IP adresi olmalıdır.',
    'json'                 => ':attribute yasal bir JSON dizesi olmalıdır',
    'max'                  => [
        'numeric' => ':attribute nin maksimum uzunluğu :max hanedir',
        'file'    => ':attribute nin maksimum boyutu :max dir',
        'string'  => ':attribute nin maksimum uzunluğu :max karakterdir',
        'array'   => ' Maksimum :attribute sayısı :max dir.',
    ],
    'mimes'                => ':attribute dosya türü :values olmalıdır',
    'min'                  => [
        'numeric' => ':attribute nin minimum uzunluğu :min basamaktır',
        'file'    => ":attribute boyutu en az :min kb'dir",
        'string'  => ':attribute nin minimum uzunluğu :min karakterdir',
        'array'   => ':attribute nin en az :min öğesi var',
    ],
    'not_in'               => 'Seçilen :attribute geçersiz',
    'numeric'              => ':attribute bir sayı olmalı',
    'present'              => ':attribute alanı mevcut olmalıdır',
    'regex'                => ':attribute biçimi geçersiz',
    'required'             => ':attribute alanı gereklidir',
    'required_if'          => ':other :value olduğunda :attribute alanı gereklidir',
    'required_unless'      => ':other :values de olmadığı sürece :attribute alanı gereklidir',
    'required_with'        => ':values mevcut olduğunda :attribute alanı gereklidir',
    'required_with_all'    => ':values mevcut olduğunda :attribute alanı gereklidir',
    'required_without'     => ':values olmadığında :attribute alanı gereklidir',
    'required_without_all' => ':values olmadığında :attribute alanı gereklidir',
    'same'                 => ':attribute ve :other eşleşmelidir',
    'size'                 => [
        'numeric' => ':attribute :size basamaklı olmalıdır',
        'file'    => ':attribute :size KB olmalıdır',
        'string'  => ':attribute :size karakter olmalıdır',
        'array'   => ':attribute :size öğe içermelidir',
    ],
    'string'               => ':attribute bir dize olmalı',
    'timezone'             => ':attribute geçerli bir saat dilimi olmalıdır.',
    'unique'               => ':attribute zaten var',
    'url'                  => ':attribute geçersiz biçim',

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
        // 'name'         => 'isim',
        // 'age'         => 'yaş',
    ],

    'otc' => [
        '商家otc挂单不存在' => 'Tüccar otc bekleyen sipariş yok',
        '交易数量不能小于' => 'İşlem sayısı aşağıdakilerden az olamaz:min_number',
        '商家不存在'=>'Tüccar yok',
        '您不能和自己交易'=>'Kendinle ticaret yapamazsın.',
        '商家挂单交易状态异常'=>'Satıcının bekleyen siparişinin işlem durumu anormal',
        '商家挂单可交易数量为空'=>'Satıcının bekleyen emriyle işlenebilecek işlem sayısı boştur',
        '商家挂单可交易数量不足,当前剩余'=>'İşlem yapılabilecek bekleyen tüccar siparişlerinin sayısı yetersizdir ve mevcut kalan',
        '商家发布挂单价格有变化,请刷新后重试'=>'Satıcı tarafından verilen bekleyen siparişin fiyatı değişti, lütfen yenileyin ve tekrar deneyin',
        '请先设置收付款信息'=>'Lütfen önce ödeme bilgilerini ayarlayın',
        '您的收付款信息与商家挂单不匹配,无法交易'=>'Ödeme bilgileriniz satıcının bekleyen siparişiyle eşleşmiyor ve işlem yapılamıyor',
        '您与该商家有交易未完成,请先完成再操作'=>'Satıcı ile bitmemiş bir işleminiz var, lütfen devam etmeden önce tamamlayın',
        '交易数量只能是'=>'İşlem sayısı yalnızca şunlar olabilir',
        '交易数量不能超过'=>'İşlem sayısı aşılamaz:max_number',
    ],

];
