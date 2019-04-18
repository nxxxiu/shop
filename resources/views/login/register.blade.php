@extends('layouts.app')
@section('content')
@if(session('fail'))
    <script>
        alert("{{session('fail')}}");
    </script>
@endif
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>会员注册</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/images/head.jpg" />
    </div><!--head-top/-->
    <form action="login.html" method="get" class="reg-login">
        <input type="hidden" id="_token" value="{{csrf_token()}}">
        <h3>已经有账号了？点此<a class="orange" href="login.html">登陆</a></h3>
        @csrf
        <div class="lrBox">
            <div class="lrList"><input type="text" name="user_email" class="email" placeholder="输入手机号码或者邮箱号" /></div>
            <div class="lrList2"><input type="text" name="user_code" class="code" placeholder="输入短信验证码" />
                <input type="button" class="button" value="获取验证码"></div>
            <div class="lrList"><input type="password" name="user_pwd" class="password" placeholder="设置新密码（6-18位数字或字母）" /></div>
            <div class="lrList"><input type="password" name="repwd" class="pwd" placeholder="再次输入密码" /></div>
        </div><!--lrBox/-->

        <div class="lrSub">
            <button class="submit">立即注册</button>
        </div>
    </form><!--reg-login/-->
    <div class="height1"></div>
    <div class="footNav">
        <dl>
            <a href="index.html">
                <dt><span class="glyphicon glyphicon-home"></span></dt>
                <dd>微店</dd>
            </a>
        </dl>
        <dl>
            <a href="/prolist/index">
                <dt><span class="glyphicon glyphicon-th"></span></dt>
                <dd>所有商品</dd>
            </a>
        </dl>
        <dl>
            <a href="car.html">
                <dt><span class="glyphicon glyphicon-shopping-cart"></span></dt>
                <dd>购物车 </dd>
            </a>
        </dl>
        <dl>
            <a href="user.html">
                <dt><span class="glyphicon glyphicon-user"></span></dt>
                <dd>我的</dd>
            </a>
        </dl>
        <div class="clearfix"></div>
    </div>
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
    $(function(){
        layui.use(['layer'],function(){
            var layer=layui.layer;
            var form=layui.form;
            var _token=$("#_token").val();
            // console.log(_token);
            $(document).on("click",".button",function(){
                var email=$(".email").val();
                // console.log(email);
                var reg=/^\w+@\w+\.com$/;
                if(email==''){
                    layer.msg('邮箱必填',{icon:2});
                    return false;
                }else if(!reg.test(email)){
                    layer.msg('填写正确的邮箱格式',{icon:2});
                    return false;
                }
                $.post(
                    "/login/sendemail",
                    {_token:_token,user_email:email},
                    function(res){
                        if(res.code==1){
                            layer.msg(res.font,{icon:res.code});
                        }
                    },
                    'json'
                )
                return false;
            })
            //注册邮箱
            $(document).on("click",".submit",function(){
                var email=$(".email").val();
                var pwd=$(".password").val();
                var code=$(".code").val();
                var repwd=$(".pwd").val();
                $.post(
                    "/login/regdo",
                    {_token:_token,user_email:email,user_code:code,user_pwd:pwd,repwd:repwd},
                    function(res){
                        layer.msg(res.font,{icon:res.code});
                        //console.log(res);
                    },
                    'json'
                );
                return false;
            })
        })
    })
</script>
@endsection
