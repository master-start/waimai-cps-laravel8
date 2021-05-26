<?php

namespace App\Http\Controllers;

use App\Http\Factory\Wechat;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MiniProgramController extends BaseController
{
    /**
     * 用户登陆
     * @param Request $request
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function login(Request $request){
        $code = $request->input('code');
        $res = Wechat::miniProgram()->server()->auth->session($code);
        $token = Crypt::encryptString($res['openid']);
        $res['remember_token'] = $token;
        UserController::server($res);
        $res['token'] = $token;
        return $this->success($res);
    }

    /**
     * 分享小程序个人二维码
     * @param Request $request
     * @return false|string
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     */
    public function wxQrcode(Request $request){
        $token = $request->input('token');
        $data = Crypt::decryptString($token);
        $user = UserController::info($data);
        $user_id = isset($user->id)?$user->id:0;
        $response = Wechat::miniProgram()->server()->app_code->getUnlimit('?lv_1_id='.$user_id, [
            'page'  => 'pages/index/index',
            'width' => 600,
        ]);
        $filename = '';
        // 保存小程序码到文件
        if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
            $filename = $response->saveAs('pages/index/index', 'appcode'.$user_id.'.png');
        }
        $res['img'] = $filename;
        return $this->success($res);
    }
    /**
     * 获取用户信息
     * @param Request $request
     * @return false|string
     */
    public function info(Request $request){
        $token = $request->input('token');
        $data = Crypt::decryptString($token);
        $res = UserController::info($data);
        return $this->success($res);
    }

    public function get_ele_url(Request $request){
        $res['wx_qrcode_url'] = 'https://gqrcode.alicdn.com/img?type=hv&text=https%3A%2F%2Fs.click.ele.me%2FsWtCTnu%3Faf%3D3%26union_lens%3DlensId%253AOPT%25401622017324%2540210584ee_07ce_179a7c43646_0413%254001%253BeventPageId%253A20150318020002597%26&h=300&w=300';
        $res['wx_miniprogram_path'] = 'pages/sharePid/web/index?scene=https://s.click.ele.me/sWtCTnu';
        $res['appid'] = 'wxece3a9a4c82f58c9';
        $data['data'] = $res;
        return $this->success($data);
    }
    /**
     * 获取相关设置
     * @param Request $request
     * @return false|string
     */
    public function setting(Request $request){
        $token = $request->input('token');
        if (!empty($token)){
            $data = Crypt::decryptString($token);
            $res = UserController::info($data);
            if (!empty($res)){
                $res = json_decode($res,true);
            }
        }
        $res['appid'] = env('WECHAT_MINI_PROGRAM_APPID');
        $res['app_name'] = '外卖优惠券';
        $res['official_account_appid'] = env('WECHAT_MINI_PROGRAM_APPID');
        $res['official_account_qrcode'] = 'https://chongkelai.oss-accelerate.aliyuncs.com/images/17/2021/05/hZ3q9Tbo9Ot29tlZYmMzMcoBTta527.jpeg';
        $res['open_share'] = 1;
        $res['is_pay'] = 0; //0=off,1=on
        $res['min_take_out'] = 1;
        $res['poster_bg'] = 'https://cps.open-shop.cn/img/1615987229.png';
        $res['share_content_ele'] = '饿了么餐前福利！外卖红包天天领，最高可得66元！';
        $res['share_content_meituan'] = '美团餐前福利！外卖红包天天领，最高可得66元！';
        $res['share_title'] = '天天来领外卖优惠券！';
        $res['take_out_ratio'] = 0;
        $res['tbk_r_id'] = 0; //是否绑定了淘宝客
        $res['tbk_name'] = 0; //淘宝客昵称

        return $this->success($res);
    }

    /**
     * 获取美团推广二维码
     * @param Request $request
     * @return false|string
     */
    public function get_meituan_qrcode(Request $request){
        $actId = $request->input('actId');
        $token = $request->input('token');
        $data = Crypt::decryptString($token);
        $res = UserController::info($data);
        $meiTuan = new MeiTuanController(null,$actId);
        $res = $meiTuan->miniCode();
        if ($res['status'] == 0 && !empty($res['data'])){
            return $this->success($res['data']);
        }else{
            return $this->error($res['des']);
        }
    }

    /**
     * 获取美团推广链接
     * @param Request $request
     * @return false|string
     */
    public function get_meituan_url(Request $request){
        $actId = $request->input('actId');
        $linkType = $request->input('linkType');
        $token = $request->input('token');
        $data = Crypt::decryptString($token);
        $res = UserController::info($data);
        $meiTuan = new MeiTuanController(null,$actId);
        $res = $meiTuan->generateLink($linkType);
        if ($res['status'] == 0 && !empty($res['data'])){
            return $this->success($res['data']);
        }else{
            return $this->error($res['des']);
        }
    }

}
