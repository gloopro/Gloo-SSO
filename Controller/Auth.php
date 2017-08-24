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

use Gloo\SSO\Auth\AuthTrait;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Magento\Framework\App\Action\Action;

abstract class Auth extends Action{
    use AuthTrait;

    const NAME = "name";
    const FIRST_NAME = "first_name";
    const LAST_NAME = "last_name";
    const GENDER = "gender";
    const EMAIL = "email";

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

    protected function authenticate(ResourceOwnerInterface $resourceOwner){
        if(!$this->userEmailIsAssociated($resourceOwner->toArray()["email"])){
            $this->createUserAccount($resourceOwner);
        }
    }
}
