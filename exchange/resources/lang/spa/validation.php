<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Líneas de idioma de validación
    |--------------------------------------------------------------------------
    |
    | Las siguientes líneas de idioma contienen los mensajes de error predeterminados utilizados por
    | la clase de validador. Algunas de estas reglas tienen varias versiones, como
    | como las reglas de tamaño. Siéntase libre de modificar cada uno de estos mensajes aquí.
    |
    */

    'accepted'             => ':attribute debe ser aceptado',
    'active_url'           => ':attribute debe ser una URL legal',
    'after'                => ':attribute  debe ser una fecha posterior :date',
    'after_or_equal'       => ':attribute debe ser una fecha posterior o igual a la :date',
    'alpha'                => ':attribute solo puede contener letras',
    'alpha_dash'           => ':attribute solo puede contener letras, números, guiones bajos o guiones bajos',
    'alpha_num'            => ':attribute solo puede contener letras y números',
    'array'                => ':attribute debe ser una matriz',
    'before'               => ':attribute debe ser una fecha antes :date',
    'before_or_equal'      => ':attribute debe ser una fecha anterior o igual a la :date',
    'between'              => [
        'numeric' => ':attribute debe estar entre :min y :max',
        'file'    => ':attribute debe estar entre :min y :max KB',
        'string'  => ':attribute debe estar entre :min y :max caracteres',
        'array'   => ':attribute debe estar entre :min y :max',
    ],
    'boolean'              => ':attribute el carácter debe ser verdadero o falso, 1 o 0 ',
    'confirmed'            => ':attribute la confirmación secundaria no coincide',
    'date'                 => ':attribute Debe ser una fecha válida',
    'date_format'          => ':attribute no coincide con el formato dado :format',
    'different'            => ':attribute debe ser diferente de :other',
    'digits'               => ':attribute debe ser :digits dígitos.',
    'digits_between'       => ':attribute debe estar entre :min y :max dígitos',
    'dimensions'           => ':attribute tiene un tamaño de imagen no válido',
    'distinct'             => ':attribute el campo tiene valores duplicados',
    'email'                => ':attribute debe ser una dirección de correo electrónico legal',
    'exists'               => 'El seleccionado :attribute Es invalido.',
    'file'                 => ':attribute debe ser un archivo',
    'filled'               => ':attribute Se requiere campo',
    'image'                => ':attribute debe ser una imagen en formato jpeg, png, bmp o gif',
    'in'                   => 'El seleccionado :attribute Es invalido',
    'in_array'             => ':attribute el campo no existe en :other',
    'integer'              => ':attribute debe ser un entero',
    'ip'                   => ':attribute debe ser una dirección IP legal',
    'json'                 => ':attribute debe ser una cadena JSON válida',
    'max'                  => [
        'numeric' => 'La longitud máxima de: atributo es :max bits',
        'file'    => 'El máximo de: atributo es :max',
        'string'  => 'El número máximo de: atributo es :max caracteres',
        'array'   => 'El número máximo de:attribute es :max.',
    ],
    'mimes'                => ':attribute el tipo de archivo debe ser :values',
    'min'                  => [
        'numeric' => 'La longitud mínima de: atributo es :min bits',
        'file'    => ':attribute el tamaño es al menos :min KB',
        'string'  => 'La longitud mínima de: atributo es :min caracteres',
        'array'   => ':attribute tiene al menos :min elementos',
    ],
    'not_in'               => 'El seleccionado :attribute Es invalido',
    'numeric'              => ':attribute Tiene que ser un número',
    'present'              => ':attribute el campo debe existir',
    'regex'                => ':attribute el formato no es válido',
    'required'             => ':attribute Se requiere campo',
    'required_if'          => ':attribute el campo es obligatorio cuando :other es :value',
    'required_unless'      => ':attribute el campo es obligatorio, a menos que :other es en :values',
    'required_with'        => ':attribute el campo es obligatorio cuando :values está presente',
    'required_with_all'    => ':attribute el campo es obligatorio cuando :values está presente',
    'required_without'     => ':attribute el campo es obligatorio cuando :values no existe',
    'required_without_all' => 'El :attribute El campo es obligatorio cuando ninguno de los :values existe',
    'same'                 => ':attribute y :other debe coincidir con',
    'size'                 => [
        'numeric' => ':attribute debe ser :size bits',
        'file'    => ':attribute debe ser :size KB',
        'string'  => ':attribute debe ser :size caracteres',
        'array'   => ':attribute debe incluir :size elementos',
    ],
    'string'               => ':attribute debe ser una cuerda',
    'timezone'             => ':attribute debe ser una zona horaria válida.',
    'unique'               => ':attribute ya existe',
    'url'                  => ':attribute formato inválido',
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'mensaje personalizado',
        ],
    ],




    'date_equals' => 'El :attribute debe ser una fecha igual a :date.',
    'ends_with' => 'El :attribute debe terminar con uno de los siguientes: :values',
    'gt' => [
        'numeric' => 'El :attribute debe ser mayor que :value.',
        'file' => 'El :attribute debe ser mayor que :value kilobytes.',
        'string' => 'El :attribute must be greater than :value caracteres.',
        'array' => 'El :attribute debe tener más de :value elementos.',
    ],
    'gte' => [
        'numeric' => 'El :attribute debe ser mayor o igual que :value.',
        'file' => 'El :attribute debe ser mayor o igual que :value kilobytes.',
        'string' => 'El :attribute debe ser mayor o igual que :value caracteres.',
        'array' => 'El :attribute debe tener :value artículos o más.',
    ],
    'ipv4' => 'El :attribute debe ser una dirección IPv4 válida.',
    'ipv6' => 'El :attribute debe ser una dirección IPv6 válida.',
    'lt' => [
        'numeric' => 'El :attribute debe ser menor que :value.',
        'file' => 'El :attribute debe ser menor que :value kilobytes.',
        'string' => 'El :attribute debe ser menor que :value caracteres.',
        'array' => 'El :attribute debe tener menos de :value elementos.',
    ],
    'lte' => [
        'numeric' => 'El :attribute debe ser menor o igual que :value.',
        'file' => 'El :attribute debe ser menor o igual que :value kilobytes.',
        'string' => 'El :attribute debe ser menor o igual que :value caracteres.',
        'array' => 'El :attribute no debe tener más de :value elementos.',
    ],

    'mimetypes' => 'El :attribute debe ser un archivo de tipo: :values.',

    'not_regex' => 'El :attribute el formato no es válido.',

    'starts_with' => 'El :attribute debe comenzar con uno de los siguientes: :values',

    'uploaded' => 'El :attribute no se pudo cargar.',
    'uuid' => 'El :attribute debe ser un UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Líneas de idioma de validación personalizadas
    |--------------------------------------------------------------------------
    |
    | Aquí puede especificar mensajes de validación personalizados para atributos utilizando el
    | convención "attribute.rule" para nombrar las líneas. Esto hace que sea rápido
    | especificar una línea de idioma personalizada específica para una regla de atributo determinada.
    |
    */


    /*
    |--------------------------------------------------------------------------
    | Atributos de validación personalizados
    |--------------------------------------------------------------------------
    |
    | Las siguientes líneas de idioma se utilizan para intercambiar nuestro marcador de posición de atributo
    | con algo más fácil de leer, como "Dirección de correo electrónico" en su lugar
    | de "correo electrónico". Esto simplemente nos ayuda a hacer que nuestro mensaje sea más expresivo.
    |
    */

    'attributes' => [],

    'otc' => [
        '商家otc挂单不存在' => 'El pedido pendiente de otc del comerciante no existe',
        '交易数量不能小于' => 'El número de transacciones no puede ser menor que :min_number',
        '商家不存在' => 'El negocio no existe',
        '您不能和自己交易' => 'No puedes comerciar contigo mismo',
        '商家挂单交易状态异常' => 'El estado de la transacción del pedido pendiente del comerciante es anormal',
        '商家挂单可交易数量为空'=>'La cantidad negociable de la orden pendiente del comerciante está vacía',
        '商家挂单可交易数量不足,当前剩余'=>'La orden pendiente del comerciante que se puede negociar es insuficiente, la actual restante',
        '商家发布挂单价格有变化,请刷新后重试'=>'El precio del pedido pendiente publicado por el comerciante ha cambiado, actualice e intente nuevamente',
        '请先设置收付款信息'=>'Primero, configure la información de recibo y pago',
        '您的收付款信息与商家挂单不匹配,无法交易'=>'Su recibo y la información de pago no coinciden con el pedido pendiente del comerciante y no se pueden intercambiar.',
        '您与该商家有交易未完成,请先完成再操作'=>'Su transacción con este comerciante no se ha completado, complete antes de operar',
        '交易数量只能是'=>'el número de transacciones solo puede ser',
        '交易数量不能超过'=>'El número de transacciones no puede exceder :max_number'
    ],

];
