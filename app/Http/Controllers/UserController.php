<?php
namespace App\Http\Controllers;

use App\Banner;
use App\User;

class UserController extends BaseController
{
    /**
     * 幻灯片广告
     * @return false|string
     */
    public function banner(){
        $data = Banner::orderBy('index','asc')->get();
        return $this->success($data);
    }

    /**
     * 根据openid或手机号获取用户信息
     * @param $data
     * @return mixed
     */
    public static function info($data){
        return User::where('openid',$data)
            ->orwhere('mobile',$data)
            ->first();
    }
    /**
     * 用户注册和更新
     * @param $data
     */
    public static function server($data){
        if (!empty($data['openid'])){
            $user = User::where('openid',$data['openid'])->first();
        }
        if (!empty($data['mobile'])){
            $user = User::where('mobile',$data['mobile'])->first();
        }
        if (empty($user)){
            $user = new User();
        }
        $username = isset($data['username'])?$data['username']:null;
        $openid = isset($data['openid'])?$data['openid']:null;
        $avatar = isset($data['avatar'])?$data['avatar']:null;
        $user->openid = $openid;
        $user->avatar = $avatar;
        $user->username = $username;
        $user->mobile = isset($data['mobile'])?$data['mobile']:null;
        $user->session_key = isset($data['session_key'])?$data['session_key']:null;
        $user->password = isset($data['password'])?$data['password']:null;
        $user->remember_token = isset($data['remember_token'])?$data['remember_token']:null;
        $user->save();
    }
}
