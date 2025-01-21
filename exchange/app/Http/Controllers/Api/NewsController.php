<?php


namespace App\Http\Controllers\Api;

use App\Models\News\News;
use App\Models\News\NewsCategory;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class NewsController extends Controller
{
    /**新闻分类
     *
     */
    public function categories(): JsonResponse
    {
        $categories = NewsCategory::get();
        return $this->success(__('api.请求成功'), $categories);
    }

    /**新闻接口
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {

        $category_id = request('category_id', 0);
        $limit = request('limit', 15);
        $ids = false;
        if(in_array($category_id ,[27,23])){
//            // 轮播图限制
//            $origin = parse_url($_SERVER['HTTP_ORIGIN'])['host'];
//            $prefix = explode('.',$origin)[0];
//            if($prefix == 'm' || $prefix == 'www'){
//                $ids = [201,202];
//            } elseif ($prefix == 'm1' || $prefix == 'www1') {
//                $ids = [203,204];
//            } elseif ($prefix == 'm2' || $prefix == 'www2') {
//                $ids = [205,206];
//            } elseif ($prefix == 'm3' || $prefix == 'www3') {
//                $ids = [207,208];
//            } elseif ($prefix == 'm4' || $prefix == 'www4') {
//                $ids = [209,210];
//            } elseif ($prefix == 'm5' || $prefix == 'www5' || $prefix == 'www7') {
//                $ids = [211,212];
//            }elseif ($prefix == 'm12' || $prefix == 'www12') {
//                $ids = [215,216];
//            }
            App::setLocale('en');
        }
        $list = News::with(['category', 'lang'])
            ->whereHas('lang', function ($query) {
                $lang = App::getLocale();
                $query->where('code', $lang);
            })->when($ids,function ($q) use ($ids){
                $q->whereIn('id',$ids);
            })->where('category_id', $category_id)
            ->orderByDesc('id')->paginate($limit);

        return $this->success(__('api.请求成功'), $list);
    }

    /**新闻详情
     *
     */
    public function info(): JsonResponse
    {
        $id = request('id', 0);
        $news = News::find($id);
        return $this->success(__('api.请求成功'), $news);
    }

}
