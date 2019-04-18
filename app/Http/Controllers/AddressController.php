<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class AddressController extends Controller
{
    //添加收货地址
    public function address(Request $request){
        $addressInfo=$this->area($request);
//        var_dump($addressInfo);
        return view('address/address',compact('addressInfo'));
    }

    //地址
    public function area(Request $request){
        $id=$request->id??'0';
        $where=[
            'pid'=>$id
        ];
        $area_model=new \App\Area;
        $data=$area_model::where($where)->get();
        return $data;
    }

    //三级联动获取地址
    public function getarea(Request $request){
        $area= $this->area($request);
        $arr=[
            'area'=>$area,
            'code'=>1
        ];
        echo json_encode($arr);
    }

    //添加执行
    public function addressdo(Request $request){
        $address_model=new \App\address;
        $data=$request->all();
//        dd($data['is_default']);
//        var_dump($data);
        unset($data['_token']);
        if ($data['is_default']==1){
            $res=DB::table('address')->where('user_id',session('user.user_id'))->update(['is_default'=>2]);
        }
//        var_dump(session('user.user_id'));die;
        foreach($data as $k=>$v){
            $address_model->$k=$v;
        }
        $res=$address_model->save();
        if($res){
            $arr=[
                'font'=>'添加成功',
                'code'=>1
            ];
            return json_encode($arr);die;
        }else{
            $arr=[
                'font'=>'添加失败',
                'code'=>2
            ];
            return json_encode($arr);die;
        }
    }

}
