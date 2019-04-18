@extends('layouts.app')
@section('content')
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>购物车</h1>
        </div>
    </header>
    <input type="hidden" id="_token" value="{{csrf_token()}}">
    <div class="head-top">
        <img src="/images/head.jpg" />
    </div><!--head-top/-->
    <table class="shoucangtab">
        <tr>
            <td width="75%"><span class="hui">购物车共有：<strong class="orange">{{$count}}</strong>件商品</span></td>
            <td width="25%" align="center" style="background:#fff url(/images/xian.jpg) left center no-repeat;">
                <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
            </td>
        </tr>
    </table>
    <div class="dingdanlist">
        <table>
            <tr>
                <td width="100%" colspan="4"><a href="javascript:;"><input type="checkbox" id="allbox" name="1" /> 全选</a></td>
            </tr>
            @foreach($data as $k=>$v)
            <tr goods_id="{{$v->goods_id}}" goods_num="{{$v->goods_num}}" cart_id="{{$v->cart_id}}">
                <td width="4%"><input type="checkbox" class="box" name="1" /></td>
                <td class="dingimg" width="15%"><img src="/images/{{$v->goods_img}}" /></td>
                <td width="50%">
                    <h3>{{$v->goods_name}}</h3>
                    <time>单价：￥ <span style="color:#ff4e00;">{{$v->self_price}}</span></time>
                </td>
                <td align="right">
                    <button class="less">－</button>
                    <input type="text" value="{{$v->buy_number}}" id="buy_number" style="height:25px;width: 25px"/>
                    <button class="add">＋</button>
                </td>
            </tr>
            <th colspan="4"><strong class="orange">￥<span>{{$v->self_price*$v->buy_number}}</span></strong></th>
            @endforeach
        </table>
    </div><!--dingdanlist/-->
    <div class="height1"></div>
    <div class="gwcpiao">
        <table>
            <tr goods_id="{{$v->goods_id}}">
                <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
                <td width="50%">总计：<strong class="orange">￥<span id="countPrice">0</span></strong></td>
                <td width="40%"><a id="order" class="jiesuan">去结算</a></td>
            </tr>
        </table>
    </div><!--gwcpiao/-->
    <!--footNav/-->
</div><!--maincont-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/js/jquery-3.2.1.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/js/bootstrap.min.js"></script>
<script src="/js/style.js"></script>
<script src="/layui/layui.all.js"></script>
<script src="/layui/layui.js"></script>
<!--jq加减-->
<script src="/js/jquery.spinner.js"></script>
<script>
    $(function () {
        $('.spinnerExample').spinner({});
        var _token=$("#_token").val();
        //点击加号
        $(document).on('click','.add',function(){
            var _this=$(this);
            var buy_number=parseInt(_this.prev("input").val());
            var goods_num=_this.parents('tr').attr('goods_num');
            var goods_id=_this.parents('tr').attr('goods_id');
            if(buy_number>=goods_num){
                _this.prop('disabled',true);
            }else{
                buy_number+=1;
                _this.prev("input").val(buy_number);
                _this.siblings("input[class='less']").prop('disabled',false);
            }
            //改变数据库或cookie中的数量
            $.post(
                "/cart/changenum",
                {_token:_token,goods_id:goods_id,buy_number:buy_number},
                function (res) {
                    if (res.code==1){
                        getTotal(_this,buy_number);
                        getCountPrice();
                    }
                    layer.msg(res.font,{icon:res.code});
                },
                'json'
            )
        });

        //点击减号
        $(document).on('click','.less',function(){
            var _this=$(this);
            var buy_number=parseInt(_this.next("input").val());
            var goods_id=_this.parents('tr').attr('goods_id');
            var goods_num=_this.parents('tr').attr('goods_num');
            if(buy_number<=1){
                _this.prop('disabled',true);
            }else{
                buy_number-=1;
                _this.next("input").val(buy_number);
                _this.siblings("input[class='add']").prop('disabled',false);
            }
            //改变数据库或cookie中的数量
            $.post(
                "/cart/changenum",
                {_token:_token,goods_id:goods_id,buy_number:buy_number},
                function (res) {
                    if (res.code==1){
                        getTotal(_this,buy_number);
                        getCountPrice();
                    }
                    layer.msg(res.font,{icon:res.code});
                },
                'json'
            )
        });

        //失去焦点
        $(document).on('blur','#buy_number',function(){
            var _this=$(this);
            var buy_number=parseInt(_this.val());
            var goods_num=_this.parents('tr').attr('goods_num');
            var goods_id=_this.parents('tr').attr('goods_id');

            //正则验证
            var reg=/^[1-9]\d*$/;
            if(!reg.test(buy_number)){
                _this.val(1);
            }else if(buy_number<=1){
                _this.val(1);
            }else if(buy_number>=goods_num){
                _this.val(goods_num);
            }else{
                _this.val(buy_number);
            }
            buy_number=parseInt(_this.val());
            //改变数据库或cookie中的数量
            $.post(
                "/cart/changenum",
                {_token:_token,goods_id:goods_id,buy_number:buy_number},
                function (res) {
                    if (res.code==1){
                        getTotal(_this,buy_number);
                        getCountPrice();
                    }
                    layer.msg(res.font,{icon:res.code});
                },
                'json'
            );
        });

        //点击复选框
        $(document).on('click','.box',function(){
            getCountPrice();
        })

        //全选
        $(document).on('click','#allbox',function(){
            var _this=$(this);
            var status=_this.prop('checked');
            $('.box').prop('checked',status);
            getCountPrice();
        });

        //计算小计
        function getTotal(_this,buy_number){
            var self_price=_this.parents('tr').find('time').children('span').text();
            // console.log(self_price);
            var total=self_price*buy_number;
            // console.log(total);
            _this.parents('tr').next().find('strong').children('span').text(total);
        }

        //获取总价
        function getCountPrice(){
            var box=$('.box');
            var cart_id='';
            box.each(function (index) {
                if($(this).prop('checked')==true){
                    cart_id+=$(this).parents('tr').attr('cart_id')+',';
                }
            });
            cart_id=cart_id.substr(0,cart_id.length-1);
            $.post(
                "/cart/getCountPrice",
                {_token:_token,cart_id:cart_id},
                function(res){
                    $('#countPrice').text(res);
                }
            );
        }

        //点击确认结算
        $(document).on('click','#order',function () {
            var box=$('.box');
            var goods_id='';
            box.each(function (index) {
                if($(this).prop('checked')==true){
                    goods_id+=$(this).parents('tr').attr('goods_id')+',';
                }
            })
            goods_id=goods_id.substr(0,goods_id.length-1);
            if(goods_id==''){
                layer.msg('请至少选择一个商品');
                return false;
            }
            location.href="/order/order?goods_id="+goods_id;
        })
    })
</script>
@endsection