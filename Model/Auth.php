<?php


namespace Gloo\SSO\Model;

use Magento\Customer\Model\AccountManagement;
use Magento\Customer\Model\AuthenticationInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Data\Customer;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\DB\TransactionFactory;
use Magento\Framework\Exception\State\UserLockedException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Catalog\Model\ResourceModel\AbstractResource;
class Auth Extends AbstractModel implements AuthInterface {

    protected $accountManagement;
    protected $customerRepository;
    protected $authentication;

    public function __construct
    (
        Context $context,
        \Magento\Framework\Registry $registry,
        TransactionFactory $transactionFactory,
        AccountManagement $accountManagement,
        AuthenticationInterface $authentication,
        CustomerRepository $customerRepository,
        AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        $this->accountManagement = $accountManagement;
        $this->customerRepository = $customerRepository;
        $this->authentication  = $authentication;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function createAccount(Customer $customer){
        return $this->accountManagement->createAccount($customer);
    }

    public function authenticate(Customer $customer){
        if($this->authentication->isLocked($customer->getId())){
            throw new UserLockedException(__('The account is locked'));
        }

        if ($this->accountManagement->getConfirmationStatus($customer->getId())
            === AccountManagement::ACCOUNT_CONFIRMATION_REQUIRED
        ) {
            throw new EmailNotConfirmedException(__('This account is not confirmed.'));
        }
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
        return !$this->accountManagement->isEmailAvailable($email);
    }
}