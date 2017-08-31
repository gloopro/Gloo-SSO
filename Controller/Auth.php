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

use Gloo\SSO\Model\AuthInterface;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Magento\Customer\Model\Data\Customer;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

abstract class Auth extends Action{

    /**
     * @var  AbstractProvider
     */
    protected $client;

    protected $authModel;

    private $code;

    abstract protected function initClient();

    public function __construct(Context $context, AuthInterface $authModel)
    {
        $this->authModel  = $authModel;
        parent::__construct($context);
    }

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

    protected function authenticate(Customer $customer){

       if(!$this->authModel->userEmailIsAssociated($customer->getEmail())){
           $this->authModel->createAccount($customer);
       }
    }

}
