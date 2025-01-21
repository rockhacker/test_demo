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

    'accepted'             => ':attribute accettazione obbligatorio',
    'active_url'           => ':attribute deve essere legale URL',
    'after'                => ':attribute deve essere obbligatoriamente :date dopo la data',
    'after_or_equal'       => ':attribute deve essere obbligatoriamente :date dopo la data o la stessa data',
    'alpha'                => ':attribute può includere esclusivamente le lettere',
    'alpha_dash'           => ':attribute può includere solo lettere, numeri,Linea mediana o sottolineatura',
    'alpha_num'            => ':attributepuò includere solo lettere e numeri',
    'array'                => ':attribute deve essere un array',
    'before'               => ':attribute deve essere :date la data precedente',
    'before_or_equal'      => ':attribute deve essere  :date dopo la data o la stessa data',
    'between'              => [
        'numeric' => ':attribute deve essere :min fino :max in mezzo',
        'file'    => ':attribute deve essere :min fino :max KB in mezzo',
        'string'  => ':attribute deve essere :min fino :max in mezzo le caratteristiche',
        'array'   => ':attribute deve essere :min fino :max in mezzo',
    ],
    'boolean'              => ':attribute la caratteristica deve essere true o false, 1 o 0 ',
    'confirmed'            => ':attribute la seconda confermazione non corrisponde',
    'date'                 => ':attribute deve essere una data legale',
    'date_format'          => ':attribute con formato dato :format non corrispondente',
    'different'            => ':attribute deve essere differente :other',
    'digits'               => ':attribute deve essere :digits .',
    'digits_between'       => ':attribute deve essere :min e :max in mezzo',
    'dimensions'           => ":attribute dotato di una dimensione dell'immagine non valida",
    'distinct'             => ':attribute campo ha valori ripetuti',
    'email'                => ':attribute deve essere un indirizzo email legale',
    'exists'               => 'Scelto :attribute non è valido.',
    'file'                 => ':attribute deve essere un documento',
    'filled'               => ':attribute campo è obbligatorio',
    'image'                => ':attributedeve essere jpeg, png, bmp oppure gif formato di immagini',
    'in'                   => 'Scelto :attribute non è valido',
    'in_array'             => ':attribute campo non esistente in :other',
    'integer'              => ':attribute deve essere un numero intero',
    'ip'                   => ':attribute deve essere un indirizzo IP legale',
    'json'                 => ':attribute deve essere di carattere JSON legale',
    'max'                  => [
        'numeric' => ':attribute lunghezza massima :max posti',
        'file'    => ':attribute più grande è :max',
        'string'  => ':attribute lunghezza più grande :max caratteri',
        'array'   => ':attribute numero massimo :max ',
    ],
    'mimes'                => ':attribute documento deve essere di :values',
    'min'                  => [
        'numeric' => ':attribute lunghezza minima è di :min ',
        'file'    => ':attribute minima di :min KB',
        'string'  => ':attribute lunghezza minima è :min caratteri',
        'array'   => ':attribute minimo di :min ',
    ],
    'not_in'               => 'Scelto :attribute non è valido',
    'numeric'              => ':attribute deve essere di numeri',
    'present'              => ':attribute il campo attributo è obbligatorio',
    'regex'                => ':attribute formato non è valido',
    'required'             => ':attribute campo è obbligatorio',
    'required_if'          => ':attribute campo è obbligatorio :other è :value',
    'required_unless'      => ':attribute campo è obbligatorio，almenoché :other 是在 :values 中',
    'required_with'        => ':attribute campo è obbligatorio :values è esistente',
    'required_with_all'    => ':attribute campo è obbligatorio :values è esistente',
    'required_without'     => ':attribute campo è obbligatorio :values non è esitente',
    'required_without_all' => ":attribute campo è obbligatorio, non c'e uno :values è esistente",
    'same'                 => ':attribute和:other deve abbinare ',
    'size'                 => [
        'numeric' => ':attribute deve essere :size posti',
        'file'    => ':attribute deve essere :size KB',
        'string'  => ':attribute deve essere :size caratteri',
        'array'   => ':attribute deve includere :size ',
    ],
    'string'               => ':attribute deve essere di una stringa',
    'timezone'             => ':attribute deve essere di un orario e luogo valido.',
    'unique'               => ':attribute già esistente',
    'url'                  => ':attribute formato non valido',

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
        // 'name'         => 'Nome',
        // 'age'         => 'età',
    ],

    'otc' => [
        '商家otc挂单不存在' => "L'ordine sospeso del venditore otc non esistente",
        '交易数量不能小于' => 'Quantità di transazione non può essere inferiore i:min_number',
        '商家不存在' => 'Venditore non esistente',
        '您不能和自己交易' => 'Non puoi negoziare con te stessa',
        '商家挂单交易状态异常' => "Transazione dell'ordine sospeso del venditore è in stato anormale",
        '商家挂单可交易数量为空'=>"Quantità negoziabile dell'ordine sospeso del venditore è vuota",
        '商家挂单可交易数量不足,当前剩余'=>"L'ordine sospeso del venditore da nagoziare insufficiente, attuamente rimane",
        '商家发布挂单价格有变化,请刷新后重试'=>"Cambiamento del prezzo d'ordine sospeso del venditore, si prega di aggiornare e riprovare più tardi",
        '请先设置收付款信息'=>'Si prega di impostare prima le informazioni di pagamento',
        '您的收付款信息与商家挂单不匹配,无法交易'=>"I tuoi informazioni di pagamento non corrispondono all'ordine sospeso del venditore,impossibile negoziare",
        '您与该商家有交易未完成,请先完成再操作'=>'Hai una transazione da completare con venditore, si prega di operare dopo aver completato',
        '交易数量只能是'=>'Quantità della transazione può essere solo',
        '交易数量不能超过'=>'Quantità transazione non può superare :max_number'
    ],

];
