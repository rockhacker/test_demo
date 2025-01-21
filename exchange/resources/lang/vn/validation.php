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

    'accepted'             => ':attribute phải được chấp nhận',
    'active_url'           => ':attribute phải là một URL hợp pháp',
    'after'                => ':attribute phải là một ngày sau :date',
    'after_or_equal'       => ':attribute phải là ngày sau hoặc trùng với ngày :date',
    'alpha'                => ':attribute chỉ có thể chứa các chữ cái',
    'alpha_dash'           => ':attribute chỉ có thể chứa các chữ cái, số, dấu gạch dưới hoặc dấu gạch dưới',
    'alpha_num'            => ':attribute chỉ có thể chứa các chữ cái và số',
    'array'                => ':attribute phải là một mảng',
    'before'               => ':attribute phải là một ngày trước :date',
    'before_or_equal'      => ':attribute phải là một ngày trước hoặc giống với :date',
    'between'              => [
        'numeric' => ':attribute phải từ :min đến :max',
        'file'    => ':attribute phải từ :min đến :max',
        'string'  => ':attribute phải từ :min đến :max ký tự',
        'array'   => ':attribute phải từ :min đến :max',
    ],
    'boolean'              => 'Ký tự :attribute phải đúng hoặc sai, 1 hoặc 0',
    'confirmed'            => 'Xác nhận phụ :attribute không khớp',
    'date'                 => ':attribute phải là một ngày hợp lệ',
    'date_format'          => ':attribute không khớp với định dạng đã cho :format',
    'different'            => ':attribute phải khác với :other',
    'digits'               => ':attribute phải có :digits chữ số.',
    'digits_between'       => ':attribute phải có từ :min đến :max chữ số',
    'dimensions'           => ':attribute có kích thước hình ảnh không hợp lệ',
    'distinct'             => 'Trường :attribute có các giá trị trùng lặp',
    'email'                => ':attribute phải là địa chỉ email hợp pháp',
    'exists'               => ':attribute đã chọn không hợp lệ.',
    'file'                 => ':attribute phải là một tệp',
    'filled'               => 'Trường :attribute là bắt buộc',
    'image'                => ':attribute phải là hình ảnh ở định dạng jpeg, png, bmp hoặc gif',
    'in'                   => ':attribute đã chọn không hợp lệ',
    'in_array'             => 'Trường :attribute không tồn tại trong năm :other',
    'integer'              => ':attribute phải là một số nguyên',
    'ip'                   => ':attribute phải là địa chỉ IP hợp pháp',
    'json'                 => ':attribute phải là một chuỗi JSON hợp lệ',
    'max'                  => [
        'numeric' => 'Độ dài tối đa của :attribute là :max bit',
        'file'    => 'Mức tối đa của :attribute là :max',
        'string'  => 'Độ dài tối đa của :attribute là :max ký tự',
        'array'   => 'Số lượng :attribute tối đa là :max.',
    ],
    'mimes'                => 'Loại tệp :attribute phải là :values',
    'min'                  => [
        'numeric' => 'Độ dài tối thiểu của :attribute là :min bit',
        'file'    => 'Kích thước :attribute tối thiểu :min KB',
        'string'  => 'Độ dài tối thiểu của :attribute là :min ký tự',
        'array'   => ':attribute có ít nhất :min mặt hàng',
    ],
    'not_in'               => ':attribute đã chọn không hợp lệ',
    'numeric'              => ':attribute phải là một số',
    'present'              => 'Trường :attribute phải tồn tại',
    'regex'                => 'Định dạng :attribute không hợp lệ',
    'required'             => 'Trường :attribute là bắt buộc',
    'required_if'          => 'Trường :attribute là bắt buộc khi :other là :value ',
    'required_unless'      => 'Trường :attribute là bắt buộc, trừ khi :other nằm trong :values',
    'required_with'        => 'Trường :attribute là bắt buộc khi có :values',
    'required_with_all'    => 'Trường :attribute là bắt buộc khi có :values',
    'required_without'     => 'Trường :attribute là bắt buộc khi :values không tồn tại',
    'required_without_all' => 'Trường :attribute là bắt buộc khi không có :values nào tồn tại',
    'same'                 => ':attribute và :other phải khớp',
    'size'                 => [
        'numeric' => ':attribute phải là :size bit',
        'file'    => ':attribute phải là :size KB',
        'string'  => ':attribute phải có :size ký tự',
        'array'   => ':attribute phải bao gồm :size mặt hàng',
    ],
    'string'               => ':attributephải là một chuỗi',
    'timezone'             => ':attribute phải là múi giờ hợp lệ.',
    'unique'               => ':attribute đã tồn tại',
    'url'                  => ':attribute định dạng không hợp lệ',
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'thông báo tùy chỉnh',
        ],
    ],




    'date_equals' => ':attribute phải là ngày bằng :date.',
    'ends_with' => ':attribute phải kết thúc bằng một trong những điều sau :values',
    'gt' => [
        'numeric' => ':attribute phải lớn hơn :value.',
        'file' => ':attribute phải lớn hơn :value kilobyte.',
        'string' => ':attribute phải lớn hơn :value ký tự.',
        'array' => ':attribute phải có hơn :value mục.',
    ],
    'gte' => [
        'numeric' => ':attribute phải lớn hơn hoặc bằng :value.',
        'file' => ':attribute phải lớn hơn hoặc bằng :value kilobyte.',
        'string' => ':attribute phải lớn hơn hoặc bằng :value ký tự.',
        'array' => ' :attribute phải có :value mục trở lên.',
    ],
    'ipv4' => ':attribute phải là địa chỉ IPv4 hợp lệ.',
    'ipv6' => ':attribute phải là địa chỉ IPv6 hợp lệ.',
    'lt' => [
        'numeric' => ':attribute phải nhỏ hơn :value.',
        'file' => ':attribute phải nhỏ hơn :value kilobyte.',
        'string' => ':attribute phải ít hơn :value ký tự.',
        'array' => ':attribute phải có ít hơn :value mục.',
    ],
    'lte' => [
        'numeric' => ':attribute phải nhỏ hơn hoặc bằng :value.',
        'file' => ':attribute phải nhỏ hơn hoặc bằng :value kilobyte.',
        'string' => 'Chữ :attribute phải nhỏ hơn hoặc bằng :value ký tự.',
        'array' => ':attribute không được có nhiều hơn :value mục.',
    ],

    'mimetypes' => ':attribute phải là tệp thuộc loại::values.',

    'not_regex' => 'Định dạng :attribute không hợp lệ.',

    'starts_with' => 'Chữ :attribute phải bắt đầu bằng một trong những điều sau::values',

    'uploaded' => ':attribute không tải lên được.',
    'uuid' => ':attribute phải là một UUID hợp lệ.',

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
        '商家otc挂单不存在' => 'Đơn đặt hàng đang chờ xử lý trên otc của người bán không tồn tại',
        '交易数量不能小于' => 'Số lượng giao dịch không được ít hơn :min_number',
        '商家不存在' => 'Doanh nghiệp không tồn tại',
        '您不能和自己交易' => 'Bạn không thể giao dịch với chính mình',
        '商家挂单交易状态异常' => 'Trạng thái giao dịch đơn đặt hàng đang chờ xử lý của người bán là bất thường',
        '商家挂单可交易数量为空'=>'Số lượng có thể giao dịch của đơn đặt hàng đang chờ xử lý của người bán trống',
        '商家挂单可交易数量不足,当前剩余'=>'Đơn đặt hàng đang chờ xử lý của người bán có thể được giao dịch không đủ, số tiền hiện tại còn lại',
        '商家发布挂单价格有变化,请刷新后重试'=>'Giá của đơn đặt hàng đang chờ xử lý do người bán đăng đã thay đổi, vui lòng làm mới và thử lại',
        '请先设置收付款信息'=>'Vui lòng đặt thông tin nhận và thanh toán trước',
        '您的收付款信息与商家挂单不匹配,无法交易'=>'Thông tin nhận và thanh toán của bạn không khớp với đơn đặt hàng đang chờ xử lý của người bán và không thể giao dịch',
        '您与该商家有交易未完成,请先完成再操作'=>'Giao dịch của bạn với người bán này chưa được hoàn tất, vui lòng hoàn tất trước khi hoạt động',
        '交易数量只能是'=>'số lượng giao dịch chỉ có thể là',
        '交易数量不能超过'=>'Số lượng giao dịch không được vượt quá :max_number'
    ],

];
