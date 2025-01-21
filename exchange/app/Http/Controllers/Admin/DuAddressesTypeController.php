<?php


namespace App\Http\Controllers\Admin;

use App\Models\DuAddress\DuAddressesType;
use App\Models\News\NewsCategory;

class DuAddressesTypeController extends Controller
{
    public function index()
    {
        return view('admin.duAddressesType.index');
    }

    public function list()
    {
        $limit     = request('limit', 10);
        $news_list = DuAddressesType::orderBy('id', 'ASC')->paginate($limit);
        return $this->layuiPageData($news_list);
    }

    public function add()
    {
        return view('admin.duAddressesType.add');
    }

    public function save()
    {
        $name  = request('name', 0);

        if (!$name) {
            return $this->error('请输入名称');
        }
        if (DuAddressesType::where('name', $name)->exists()) {
            return $this->error('名称已存在');
        }

        DuAddressesType::create([
            'name'  => $name,
        ]);
        if (!$name) {
            return $this->error('请输入名称');
        }

        return $this->success('操作成功');
    }

    public function edit()
    {
        $id   = request('id', 0);
        $info = DuAddressesType::find($id);
        return view('admin.duAddressesType.edit', [
            'info' => $info,
        ]);
    }

    public function update()
    {


            $id = request('id', 0);
            $name = request('name', 0);

            if (!$name) {
                return $this->error('请输入名称');
            }
            if (DuAddressesType::where('name', $name)->where('id', '!=', $id)->exists()) {
                return $this->error('名称已存在');
            }

        DuAddressesType::where('id',$id)->update([
                'name'  => $name,

            ]);


            return $this->success('操作成功');
    }

    public function delete()
    {
        $id = request('id', 0);
        DuAddressesType::destroy($id);
        return $this->success('删除成功');
    }
}
