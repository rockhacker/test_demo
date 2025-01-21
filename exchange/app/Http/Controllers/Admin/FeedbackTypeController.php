<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Models\Feedback\Feedback;
use App\Models\Feedback\FeedbackType;

class FeedbackTypeController extends Controller
{
    public function index()
    {
        return view('admin.feedbackType.index');
    }

    public function list()
    {
        $limit = request('limit', 10);
        $list = FeedbackType::orderBy('sorts', 'ASC')->paginate($limit);
        return $this->layuiPageData($list);
    }

    public function add()
    {
        return view('admin.feedbackType.add');
    }

    public function save()
    {
        return $this->error('演示环境禁止修改');

        try {
            $name = request('name', 0);
            $sorts = request('sorts', 0);
            $validator = Validator::make(request()->all(), [
                'name' => 'required|string|min:1|unique:feedback_types',
            ], [], [
                'name' => '名称',
            ]);
            throw_if($validator->fails(), new \Exception($validator->errors()->first()));
            FeedbackType::create([
                'sorts' => $sorts,
                'name' => $name,
            ]);
            return $this->success('操作成功');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }

    }

    public function edit()
    {
        $id = request('id', 0);
        $info = FeedbackType::find($id);
        return view('admin.feedbackType.edit', [
            'info' => $info,
        ]);
    }

    public function update()
    {
        return $this->error('演示环境禁止修改');

        return transaction(function () {
            $id = request('id', 0);
            $name = request('name', 0);
            $sorts = request('sorts', 0);
            $validator = Validator::make(request()->all(), [
                'name' => 'required|string|min:1|unique:feedback_types,name,' . $id,
            ], [], [
                'name' => '名称',
            ]);
            throw_if($validator->fails(), new \Exception($validator->errors()->first()));

            FeedbackType::findOrFail($id)->update([
                'sorts' => $sorts,
                'name' => $name,
            ]);

            return $this->success('操作成功');
        });
    }

    public function delete()
    {
        $id = request('id', 0);
        if (Feedback::where('type_id', $id)->exists()) {
            return $this->error('该类别存在于用户反馈列表中,无法删除');
        }
        FeedbackType::destroy($id);
        return $this->success('删除成功');
    }
}
