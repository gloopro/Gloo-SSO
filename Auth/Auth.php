<?php
    namespace Gloo\SSO\Auth;
    use Gloo\SSO\Helper\Data;
    use Magento\Framework\App\Action\Context;
    use Magento\Framework\DB\TransactionFactory;
    use Magento\Store\Model\StoreManagerInterface;
    use Magento\Customer\Model\CustomerFactory;

    trait AuthTrait {

        protected $storeManager;
        protected $customerFactory;
        protected $dataHelper;
        protected $transactionFactory;


        public function __construct(
            Context $context,
            StoreManagerInterface $storeManager,
            CustomerFactory $customerFactory,
            TransactionFactory $transactionFactory,
            Data $dataHelper
        )
        {
            $this->storeManager = $storeManager;
            $this->customerFactory = $customerFactory;
            $this->transactionFactory = $transactionFactory;
            $this->dataHelper = $dataHelper;
        }

        function getRandomBytes($nbBytes = 32)
        {
            $bytes = openssl_random_pseudo_bytes($nbBytes, $strong);
            if (false !== $bytes && true === $strong) {
                return $bytes;
            }
            else {
                throw new \Exception("Unable to generate secure token from OpenSSL.");
            }
        }

        function generatePassword($length){
            return substr(preg_replace("/[^a-zA-Z0-9]/", "", base64_encode(getRandomBytes($length+1))),0,$length);
        }

        function getTransactionObject(){
            return $this->transactionFactory->create();
        }
    }