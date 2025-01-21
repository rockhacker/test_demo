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

    'accepted'             => ":attribute il faut accepter",
    'active_url'           => ":attribute il faut être égal URL",
    'after'                => ":attribute il faut être :date date après",
    'after_or_equal'       => ":attribute il faut être :date une date même ou similaire",
    'alpha'                => ":attribute comprend seulement des lettres",
    'alpha_dash'           => ":attribute comprend seulement lettre, numéros, tiret au milieu, tiret bas",
    'alpha_num'            => ":attribute comprend seulement des lettres et numéros",
    'array'                => ":attribute il faut être une équipe de nombre",
    'before'               => ":attribute il faut être :date une date avant",
    'before_or_equal'      => ":attribute il faut être :date date une date même ou similaire",
    'between'              => [
        'numeric' => ":attribute il faut être dans :min entre :max ",
        'file'    => ":attribute il faut être dans :min entre :max KB ",
        'string'  => ":attribute il faut être dans :min entre :max des lettres",
        'array'   => ":attribute il faut être dans :min entre :max",
    ],
    'boolean'              => ":attribute des lettres devront être true 或false, 1 或 0 ",
    'confirmed'            => ":attribute ces deux confirmation ne correspondent pas ",
    'date'                 => ":attribute  il faut être une date égal",
    'date_format'          => ":attribute  modèle précisé :format ne correspond pas ",
    'different'            => ":attribute il faut être différent de :other",
    'digits'               => ":attribute il faut être  :digits numéro.",
    'digits_between'       => ":attribute il faut être  dans :entre min et :max ",
    'dimensions'           => ":attribute  dimensions de photos invalide",
    'distinct'             => ":attribute il existe des numéros même",
    'email'                => ":attribute il faut être un adresse valide de émail",
    'exists'               => "choisi :attribute invalide.",
    'file'                 => ":attribute il faut être un document",
    'filled'               => ":attribute ces lettres, il faut remplir",
    'image'                => ":attribute il faut être des photos en jpeg, png, bmp ougif",
    'in'                   => "choisi :attribute invalide",
    'in_array'             => ":attribute ces lettres n’existent pas :other",
    'integer'              => ":attribute il faut être une lettre entier",
    'ip'                   => ":attribute il faut être un adresse IP égal",
    'json'                 => ":attribute il faut être chaîne de JSON  caractère égal",
    'max'                  => [
        'numeric' => ":attribute longueur maximum est :max ",
        'file'    => ":attribute maximum est :max",
        'string'  => ":attribute longueur maximum est :max léttres",
        'array'   => ":attribute maximum est :max unité.",
    ],
    'mimes'                => ":attribute le genre de document doit être :values",
    'min'                  => [
        'numeric' => ":attribute longueur minimum est :min ",
        'file'    => ":attribute taille est au moins :min KB",
        'string'  => ":attribute longueur minimum est :min lettres",
        'array'   => ":attribute avoir au moins :min terme",
    ],
    'not_in'               => "choisi :attribute invalide",
    'numeric'              => ":attribute il faut être des numeros",
    'present'              => ":attribute code doit exister",
    'regex'                => ":attribute formule est invalide",
    'required'             => ":attribute code est obligatoire",
    'required_if'          => ":attribute code est obligatoire quand:other est :value",
    'required_unless'      => ":attribute code est obligatoire，sinon :other est :values 中",
    'required_with'        => ":attribute code est obligatoire quand:values existe",
    'required_with_all'    => ":attribute code est obligatoire quand :values existe",
    'required_without'     => ":attribute code est obligatoire quand:values n’existe pas",
    'required_without_all' => ":attribute code est obligatoire quand il n’y pas  :values existe",
    'same'                 => ":attribute et:other doit se correspondre",
    'size'                 => [
        'numeric' => ":attribute il faut être :size unité",
        'file'    => ":attribute il faut être :size KB",
        'string'  => ":attribute il faut être :size lettres",
        'array'   => ":attribute il faut comprend :size termes",
    ],
    'string'               => ":attribute il faut être chaine de caractères",
    'timezone'             => ":attribute il faut être un fuseau horaire valide.",
    'unique'               => ":attribute existe",
    'url'                  => ":attribute formule invalide",

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
            'rule-name' => "custom-message",
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
        // 'name'         => ‘nom et prénom",
        // 'age'         => ‘age",
    ],

    'otc' => [
        '商家otc挂单不存在' => " la commande d’ordre otc de commerçant n’existe pas",
        '交易数量不能小于' => "nombre de marché ne peut pas inférieur à:min_number",
        '商家不存在' => "commerçant n’existe pas",
        '您不能和自己交易' => "vous ne pouvez pas faire le marché avec vous même",
        '商家挂单交易状态异常' => "l’état anormal de commande d’ordre ",
        '商家挂单可交易数量为空'=>"nombre de commande d’ordre disponibles est vide",
        '商家挂单可交易数量不足,当前剩余'=>"nombre de commande d’ordre disponibles est insuffisant,le solde à présent est ",
        '商家发布挂单价格有变化,请刷新后重试'=>"il y’a un changement de prix de commande d’ordre publié par commerçant, veillez ressayer après renouvellement",
        '请先设置收付款信息'=>"veillez établir des informations de payer et recevoir de liquide",
        '您的收付款信息与商家挂单不匹配,无法交易'=>"votre informations de payer et recevoir de liquide ne correspond à la commande d’ordre, impossible de passer le marché ",
        '您与该商家有交易未完成,请先完成再操作'=>"votre marché avec commerçant n’a pas été fini, veillez le terminer et opérer",
        '交易数量只能是'=>"le nombre de marché doit être seulement",
        '交易数量不能超过'=>'le nombre de marché ne peut pas dépasser:max_number'
    ],

];
