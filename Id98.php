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
     * Sends HTTP request.
     * @param string $method request type.
     * @param string $url request URL.
     * @param array $params request params.
     * @param array $headers additional request headers.
     * @return object response.
     * @throws Exception on failure.
     */
    protected function sendRequest($method, $url, array $params = [], array $headers = [])
    {
        $response = $request = $this->getHttpClient()->createRequest()
            ->setUrl($url)
            ->setMethod($method)
            ->setHeaders($headers)
            ->setData($params)
            ->send();
        if (!$response->isOk) {
            throw new Exception ('Http request failed.');
        }
        return $response;
    }

    /**
     * 身份证实名认证接口
     * @param string $name 姓名
     * @param string $cardno 身份证号码
     * @return array
     * @throws Exception
     */
    public function getIdCard($name, $cardno)
    {
        $response = $this->getHttpClient()->get('idcard', [
            'name' => $name,
            'cardno' => $cardno,
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