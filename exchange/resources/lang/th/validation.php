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

    'accepted'             => 'ต้องยอมรับ:attribute',
    'active_url'           => ':attribute ต้องเป็น URL ที่ถูกกฎหมาย',
    'after'                => ':attribute ต้องเป็นวันที่หลังจาก :date',
    'after_or_equal'       => ':attribute ต้องเป็นวันที่หลังจากหรือตรงกับ :date',
    'alpha'                => ':attribute มีได้เฉพาะตัวอักษร',
    'alpha_dash'           => ':attribute สามารถประกอบด้วยตัวอักษรตัวเลขขีดล่างหรือขีดล่างเท่านั้น',
    'alpha_num'            => ':attribute สามารถประกอบด้วยตัวอักษรและตัวเลขเท่านั้น',
    'array'                => ':attribute ต้องเป็นอาร์เรย์',
    'before'               => ':attribute ต้องเป็นวันที่ก่อน :date',
    'before_or_equal'      => ':attribute ต้องเป็นวันที่ก่อนหน้าหรือตรงกับ :date',
    'between'              => [
        'numeric' => ':attribute ต้องอยู่ระหว่าง :min และ :max',
        'file'    => ':attribute ต้องอยู่ระหว่าง :min และ :max KB',
        'string'  => ':attribute ต้องอยู่ระหว่าง :min ถึง :max อักขระ',
        'array'   => ':attribute ต้องอยู่ระหว่าง :min ถึง :max',
    ],
    'boolean'              => 'อักขระ :attribute ต้องเป็นจริงหรือเท็จ 1 หรือ 0',
    'confirmed'            => 'การยืนยันรอง :attribute ไม่ตรงกัน',
    'date'                 => ':attribute ต้องเป็นวันที่ที่ถูกต้อง',
    'date_format'          => ':attribute ไม่ตรงกับรูปแบบที่กำหนด :format',
    'different'            => ':attribute ต้องแตกต่างจาก :other',
    'digits'               => ':attribute ต้องเป็น :digits หลัก',
    'digits_between'       => ':attribute ต้องอยู่ระหว่าง :min ถึง :max หลัก',
    'dimensions'           => ':attribute มีขนาดภาพที่ไม่ถูกต้อง',
    'distinct'             => 'ฟิลด์ :attribute มีค่าที่ซ้ำกัน',
    'email'                => ':attribute ต้องเป็นที่อยู่อีเมลตามกฎหมาย',
    'exists'               => ':attribute ที่เลือกไม่ถูกต้อง',
    'file'                 => ':attribute ต้องเป็นไฟล์',
    'filled'               => 'ต้องระบุฟิลด์ :attribute',
    'image'                => ':attribute ต้องเป็นรูปภาพในรูปแบบ jpeg, png, bmp หรือ gif',
    'in'                   => ':attribute ที่เลือกไม่ถูกต้อง',
    'in_array'             => 'ไม่มีช่อง :attribute ใน :other',
    'integer'              => ':attribute ต้องเป็นจำนวนเต็ม',
    'ip'                   => ':attribute ต้องเป็นที่อยู่ IP ตามกฎหมาย',
    'json'                 => ':attribute ต้องเป็นสตริง JSON ที่ถูกต้อง',
    'max'                  => [
        'numeric' => 'ความยาวสูงสุดของ :attribute คือ :max บิต',
        'file'    => ':attribute สูงสุดคือ :max',
        'string'  => 'ความยาวสูงสุดของ :attribute คือ :max อักขระ',
        'array'   => 'จำนวนสูงสุด :attribute คือ :max',
    ],
    'mimes'                => 'ประเภทไฟล์ :attribute ต้องเป็น :values',
    'min'                  => [
        'numeric' => 'ความยาวขั้นต่ำของ :attribute คือ :min บิต',
        'file'    => 'ขนาด :attribute อย่างน้อย :min KB',
        'string'  => 'ความยาวขั้นต่ำของ :attribute คือ :min อักขระ',
        'array'   => ':attribute มีอย่างน้อย :min รายการ',
    ],
    'not_in'               => ':attribute ที่เลือกไม่ถูกต้อง',
    'numeric'              => ':attribute ต้องเป็นตัวเลข',
    'present'              => 'ต้องมีช่อง :attribute',
    'regex'                => 'รูปแบบ :attribute ไม่ถูกต้อง',
    'required'             => 'ต้องระบุฟิลด์ :attribute',
    'required_if'          => 'ต้องระบุฟิลด์ :attribute เมื่อ :other คือ :value',
    'required_unless'      => 'ต้องระบุฟิลด์ :attribute เว้นแต่ :other จะอยู่ใน :values',
    'required_with'        => 'ต้องระบุฟิลด์ :attribute เมื่อมี :values',
    'required_with_all'    => 'ต้องระบุฟิลด์ :attribute เมื่อมี :values',
    'required_without'     => 'ต้องระบุฟิลด์ :attribute เมื่อไม่มี :values',
    'required_without_all' => 'ต้องระบุฟิลด์ :attribute เมื่อไม่มี :values อยู่',
    'same'                 => ':attribute และ :other ต้องตรงกัน',
    'size'                 => [
        'numeric' => ':attribute ต้องเป็น :size บิต',
        'file'    => ':attribute ต้องมีขนาด :size KB',
        'string'  => ':attribute ต้องเป็น :size อักขระ',
        'array'   => ':attribute ต้องมี :size รายการ',
    ],
    'string'               => ':attribute ต้องเป็นสตริง',
    'timezone'             => ':attribute ต้องเป็นเขตเวลาที่ถูกต้อง',
    'unique'               => ':attribute มีอยู่แล้ว',
    'url'                  => ':attribute รูปแบบไม่ถูกต้อง',
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'ข้อความที่กำหนดเอง',
        ],
    ],




    'date_equals' => ':attribute ต้องเป็นวันที่เท่ากับ :date',
    'ends_with' => ':attribute ต้องลงท้ายด้วยข้อใดข้อหนึ่งต่อไปนี้::values',
    'gt' => [
        'numeric' => ':attribute ต้องมากกว่า :value',
        'file' => ':attribute ต้องมากกว่า :value กิโลไบต์',
        'string' => ':attribute ต้องมากกว่า :value อักขระ',
        'array' => ':attribute ต้องมีมากกว่า :value รายการ',
    ],
    'gte' => [
        'numeric' => ':attribute ต้องมากกว่าหรือเท่ากับ :value',
        'file' => ':attribute ต้องมากกว่าหรือเท่ากับ :value กิโลไบต์',
        'string' => ':attribute ต้องมากกว่าหรือเท่ากับ :value อักขระ',
        'array' => ':attribute ต้องมี :value รายการขึ้นไป',
    ],
    'ipv4' => ':attribute ต้องเป็นที่อยู่ IPv4 ที่ถูกต้อง',
    'ipv6' => ':attribute ต้องเป็นที่อยู่ IPv6 ที่ถูกต้อง',
    'lt' => [
        'numeric' => ':attribute ต้องน้อยกว่า :value',
        'file' => ':attribute ต้องน้อยกว่า :value กิโลไบต์',
        'string' => ':attribute ต้องมีความยาวน้อยกว่า :value อักขระ',
        'array' => ':attribute ต้องมีน้อยกว่า :value รายการ',
    ],
    'lte' => [
        'numeric' => ':attribute ต้องน้อยกว่าหรือเท่ากับ :value',
        'file' => ':attribute ต้องน้อยกว่าหรือเท่ากับ :value กิโลไบต์',
        'string' => ':attribute ต้องน้อยกว่าหรือเท่ากับ :value อักขระ',
        'array' => ':attribute ต้องมีรายการไม่เกิน :value',
    ],

    'mimetypes' => ':attribute ต้องเป็นไฟล์ประเภท: :values',

    'not_regex' => 'รูปแบบ :attribute ไม่ถูกต้อง',

    'starts_with' => ':attribute ต้องขึ้นต้นด้วยข้อใดข้อหนึ่งต่อไปนี้: :values',

    'uploaded' => 'อัปโหลด :attribute ไม่สำเร็จ',
    'uuid' => ':attribute ต้องเป็น UUID ที่ถูกต้อง',

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
        '商家otc挂单不存在' => 'ไม่มีคำสั่งซื้อที่รอดำเนินการของผู้ค้า',
        '交易数量不能小于' => 'จำนวนธุรกรรมต้องไม่น้อยกว่า :min_number',
        '商家不存在' => 'ไม่มีธุรกิจ',
        '您不能和自己交易' => 'คุณไม่สามารถซื้อขายกับตัวเองได้',
        '商家挂单交易状态异常' => 'สถานะธุรกรรมคำสั่งซื้อที่รอดำเนินการของผู้ค้าผิดปกติ',
        '商家挂单可交易数量为空'=>'ปริมาณที่ซื้อขายได้ของคำสั่งซื้อที่รอดำเนินการของผู้ขายว่างเปล่า',
        '商家挂单可交易数量不足,当前剩余'=>'คำสั่งซื้อที่รอดำเนินการของผู้ขายสามารถซื้อขายได้ไม่เพียงพอจำนวนที่เหลืออยู่ในปัจจุบัน',
        '商家发布挂单价格有变化,请刷新后重试'=>'ราคาของคำสั่งซื้อที่รอดำเนินการที่โพสต์โดยผู้ขายมีการเปลี่ยนแปลงโปรดรีเฟรชและลองอีกครั้ง',
        '请先设置收付款信息'=>'กรุณาตั้งค่าข้อมูลการรับและการชำระเงินก่อน',
        '您的收付款信息与商家挂单不匹配,无法交易'=>'ข้อมูลใบเสร็จและการชำระเงินของคุณไม่ตรงกับคำสั่งซื้อที่รอดำเนินการของร้านค้าและไม่สามารถซื้อขายได้',
        '您与该商家有交易未完成,请先完成再操作'=>'การทำธุรกรรมของคุณกับผู้ขายรายนี้ยังไม่เสร็จสมบูรณ์โปรดดำเนินการให้เสร็จสิ้นก่อนดำเนินการ',
        '交易数量只能是'=>'จำนวนธุรกรรมสามารถเป็นได้เท่านั้น',
        '交易数量不能超过'=>'จำนวนธุรกรรมต้องไม่เกิน :max_number'
    ],

];
