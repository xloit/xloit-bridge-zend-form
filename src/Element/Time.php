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

use Xloit\Bridge\Zend\Filter\TimeToDateTime;
use Zend\Filter;
use Zend\Form\Element\Date as ZendDate;

/**
 * A {@link Time} class.
 *
 * @package Xloit\Bridge\Zend\Form\Element
 */
class Time extends ZendDate
{
    /**
     * Accepted options for DateTime:
     * - format: A \DateTime compatible string
     *
     * @param array|\Traversable $options
     *
     * @return $this
     */
    public function setOptions($options)
    {
        /** @noinspection UnSafeIsSetOverArrayInspection */
        if (isset($options['time_format'])) {
            $this->setFormat($options['time_format']);

            unset($options['time_format']);
        }

        parent::setOptions($options);

        return $this;
    }

    /**
     * Provide default input rules for this element and attaches default validators for the Date input.
     *
     * @return array
     */
    public function getInputSpecification()
    {
        $dateValidator     = $this->getDateValidator();
        $dateValidatorName = get_class($dateValidator);

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
                ],
                TimeToDateTime::class       => [
                    'name'    => TimeToDateTime::class,
                    'options' => [
                        'time_format' => $this->getFormat()
                    ]
                ]
            ],
            'validators' => [
                $dateValidatorName => $dateValidator
            ]
        ];
    }
}
