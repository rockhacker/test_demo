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

    'accepted'             => ':attribute يجب قبول',
    'active_url'           => 'يجب أن يكون attribute: عنوان URL قانونيًا',
    'after'                => 'يجب أن يكون attribute: تاريخًا بعد date:',
    'after_or_equal'       => 'يجب أن يكون تاريخ attribute: بعد date: أو نفس التاريخ',
    'alpha'                => 'يمكن أن تحتوي attribute: على أحرف فقط',
    'alpha_dash'           => 'يمكن أن تحتوي attribute: على أحرف أو أرقام أو شرطات سفلية أو شرطات سفلية فقط',
    'alpha_num'            => 'يمكن أن تحتوي attribute: على أحرف وأرقام فقط',
    'array'                => 'يجب أن تكون attribute: عبارة عن صفيف',
    'before'               => 'يجب أن يكون تاريخ attribute: قبل date:',
    'before_or_equal'      => 'يجب أن يكون تاريخ attribute: قبل أو نفس تاريخ date:',
    'between'              => [
        'numeric' => 'يجب أن يكون attribute: بين max: و min:',
        'file'    => 'يجب أن يكون حجم attribute: بين min: و max: كيلوبايت',
        'string'  => 'يجب أن يتراوح عدد أحرف attribute: بين min: و max: حرفًا',
        'array'   => 'يجب أن تكون attribute: بين min: و max:',
    ],
    'boolean'              => 'يجب أن يكون حرف attribute: صحيحًا أو خطأ ، 1 أو 0',
    'confirmed'            => 'تأكيد attribute: الثانوي غير متطابق',
    'date'                 => 'يجب أن يكون attribute: تاريخًا صالحًا',
    'date_format'          => 'لا يتطابق attribute: مع التنسيق المحدد format:',
    'different'            => 'يجب أن تكون attribute: مختلفة عن other:',
    'digits'               => 'يجب أن تتكون attribute: من digits: رقمًا.',
    'digits_between'       => 'يجب أن يكون حجم attribute: بين min: و max: رقمًا',
    'dimensions'           => 'حجم الصورة attribute: غير صالح',
    'distinct'             => 'يحتوي حقل attribute: على قيم مكررة',
    'email'                => 'يجب أن يكون attribute: عنوان بريد إلكتروني قانوني',
    'exists'               => ':attribute المحدد غير صالح.',
    'file'                 => 'يجب أن يكون attribute: ملفًا',
    'filled'               => 'مطلوب حقل attribute:',
    'image'                => 'يجب أن تكون attribute: صورة بتنسيق jpeg أو png أو bmp أو gif',
    'in'                   => ':attribute المحدد غير صالح',
    'in_array'             => 'لا يوجد حقل attribute: في order:',
    'integer'              => 'يجب أن تكون attribute: عددًا صحيحًا',
    'ip'                   => 'يجب أن يكون attribute: عنوان IP قانونيًا',
    'json'                 => 'يجب أن تكون attribute: سلسلة JSON صالحة',
    'max'                  => [
        'numeric' => 'الحد الأقصى لطول attribute: هو max: بت',
        'file'    => 'الحد الأقصى ل attribute: هو max:',
        'string'  => 'الحد الأقصى لطول attribute: هو max: حرفًا',
        'array'   => 'الحد الأقصى لعدد attribute: هو max:.',
    ],
    'mimes'                => 'يجب أن يكون نوع ملف attribute :values:',
    'min'                  => [
        'numeric' => 'الحد الأدنى لطول attribute: هو min: بت',
        'file'    => 'حجم attribute: لا يقل عن min: كيلوبايت',
        'string'  => 'الحد الأدنى لطول attribute: هو min: حرفًا',
        'array'   => 'يحتوي attribute: على min: عنصرًا على الأقل',
    ],
    'not_in'               => ':attribute المحدد غير صالح',
    'numeric'              => 'يجب أن تكون attribute: رقمًا',
    'present'              => 'يجب أن يوجد حقل attribute:',
    'regex'                => 'تنسيق attribute: غير صالح',
    'required'             => 'مطلوب حقل attribute:',
    'required_if'          => 'مطلوب حقل attribute: عندما يكون order: هو value:',
    'required_unless'      => 'مطلوب حقل attribute: ، ما لم يكن order: في values:',
    'required_with'        => 'مطلوب حقل attribute: عند وجود values:',
    'required_with_all'    => 'مطلوب حقل attribute: عند وجود values:',
    'required_without'     => 'مطلوب حقل attribute: في حالة عدم وجود values:',
    'required_without_all' => 'مطلوب حقل attribute: في حالة عدم وجود values:',
    'same'                 => 'يجب أن تتطابق attribute: و order:',
    'size'                 => [
        'numeric' => 'يجب أن يكون attribute :size: بت',
        'file'    => 'يجب أن يكون حجم attribute :size: كيلوبايت',
        'string'  => 'يجب أن يتكون attribute: من size: حرفًا',
        'array'   => 'يجب أن تتضمن attribute :size: عنصرًا',
    ],
    'string'               => 'يجب أن تكون attribute: عبارة عن سلسلة',
    'timezone'             => 'يجب أن تكون attribute: منطقة زمنية صالحة.',
    'unique'               => ':attribute موجود بالفعل',
    'url'                  => ':attribute تنسيق غير صالح',
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'رسالة مخصصة',
        ],
    ],




    'date_equals' => 'يجب أن يكون تاريخ attribute: مساويًا لـ data:.',
    'ends_with' => 'يجب أن تنتهي attribute: بأي مما يلي: values:',
    'gt' => [
        'numeric' => 'يجب أن تكون قيمة attribute: أكبر من value:.',
        'file' => 'يجب أن يكون حجم attribute: أكبر من value: كيلو بايت.',
        'string' => 'يجب أن تكون attribute: أكبر من أحرف value:.',
        'array' => 'يجب أن يحتوي attribute: على أكثر من value: عنصرًا.',
    ],
    'gte' => [
        'numeric' => 'يجب أن تكون attribute: أكبر من أو تساوي value:.',
        'file' => 'يجب أن تكون attribute: أكبر من أو تساوي value: كيلو بايت.',
        'string' => 'يجب أن يكون attribute: أكبر من أو يساوي value: حرفًا.',
        'array' => 'يجب أن تحتوي attribute: على value: عنصرًا أو أكثر.',
    ],
    'ipv4' => 'يجب أن يكون attribute: عنوان IPv4 صالحًا.',
    'ipv6' => 'يجب أن يكون attribute: عنوان IPv6 صالحًا.',
    'lt' => [
        'numeric' => 'يجب أن يكون attribute: أقل من value:.',
        'file' => 'يجب أن يكون حجم attribute: أقل من value: كيلو بايت.',
        'string' => 'يجب ألا يزيد عدد أحرف attribute: عن value: حرفًا.',
        'array' => 'يجب أن تحتوي attribute: على أقل من value: عنصرًا.',
    ],
    'lte' => [
        'numeric' => 'يجب أن تكون attribute: أقل من أو تساوي value:.',
        'file' => 'يجب أن يكون attribute: أقل من أو يساوي value: كيلو بايت.',
        'string' => 'يجب أن يكون attribute: أقل من أو يساوي value: حرفًا.',
        'array' => 'يجب ألا يحتوي attribute: على أكثر من value: عنصرًا.',
    ],

    'mimetypes' => 'يجب أن يكون attribute: ملفًا من النوع: values:',

    'not_regex' => 'تنسيق attribute: غير صالح.',

    'starts_with' => 'يجب أن تبدأ attribute: بأحد الإجراءات التالية: values:',

    'uploaded' => 'فشل تحميل attribute:.',
    'uuid' => 'يجب أن تكون attribute: عبارة عن UUID صالح.',

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
        '商家otc挂单不存在' => 'الأمر المعلق للتاجر غير موجود',
        '交易数量不能小于' => 'لا يمكن أن يكون عدد المعاملات أقل من min_number:',
        '商家不存在' => 'العمل غير موجود',
        '您不能和自己交易' => 'لا يمكنك التجارة مع نفسك',
        '商家挂单交易状态异常' => 'حالة معاملة طلب التاجر المعلق غير طبيعية',
        '商家挂单可交易数量为空'=>'الكمية القابلة للتداول لأمر التاجر المعلق فارغة',
        '商家挂单可交易数量不足,当前剩余'=>'يمكن تداول أمر التاجر المعلق غير كافٍ ، والباقي الحالي',
        '商家发布挂单价格有变化,请刷新后重试'=>'تم تغيير سعر الطلب المعلق الذي نشره التاجر ، يرجى التحديث والمحاولة مرة أخرى',
        '请先设置收付款信息'=>'يرجى ضبط الإيصال ومعلومات الدفع أولاً',
        '您的收付款信息与商家挂单不匹配,无法交易'=>'معلومات الإيصال والدفع لا تتطابق مع طلب التاجر المعلق ولا يمكن تداولها',
        '您与该商家有交易未完成,请先完成再操作'=>'لم تكتمل معاملتك مع هذا التاجر ، يرجى إكمالها قبل التشغيل',
        '交易数量只能是'=>'يمكن أن يكون عدد المعاملات فقط',
        '交易数量不能超过'=>'لا يمكن أن يتجاوز عدد المعاملات max_number:'
    ],

];
