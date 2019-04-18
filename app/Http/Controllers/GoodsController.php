<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class GoodsController extends Controller
{
    public function index(Request $request)
    {
        $model=new \App\Goods;
        $where=[];
        if ($request->search??''){
            $where[]=['goods_name','like',"%".$request->search."%"];
        }
        $arr=$model->where($where)->get();
        return view('goods/goodslist',compact('arr'));
    }

    //重新获取商品
    public function getNewGoods(Request $request)
    {
        $model=new \App\Goods;
        $status=$request->status??'';
        $where=[];
        if ($status==1){
            $where['is_new']=1;
        }else if($status==2){
            $where['is_best']=1;
        }
        if($request->search??''){
            $where[]=['goods_name','like',"%".$request->search."%"];
        }
        if ($status==3){
            $arr=$model->where($where)->orderBy('self_price',$request->order)->get();
        }else{
            $arr=$model->where($where)->get();
        }
//        var_dump($where);
        return view('/goods/replace',compact('arr'));
    }

    //商品详情
    public function goodsdetail($id)
    {
        $model=new \App\Goods;
        $arr=$model->where('goods_id',$id)->first();
//        $goods_imgs=explode('|',$arr['goods_imgs']);
//        unset($goods_imgs[count($goods_imgs)-1]);
//        var_dump($goods_imgs);die;
        return view('goods/goodsdetail',compact('arr'));
    }
}
