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

use Xloit\Bridge\Zend\Validator\Username as UsernameValidator;
use Zend\Filter;
use Zend\Form\Element\Text;
use Zend\Form\ElementPrepareAwareInterface;
use Zend\Form\FormInterface;

/**
 * An {@link Username} class.
 *
 * @package Xloit\Bridge\Zend\Form\Element
 */
class Username extends Text implements ElementPrepareAwareInterface
{
    /**
     * Constructor to prevent {@link Username} from being loaded more than once.
     *
     * @param string|null $name
     * @param array       $options
     *
     * @throws \Zend\Form\Exception\InvalidArgumentException
     */
    public function __construct($name = 'username', $options = [])
    {
        $this->setLabel('Username');
        $this->setAttribute('placeholder', 'Username');
        $this->setAttribute('autocomplete', 'off');

        parent::__construct($name, $options);
    }

    /**
     * Remove the password before rendering if the form fails in order to avoid any security issue.
     *
     * @param FormInterface $form
     *
     * @return void
     */
    public function prepareElement(FormInterface $form)
    {
        $this->setValue('');
    }

    /**
     * Provide default input rules for this element and attaches an password validator.
     *
     * @return array
     */
    public function getInputSpecification()
    {
        return [
            'name'       => $this->getName(),
            'required'   => true,
            'filters'    => [
                Filter\StringTrim::class    => [
                    'name' => Filter\StringTrim::class
                ],
                Filter\StripNewlines::class => [
                    'name' => Filter\StripNewlines::class
                ]
            ],
            'validators' => [
                UsernameValidator::class => [
                    'name' => UsernameValidator::class
                ]
            ]
        ];
    }
}
