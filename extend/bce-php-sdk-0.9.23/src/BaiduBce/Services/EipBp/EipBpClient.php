<?php
/*
* Copyright 2017 Baidu, Inc.
*
* Licensed under the Apache License, Version 2.0 (the "License"); you may not
* use this file except in compliance with the License. You may obtain a copy of
* the License at
*
* Http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
* WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
* License for the specific language governing permissions and limitations under
* the License.
*/

namespace BaiduBce\Services\EipBp;

use BaiduBce\Auth\BceV1Signer;
use BaiduBce\BceBaseClient;
use BaiduBce\Http\BceHttpClient;
use BaiduBce\Http\HttpHeaders;
use BaiduBce\Http\HttpMethod;
use BaiduBce\Http\HttpContentTypes;


/**
 * This module provides a client class for EipBp.
 */
class EipBpClient extends BceBaseClient
{

    private $signer;
    private $httpClient;
    private $prefix = '/v1';

    /**
     * The EipBpClient constructor.
     *
     * @param array $config The client configuration
     */
    function __construct(array $config)
    {
        parent::__construct($config, 'eipbp');
        $this->signer = new BceV1Signer();
        $this->httpClient = new BceHttpClient();
    }

    /**
     * Create an eipBp with the specified options.
     *
     * @param string $eip
     *          the eip address that the eip_bp attach.
     * @param string $eipGroupId
     *          the eipgroupId that the eip_bp attach.
     * Param $eip and $eipGroupId will has only one param take effect.
     *
     * @param int $bandwidthInMbps
     *          specify the bandwidth in Mbps
     *
     * @param string $name
     *          name of eipBp. The optional parameter
     *
     * @param string $autoReleaseTime (UTC format,like yyyy:mm:ddThh:mm:ssZ)
     *          autoReleaseTime of eipBp. The optional parameter
     *
     * @param string $clientToken
     *          if the clientToken is not specified by the user, a random String
     *          generated by default algorithm will be used.
     *
     * @param array $options
     *          The optional bce configuration, which will overwrite the
     *          default configuration that was passed while creating EipBpClient instance.
     *
     * @return mixed
     */

    public function createEipBp($eip, $eipGroupId, $bandwidthInMbps, $name = null, $autoReleaseTime = null, $clientToken = null, $options = array())
    {
        list($config) = $this->parseOptions($options, 'config');
        $body = array();
        if (empty($bandwidthInMbps)) {
            throw new \InvalidArgumentException(
                '$bandwidthInMbps should not be empty.'
            );
        }
        if (empty($eip) && empty($eipGroupId)) {
            throw new \InvalidArgumentException(
                '$eip and $eipGroupId should not be empty at the same time.'
            );
        }

        $body['bandwidthInMbps'] = $bandwidthInMbps;

        if (!empty($eip)) {
            $body['eip'] = $eip;
        }
        if (!empty($eipGroupId)) {
            $body['eipGroupId'] = $eipGroupId;
        }
        if (!empty($name)) {
            $body['name'] = $name;
        }
        if (!empty($autoReleaseTime)) {
            $body['autoReleaseTime'] = $autoReleaseTime;
        }

        $params = array();
        if (empty($clientToken)) {
            $params['clientToken'] = $this->generateClientToken();
        } else {
            $params['clientToken'] = $clientToken;
        }

        return $this->sendRequest(
            HttpMethod::POST,
            array(
                'config' => $config,
                'params' => $params,
                'body' => json_encode($body),
            ),
            '/eipbp'
        );
    }

