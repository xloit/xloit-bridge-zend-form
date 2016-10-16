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

namespace Xloit\Bridge\Zend\Form;

use Xloit\Std\ArrayUtils;
use Zend\Form\Form as AbstractForm;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterProviderInterface;

/**
 * A {@link Form} class.
 *
 * @package Xloit\Bridge\Zend\Form
 */
class Form extends AbstractForm
{
    use ElementRequireAttributesProviderTrait;

    /**
     * Return element value.
     *
     * @param string $name Name
     *
     * @return string
     */
    public function getValue($name = null)
    {
        if ($this->has($name)) {
            return $this->get($name)->getValue();
        }

        return parent::getValue();
    }

    /**
     * Retrieve input filter used by this form.
     *
     * @return InputFilterInterface
     * @throws \Xloit\Std\Exception\RuntimeException
     * @throws \Zend\InputFilter\Exception\RuntimeException
     * @throws \Zend\InputFilter\Exception\InvalidArgumentException
     */
    public function getInputFilter()
    {
        if ($this->filter) {
            return $this->filter;
        }

        $specifications = [];

        if ($this->object && $this->object instanceof InputFilterProviderInterface) {
            $specifications = $this->object->getInputFilterSpecification();
        }

        if ($this instanceof InputFilterProviderInterface) {
            $specifications = ArrayUtils::merge($specifications, $this->getInputFilterSpecification());
        }

        $this->addRequiredAttributeToFields($specifications);

        /** @noinspection IsEmptyFunctionUsageInspection */
        if (!empty($specifications) && null === $this->baseFieldset) {
            $formFactory  = $this->getFormFactory();
            $inputFactory = $formFactory->getInputFilterFactory();

            if (!($this->filter instanceof InputFilterInterface)) {
                $this->filter = new InputFilter();
                $this->filter->setFactory($inputFactory);
            }

            foreach ($specifications as $name => $specification) {
                $input = $inputFactory->createInput($specification);

                $this->filter->add($input, $name);
            }
        }

        return parent::getInputFilter();
    }

    /**
     * Determine is form multipart.
     *
     * @return bool
     */
    public function isMultipart()
    {
        return $this->getAttribute('enctype') === 'multipart/form-data';
    }
}
