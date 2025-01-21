<?php


namespace App\Http\Controllers\Admin;

use App\Models\DuAddress\DuAddress;
use App\Models\DuAddress\DuAddressesType;
use App\Models\News\NewsCategory;

class DuAddressController extends Controller
{
    public function index()
    {
        return view('admin.duAddress.index');
    }

    public function list()
    {
        $limit     = request('limit', 10);
        $news_list = DuAddress::orderBy('id', 'ASC')->paginate($limit);
        foreach ($news_list as $k=>$v){
            $news_list[$k]['type'] = DuAddressesType::where('id',$v['type_id'])->value('name');
        }
        return $this->layuiPageData($news_list);
    }

    public function add()
    {
        return view('admin.duAddress.add');
    }

    public function save()
    {
//        return $this->error('演示环境禁止修改');

        $name  = request('name', 0);

        if (!$name) {
            return $this->error('请输入名称');
        }
        if (DuAddress::where('name', $name)->exists()) {
            return $this->error('名称已存在');
        }

        DuAddress::create([
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
        $info = DuAddress::find($id);
        $types = DuAddressesType::get();
        return view('admin.duAddress.edit', [
            'info' => $info,
            'types' => $types,
        ]);
    }

    public function update()
    {

//        return $this->error('演示环境禁止修改');

            $id = request('id', 0);
            $address = request('address', 0);
            $private_key = request('private_key', 0);
            $type_id = request('type_id', 0);

            if (!$address || !$private_key) {
                return $this->error('地址和私钥必填');
            }

            $key_str = substr($private_key , 0,2);
            if ($key_str == '0x'){
                return $this->error('密钥前面请勿带0x字符');
            }
            if (DuAddress::where('address', $address)->where('id', '!=', $id)->exists()) {
                return $this->error('地址已存在');
            }

        if (DuAddress::where('private_key', $private_key)->where('id', '!=', $id)->exists()) {
            return $this->error('密钥已存在');
        }

        if (DuAddress::where('type_id', $type_id)->where('id', '!=', $id)->exists()) {
            return $this->error('类型已存在');
        }

        DuAddress::where('id',$id)->update([
                'address'  => $address,
                'private_key'  => $private_key,
                'type_id'  => $type_id,
                'updated_at'  => date("Y-m-d H:i:s"),

            ]);


            return $this->success('操作成功');
    }

    public function delete()
    {
        $id = request('id', 0);
        DuAddress::destroy($id);
        return $this->success('删除成功');
    }
}
