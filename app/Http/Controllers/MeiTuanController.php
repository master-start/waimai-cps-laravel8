<?php
namespace App\Http\Controllers;

class MeiTuanController extends BaseController
{

    protected $url = 'https://runion.meituan.com/';

    protected $secret = '9306c46f08ccaa69b5355454fde38b3a';

    protected $appkey = '9bf50bad77e7f29516bcb5892caec459';

    protected $sid = 'ad1';

    protected $actId = 2;

    public function __construct($sid = null,$actId = null)
    {
        if (!empty($sid)){
            $this->sid = $sid;
        }
        if (!empty($actId)){
            $this->actId = $actId;
        }
    }

    /**
     * 自助取链接口
     * @param int $linkType
     * @return false|mixed
     */
    public function generateLink(int $linkType = 4){
        $param = [
            'actId' => $this->actId,
            'key' => $this->appkey,
            'sid' => $this->sid,
            'linkType' => $linkType,
        ];
        $param['sign'] = $this->genSign($param);
        $param = http_build_query($param);
        $url = $this->url.'generateLink?'.$param;
        $result = $this->curl_request($url);
        return $result;
    }

    /**
     * 领券结果查询
     * @param int $type 目前只支持4外卖、5话费、6闪购订单类型查询
     * 0 团购订单 2 酒店订单 4 外卖订单 5 话费订单 6 闪购订单
     * @return false|mixed
     */
    public function couponList(int $type){
        $param = [
            'key' => $this->appkey,
            'ts' => time(),
            'type' => $type,
            'startTime' => time() - 30 * 24 * 3600,
            'endTime' => time(),
            'page' => 1,
            'limit' => 10,
            'sid' => $this->sid
        ];
        $param['sign'] = $this->genSign($param);
        $param = http_build_query($param);
        $url = $this->url.'api/couponList?'.$param;
        $result = $this->curl_request($url);
        return $result;
    }

    /**
     * 订单列表查询(新)
     * @param $type
     * @return false|mixed
     */
    public function orderList($type){
        $param = [
            'key' => $this->appkey,
            'ts' => time(),
            'type' => $type,
            'startTime' => time() - 30 * 24 * 3600,
            'endTime' => time(),
            'page' => 1,
            'limit' => 10,
            'sid' => $this->sid
        ];
        $param['sign'] = $this->genSign($param);
        $param = http_build_query($param);
        $url = $this->url.'api/orderList?'.$param;
        $result = $this->curl_request($url);
        return $result;
    }

    /**
     * 小程序二维码生成
     * @return false|mixed
     */
    public function miniCode(){
        $param = [
            'key' => $this->appkey,
            'sid' => $this->sid, //渠道方用户唯一标识
            'actId' => $this->actId,
        ];
        $param['sign'] = $this->genSign($param);
        $param = http_build_query($param);
        $url = $this->url.'miniCode?'.$param;
        $result = $this->curl_request($url);
        return $result;
    }

    /**
     * 生成签名
     * @param $params
     * @return string
     */
    public function genSign($params)
    {
        $secret = $this->secret;
        unset($params["sign"]);
        ksort($params);
        $str = $secret; // $secret为分配的密钥
        foreach($params as $key => $value) {
            $str .= $key . $value;
        }
        $str .= $secret;
        $sign = md5($str);
        return $sign;
    }
}
