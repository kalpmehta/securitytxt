<?php
/**
 * This file is part of Kalpesh_Securitytxt.
 *
 * (c) Kalpesh Mehta <k@lpe.sh>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Kalpesh\Securitytxt\Block;

use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Context;
use Kalpesh\Securitytxt\Model\Securitytxt as SecuritytxtModel;
use Magento\Store\Model\StoreResolver;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\RequestInterface;

/**
 * Securitytxt Block Class.
 *
 * Prepares base content for security.txt
 *
 * @api
 */
class Securitytxt extends AbstractBlock
{
    /**
     * @var SecuritytxtModel
     */
    private $securitytxt;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param Context $context
     * @param SecuritytxtModel $securitytxt
     * @param StoreResolver $storeResolver
     * @param StoreManagerInterface|null $storeManager,
     * @param RequestInterface $request,
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(
        Context $context,
        SecuritytxtModel $securitytxt,
        StoreResolver $storeResolver,
        StoreManagerInterface $storeManager = null,
        RequestInterface $request,
        array $data = []
    ) {
        $this->securitytxt = $securitytxt;
        $this->request = $request;
        $this->storeManager = $storeManager ?: \Magento\Framework\App\ObjectManager::getInstance()
            ->get(StoreManagerInterface::class);

        parent::__construct($context, $data);
    }

    /**
     * Retrieve content for security.txt file
     *
     * @return string
     */
    protected function _toHtml()
    {

        $identifier = trim($this->request->getPathInfo(), '/');
        if ($identifier === '.well-known/security.txt') {
            return $this->securitytxt->getSecuritytxt() . PHP_EOL;
        } else if($identifier === '.well-known/security.txt.sig') {
            return $this->securitytxt->getSecuritytxtsig() . PHP_EOL;
        }


    }

}
