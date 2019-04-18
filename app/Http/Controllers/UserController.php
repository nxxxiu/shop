<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user/user');
    }

    //优惠券
    public function coupon(){
        return view('user/coupon');
    }

    //收获地址
    public function address(Request $request){
        $add_model=new \App\Address;
        $data=$add_model->get();
//        var_dump($data);
        return view('user/address',compact('data'));
    }

    //收藏
    public function collect(){
        return view('user/collect');
    }

    //提现
    public function cash(){
        return view('user/cash');
    }

    //全部订单
    public function order(){
        return view('user/order');
    }
}
