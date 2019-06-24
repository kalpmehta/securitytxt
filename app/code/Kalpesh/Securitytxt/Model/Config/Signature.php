<?php
/**
 * This file is part of Kalpesh_Securitytxt.
 *
 * (c) Kalpesh Mehta <k@lpe.sh>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kalpesh\Securitytxt\Model\Config;
use \Magento\Config\Model\Config\CommentInterface;
class Signature implements CommentInterface
{

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManagerInterface;

    /**
     * Signature constructor.
     * @param \Magento\Store\Model\StoreManagerInterface $storeManagerInterface
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface
    )
    {
        $this->_storeManagerInterface = $storeManagerInterface;
    }

    /**
     * @param string $elementValue
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCommentText($elementValue)
    {
        return "<ol>
            <li>Download your security.txt file from " . $this->_storeManagerInterface->getStore()->getBaseUrl() .
                ".well-known/security.txt</li>
            <li>Sign your security.txt file with the encryption key you specified in your security.txt file. 
                You can do this with GPG with a command like:
                <kbd>gpg -u KEYID --output security.txt.sig  --armor --detach-sig security.txt</kbd></li>
            <li>Paste the contents of the generated <kbd>security.txt.sig</kbd> file into the Signature textarea above.</li>
        </ol>";
    }
}