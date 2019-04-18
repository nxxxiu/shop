<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class CartController extends Controller
{
    //购物车列表
    public function index(Request $request)
    {
        if(!session('user')){
            $arr=[
                'font'=>'请登录',
                'code'=>3
            ];
            return json_encode($arr);die;
        }else{
            $data=Db::select("select * from goods join cart on goods.goods_id=cart.goods_id and cart_status=1");
//            dd($data);
            $count=count($data);
            return view('cart/cart',compact('data','count'));
        }
    }

    //改变购物车数量
    public function changenum(Request $request){
        $goods_id=$request->goods_id;
        $buy_number=$request->buy_number;
        $user_id=session('user.user_id');
        $cartdata=DB::table('cart')->where(['goods_id'=>$goods_id])->value('buy_number');
        $cartwhere=[
            'buy_number'=>$buy_number
        ];
        $res=DB::table('cart')->where(['goods_id'=>$goods_id,'user_id'=>$user_id])->update($cartwhere);
        if ($res){
            $arr=[
                'font'=>'操作成功',
                'code'=>1
            ];
            return json_encode($arr);die;
        }else{
            $arr=[
                'font'=>'操作失败',
                'code'=>2
            ];
            return json_encode($arr);die;
        }
    }

    //获取总价
    public function getCountPrice(Request $request){
        $cart_id=$request->cart_id??'';
        $price=0;
        if($cart_id){
            $data=DB::select("select * from goods join cart on goods.goods_id=cart.goods_id and cart_status=1 and cart_id in(".$cart_id.")");
            foreach ($data as $k=>$v){
                $price=$price+$v->self_price*$v->buy_number;
            }
            return $price;
        }else{
            return $price;
        }
    }

    //添加购物车
    public function cartadd(Request $request)
    {
        if(!session('user')){
            $arr=[
                'font'=>'请登录',
                'code'=>3
            ];
            return json_encode($arr);die;
        }else{
            $goods_model=new \App\Goods;
            $data=$request->all();
            $goods_id=$request->goods_id;
            $buy_number=$request->buy_number;
            unset($data['_token']);
            $goodsWhere=[
                'goods_id'=>$goods_id
            ];
            $goodsInfo= $goods_model->where($goodsWhere)->first();
//        var_dump($data);die;
            $cart_model=new \App\Cart;
            $cartWhere=[
                'goods_id'=>$goods_id,
                'cart_status'=>1
            ];
//        var_dump($cartWhere);
            $cartInfo=$cart_model->where($cartWhere)->first();
//        var_dump($cartInfo);die;
            if($cartInfo){
                if (($cartInfo['buy_number']+$data['buy_number'])>$goodsInfo['goods_num']){
                    $arr=[
                        'font'=>'库存不足',
                        'code'=>2
                    ];
                    return json_encode($arr);die;
                }else{
                    $cart=$cart_model->find($cartInfo['cart_id']);
//                    dd($cart);
//                    var_dump($cartInfo['buy_number']+$data['buy_number']);
                    $cart->buy_number=$cartInfo['buy_number']+$data['buy_number'];
                    $res=$cart->save();
                    if($res){
                        $arr=[
                            'font'=>'加入购物车成功',
                            'code'=>1
                        ];
                        return json_encode($arr);die;
                    }else{
                        $arr=[
                            'font'=>'加入购物车失败',
                            'code'=>2
                        ];
                        return json_encode($arr);die;
                    }
                }
            }else{
                foreach ($data as $k=>$v){
                    $cart_model->$k=$v;
                }
                $cart_model->user_id=session('user.user_id');
//                var_dump($cart_model);die;
                $res=$cart_model->save();
                if($res){
                    $arr=[
                        'font'=>'加入购物车成功',
                        'code'=>1
                    ];
                    return json_encode($arr);die;
                }else{
                    $arr=[
                        'font'=>'加入购物车失败',
                        'code'=>2
                    ];
                    return json_encode($arr);die;
                }
            }
        }

    }

}
