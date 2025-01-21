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

    'accepted'             => ':attribute akzeptiert',
    'active_url'           => ':attribute eine legale URL',
    'after'                => ':attribute Datum nach dem :date ',
    'after_or_equal'       => ':attribute Datum nach dem :date oder einem der gleichen Termine sein',
    'alpha'                => ':attribute nur Buchstaben',
    'alpha_dash'           => ':attribute nur Buchstaben, Zahlen, Unterstreichungen oder Unterstriche enthalten',
    'alpha_num'            => ':attribute nur Buchstaben, Zahlen',
    'array'                => ':attribute Array',
    'before'               => ':attribute Datum vor dem :date ',
    'before_or_equal'      => ':attribute Datum vor dem :date oder einem der gleichen Termine sein',
    'between'              => [
        'numeric' => ':attribute zwischen :min und :max ',
        'file'    => ':attribute zwischen :min und :max KB ',
        'string'  => ':attribute zwischen :min und :max Zeichen',
        'array'   => ':attribute zwischen :min und :max Glieder',
    ],
    'boolean'              => ':attribute Zeichen muss true oder false, 1 oder 0 ',
    'confirmed'            => ':attribute Zweite Bestätigung der Fehlanpassung',
    'date'                 => ':attribute legales Datum',
    'date_format'          => ':attribute entspricht nicht dem angegebenen :format ',
    'different'            => ':attribute anders als :other',
    'digits'               => ':attribute :digits Ziffern.',
    'digits_between'       => ':attribute zwischen :min und :max Ziffern',
    'dimensions'           => ':attributeungültige Bildgröße',
    'distinct'             => ':attributedoppelte Werte',
    'email'                => ':attributelegales E-Mail Adresse',
    'exists'               => 'ausgewählte :attribute ist ungültig.',
    'file'                 => ':attribute Dokument',
    'filled'               => ':attribute obligatorisch',
    'image'                => ':attributeim Format jpeg, png, bmp oder gif ',
    'in'                   => 'ausgewählte :attribute ist ungültig',
    'in_array'             => ':attribute Felder existiert nicht in :other',
    'integer'              => ':attribute ganze Zahl',
    'ip'                   => ':attribute legale IP-Adresse',
    'json'                 => ':attribute legale JSON Zeichenkette',
    'max'                  => [
        'numeric' => ':attribute maximale Länge beträgt :max Ziffern',
        'file'    => ':attribute größte ist :max',
        'string'  => ':attribute maximale Länge beträgt :max Zeichen',
        'array'   => ':attribute maximale Anzahl :max .',
    ],
    'mimes'                => ':attribute Dateityp :values',
    'min'                  => [
        'numeric' => ':attribute Mindestlänge beträgt :min Ziffern',
        'file'    => ':attribute mindestens :min KB',
        'string'  => ':attribute minimale Länge :min Zeichen',
        'array'   => ':attribute mindestens :min Glieder',
    ],
    'not_in'               => 'ausgewählte :attribute ist ungültig',
    'numeric'              => ':attribute Zahl',
    'present'              => ':attribute Feld existiert',
    'regex'                => ':attribute Feld ungültig',
    'required'             => ':attribute Feld erforderlich',
    'required_if'          => ':attribute Feld erforderlich, wenn :other ist :value',
    'required_unless'      => ':attribute Feld erforderlich, nur wenn :other ist in :values 中',
    'required_with'        => ':attribute Feld erforderlich, wenn :values existiert',
    'required_with_all'    => ':attribute Feld erforderlich, :values existiert',
    'required_without'     => ':attribute Feld erforderlich, :values nicht existiert',
    'required_without_all' => ':attribute Feld erforderlich, wenn keines der :values existiert',
    'same'                 => ':attributeund:otherübereinstimmen',
    'size'                 => [
        'numeric' => ':attribute :size Ziffern',
        'file'    => ':attribute :size KB',
        'string'  => ':attribute :size Zeichen lang',
        'array'   => ':attribute enthaltet :size Glieder',
    ],
    'string'               => ':attribute Zeichenkette',
    'timezone'             => ':attribute gültige Zeitzone.',
    'unique'               => ':attribute existiert nicht',
    'url'                  => ':attribute ungültiges Format',

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
        // 'name'         => 'Name',
        // 'age'         => 'Alter',
    ],

    'otc' => [
        '商家otc挂单不存在' => 'Ausstehende Otc-Aufträge des Händlers sind nicht vorhanden',
        '交易数量不能小于' => 'Transaktionenanzahl nicht kleiner als:min_number',
        '商家不存在' => 'Händler existiert nicht',
        '您不能和自己交易' => 'Sie können nicht mit sich selbst handeln',
        '商家挂单交易状态异常' => 'Ausnahme für den Transaktionsstatus einer ausstehenden Bestellung des Händlers',
        '商家挂单可交易数量为空'=>'Die Anzahl von Händleraufträgen, die gehandelt werden können, ist leer',
        '商家挂单可交易数量不足,当前剩余'=>'Die Anzahl der für den Handel verfügbaren Händleraufträge ist gering, derzeit verbleiben',
        '商家发布挂单价格有变化,请刷新后重试'=>'Bitte aktualisieren Sie und versuchen Sie es erneut, nachdem der Händler den Preis für die ausstehende Bestellung geändert hat',
        '请先设置收付款信息'=>'Bitte richten Sie zunächst Zahlungs- und Beleginformationen ein',
        '您的收付款信息与商家挂单不匹配,无法交易'=>'Ihre Zahlungs- und Beleginformationen stimmen nicht mit der ausstehenden Bestellung des Händlers überein und können nicht gehandelt werden',
        '您与该商家有交易未完成,请先完成再操作'=>'Sie haben eine offene Transaktion mit diesem Händler, bitte schließen Sie diese zuerst ab, bevor Sie fortfahren',
        '交易数量只能是'=>'Transaktionenanzahl ist nur',
        '交易数量不能超过'=>'Transaktionenanzahl nicht höher als:max_number sein'
    ],

];
