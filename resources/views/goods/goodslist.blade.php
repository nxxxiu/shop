@extends('layouts.app')
@section('content')
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <form action="#" method="get" class="prosearch"><input type="text" id="search"/></form>
        </div>
    </header>
    <ul class="pro-select">
        <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
        <li class="new" status="1"><a href="javascript:;">新品</a></li>
        <li class="new" status="2"><a href="javascript:;">销量</a></li>
        <li class="new" status="3"><a href="javascript:;">价格<span id="sp">↓</span></a></li>
    </ul><!--pro-select/-->
    <div id="replace">
        <div class="prolist">
        @foreach($arr as $k=>$v)
            <dl>
                <dt><a href="/goods/goodsdetail/{{$v->goods_id}}"><img src="/images/{{$v->goods_img}}" width="100" height="100" /></a></dt>
                <dd>
                    <h3><a href="proinfo.html">{{$v->goods_name}}</a></h3>
                    <div class="prolist-price"><strong>￥{{$v->self_price}}</strong> <span>￥{{$v->market_price}}</span></div>
                    <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
                </dd>
                <div class="clearfix"></div>
            </dl>
        @endforeach
        </div><!--prolist/-->
    </div>
    <div class="height1"></div>
    @include('public.footer')
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/style.js"></script>
    <script type="text/javascript" src="/layui/layui.js"></script>
    <!--jq加减-->
    <script src="/js/jquery.spinner.js"></script>
<script>
    $(function () {
        layui.use('layer',function () {
            $('.new').click(function () {
                var _this=$(this);
                var status=_this.attr('status');
                var _token=$('#token').val();
                var search=$('#search').val();
                var order;
                _this.addClass('bgcolor');
                _this.siblings().removeClass('bgcolor');
                if(status==3){
                    if ($('#sp').text()=='↑'){
                        $('#sp').text('↓');
                        order="asc";
                    } else if($('#sp').text()=='↓'){
                        $('#sp').text('↑');
                        order="desc";
                    }
                }
                $.post(
                    "getNewGoods",
                    {_token:_token,status:status,search:search,order:order},
                    function (res) {
                        $('#replace').html(res);
                        // console.log(res);
                    }
                )
            });
            //搜索
            $('#search').change(function () {
                var status=$('li[class="new bgcolor"]').attr('status');
                var _token=$('#token').val();
                var search=$('#search').val();
                var order;
                if(status==3){
                    if ($('#sp').text()=='↑'){
                        order="desc";
                    } else if($('#sp').text()=='↓'){
                        order="asc";
                    }
                }
                $.post(
                    "getNewGoods",
                    {_token:_token,status:status,search:search,order:order},
                    function (res) {
                        $('#replace').html(res);
                        // console.log(res);
                    }
                )
            })
        })
    });
</script>
@endsection