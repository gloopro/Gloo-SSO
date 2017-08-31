<?php

namespace Gloo\SSO\Model;

use Magento\Customer\Model\Data\Customer;

interface AuthInterface{

    public function createAccount(Customer $customer);

    public function login();

    public function logout();

    public function linkAccount();

    public function unlinkAccount();

    /**
     * checks if user email is associated
     * @param $email
     * @return bool
     */
    public function userEmailIsAssociated($email);
}