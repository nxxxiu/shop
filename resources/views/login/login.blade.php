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
    <form action="/login/logindo" method="post" class="reg-login">
        @csrf
        <h3>还没有三级分销账号？点此<a class="orange" href="/login/register">注册</a></h3>
        <div class="lrBox">
            <div class="lrList"><input type="text" id="email" name="user_email" placeholder="输入邮箱" /></div>
            <div class="lrList"><input type="password" id="pwd" name="user_pwd" placeholder="输入密码" /></div>
        </div><!--lrBox/-->
        <div class="lrSub">
            <input type="submit" id="sub" value="立即登录" />
        </div>
    </form><!--reg-login/-->
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
    <script type="text/javascript">
    $(function(){
        layui.use('layer',function(){
            //点击提交
            $('#sub').click(function(){
                var _form=$('form');
                var pwd=$('#pwd').val();
                if($('#email').val()==''){
                    layer.msg('邮箱必填',{icon:2})
                    _form.attr('onsubmit','return false');
                    return false;
                }else{
                    _form.attr('onsubmit','return true');
                }
                if(pwd==''){
                    layer.msg('密码必填',{icon:2})
                    _form.attr('onsubmit','return false');
                    return false
                }else{
                    _form.attr('onsubmit','return true');
                }
            })
        })
    })
</script>
@endsection