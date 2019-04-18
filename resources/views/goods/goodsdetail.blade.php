<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>三级分销</title>
    <link rel="shortcut icon" href="/images/favicon.ico" />
    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/response.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond./js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="maincont">
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>产品详情</h1>
        </div>
    </header>
    <div id="sliderA" class="slider">
        {{--@for($i=0;$i<=count($goods_imgs)-1;$i++)--}}
            {{--<img src="/images{{$goods_imgs[$i]}}" />--}}
        {{--@endfor--}}
        <img src="/images/image1.jpg" />
        <img src="/images/image2.jpg" />
        <img src="/images/image3.jpg" />
        <img src="/images/image4.jpg" />
        <img src="/images/image5.jpg" />
    </div><!--sliderA/-->
    <input type="hidden" id="goods_id" value="{{$arr->goods_id}}">
    <input type="hidden" id="_token" value="{{csrf_token()}}">
    <table class="jia-len">
        <tr goods_id="{{$arr->goods_id}}" goods_num="{{$arr->goods_num}}">
            <th><strong class="orange">￥{{$arr->self_price}}</strong></th>
            <td>
                <input type="text" id="buy_number" value="1" class="spinnerExample" />
                <a id="cartAdd">
                    <img src="/images/j_car.png" />
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <strong>{{$arr->goods_name}}</strong>
            </td>
            <td align="right">
                <a href="javascript:;" class="shoucang"><span class="glyphicon glyphicon-star-empty"></span></a>
            </td>
        </tr>
    </table>
    <div class="height2"></div>
    <h3 class="proTitle">商品规格</h3>
    <ul class="guige">
        <li class="guigeCur"><a href="javascript:;">50ML</a></li>
        <li><a href="javascript:;">100ML</a></li>
        <li><a href="javascript:;">150ML</a></li>
        <li><a href="javascript:;">200ML</a></li>
        <li><a href="javascript:;">300ML</a></li>
        <div class="clearfix"></div>
    </ul><!--guige/-->
    <div class="height2"></div>
    <div class="zhaieq">
        <a href="javascript:;" class="zhaiCur">商品简介</a>
        <a href="javascript:;">商品参数</a>
        <a href="javascript:;" style="background:none;">订购列表</a>
        <div class="clearfix"></div>
    </div><!--zhaieq/-->
    <div class="proinfoList">
        <img src="/images/image4.jpg" width="636" height="822" />
        <p class="hui">{!!$arr->goods_desc!!}</p>
    </div><!--proinfoList/-->
    <div class="proinfoList">
        暂无信息....
    </div><!--proinfoList/-->
    <div class="proinfoList">
        暂无信息......
    </div><!--proinfoList/-->
    <table class="jrgwc">
        <tr>
            <th>
                <a href="index.html"><span class="glyphicon glyphicon-home"></span></a>
            </th>
            <td></td>
        </tr>
    </table>
</div><!--maincont-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/js/bootstrap.min.js"></script>
<script src="/js/style.js"></script>
<!--焦点轮换-->
<script src="/js/jquery.excoloSlider.js"></script>
<script src="/layui/layui.all.js"></script>
<script src="/layui/layui.js"></script>
<script>
    $(function () {
        $("#sliderA").excoloSlider();
    });
</script>
<!--jq加减-->
<script src="/js/jquery.spinner.js"></script>
<script>
    $(function () {
        $('.spinnerExample').spinner({});
        //点击加号
        $(document).on('click','.increase',function () {
            var _this=$(this);
            var buy_number=parseInt(_this.prev("input").val());
            var goods_id=_this.parents('tr').attr('goods_id');
            var goods_num=_this.parents('tr').attr('goods_num');
            if(buy_number>=goods_num){
                _this.prop('disabled',true);
                $('#less').removeAttr('disabled');
            }else{
                buy_number+=1;
                _this.next("input").val(buy_number);
                _this.siblings("input[class='decrease']").prop('disabled',false);
                $('.decrease').removeAttr('disabled');
            }
        })
        //点击减号
        $(document).on('click','.decrease',function () {
            var _this=$(this);
            var buy_number=parseInt(_this.next("input").val());
            var goods_id=_this.parents('tr').attr('goods_id');
            var goods_num=_this.parents('tr').attr('goods_num');
            if(buy_number<=1){
                _this.prop('disabled',true);
                $('#add').removeAttr('disabled');
            }else{
                buy_number-=1;
                _this.prev("input").val(buy_number);
                _this.siblings("input[class='increase']").prop('disabled',false);
                $('.increase').removeAttr('disabled');
            }
        })
        //文本框失去焦点
        $(document).on('blur','.spinnerExample',function () {
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
        })
        //加入购物车
        $("#cartAdd").click(function(){
            //商品ID
            var goods_id=$("#goods_id").val();
            //购买数量
            var buy_number=$("#buy_number").val();
            var _token=$("#_token").val();
            $.post(
                "/cart/cartadd",
                {_token:_token,goods_id:goods_id,buy_number:buy_number},
                function(res){
                    // console.log(res);
                    if(res.code==3){
                        layer.msg(res.font,{icon:res.code});
                        location.href="/login/login"
                    }else{
                        layer.msg(res.font,{icon:res.code});
                        location.href="/cart/index";
                    }
                },
                'json'
            );
        })
    })
</script>
</body>
</html>