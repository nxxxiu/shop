<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserPost;
use Illuminate\Support\Facades\Mail;
class LoginController extends Controller
{
    //注册
    public function register()
    {
        return view('login/register');
    }

    //注册执行
    public function regdo(StoreUserPost $request){
        $data=$request->all();
        unset($data['_token']);
        unset($data['repwd']);
        $model=new \App\User;
        $data['user_pwd']=encrypt($data['user_pwd']);
        foreach($data as $k=>$v){
            $model->$k=$v;
        }
        $res=$model->save();
//        dump($res);
        if($res){
            return redirect('/index/index')->with('message', '注册成功!');
        }
    }

    //发送邮件
    public function sendemail(Request $request){
//        dd(request()->user_email);
        $code=rand(100000,999999);
        $flag=Mail::send('/login/email',['data'=>$code],function ($message){
            $message->to(request()->user_email)->subject('验证码');
        });
        if($flag!==false){
            $arr=[
                'font'=>'验证码发送成功',
                'code'=>1
            ];
            session(['code'=>$code]);
            echo json_encode($arr);
        }else{
            $arr=[
                'font'=>'验证码发送失败',
                'code'=>2
            ];
            session(['code'=>$code]);
            echo json_encode($arr);
        }
    }

    //登录
    public function login()
    {
        return view('login/login');
    }

    //登录执行
    public function logindo(Request $request){
        $data=$request->all();
//        dd($data);
        $model=new \App\User;
        $info=$model->where('user_email',$data['user_email'])->first();
//        dd($info);
        if(empty($info)){
            return redirect('login/login')->with('fail','邮箱或密码不正确');
        }else{
            if($data['user_pwd']!==decrypt($info['user_pwd'])){
                return redirect('login/login')->with('fail','邮箱或密码不正确');
            }else{
                session(['user'=>['user_email'=>$data['user_email'],'user_id'=>$info['user_id']]]);
                return redirect('index/index')->with('message','登录成功');
            }
        }
    }

    //退出
    public function quit()
    {
        request()->session()->flush();
        return redirect('/goods/index');
    }
}
