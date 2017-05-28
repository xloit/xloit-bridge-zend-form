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

use Zend\Form\Element\Button;
use Zend\Form\Element\Collection as CollectionElement;
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormCollection as ZendFormCollection;

/**
 * A {@link FormCollection} class.
 *
 * @package Xloit\Bridge\Zend\Form\View\Helper
 */
class FormCollection extends ZendFormCollection
{
    /**
     *
     *
     * @var string
     */
    protected $wrapper = '<div class="form-group %s" %s>%s<div class="%s">%s</div>%s</div>';

    /**
     *
     *
     * @var string
     */
    protected $elementWrap = '<div class="row"><div class="col-sm12 m-bot15 %s">%s%s</div></div>';

    /**
     * Where shall the template-data be inserted into.
     *
     * @var string
     */
    protected $templateWrapper = '<div class="hidden" data-template="%s"></div>';

    /**
     *
     *
     * @var string
     */
    protected $horizontalWrapClass = 'col-sm-9 col-md-6';

    /**
     * Form element errors helper instance.
     *
     * @var FormElementErrors
     */
    protected $elementErrorsHelper;

    /**
     *
     *
     * @var array
     */
    protected $hiddenClass = 'hidden';

    /**
     *
     *
     * @var array
     */
    protected $errorClass = 'has-error';

    /**
     * The name of the default view helper that is used to render sub elements.
     *
     * @var string
     */
    protected $defaultElementHelper = 'formElement';

    /**
     * Form label helper instance.
     *
     * @var FormLabel
     */
    protected $labelHelper;

    /**
     * Render a collection by iterating through all fieldset and elements.
     *
     * @param ElementInterface $element
     *
     * @return string
     * @throws \RuntimeException
     * @throws \Zend\Form\Exception\InvalidArgumentException
     */
    public function render(ElementInterface $element)
    {
        $renderer = $this->getView();

        if (!method_exists($renderer, 'plugin')) {
            return '';
        }

        $wrapperClass     = '';
        $elementMarkup    = '';
        $templateMarkup   = '';
        $attributesString = '';
        $label            = '';

        if ($element instanceof CollectionElement && $element->shouldCreateTemplate()) {
            $templateMarkup = $this->renderTemplate($element);
        }

        foreach ($element->getIterator() as $elementOrFieldset) {
            /** @var  ElementInterface $elementOrFieldset */
            $elementMarkup .= $this->renderElement($elementOrFieldset);
        }

        $helperFormButtonIcon = $this->getFormButtonIconHelper();
        $helperLabel          = $this->getLabelHelper();

        $elementMarkup .= sprintf(
            $this->elementWrap,
            '',
            $helperFormButtonIcon(
                new Button(
                    null,
                    [
                        'label' => 'Add New',
                        'icon'  => 'fa fa-plus-circle'
                    ]
                )
            ),
            ''
        );

        if ($this->shouldWrap) {
            $attributes = $element->getAttributes();

            /** @noinspection UnSafeIsSetOverArrayInspection */
            if (isset($attributes['class'])) {
                $wrapperClass = $attributes['class'];

                unset($attributes['class']);
            }

            unset($attributes['name']);

            $attributesString = count($attributes) ? ' ' . $this->createAttributesString($attributes) : '';

            /** @noinspection IsEmptyFunctionUsageInspection */
            if (!empty($element->getLabel())) {
                $label = $helperLabel($element);
            }
        }

        return sprintf(
            $this->wrapper,
            $wrapperClass,
            $attributesString,
            $label,
            $this->horizontalWrapClass,
            $elementMarkup,
            $templateMarkup
        );
    }

    /**
     *
     *
     * @param ElementInterface $element
     *
     * @return string
     * @throws \RuntimeException
     */
    protected function renderElement(ElementInterface $element)
    {
        /** @var $elementHelper Callable */
        $elementHelper = $this->getElementHelper();
        $wrapClass     = '';

        if ($element->getAttribute('type') === $this->hiddenClass) {
            $wrapClass .= $this->hiddenClass;
        }

        $helperElementErrors = $this->getElementErrorsHelper();
        $errorHtml           = $helperElementErrors($element);

        /** @noinspection IsEmptyFunctionUsageInspection */
        if (!empty($errorHtml)) {
            $wrapClass .= ' ' . $this->errorClass;
        }

        return sprintf(
            $this->elementWrap,
            $wrapClass,
            $elementHelper($element),
            $errorHtml
        );
    }

    /**
     * Retrieve the FormButtonIcon helper.
     *
     * @return FormButtonIcon
     */
    protected function getFormButtonIconHelper()
    {
        return new FormButtonIcon();
    }

    /**
     * Retrieve the FormElementErrors helper.
     *
     * @return FormElementErrors
     */
    protected function getElementErrorsHelper()
    {
        if ($this->elementErrorsHelper) {
            return $this->elementErrorsHelper;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->elementErrorsHelper = $this->view->plugin('form_element_errors');
        }

        if (!$this->elementErrorsHelper instanceof FormElementErrors) {
            $this->elementErrorsHelper = new FormElementErrors();
        }

        return $this->elementErrorsHelper;
    }

    /**
     * Retrieve the FormLabel helper.
     *
     * @return FormLabel
     */
    protected function getLabelHelper()
    {
        if ($this->labelHelper) {
            return $this->labelHelper;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->labelHelper = $this->view->plugin('form_label');
        }

        if (!$this->labelHelper instanceof FormLabel) {
            $this->labelHelper = new FormLabel();
        }

        if ($this->hasTranslator()) {
            $this->labelHelper->setTranslator(
                $this->getTranslator(),
                $this->getTranslatorTextDomain()
            );
        }

        return $this->labelHelper;
    }
}
