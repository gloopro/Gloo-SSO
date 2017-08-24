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

        public function createUserAccount(ResourceOwnerInterface $resourceOwner){
            /**
             * This function should handle transaction incase account linking fails
             * You need to rollback before account creation
             */
            $data = $resourceOwner->toArray();
            $websiteID = $this->storeManager->getWebsite()->getId();
            $transactionObject = $this->getTransactionObject();

            //begin transaction
            try {

            }catch(\Exception $e){

            }
            $customer = $this->customerFactory->create();

            $customer->setWebsiteId($websiteID);
            $customer->setUserid($resourceOwner->getId());
            $customer->setName($data['name']);
            $customer->setFirstname($data[self::FIRST_NAME]);
            $customer->setLastname($data[self::LAST_NAME]);
            $customer->setGender($data[self::GENDER]);
            $customer->setEmail($data[self::EMAIL]);
            $password = $this->generatePassword(12);
            $customer->setPassword($password);

            $customer->save();

            //send confirmation email if all goes well
            if($this->dataHelper->getConfig("send_confirmation_email")){
                $customer->sendNewAccountEmail();
            }
        }

    }