    /**
     * Resizing eipBp
     *
     * @param string $id
     *          eipbp's id to be resized
     *
     * @param int $newBandwidthInMbps
     *          specify new bandwidth in Mbps for eipBp
     *
     * @param string $clientToken
     *          if the clientToken is not specified by the user, a random String
     *          generated by default algorithm will be used.
     *
     * @param array $options
     *          The optional bce configuration, which will overwrite the
     *          default configuration that was passed while creating EipBpClient instance.
     *
     * @return mixed
     */
    public function resizeEipBp($id, $newBandwidthInMbps, $clientToken = null, $options = array())
    {
        list($config) = $this->parseOptions($options, 'config');
        if (empty($id)) {
            throw new \InvalidArgumentException(
                '$id should not be empty.'
            );
        }
        if (empty($newBandwidthInMbps)) {
            throw new \InvalidArgumentException(
                '$newBandwidthInMbps should not be empty.'
            );
        }
        $body = array();
        $body['bandwidthInMbps'] = $newBandwidthInMbps;
        $params = array();
        $params['resize'] = null;
        if (empty($clientToken)) {
            $params['clientToken'] = $this->generateClientToken();
        } else {
            $params['clientToken'] = $clientToken;
        }

        return $this->sendRequest(
            HttpMethod::PUT,
            array(
                'config' => $config,
                'params' => $params,
                'body' => json_encode($body),
            ),
            '/eipbp/' . $id
        );
    }

    /**
     * Get eipBp's detail  owned by the authenticated user and specified conditions.
     *
     * @param string $id
     *          eipBp 's id conditions
     *
     * @return mixed
     */
    public function getEipBp($id, $options = array())
    {
        list($config) = $this->parseOptions($options, 'config');
        if (empty($id)) {
            throw new \InvalidArgumentException(
                '$id should not be empty.'
            );
        }
        return $this->sendRequest(
            HttpMethod::GET,
            array(
                'config' => $config
            ),
            '/eipbp' . $id
        );
    }

    /**
     * Get a list of eipBp owned by the authenticated user and specified conditions.
     * we can Also get a single eipBp function  through this interface by eipBp condition
     *
     * @param string $id
     *          eipBp 's id conditions
     *
     * @param string $name
     *          eipBp 's name condition
     *
     * @param string $bindType
     *          eipBp 's bindType condition, 'eip' or 'eipgroup'
     *
     * @param string $marker
     *          The optional parameter marker specified in the original request to specify
     *          where in the results to begin listing.
     *
     * @param int $maxKeys
     *          The optional parameter to specifies the max number of list result to return.
     *          The default value is 1000.
     *
     * @param array $options
     *           The optional bce configuration, which will overwrite the
     *          default configuration that was passed while creating EipBpClient instance.
     *
     * @return mixed
     */
    public function listEipBps($id = null, $name = null, $bindType = null, $marker = null, $maxKeys = 1000,
                               $options = array())
    {
        list($config) = $this->parseOptions($options, 'config');
        $params = array();
        if ($id !== null) {
            $params['id'] = $id;
        }
        if ($name !== null) {
            $params['name'] = $name;
        }
        if ($bindType !== null) {
            $params['bindType'] = $bindType;
        }
        if ($marker !== null) {
            $params['marker'] = $marker;
        }
        if ($maxKeys !== null) {
            $params['maxKeys'] = $maxKeys;
        }

        return $this->sendRequest(
            HttpMethod::GET,
            array(
                'config' => $config,
                'params' => $params,
            ),
            '/eipbp'
        );
    }

    /**
     * Update eipBp's autoReleaseTime
     *
     * @param string $id
     *          eipBp's id to be update autoReleaseTime
     *
     * @param string $autoReleaseTime
     *          specify auto_release_time for eipBp(UTC format,like yyyy:mm:ddThh:mm:ssZ)
     *
     * @param string $clientToken
     *          if the clientToken is not specified by the user, a random String
     *          generated by default algorithm will be used.
     *
     * @param array $options
     *          The optional bce configuration, which will overwrite the
     *          default configuration that was passed while creating EipBpClient instance.
     *
     * @return mixed
     */
    public function updateEipBpAutoReleaseTime($id, $autoReleaseTime, $clientToken = null, $options = array())
    {
        list($config) = $this->parseOptions($options, 'config');
        if (empty($id)) {
            throw new \InvalidArgumentException(
                '$id should not be empty.'
            );
        }
        if (empty($autoReleaseTime)) {
            throw new \InvalidArgumentException(
                '$autoReleaseTime should not be empty.'
            );
        }
        $body = array();
        $body['autoReleaseTime'] = $autoReleaseTime;
        $params = array();
        $params['retime'] = null;
        if (empty($clientToken)) {
            $params['clientToken'] = $this->generateClientToken();
        } else {
            $params['clientToken'] = $clientToken;
        }

        return $this->sendRequest(
            HttpMethod::PUT,
            array(
                'config' => $config,
                'params' => $params,
                'body' => json_encode($body),
            ),
            '/eipbp/' . $id
        );
    }


