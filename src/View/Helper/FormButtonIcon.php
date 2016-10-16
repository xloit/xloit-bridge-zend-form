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
use Zend\Form\Exception;
use Zend\Form\View\Helper\FormButton;

/**
 * A {@link FormButtonIcon} class.
 *
 * @package Xloit\Bridge\Zend\Form\View\Helper
 */
class FormButtonIcon extends FormButton
{
    /**
     * Render a form <button> element from the provided $element, using content from $buttonContent or the element's
     * "label" attribute.
     *
     * @param ElementInterface $element
     * @param string           $buttonContent
     *
     * @return string
     * @throws \Zend\Form\Exception\DomainException
     * @throws \Zend\Form\Exception\InvalidArgumentException
     */
    public function render(ElementInterface $element, $buttonContent = null)
    {
        $openTag = $this->openTag($element);

        if (null === $buttonContent) {
            $buttonContent = $element->getLabel();
            $options       = $element->getOptions();

            if (null !== ($translator = $this->getTranslator())) {
                $buttonContent = $translator->translate(
                    $buttonContent, $this->getTranslatorTextDomain()
                );
            }

            /** @noinspection UnSafeIsSetOverArrayInspection */
            if (isset($options['icon'])) {
                $buttonContent = sprintf('<i class="%s"></i>%s', $options['icon'], $buttonContent);
            }
        }

        if (null === $buttonContent) {
            throw new Exception\DomainException(
                sprintf(
                    '%s expects either button content as the second argument, ' .
                    'or that the element provided has a label value; neither found',
                    __METHOD__
                )
            );
        }

        return $openTag . $buttonContent . $this->closeTag();
    }

    /**
     * Generate an opening button tag.
     *
     * @param array|ElementInterface $attributesOrElement
     *
     * @return string
     * @throws \Zend\Form\Exception\InvalidArgumentException
     * @throws \Zend\Form\Exception\DomainException
     */
    public function openTag($attributesOrElement = null)
    {
        if (null === $attributesOrElement) {
            return '<button>';
        }

        if (is_array($attributesOrElement)) {
            $attributes = $this->createAttributesString($attributesOrElement);

            return sprintf('<button %s>', $attributes);
        }

        if (!$attributesOrElement instanceof ElementInterface) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    '%s expects an array or Zend\Form\ElementInterface instance; received "%s"',
                    __METHOD__,
                    (is_object($attributesOrElement) ? get_class($attributesOrElement) :
                        gettype($attributesOrElement))
                )
            );
        }

        $element    = $attributesOrElement;
        $attributes = $element->getAttributes();
        $name       = $element->getName();

        if ($name) {
            $attributes['name'] = $name;
        }

        $attributes['type'] = $this->getType($element);
        $classList          = [
            'btn',
            'btn-white'
        ];

        /** @noinspection UnSafeIsSetOverArrayInspection */
        if (isset($attributes['class'])) {
            $attributes['class'] = implode(
                ' ', array_unique(array_merge(explode(' ', $attributes['class']), $classList))
            );
        } else {
            $attributes['class'] = implode(' ', $classList);
        }

        return sprintf(
            '<button %s>',
            $this->createAttributesString($attributes)
        );
    }
} 
