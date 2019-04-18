@extends('layouts.app')
@section('content')
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>收货地址</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/images//head.jpg" />
    </div><!--head-top/-->
    <table class="shoucangtab">
        <tr>
            <td width="75%"><a href="/address/address" class="hui"><strong class="">+</strong> 新增收货地址</a></td>
            <td width="25%" align="center" style="background:#fff url(/images//xian.jpg) left center no-repeat;"><a href="javascript:;" class="orange">删除信息</a></td>
        </tr>
    </table>
    <div class="dingdanlist">
        <table>
            @foreach($data as $k=>$v)
            <tr>
                <td width="50%">
                    <h3>{{$v->address_name}}&nbsp;&nbsp;{{$v->address_tel}}</h3>
                    <time>{{$v->address_detail}}</time>
                </td>
                <td align="right"><a href="javascript:;" class="hui"><span class="glyphicon glyphicon-check"></span> 修改信息</a></td>
            </tr>
            @endforeach
        </table>
    </div><!--dingdanlist/-->
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
    $('.spinnerExample').spinner({});
</script>
@endsection