    /**
     * Update eipBp's autoReleaseTime
     *
     * @param string $id
     *          eipBp's id to be rename
     *
     * @param string $name
     *          eipBp's name
     *
     * @param string $clientToken
     *          if the clientToken is not specified by the user, a random String
     *          generated by default algorithm will be used.
     *
     * @param array $options
     *          The optional bce configuration, which will overwrite the
     *          default configuration that was passed while creating EipBpClient instance.
     *
     * @return mixed
     */
    public function renameEipBp($id, $name, $clientToken = null, $options = array())
    {
        list($config) = $this->parseOptions($options, 'config');
        if (empty($id)) {
            throw new \InvalidArgumentException(
                '$id should not be empty.'
            );
        }
        if (empty($name)) {
            throw new \InvalidArgumentException(
                '$name should not be empty.'
            );
        }
        $body = array();
        $body['name'] = $name;
        $params = array();
        $params['rename'] = null;
        if (empty($clientToken)) {
            $params['clientToken'] = $this->generateClientToken();
        } else {
            $params['clientToken'] = $clientToken;
        }

        return $this->sendRequest(
            HttpMethod::PUT,
            array(
                'config' => $config,
                'params' => $params,
                'body' => json_encode($body),
            ),
            '/eipbp/' . $id
        );
    }

    /**
     * Release the eipBp(delete operation)
     *
     * @param string $id
     *          eipBp's id to be released
     *
     * @param string $clientToken
     *          if the clientToken is not specified by the user, a random String
     *          generated by default algorithm will be used.
     *
     * @param array $options
     *          The optional bce configuration, which will overwrite the
     *          default configuration that was passed while creating EipBpClient instance.
     *
     * @return mixed
     */
    public function releaseEipBp($id, $clientToken = null, $options = array())
    {
        list($config) = $this->parseOptions($options, 'config');
        if (empty($clientToken)) {
            $clientToken = $this->generateClientToken();
        }
        $params = array();
        $params['clientToken'] = $clientToken;

        return $this->sendRequest(
            HttpMethod::DELETE,
            array(
                'config' => $config,
                'params' => $params,
            ),
            '/eipbp/' . $id
        );
    }

    /**
     * Create HttpClient and send request
     *
     * @param string $httpMethod
     *          The Http request method
     *
     * @param array $varArgs
     *          The extra arguments
     *
     * @param string $requestPath
     *          The Http request uri
     *
     * @return mixed The Http response and headers.
     */
    private function sendRequest($httpMethod, array $varArgs, $requestPath = '/')
    {
        $defaultArgs = array(
            'config' => array(),
            'body' => null,
            'headers' => array(),
            'params' => array(),
        );

        $args = array_merge($defaultArgs, $varArgs);
        if (empty($args['config'])) {
            $config = $this->config;
        } else {
            $config = array_merge(
                array(),
                $this->config,
                $args['config']
            );
        }
        if (!isset($args['headers'][HttpHeaders::CONTENT_TYPE])) {
            $args['headers'][HttpHeaders::CONTENT_TYPE] = HttpContentTypes::JSON;
        }
        $path = $this->prefix . $requestPath;
        $response = $this->httpClient->sendRequest(
            $config,
            $httpMethod,
            $path,
            $args['body'],
            $args['headers'],
            $args['params'],
            $this->signer
        );

        $result = $this->parseJsonResult($response['body']);

        return $result;
    }

    /**
     * The default method to generate the random String for clientToken if the optional parameter clientToken
     * is not specified by the user.
     *
     * The default algorithm is Mersenne Twister to generate a random UUID,
     * @return String An random String generated by Mersenne Twister.
     */
    public static function generateClientToken()
    {
        $uuid = md5(uniqid(mt_rand(), true));
        return $uuid;
    }
}