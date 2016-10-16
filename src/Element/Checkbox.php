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

namespace Xloit\Bridge\Zend\Form\Element;

use Zend\Form\Element\Checkbox as ZendCheckbox;

/**
 * A {@link Checkbox} class.
 *
 * @package Xloit\Bridge\Zend\Form\Element
 */
class Checkbox extends ZendCheckbox
{
    /**
     * Provide default input rules for this element Attaches the captcha as a validator.
     *
     * @return array
     */
    public function getInputSpecification()
    {
        $specifications = parent::getInputSpecification();

        $specifications['required'] = false;

        return $specifications;
    }
}
