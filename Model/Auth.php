<?php


namespace Gloo\SSO\Model;

use Magento\Customer\Model\AccountManagement;
use Magento\Customer\Model\Data\Customer;
use Magento\Framework\DB\TransactionFactory;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Catalog\Model\ResourceModel\AbstractResource;
class Auth Extends AbstractModel implements AuthInterface {

    protected $accountManagement;

    public function __construct
    (
        Context $context,
        \Magento\Framework\Registry $registry,
        TransactionFactory $transactionFactory,
        AccountManagement $accountManagement,
        AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        $this->accountManagement = $accountManagement;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function createAccount(Customer $customer){

        return $this->accountManagement->createAccount($customer);
    }

    public function login(){

    }

    public function linkAccount(){

    }

    public function logout()
    {
        // TODO: Implement logout() method.
    }

    public function unlinkAccount()
    {
        // TODO: Implement unlinkAccount() method.
    }

    public function userEmailIsAssociated($email)
    {
        return $this->accountManagement->isEmailAvailable($email);
    }
}