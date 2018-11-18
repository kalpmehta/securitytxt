<?php
/**
 * This file is part of Kalpesh_Securitytxt.
 *
 * (c) Kalpesh Mehta <k@lpe.sh>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Kalpesh\Securitytxt\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Escaper;

/**
 * Returns data for security.txt file
 */
class Securitytxt
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param Escaper $escaper
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        Escaper $escaper
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->escaper = $escaper;
    }

    /**
     * Append all the fields to prepare the final contents of the security.txt file
     *
     * @param $data
     * @return string
     */
    public function prepareData($data)
    {
        $contents = "";
        if(isset($data['enabled']) && $data['enabled'] == 1)
        {
            if(isset($data['contact']))
            {
                $contents .= 'Contact: ' . $this->escaper->escapeHtml($data['contact']) . PHP_EOL;
            }
            if(isset($data['encryption']))
            {
                $contents .= 'Encryption: ' . $this->escaper->escapeHtml($data['encryption']) . PHP_EOL;
            }
            if(isset($data['acknowledgements']))
            {
                $contents .= 'Acknowledgements: ' . $this->escaper->escapeHtml($data['acknowledgements']) . PHP_EOL;
            }
            if(isset($data['policy']))
            {
                $contents .= 'Policy: ' . $this->escaper->escapeHtml($data['policy']) . PHP_EOL;
            }
            if(isset($data['signature']))
            {
                $contents .= 'Signature: ' . $this->storeManager->getStore()->getBaseUrl() . '.well-known/security.txt.sig';
            }
        }
        return $contents;
    }

    /**
     * Get the main data for security.txt file as defined in configuration
     *
     * @return string
     */
    public function getSecuritytxt()
    {

        $securitytxt = $this->scopeConfig->getValue(
            'kalpesh_securitytxt_securitytxt/general',
            ScopeInterface::SCOPE_WEBSITE
        );

        return $this->prepareData($securitytxt);
    }

    /**
     * Get the main data for security.txt file as defined in configuration
     *
     * @return string
     */
    public function getSecuritytxtsig()
    {

        return $this->escaper->escapeHtml(
            $this->scopeConfig->getValue(
            'kalpesh_securitytxt_securitytxt/general/signature_text',
            ScopeInterface::SCOPE_WEBSITE
            )
        );
    }
}
