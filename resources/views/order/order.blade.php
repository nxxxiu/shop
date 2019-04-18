@extends('layouts.app')
@section('content')
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>购物车</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/images/head.jpg" />
    </div><!--head-top/-->
    <div class="dingdanlist">
        <input type="hidden" id="_token" value="{{csrf_token()}}">
        <table>
            <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
            @foreach($addinfo as $k=>$v)
            <tr>
                <td class="dingimg" id="add" address_id="{{$v->address_id}}">收货地址</td>
                <td>
                    <h3>姓名：{{$v->address_name}}&nbsp;&nbsp;手机：{{$v->address_tel}}</h3>
                    <h3>{{$v->province}}{{$v->city}}{{$v->area}}{{$v->address_detail}}</h3>
                </td>
            </tr>
            @endforeach
            <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
            <tr>
                <td class="dingimg" width="75%" colspan="2">新增收货地址</td>
                <td align="right"><a href="/address/address"><img src="/images/jian-new.png" /></a></td>
            </tr>
            <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
            <tr>
                <td class="dingimg" width="75%" colspan="2">支付方式</td>
                <td align="right"><span class="hui" value="1">支付宝</span></td>
            </tr>
            <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
            <tr>
                <td class="dingimg" width="75%" colspan="2">优惠券</td>
                <td align="right"><span class="hui">无</span></td>
            </tr>
            <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
            <tr>
                <td class="dingimg" width="75%" colspan="3">商品清单</td>
            </tr>

            @foreach($goodsInfo as $k=>$v)
            <tr goods_id="{{$v->goods_id}}" class="goods_id">
                <td class="dingimg" width="15%"><img src="/images/{{$v->goods_img}}" /></td>
                <td width="50%">
                    <h3>{{$v->goods_name}}</h3>
                    <time>单价：￥ <span style="color:#ff4e00;">{{$v->self_price}}</span></time>
                </td>
                <td align="right"><span class="qingdan">X {{$v->buy_number}}</span></td>
            </tr>
            <tr>
                <th colspan="3"><strong class="orange">￥{{$v->self_price*$v->buy_number}}</strong></th>
            </tr>
            @endforeach
        </table>
    </div><!--dingdanlist/-->
</div><!--content/-->
<div class="height1"></div>
<div class="gwcpiao">
    <table>
        <tr>
            <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
            <td width="50%">总计：<strong class="orange">￥{{$countPrice}}</strong></td>
            <td width="40%"><a id="subOrder" class="jiesuan">提交订单</a></td>
        </tr>
    </table>
</div><!--gwcpiao/-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/js/bootstrap.min.js"></script>
<script src="/js/style.js"></script>
<script type="text/javascript" src="/layui/layui.js"></script>
<!--jq加减-->
<script src="/js/jquery.spinner.js"></script>
<script>
    $('.spinnerExample').spinner({});
</script>
<script>
    $(function () {
        layui.use('layer',function () {
            var _this=$(this);
            //点击确认订单
            $("#subOrder").click(function(){
                var _token=$('#_token').val();
                var goods_id='';
                $('.goods_id').each(function (index) {
                    goods_id+=$(this).attr('goods_id')+',';
                });
                goods_id=goods_id.substr(0,goods_id.length-1);
                //地址
                var address_id=$('#add').attr('address_id');
                $.post(
                    "/order/suborder",
                    {_token:_token,goods_id:goods_id,address_id:address_id},
                    function (res) {
                        // console.log(res);
                        layer.msg(res.font,{icon:res.code});
                        if(res.code=1){
                            location.href="/order/confirm?goods_id="+goods_id;
                        }
                    },
                    'json'
                )
            });
        })
    })
</script>
@endsection
