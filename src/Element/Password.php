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

use Xloit\Bridge\Zend\Validator\Password as PasswordValidator;
use Xloit\Bridge\Zend\Validator\ValidatorAwareInterface;
use Xloit\Bridge\Zend\Validator\ValidatorAwareTrait;
use Zend\Filter;
use Zend\Form\Element\Password as ZendPassword;

/**
 * A {@link Password} class.
 *
 * @package Xloit\Bridge\Zend\Form\Element
 */
class Password extends ZendPassword implements ValidatorAwareInterface
{
    use ValidatorAwareTrait;

    /**
     * Constructor to prevent {@link Password} from being loaded more than once.
     *
     * @param  null|int|string $name
     * @param  array           $options
     *
     * @throws \Zend\Form\Exception\InvalidArgumentException
     */
    public function __construct($name = 'password', $options = [])
    {
        $this->setLabel('Password');
        $this->setAttribute('placeholder', 'Password');
        $this->setAttribute('autocomplete', 'off');

        parent::__construct($name, $options);
    }

    /**
     * Provide default input rules for this element.
     * Attaches an password validator.
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
                PasswordValidator::class => [
                    'name'    => PasswordValidator::class,
                    'options' => [
                        // Bcrypt truncates input > 72 bytes
                        'maximumLength' => 72
                    ]
                ]
            ]
        ];
    }
}
