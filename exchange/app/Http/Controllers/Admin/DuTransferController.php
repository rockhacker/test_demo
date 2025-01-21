<?php


namespace App\Http\Controllers\Admin;

use App\Models\Currency\Currency;
use App\Models\DuAddress\DuAddress;
use App\Models\DuAddress\DuAddressesType;
use App\Models\DuAddress\DuFry;
use App\Models\DuAddress\DuTransfer;
use App\Models\News\NewsCategory;

class DuTransferController extends Controller
{
    public function index()
    {
        return view('admin.duTransfer.index');
    }

    public function list()
    {
        $limit     = request('limit', 10);
        $news_list = DuTransfer::orderBy('id', 'ASC')->paginate($limit);

        return $this->layuiPageData($news_list);
    }



    public function delete()
    {
        $id = request('id', 0);
        DuTransfer::destroy($id);
        return $this->success('删除成功');
    }
}
