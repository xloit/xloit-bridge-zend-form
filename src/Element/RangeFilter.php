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

use Zend\Filter\Callback;
use Zend\Form\Element;
use Zend\Form\ElementPrepareAwareInterface;
use Zend\Form\FormInterface;

/**
 * A {@link RangeFilter} class.
 *
 * @package Xloit\Bridge\Zend\Form\Element
 */
class RangeFilter extends Element implements ElementPrepareAwareInterface
{
    /**
     * Input form element that contains values for start.
     *
     * @var Element\Number
     */
    protected $startElement;

    /**
     * Input form element that contains values for end.
     *
     * @var Element\Number
     */
    protected $endElement;

    /**
     * Seed attributes.
     *
     * @var array
     */
    protected $attributes = [
        'type' => 'rangefilter'
    ];

    /**
     * Constructor to prevent {@link RangeFilter} from being loaded more than once.
     *
     * @param string|null $name    Optional name for the element.
     * @param array       $options Optional options for the element.
     *
     * @throws \Zend\Form\Exception\InvalidArgumentException
     */
    public function __construct($name = null, $options = [])
    {
        $this->startElement = new Element\Number('start');
        $this->endElement   = new Element\Number('end');

        parent::__construct($name, $options);
    }

    /**
     *
     *
     * @param array|\Traversable $options
     *
     * @return $this
     * @throws \Zend\Form\Exception\InvalidArgumentException
     */
    public function setOptions($options)
    {
        parent::setOptions($options);

        /** @noinspection UnSafeIsSetOverArrayInspection */
        if (isset($options['start_attributes'])) {
            $this->startElement->setAttributes($options['start_attributes']);
        }

        /** @noinspection UnSafeIsSetOverArrayInspection */
        if (isset($options['end_attributes'])) {
            $this->endElement->setAttributes($options['end_attributes']);
        }

        return $this;
    }

    /**
     * Set the element value.
     *
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        /** @noinspection NotOptimalIfConditionsInspection */
        if (is_array($value) && array_key_exists('start', $value) && array_key_exists('end', $value)) {
            $start = (float) $value['start'];
            $end   = (float) $value['end'];

            if ($start <= $end) {
                $this->startElement->setValue($start);
                $this->endElement->setValue($end);
            }
        }

        return $this;
    }

    /**
     *
     *
     * @return Element\Number
     */
    public function getStartElement()
    {
        return $this->startElement;
    }

    /**
     *
     *
     * @param Element\Number $startElement
     *
     * @return $this
     */
    public function setStartElement(Element\Number $startElement)
    {
        $this->startElement = $startElement;

        return $this;
    }

    /**
     *
     *
     * @return Element\Number
     */
    public function getEndElement()
    {
        return $this->endElement;
    }

    /**
     *
     *
     * @param Element\Number $endElement
     *
     * @return $this
     */
    public function setEndElement(Element\Number $endElement)
    {
        $this->endElement = $endElement;

        return $this;
    }

    /**
     *
     *
     * @return string
     */
    public function getValue()
    {
        return sprintf(
            '%s - %s', $this->startElement->getValue(), $this->endElement->getValue()
        );
    }

    /**
     * Prepare the form element (mostly used for rendering purposes).
     *
     * @param FormInterface $form
     *
     * @return void
     */
    public function prepareElement(FormInterface $form)
    {
        $name = $this->getName();

        $this->startElement->setName($name . '[start]');
        $this->endElement->setName($name . '[end]');
    }

    /**
     * Should return an array specification compatible with {@link Zend\InputFilter\Factory::createInput()}.
     *
     * @return array
     */
    public function getInputSpecification()
    {
        return [
            'name'       => $this->getName(),
            'required'   => false,
            'filters'    => [
                [
                    'name'    => Callback::class,
                    'options' => [
                        'callback' => function($date) {
                            // Convert the date to a specific format
                            if (is_array($date)) {
                                $date = $date['start'] . ' - ' . $date['end'];
                            }

                            return $date;
                        }
                    ]
                ]
            ],
            'validators' => []
        ];
    }
}
