<?php
/**
 * This source file is part of Xloit project.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * <http://www.opensource.org/licenses/mit-license.php>
 * If you did not receive a copy of the license and are unable to obtain it through the world-wide-web,
 * please send an email to <license@xloit.com> so we can send you a copy immediately.
 *
 * @license   MIT
 * @link      http://xloit.com
 * @copyright Copyright (c) 2016, Xloit. All rights reserved.
 */

namespace Xloit\Bridge\Zend\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormSubmit as ZendFormSubmit;

/**
 * A {@link FormSubmit} class.
 *
 * @package Xloit\Bridge\Zend\Form\View\Helper
 */
class FormSubmit extends ZendFormSubmit
{
    use HelperTrait;

    /**
     * Invoke helper as function.
     * Proxies to {@link render()}.
     *
     * @param ElementInterface $element
     *
     * @return string|static
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (!$element) {
            return $this;
        }

        return parent::__invoke(
            $this->addElementClass($element, ['btn'])
        );
    }
} 
