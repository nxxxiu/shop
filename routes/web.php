<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    return view('welcome');
});

//必选参数
//Route::get('goods/{id}', function ($id) {
//    return 'Goods ' . $id;
//});

//可选参数
//Route::get('goods/{id?}', function ($id=null) {
//    return 'Goods ' . $id;
//});

//路由视图
//Route::get('/goods','Goodscontroller@show');

//Route::get('/add',function(){
//    return '<form action="/add_do" method="post"><input type="text" value="" name="name"><button value="提交"></button></form>';
//});

//首页
Route::any('index/index','IndexController@index');

//所有商品
Route::any('goods/index','GoodsController@index');
Route::any('goods/goodsdetail/{id}','GoodsController@goodsdetail');//商品详情
Route::any('goods/getNewGoods','GoodsController@getNewGoods');//重新获取商品

//购物车
Route::any('cart/index','CartController@index');
Route::any('cart/cartadd','CartController@cartadd');//添加购物车
Route::any('cart/changenum','CartController@changenum');//改变数量
Route::any('cart/getCountPrice','CartController@getCountPrice');//改变总价

//个人中心
Route::any('user/index','UserController@index');
Route::any('user/order','UserController@order');//全部订单
Route::any('user/coupon','UserController@coupon');//优惠券
Route::any('user/address','UserController@address');//收获地址
Route::any('user/collect','UserController@collect');//收藏
Route::any('user/cash','UserController@cash');//提现

//登录
Route::any('login/login','LoginController@login');//登录
Route::any('login/register','LoginController@register');//注册
Route::any('login/regdo','LoginController@regdo');//注册执行
Route::any('login/logindo','LoginController@logindo');//注册执行
Route::any('login/sendemail','LoginController@sendemail');//发送邮件

//订单
Route::any('order/order','OrderController@order');
Route::any('order/confirm','OrderController@confirm');//订单生成成功
Route::any('order/suborder','OrderController@suborder');//提交订单
Route::any('order/alipay/{order_no}','OrderController@alipay');//电脑支付宝支付
Route::any('order/mb_alipay/{order_no}','OrderController@mb_alipay');//手机支付宝支付
Route::any('order/returnpay','OrderController@returnpay');//同步
Route::any('order/notifypay','OrderController@notifypay');//异步
Route::any('wxpay/test/{id}','WxpayController@test');//微信支付
Route::post('wxpay/notify','WxpayController@notify');//异步

//收货地址
Route::any('address/address','AddressController@address');
Route::any('address/getarea','AddressController@getarea');//三级联动获取收货地址
Route::any('address/addressdo','AddressController@addressdo');//添加执行‘


