<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace xutl\id98;

use Yii;
use yii\base\Component;
use yii\httpclient\Client;
use yii\httpclient\Exception;
use yii\base\InvalidConfigException;

/**
 * ID98 接口
 */
class Id98 extends Component
{
    public $baseUrl = 'http://api.id98.cn/api';

    /**
     * @var string ApiKey
     */
    public $apiKey;

    /**
     * @var Client
     */
    public $_httpClient;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (empty ($this->apiKey)) {
            throw new InvalidConfigException ('The "apiKey" property must be set.');
        }
    }

    /**
     * 获取Http Client
     * @return Client
     */
    public function getHttpClient()
    {
        if (!is_object($this->_httpClient)) {
            $this->_httpClient = new Client([
                'baseUrl' => $this->baseUrl,
                'responseConfig' => [
                    'format' => Client::FORMAT_JSON
                ],
            ]);
        }
        return $this->_httpClient;
    }

    /**
     * 银行卡号+姓名验证+身份证号+预留手机号
     * @param string $bankcardNo 银行卡号
     * @param string $name 持卡人姓名
     * @param string $idCardNo 身份证号码
     * @param string $tel 预留手机号
     * @return array
     */
    public function getBankcard($bankcardNo, $name, $idCardNo, $tel)
    {
        $response = $this->getHttpClient()->get('v2/bankcard', [
            'bankcardno' => $bankcardNo,
            'name' => $name,
            'idcardno' => $idCardNo,
            'tel' => $tel,
            'appkey' => $this->apiKey,
            'output' => 'json',
        ])->send();
        $result = [];
        if (!$response->isOk || $response->data['isok'] == 0) {
            $result['success'] = false;
        } else if ($response->data['isok'] == 1) {
            $result['success'] = true;
            $result['data'] = $response->data['code'];
        }
        return $result;
    }

    /**
     * 银行卡号+姓名验证
     * @param string $bankcardNo 银行卡号
     * @param string $name 持卡人姓名
     * @return array
     */
    public function getBankcardByName($bankcardNo, $name)
    {
        $response = $this->getHttpClient()->get('v2/bankcard', [
            'bankcardno' => $bankcardNo,
            'name' => $name,
            'appkey' => $this->apiKey,
            'output' => 'json',
        ])->send();
        $result = [];
        if (!$response->isOk || $response->data['isok'] == 0) {
            $result['success'] = false;
        } else if ($response->data['isok'] == 1) {
            $result['success'] = true;
            $result['data'] = $response->data['code'];
        }
        return $result;
    }

    /**
     * 银行卡号+姓名验证+电话
     * @param string $bankcardNo 银行卡号
     * @param string $name 持卡人姓名
     * @param string $tel 预留手机号
     * @return array
     */
    public function getBankcardByNameAndTel($bankcardNo, $name, $tel)
    {
        $response = $this->getHttpClient()->get('v2/bankcard', [
            'bankcardno' => $bankcardNo,
            'name' => $name,
            'tel' => $tel,
            'appkey' => $this->apiKey,
            'output' => 'json',
        ])->send();
        $result = [];
        if (!$response->isOk || $response->data['isok'] == 0) {
            $result['success'] = false;
        } else if ($response->data['isok'] == 1) {
            $result['success'] = true;
            $result['data'] = $response->data['code'];
        }
        return $result;
    }

    /**
     * 银行卡号+姓名验证+身份证号
     * @param string $bankcardNo 银行卡号
     * @param string $name 持卡人姓名
     * @param string $idCardNo 身份证号码
     * @return array
     */
    public function getBankcardByNameAndIdCard($bankcardNo, $name, $idCardNo)
    {
        $response = $this->getHttpClient()->get('v2/bankcard', [
            'bankcardno' => $bankcardNo,
            'name' => $name,
            'idcardno' => $idCardNo,
            'appkey' => $this->apiKey,
            'output' => 'json',
        ])->send();
        $result = [];
        if (!$response->isOk || $response->data['isok'] == 0) {
            $result['success'] = false;
        } else if ($response->data['isok'] == 1) {
            $result['success'] = true;
            $result['data'] = $response->data['code'];
        }
        return $result;
    }

    /**
     * 银行卡号+身份证验证
     * @param string $bankcardNo 银行卡号
     * @param string $idCardNo 身份证号码
     * @return array
     */
    public function getBankcardByIdCard($bankcardNo, $idCardNo)
    {
        $response = $this->getHttpClient()->get('v2/bankcard', [
            'bankcardno' => $bankcardNo,
            'idcardno' => $idCardNo,
            'appkey' => $this->apiKey,
            'output' => 'json',
        ])->send();
        $result = [];
        if (!$response->isOk || $response->data['isok'] == 0) {
            $result['success'] = false;
        } else if ($response->data['isok'] == 1) {
            $result['success'] = true;
            $result['data'] = $response->data['code'];
        }
        return $result;
    }

    /**
     * 银行卡号+身份证+手机号
     * @param string $bankcardNo 银行卡号
     * @param string $idCardNo 身份证号码
     * @param string $tel 预留手机号
     * @return array
     */
    public function getBankcardByIdCardAndTel($bankcardNo, $idCardNo, $tel)
    {
        $response = $this->getHttpClient()->get('v2/bankcard', [
            'bankcardno' => $bankcardNo,
            'idcardno' => $idCardNo,
            'tel' => $tel,
            'appkey' => $this->apiKey,
            'output' => 'json',
        ])->send();
        $result = [];
        if (!$response->isOk || $response->data['isok'] == 0) {
            $result['success'] = false;
        } else if ($response->data['isok'] == 1) {
            $result['success'] = true;
            $result['data'] = $response->data['code'];
        }
        return $result;
    }

    /**
     * 银行卡号+预留手机号
     * @param string $bankcardNo 银行卡号
     * @param string $tel 预留手机号
     * @return array
     */
    public function getBankcardByTel($bankcardNo, $tel)
    {
        $response = $this->getHttpClient()->get('v2/bankcard', [
            'bankcardno' => $bankcardNo,
            'tel' => $tel,
            'appkey' => $this->apiKey,
            'output' => 'json',
        ])->send();
        $result = [];
        if (!$response->isOk || $response->data['isok'] == 0) {
            $result['success'] = false;
        } else if ($response->data['isok'] == 1) {
            $result['success'] = true;
            $result['data'] = $response->data['code'];
        }
        return $result;
    }

    /**
     * 手机号实名认证
     * @param string $name 姓名
     * @param string $cardNo 身份证号码
     * @param string $phone 手机号
     * @return array
     */
    public function getCallPhone($name, $cardNo, $phone)
    {
        $response = $this->getHttpClient()->get('cellphone', [
            'name' => $name,
            'cardno' => $cardNo,
            'phone' => $phone,
            'appkey' => $this->apiKey,
            'output' => 'json',
        ])->send();
        $result = [];
        if (!$response->isOk || $response->data['isok'] == 0) {
            $result['success'] = false;
        } else if ($response->data['isok'] == 1) {
            $result['success'] = true;
            $result['data'] = $response->data['code'];
        }
        return $result;
    }

    /**
     * 身份证实名认证接口
     * @param string $name 姓名
     * @param string $cardNo 身份证号码
     * @return array
     * @throws Exception
     */
    public function getIdCard($name, $cardNo)
    {
        $response = $this->getHttpClient()->get('idcard', [
            'name' => $name,
            'cardno' => $cardNo,
            'appkey' => $this->apiKey,
            'output' => 'json',
        ])->send();
        $result = [];
        if (!$response->isOk || $response->data['isok'] == 0) {
            $result['success'] = false;
        } else if ($response->data['isok'] == 1) {
            $result['success'] = true;
            $result['data'] = $response->data['code'];
        }
        return $result;
    }
}