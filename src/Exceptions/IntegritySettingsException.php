<?php
/**
 * Created for plugin-component-settings
 * Date: 24.11.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Components\Settings\Exceptions;


use Exception;

class IntegritySettingsException extends Exception
{

    public function __construct($message = "")
    {
        parent::__construct($message, 424);
    }

}