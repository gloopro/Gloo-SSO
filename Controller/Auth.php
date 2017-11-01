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
use Gloo\SSO\PageCache\Version;
use Magento\Customer\Model\Data\Customer;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\EmailNotConfirmedException;
use Magento\Framework\Exception\State\UserLockedException;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Account\Redirect;

abstract class Auth extends Action{

    /**
     * @var  AbstractProvider
     */
    protected $client;

    protected $authModel;

    protected $session;

    protected $accountRedirect;

    protected $redirectUrl = null;

    private $cookieMetadataManager;

    private $cookieMetadataFactory;

    private $scopeConfig;

    private $code;

    /**
     * @var Version
     */
    private $version;

    abstract protected function initClient();

    public function __construct
    (
        Context $context,
        AuthInterface $authModel,
        Session $session,
        Redirect $accountRedirect
    )
    {
        $this->authModel  = $authModel;
        $this->session = $session;
        $this->accountRedirect = $accountRedirect;
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
            $customer = $this->authModel->createAccount($customer);
        }
        try{
            $this->authModel->authenticate($customer);
            $this->session->setCustomerDataAsLoggedIn($customer);
            $this->session->regenerateId();
            if ($this->getCookieManager()->getCookie('mage-cache-sessid')) {
                $metadata = $this->getCookieMetadataFactory()->createCookieMetadata();
                $metadata->setPath('/');
                $this->getCookieManager()->deleteCookie('mage-cache-sessid', $metadata);
            }
            $this->getVersion()->process();
            $redirectUrl = $this->accountRedirect->getRedirectCookie();
            if(!is_null($this->redirectUrl)){
                $redirectUrl = $this->redirectUrl;
            }
            if (!$this->getScopeConfig()->getValue('customer/startup/redirect_dashboard') &&$redirectUrl) {
                $this->accountRedirect->clearRedirectCookie();
                $resultRedirect = $this->resultRedirectFactory->create();
                // URL is checked to be internal in $this->_redirect->success()
                $resultRedirect->setUrl($this->_redirect->success($redirectUrl));
                return $resultRedirect;
            }


        }catch (UserLockedException $e){

            $message = __(
                'The account is locked. Please wait and try again or contact %1.',
                $this->getScopeConfig()->getValue('contact/email/recipient_email')
            );
            $this->messageManager->addError($message);
            $this->session->setUsername($customer->getEmail());

        }catch (EmailNotConfirmedException $e){

            $value = $this->customerUrl->getEmailConfirmationUrl($customer->getEmail());
            $message = __(
                'This account is not confirmed. <a href="%1">Click here</a> to resend confirmation email.',
                $value
            );
            $this->messageManager->addError($message);
            $this->session->setUsername($customer->getEmail());
        } catch (LocalizedException $e) {
            $message = $e->getMessage();
            $this->messageManager->addError($message);
            $this->session->setUsername($customer->getEmail());
        } catch (\Exception $e) {
            $this->messageManager->addError(
                __('An unspecified error occurred. Please contact us for assistance.')
            );
        }

        return $this->accountRedirect->getRedirect();

    }

    /**
     * Retrieve cookie manager
     *
     * @return \Magento\Framework\Stdlib\Cookie\PhpCookieManager
     */
    private function getCookieManager()
    {
        if (!$this->cookieMetadataManager) {
            $this->cookieMetadataManager = \Magento\Framework\App\ObjectManager::getInstance()->get(
                \Magento\Framework\Stdlib\Cookie\PhpCookieManager::class
            );
        }
        return $this->cookieMetadataManager;
    }

    /**
     * Retrieve cookie metadata factory
     *
     *
     * @return \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory
     */
    private function getCookieMetadataFactory()
    {
        if (!$this->cookieMetadataFactory) {
            $this->cookieMetadataFactory = \Magento\Framework\App\ObjectManager::getInstance()->get(
                \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory::class
            );
        }
        return $this->cookieMetadataFactory;
    }

    /**
     * Get scope config
     *
     * @return ScopeConfigInterface
     *
     */
    private function getScopeConfig()
    {
        if (!($this->scopeConfig instanceof \Magento\Framework\App\Config\ScopeConfigInterface)) {
            return \Magento\Framework\App\ObjectManager::getInstance()->get(
                \Magento\Framework\App\Config\ScopeConfigInterface::class
            );
        } else {
            return $this->scopeConfig;
        }
    }

    private function getVersion(){
        if(!$this->version){
            $this->version = \Magento\Framework\App\ObjectManager::getInstance()->get(
                Version::class
            );
        }
        return $this->version;
    }

}
