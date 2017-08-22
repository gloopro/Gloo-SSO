<?php
/**
 *
 * This file is part of Gloo SSO
 * Created by dave
 * Copyright © Gloo.ng. All rights reserved.
 * Check composer.json for license details
 *
 */

namespace Gloo\SSO\Controller;

use Magento\Framework\App\Action\Action;

abstract class Auth extends Action{

    /**
     * @var  \League\OAuth2\Client\Provider\ProviderInterface
     */
    protected $client;

    private $code;

    abstract protected function initClient();

    protected function getAccessCode(){
        if(!$this->code){
            $this->code = $this->getRequest()->getParam('code');
        }
        return $this->code;
    }

    protected function getAccessToken($accessCode){

        return $this->client->getAccessToken('authorization_code',['code'=>$accessCode]);
    }


    protected function getAuthClient(){
        return $this->client;
    }

    protected function authenticate(){

    }

}
