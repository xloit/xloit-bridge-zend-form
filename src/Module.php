<?php
/**
 * This source file is part of Virtupeer project.
 *
 * @link      https://virtupeer.com
 * @copyright Copyright (c) 2016, Virtupeer. All rights reserved.
 */

namespace Xloit\Bridge\Zend\Form;

use Zend\Form\ElementFactory;

/**
 * A {@link Module} class.
 *
 * @package Xloit\Bridge\Zend\Form
 */
class Module
{
    /**
     * Return default zend-validator configuration for zend-mvc applications.
     *
     * @return array
     */
    public function getConfig()
    {
        return [
            'form_elements' => [
                'aliases'   => [
                    'checkbox'       => Element\Checkbox::class,
                    'Checkbox'       => Element\Checkbox::class,
                    'ckeditor'       => Element\CkEditor::class,
                    'ckEditor'       => Element\CkEditor::class,
                    'CkEditor'       => Element\CkEditor::class,
                    'csrf'           => Element\Csrf::class,
                    'Csrf'           => Element\Csrf::class,
                    'date'           => Element\Date::class,
                    'Date'           => Element\Date::class,
                    'datetime'       => Element\DateTime::class,
                    'dateTime'       => Element\DateTime::class,
                    'DateTime'       => Element\DateTime::class,
                    'email'          => Element\Email::class,
                    'Email'          => Element\Email::class,
                    'multipleinput'  => Element\MultipleInput::class,
                    'multipleInput'  => Element\MultipleInput::class,
                    'MultipleInput'  => Element\MultipleInput::class,
                    'password'       => Element\Password::class,
                    'Password'       => Element\Password::class,
                    'rangefilter'    => Element\RangeFilter::class,
                    'rangeFilter'    => Element\RangeFilter::class,
                    'RangeFilter'    => Element\RangeFilter::class,
                    'time'           => Element\Time::class,
                    'Time'           => Element\Time::class,
                    'timezoneselect' => Element\TimeZoneSelect::class,
                    'timezoneSelect' => Element\TimeZoneSelect::class,
                    'TimezoneSelect' => Element\TimeZoneSelect::class,
                    'username'       => Element\Username::class,
                    'Username'       => Element\Username::class,
                    'yesnoselect'    => Element\YesNoSelect::class,
                    'yesNoSelect'    => Element\YesNoSelect::class,
                    'YesNoSelect'    => Element\YesNoSelect::class
                ],
                'factories' => [
                    Element\Checkbox::class       => ElementFactory::class,
                    Element\CkEditor::class       => ElementFactory::class,
                    Element\Csrf::class           => ElementFactory::class,
                    Element\Date::class           => ElementFactory::class,
                    Element\DateTime::class       => ElementFactory::class,
                    Element\Email::class          => ElementFactory::class,
                    Element\MultipleInput::class  => ElementFactory::class,
                    Element\Password::class       => ElementFactory::class,
                    Element\RangeFilter::class    => ElementFactory::class,
                    Element\Time::class           => ElementFactory::class,
                    Element\TimeZoneSelect::class => ElementFactory::class,
                    Element\Username::class       => ElementFactory::class,
                    Element\YesNoSelect::class    => ElementFactory::class
                ]
            ]
        ];
    }
}
