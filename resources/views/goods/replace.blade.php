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