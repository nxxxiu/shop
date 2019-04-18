@extends('layouts.app')
@section('content')
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>收货地址</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/images/head.jpg" />
    </div><!--head-top/-->
    <form onsubmit="return false" class="reg-login">
        <input type="hidden" id="_token" value="{{csrf_token()}}">
        <div class="lrBox">
            <div class="lrList"><input type="text" name="address_name" id="address_name" placeholder="收货人" /></div>
            <div class="lrList"><input type="text" name="address_detail" id="address_detail" placeholder="详细地址" /></div>
            <div class="lrList">
                <select id="province" class="area">
                    <option value="" selected="selected">省/直辖市</option>
                    @foreach($addressInfo as $k=>$v)
                        <option value="{{$v->id}}">{{$v->name}}</option>
                    @endforeach
                </select>

                <select id="city" class="area">
                    <option value="" selected="selected">市</option>
                </select>

                <select id="area" class="area">
                    <option value="" selected="selected">区</option>
                </select>
            </div>
            <div class="lrList"><input type="tel" name="address_tel" id="address_tel" placeholder="手机" /></div>
            <div class="lrList2">
                <input type="checkbox" placeholder="设为默认地址" id="is_default"><button>设为默认</button>
            </div>
        </div><!--lrBox/-->
        <div class="lrSub">
            <input type="submit" id="sub" value="保存" />
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
    <script>
    $('.spinnerExample').spinner({});
    $(function () {
        layui.use('layer',function(){
            var layer=layui.layer;
            _token=$('#_token').val();
            //三级联动
            $(document).on('change','.area',function () {
                var _this=$(this);
                var id=_this.children();
                var _option="<option selected value='0'>---请选择---</option>";
                id.each(function(index){
                    if($(this).prop('selected')==true){
                        id=$(this).val();
                    }
                })
                $.post(
                    "/address/getarea",
                    {_token:_token,id:id},
                    function(res){
                        for(i in res['area']){
                            _option+='<option value="'+res['area'][i]['id']+'">'+res['area'][i]['name']+'</option>';
                        }
                        _this.nextAll().html(_option);
                    },
                    'json'
                )
            })

            //添加
            $(document).on('click','#sub',function () {
                var obj={};
                obj._token=_token;
                obj.province=$('#province').val();
                obj.city=$('#city').val();
                obj.area=$('#area').val();
                obj.address_name=$('#address_name').val();
                obj.address_detail=$('#address_detail').val();
                obj.address_tel=$('#address_tel').val();
                var is_default=$('#is_default').prop('checked');
                // console.log(obj);
                if(is_default==true){
                    obj.is_default=1;
                }else{
                    obj.is_default=2;
                }
                //验证
                if(obj.address_name==''){
                    layer.msg('收货人姓名不能为空',{icon:2});
                    return false;
                }else if (obj.address_detail=='') {
                    layer.msg('地址详情不能为空',{icon:2});
                    return false;
                }else if (obj.address_tel=='') {
                    layer.msg('收货人手机不能为空',{icon:2});
                    return false;
                }else if (obj.province=='') {
                    layer.msg('请填写完整的收获地址',{icon:2});
                    return false;
                }else if (obj.city=='') {
                    layer.msg('请填写完整的收获地址',{icon:2});
                    return false;
                }else if (obj.area=='') {
                    layer.msg('请填写完整的收获地址',{icon:2});
                    return false;
                }
                //添加
                $.post(
                    "/address/addressdo",
                    obj,
                    function (res) {
                        layer.msg(res.font,{icon:res.code,time:2000},function(){
                            if (res.code==1){
                                location.href="/user/address";
                            }
                        });
                    },
                    'json'
                )
            })
        })
    })
</script>
@endsection