<?php
namespace Gloo\SSO\PageCache;

use Magento\Framework\App\PageCache\Version as CoreVersion;


class Version extends CoreVersion{

    /**
     * Handle private content version cookie
     * Set cookie if it is not set.
     * Increment version on post requests.
     * In all other cases do nothing.
     *
     * @return void
     */
    public function process()
    {
            $publicCookieMetadata = $this->cookieMetadataFactory->createPublicCookieMetadata()
                ->setDuration(self::COOKIE_PERIOD)
                ->setPath('/')
                ->setSecure($this->request->isSecure())
                ->setHttpOnly(false);
            $this->cookieManager->setPublicCookie(self::COOKIE_NAME, $this->generateValue(), $publicCookieMetadata);

    }
}