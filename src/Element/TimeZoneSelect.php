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

use DateTimeZone;
use Zend\Form\Element\Select;
use Zend\Validator\Explode as ExplodeValidator;
use Zend\Validator\InArray as InArrayValidator;

/**
 * A {@link TimeZoneSelect} class.
 *
 * @package Xloit\Bridge\Zend\Form\Element
 */
class TimeZoneSelect extends Select
{
    /**
     *
     *
     * @return array
     */
    public function getValueOptions()
    {
        if (count($this->valueOptions) === 0) {
            $timezoneIdentifiers = DateTimeZone::listIdentifiers();

            foreach ($timezoneIdentifiers as $timezone) {
                if (strpos($timezone, '/') !== false) {
                    list($continent, $city) = explode('/', $timezone);
                    $city = str_replace('_', ' ', $city);

                    if (!array_key_exists($continent, $this->valueOptions)) {
                        $this->valueOptions[$continent] = [
                            'label'   => $continent,
                            'options' => []
                        ];
                    }

                    $this->valueOptions[$continent]['options'][$timezone] = $city;
                } else {
                    $this->valueOptions[$timezone] = $timezone;
                }
            }
        }

        return $this->valueOptions;
    }

    /**
     *
     *
     * @param array $options
     *
     * @return $this
     */
    public function setValueOptions(array $options)
    {
        $this->valueOptions = $options;

        // Update InArrayValidator validator haystack
        if (null !== $this->validator) {
            if ($this->validator instanceof InArrayValidator) {
                $validator = $this->validator;
            }

            if ($this->validator instanceof ExplodeValidator
                && $this->validator->getValidator() instanceof InArrayValidator
            ) {
                $validator = $this->validator->getValidator();
            }

            /** @noinspection IsEmptyFunctionUsageInspection */
            if (!empty($validator)) {
                $validator->setHaystack($this->getValueOptionsValues());
            }
        }

        return $this;
    }
}
