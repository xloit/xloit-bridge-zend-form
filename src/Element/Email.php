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

use Zend\Form\Element\Email as EmailElement;
use Zend\Validator;

/**
 * An {@link Email} class.
 *
 * @package Xloit\Bridge\Zend\Form\Element
 */
class Email extends EmailElement
{
    /**
     * Constructor to prevent {@link Email} from being loaded more than once.
     *
     * @param int|string $name
     * @param array      $options
     *
     * @throws \Zend\Form\Exception\InvalidArgumentException
     */
    public function __construct($name = 'email', $options = [])
    {
        $this->setLabel('Email Address');
        $this->setAttribute('placeholder', 'Email Address');
        $this->setAttribute('autocomplete', 'off');

        parent::__construct($name, $options);
    }
}
