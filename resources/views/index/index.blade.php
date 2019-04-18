@extends('layouts.app')
@section('content')
    @if(session('message'))
        <script>
            alert("{{session('message')}}");
        </script>
    @endif
    <div class="head-top">
        <img src="/images/head.jpg" />
        <dl>
            <dt><a href="user.html"><img src="/images/touxiang.jpg" /></a></dt>
            <dd>
                <h1 class="username">三级分销终身荣誉会员</h1>
                <ul>
                    <li><a href="/goods/index"><strong>34</strong><p>全部商品</p></a></li>
                    <li><a href="javascript:;"><span class="glyphicon glyphicon-star-empty"></span><p>收藏本店</p></a></li>
                    <li style="background:none;"><a href="javascript:;"><span class="glyphicon glyphicon-picture"></span><p>二维码</p></a></li>
                    <div class="clearfix"></div>
                </ul>
            </dd>
            <div class="clearfix"></div>
        </dl>
    </div><!--head-top/-->
    <form action="/goods/index" method="get" class="search">
        <input type="text" name="search" class="seaText fl" />
        <input type="submit" value="搜索" class="seaSub fr" />
    </form><!--search/-->
    <ul class="reg-login-click">
        @if(session('user'))
            欢迎 <a href="">{{session('user.user_email')}}</a>登录
        @else
            <li><a href="/login/login">登录</a></li>
            <li><a href="/login/register" class="rlbg">注册</a></li>
            <div class="clearfix"></div>
        @endif
    </ul><!--reg-login-click/-->
    <div id="sliderA" class="slider">
        <img src="/images/image1.jpg" />
        <img src="/images/image2.jpg" />
        <img src="/images/image3.jpg" />
        <img src="/images/image4.jpg" />
        <img src="/images/image5.jpg" />
    </div><!--sliderA/-->
    <ul class="pronav">
        <li><a href="prolist.html">晋恩干红</a></li>
        <li><a href="prolist.html">万能手链</a></li>
        <li><a href="prolist.html">高级手镯</a></li>
        <li><a href="prolist.html">特异戒指</a></li>
        <div class="clearfix"></div>
    </ul><!--pronav/-->
    <div class="index-pro1">
        @foreach($arr as $k=>$v)
        <div class="index-pro1-list">
            <dl>
                <dt><a href="/goods/goodsdetail/{{$v->goods_id}}"><img src="/images/{{$v->goods_img}}"/></a></dt>
                <dd class="ip-text"><a href="/goods/goodsdetail/{{$v->goods_id}}">{{$v->goods_name}}</a><span>已售：488</span></dd>
                <dd class="ip-price"><strong>￥{{$v->self_price}}</strong> <span>￥{{$v->market_price}}</span></dd>
            </dl>
        </div>
        @endforeach
        <div class="clearfix"></div>
    </div><!--index-pro1/-->
    <div class="joins"><a href="fenxiao.html"><img src="/images/jrwm.jpg" /></a></div>
    <div class="copyright">Copyright &copy; <span class="blue">这是就是三级分销底部信息</span></div>
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
@endsection