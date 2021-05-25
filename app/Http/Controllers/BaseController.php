<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class BaseController extends Controller
{
    /**
     * 成功
     * @param $data
     * @param int $code
     * @param string $msg
     * @return false|string
     */
    public function success($data, $code = 200, $msg = '成功')
    {
        $data = [
            'code' => $code,
            'data' => $data,
            'msg' => $msg,
            'time' => time()
        ];
        return json_encode($data);
    }

    /**
     * 错误
     * @param string $msg
     * @param array $data
     * @param int $code
     * @return false|string
     */
    public function error($msg = '请求失败',$data=[],$code=500){
        $data = [
            'code' => $code,
            'data' => $data,
            'msg' => $msg,
            'time' => time()
        ];
        return json_encode($data);
    }
    /**
     * curl请求
     * @param $url
     * @param null $data
     * @return mixed
     */
    public function curl_request($url,$data = null)
    {
        $headerArray =array("Content-type:application/json;charset='utf-8'","Accept:application/json");
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        $output = curl_exec($curl);
        // 显示错误信息
        $res = false;
        if (curl_error($curl)) {
            Log::debug("Error: " . curl_error($curl));
        } else {
            // 打印返回的内容
            curl_close($curl);
            $res = json_decode($output,true);
        }
        return $res;
    }

}
