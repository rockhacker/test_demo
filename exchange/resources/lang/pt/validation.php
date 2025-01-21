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
			
     'accepted'             => ':attribute Deve aceitar',			
     'active_url'           => ':attribute Deve ser um URL jurídico',			
     'after'                => ':attribute Deve ser uma data após :data',			
     'after_or_equal'       => ':attribute Deve ser uma data após :data ou a mesma data',			
     'alpha'                => ':attribute Só pode conter cartas',			
     'alpha_dash'           => ':attribute Só pode conter letras, números, traços ou sublinhados',			
     'alpha_num'            => ':attribute Só pode conter letras e números',			
     'array'                => ':attribute Deve ser uma matriz',			
     'before'               => ':attribute Deve ser uma data antes :data',			
     'before_or_equal'      => ':attribute Deve ser uma data antes ou a mesma que :data',			
    'between'              => [			
        'numeric' => ':attribute Deve ser entre :min e :max',			
        'file'    => ':attribute Deve ser entre :min e :max KB',			
        'string'  => ':attribute Deve ser entre :min e :max caracteres',			
        'array'   => ':attribute  Deve ser entre :min e :max itens',			
     ],			
     'boolean'              => ':attribute O caráter deve ser true ou false, 1 ou 0',			
     'confirmed'            => ':attribute  A confirmação secundária não corresponde',			
     'date'                 => ':attribute Deve ser uma data jurídico',			
     'date_format'          => ':attribute  Não corresponde ao formato dado :format',			
     'different'            => ':attribute Deve ser diferente de :other',			
     'digits'               => ':attribute Deve ser :digits .',			
     'digits_between'       => ':attribute Deve ser entre :min e :max bits',			
     'dimensions'           => ':attribute Tem uma imagem de tamanho inválido',			
     'distinct'             => ':attribute O campo tem valores duplicados',			
     'email'                => ':attribute Deve ser um endereço de e-mail jurídico',			
     'exists'               => 'O selecionado :attribute é inválido.',			
     'file'                 => ':attribute Deve ser um arquivo',			
     'filled'               => ':attribute os campos são obrigatórios',			
     'image'                => ':attribute Deve ser imagem em formato jpeg, png, bmp ou gif',			
     'in'                   => 'O selecionado :attribute é inválido',			
     'in_array'             => ':attribute Campo não existe em :other',			
     'integer'              => ':attribute Deve ser um número inteiro',			
     'ip'                   => ':attribute Deve ser um endereço IP jurídico',			
     'json'                 => ':attribute Deve ser uma sequência jurídico do JSON',			
    'max'                  => [			
        'numeric' => ':attribute Tem um comprimento máximo é :max bits',			
        'file'    => ':attribute Tem máximo é :max',			
        'string'  => ':attribute Tem um comprimento máximo é :max caracteres',			
        'array'   => ':attribute O número máximo é :max 个.',			
     ],			
     'mimes'                => ':attribute O tipo de arquivo deve ser :values',			
     'min'                  => [			
        'numeric' => ':attribute O comprimento mínimo é :min bits',			
        'file'    => ':attribute Tem um tamanho de pelo menos :min KB',			
        'string'  => ':attribute Tem um comprimento mínimo é :min caracteres',			
        'array'   => ':attribute Tem pelo menos :min itens',			
     ],			
     'not_in'               => 'O selecionado :attribute é inválido',			
     'numeric'              => ':attribute Deve ser número',			
     'present'              => ':attribute Campo deve existir',			
     'regex'                => ':attribute O formato é inválido',			
     'required'             => ':attribute Campo é obrigatório',			
     'required_if'          => ':attribute Campo é obrigatório quando :other é :value',			
     'required_unless'      => ':attribute Campo é obrigatório，a menos que :other é entre :values ',			
     'required_with'        => ':attribute Campo é obrigatório quando :values existe',			
     'required_with_all'    => ':attribute Campo é obrigatório quando :values existe',			
     'required_without'     => ':attribute Campo é obrigatório quando :values não existe',			
     'required_without_all' => ':attribute Campo é obrigatório quando nenhum :values existe',			
     'same'                 => ':attribute e :other deve corresponder',			
    'size'                 => [			
        'numeric' => ':attribute Deve ser :size bits',			
        'file'    => ':attribute Deve ser :size KB',			
        'string'  => ':attribute Deve ser :size caracteres',			
        'array'   => ':attribute  Deve incluir :size item ',			
     ],			
     'string'               => ':attribute Deve ser uma sequência',			
     'timezone'             => ':attribute Deve ser um fuso horário válido.',			
     'unique'               => ':attribute Já existe',			
     'url'                  => ':attribute Formato inválido',			
			
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
        // 'age'         => 'Idade',			
     ],			
			
    'otc' => [			
        '商家otc挂单不存在' => 'A ordem pendente de otc do comerciante não existe',			
        '交易数量不能小于' => 'O número de transações não pode ser menor que: min_number',			
        '商家不存在'=>'O comerciante não existe',			
        '您不能和自己交易'=>'Você não pode negociar com você mesmo',			
        '商家挂单交易状态异常'=>'O status da ordem pendente do comerciante é anormal',			
        '商家挂单可交易数量为空'=>'A ordem pendente do comerciante está vazio',			
        '商家挂单可交易数量不足,当前剩余'=>'O número de ordens disponíveis não é suficiente, atualmente o restante é',			
        '商家发布挂单价格有变化,请刷新后重试'=>'Comerciante postou uma mudança de preço, por favor, atualize e tente novamente',			
        '请先设置收付款信息'=>'Por favor, configure primeiro as informações de pagamento e recebimento',			
        '您的收付款信息与商家挂单不匹配,无法交易'=>'Suas informações de pagamento não correspondem à ordem do comerciante e não podem ser negociadas',			
        '您与该商家有交易未完成,请先完成再操作'=>'Você tem uma transação inacabada com este comerciante, conclua-a antes de continuar',			
        '交易数量只能是'=>'O número de transações só pode ser',			
        '交易数量不能超过'=>'O número de transações não pode exceder: max_number',			
     ],			
			
];			
