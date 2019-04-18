<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class OrderController extends Controller
{
    //订单
    public function order(Request $request){
        //检测是否选择商品
        $goods_id=$request->goods_id;
        if(empty($goods_id)){
            $arr=[
                'code'=>2,
                'font'=>'请选择一个商品'
            ];
            return json_encode($arr);die;
        }
        $goodsInfo=DB::select("select * from goods join cart on goods.goods_id=cart.goods_id and cart_status=1 and cart.goods_id in(".$goods_id.")");
//        var_dump($goodsInfo);
        //获取商品总价
        $countPrice=0;
        foreach($goodsInfo as $k=>$v){
            $countPrice=$countPrice+$v->self_price*$v->buy_number;
        }
        //获取默认地址
        $addinfo=DB::table('address')->where(['is_default'=>1])->get();
        if (!empty($addinfo)){
            foreach($addinfo as $k=>$v){
                $addinfo[$k]->province=DB::table('area')->where(['id'=>$v->province])->value('name');
                $addinfo[$k]->city=DB::table('area')->where(['id'=>$v->city])->value('name');
                $addinfo[$k]->area=DB::table('area')->where(['id'=>$v->area])->value('name');
            }
        }else{
            return false;
        }
        return view('order/order',compact('goodsInfo','countPrice','addinfo'));
    }

    //确认结算
    public function suborder(Request $request){
        $goods_id=$request->goods_id;
//        var_dump($goods_id);
        $address_id=$request->address_id;
        $user_id=session('user.user_id');
//        echo $user_id;
        //订单号
        $order_no=time().rand(1111,9999);
        $goodsinfo=DB::select('select * from cart join goods on cart.goods_id=goods.goods_id where cart.user_id='.$user_id.' and cart.goods_id in( '.$goods_id.')');
        $order_amount=0;
        foreach ($goodsinfo as $k=>$v){
            $order_amount=$order_amount+$v->buy_number*$v->self_price;
        }
        $data=[
            'order_no'=>$order_no,
            'user_id'=>$user_id,
            'order_amount'=>$order_amount
        ];
        $order=DB::table('order');
        $res1=$order->insert($data);
//        var_dump($arr);
        if($res1!=true){
            $arr=[
                'code'=>2,
                'font'=>'提交失败'
            ];
            return json_encode($arr);die;
        }
        // //获取order当前id
        $order_id = DB::getPdo('order')->lastInsertId();
//        var_dump($ordere_id);
        // 商品添加
        if($order_id==0){
            $arr=[
                'code'=>2,
                'font'=>'提交失败'
            ];
            return json_encode($arr);die;
        }
        //详情
        $goodsinfo=DB::select('select * from cart join goods on cart.goods_id=goods.goods_id where cart.user_id='.$user_id.' and cart.goods_id in( '.$goods_id.')');
//        var_dump($goodsinfo);
        foreach($goodsinfo as $k=>$v){
            $info=[
                'goods_id'=>$v->goods_id,
                'user_id'=>$v->user_id,
                'buy_number'=>$v->buy_number,
                'self_price'=>$v->self_price,
                'goods_img'=>$v->goods_img,
                'goods_name'=>$v->goods_name,
            ];
            $info['order_id']=$order_id;
            $info['user_id']=$user_id;
            $order_detail=DB::table('order_detail');
            $res2=$order_detail->insert($info);
//            var_dump($detailarr);
            if($res2){
                //删除购物车
                $res4=DB::table('cart')->where('cart_id',$v->cart_id)->update(['cart_status'=>2]);
                //减少商品库存
                $res5=DB::table('goods')->where('goods_id',$v->goods_id)->update(['goods_num'=>$v->goods_num-$v->buy_number]);
            }else{
                $arr=[
                    'code'=>2,
                    'font'=>'提交失败'
                ];
                return json_encode($arr);die;
            }
        }
        //地址添加
        $address=DB::table('address')->where(['address_id'=>$address_id])->get();
        foreach($address as $k=>$v){
            $addinfo=[
                'address_name'=>$v->address_name,
                'address_tel'=>$v->address_tel,
                'address_detail'=>$v->address_detail,
                'province'=>$v->province,
                'city'=>$v->city,
                'area'=>$v->area,
            ];
            $addinfo['user_id']=$user_id;
            $addinfo['order_id']=$order_id;
//          var_dump($addinfo);
            $res3=DB::table('order_address')->insert($addinfo);
            if($res3!=true){
                $arr=[
                    'code'=>2,
                    'font'=>'提交失败'
                ];
                return json_encode($arr);die;
            }
        }
        if($res1=='true'&&$res2=='true'&&$res3=='true'){
            $arr=[
                'code'=>1,
                'font'=>'提交成功'
            ];
            return json_encode($arr);die;
        }else{
            $arr=[
                'code'=>2,
                'font'=>'提交失败'
            ];
            return json_encode($arr);die;
        }
    }

    //下单成功
    public function confirm(Request $request){
        $goods_id=$request->goods_id??'';
        $reg="/^[0-9,]{1,}$/";
        if(!preg_match($reg,$goods_id)){
            return redirect('/index/index');
        }
        $goods_id=explode(',',$goods_id);
        $info=DB::table('order')
            ->join('order_address','order.order_id','=','order_address.order_id')
            ->join('order_detail','order.order_id','=','order_detail.order_id')
            ->where(['order.user_id'=>session('user.user_id'),'order.pay_status'=>1])
            ->wherein('order_detail.goods_id',$goods_id)
            ->first();
//        var_dump($info);die;
        return view('order/confirm',compact('info'));
    }

    //电脑支付宝支付
//    public function alipay($order_no){
////        echo $order_no;
//        $order=DB::table('order')->select(['order_no','order_amount'])->where('order_no',$order_no)->first();
//        require_once app_path('/libs/alipay/pagepay/service/AlipayTradeService.php');
//        require_once app_path('/libs/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php');
//
//        //商户订单号，商户网站订单系统中唯一订单号，必填
//        $out_trade_no = trim($order_no);
//
//        //订单名称，必填
//        $subject = '郭采洁';
//
//        //付款金额，必填
//        $total_amount = trim($order->order_amount);
//
//        //商品描述，可空
//        $body = trim('黑恶');
//
//        //构造参数
//        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
//        $payRequestBuilder->setBody($body);
//        $payRequestBuilder->setSubject($subject);
//        $payRequestBuilder->setTotalAmount($total_amount);
//        $payRequestBuilder->setOutTradeNo($out_trade_no);
//
//        $aop = new \AlipayTradeService(config('alipay'));
//
//        /**
//         * pagePay 电脑网站支付请求
//         * @param $builder 业务参数，使用buildmodel中的对象生成。
//         * @param $return_url 同步跳转地址，公网可以访问
//         * @param $notify_url 异步通知地址，公网可以访问
//         * @return $response 支付宝返回的信息
//         */
//        $response = $aop->pagePay($payRequestBuilder,config('alipay.return_url'),config('alipay.notify_url'));
//
//        //输出表单
//        var_dump($response);
//    }

    //手机端支付宝
    public function mb_alipay($order_no){
        $order=DB::table('order')->select(['order_no','order_amount'])->where('order_no',$order_no)->first();
        require_once app_path ('/libs/mb_alipay/alipay/wappay/service/AlipayTradeService.php');
        require_once app_path ('/libs/mb_alipay/alipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php');
        if (!empty($order_no)&& trim($order_no)!="") {
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = $order_no;

            //订单名称，必填
            $subject = "郭采洁";

            //付款金额，必填
            $total_amount = $order->order_amount;

            //商品描述，可空
            $body = "nene";

            //超时时间
            $timeout_express = "5m";

            $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
            $payRequestBuilder->setBody($body);
            $payRequestBuilder->setSubject($subject);
            $payRequestBuilder->setOutTradeNo($out_trade_no);
            $payRequestBuilder->setTotalAmount($total_amount);
            $payRequestBuilder->setTimeExpress($timeout_express);

            $payResponse = new \AlipayTradeService(config('alipay'));
            $result = $payResponse->wapPay($payRequestBuilder, config('alipay.return_url'), config('alipay.notify_url'));

            return;
        }
    }

    //同步
    public function returnpay(){
        $order=DB::table('order')->where(['order_no'=>$_GET['out_trade_no'],'order_amount'=>$_GET['total_amount']])->first();
        if (!$order){
            return redirect('order/order')->with('message','订单信息不存在');
        }else{
            require_once app_path('/libs/alipay/pagepay/service/AlipayTradeService.php');
            $arr=$_GET;
            $alipaySevice = new \AlipayTradeService(config('alipay'));
            $result = $alipaySevice->check($arr);
            if ($result){
                return redirect('/order/order');
            }
        }
    }

    //异步
    public function notifypay(){

    }

}

