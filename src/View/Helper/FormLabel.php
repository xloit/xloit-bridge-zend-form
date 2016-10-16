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
use Zend\Form\LabelAwareInterface;
use Zend\Form\View\Helper\FormLabel as ZendFormLabel;

/**
 * A {@link FormLabel} class.
 *
 * @package Xloit\Bridge\Zend\Form\View\Helper
 */
class FormLabel extends ZendFormLabel
{
    /**
     *
     *
     * @var string
     */
    protected $horizontalLabelClass = 'col-sm-3 col-md-2';

    /**
     * Generate a form label, optionally with content.
     * Always generates a "for" statement, as we cannot assume the form input will be provided in the $labelContent.
     *
     * @param ElementInterface $element
     * @param string           $labelContent
     * @param string           $position
     *
     * @return string|static
     * @throws \Zend\Form\Exception\DomainException
     */
    public function __invoke(ElementInterface $element = null, $labelContent = null, $position = null)
    {
        $this->addLabelClass(
            $element,
            [
                'control-label',
                $this->horizontalLabelClass
            ]
        );

        return parent::__invoke($element, $labelContent, $position);
    }

    /**
     *
     *
     * @param ElementInterface $element
     * @param array            $classList
     *
     * @return void
     */
    protected function addLabelClass(ElementInterface $element, $classList)
    {
        $labelAttributes = [];

        if ($element instanceof LabelAwareInterface) {
            $labelAttributes = $element->getLabelAttributes();
        }

        /** @noinspection UnSafeIsSetOverArrayInspection */
        if (isset($labelAttributes['class'])) {
            $labelAttributes['class'] = implode(
                ' ',
                array_unique(array_merge(explode(' ', $labelAttributes['class']), $classList))
            );
        } else {
            $labelAttributes['class'] = implode(' ', $classList);
        }

        $element->setLabelAttributes($labelAttributes);
    }
} 
