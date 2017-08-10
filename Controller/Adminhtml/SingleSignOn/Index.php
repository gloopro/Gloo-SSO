<?php
    namespace Gloo\SSO\Controller\Adminhtml\SingleSignOn;
    use Magento\Backend\App\Action;

    class Index extends Action {

        public function execute()
        {
            $resultPage = $this->resultPageFactory->create();
            //return $resultPage;
            die("Admin Route");
        }
    }