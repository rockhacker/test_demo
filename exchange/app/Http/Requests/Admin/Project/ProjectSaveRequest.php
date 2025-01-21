<?php

namespace App\Http\Requests\Admin\Project;

use App\Http\Requests\BaseRequest;
use App\Models\Currency\Currency;

class ProjectSaveRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'currency_id' => 'required',
            'banner' => 'required',
            'introduction' => 'required',
            'min_buy_number' => 'required|numeric',
            'max_buy_number' => 'required|numeric',
            'project_number' => 'required|numeric',
            'range_time' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'currency_id' => '币种',
            'title' => '标题',
            'banner' => 'Banner',
            'introduction' => '简介',
            'min_buy_number' => '购买数量',
            'max_buy_number' => '购买数量',
            'project_number' => '总认购数量',
            'range_time' => '认购时间范围',

        ];
    }

    /**
     *  配置验证器实例。
     *
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return void
     */
    public function withValidator($validator)
    {
    }

}
