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

use Zend\Filter;
use Zend\Form\Element\Select;
use Zend\Validator;

/**
 * A {@link YesNoSelect} class.
 *
 * @package Xloit\Bridge\Zend\Form\Element
 */
class YesNoSelect extends Select
{
    /**
     * Constructor to prevent {@link YesNoSelect} from being loaded more than once.
     *
     * @param string|null $name    Optional name for the element.
     * @param array       $options Optional options for the element.
     *
     * @throws \Zend\Form\Exception\InvalidArgumentException
     */
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setEmptyOption('');
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
                ],
                Filter\StripTags::class     => [
                    'name' => Filter\StripTags::class
                ]
            ],
            'validators' => [
                Validator\InArray::class => [
                    'name'    => Validator\InArray::class,
                    'options' => [
                        'haystack' => [
                            1 => 'Yes',
                            0 => 'No'
                        ]
                    ]
                ]
            ]
        ];
    }
}
