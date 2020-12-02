<?php
/**
 * Created for plugin-component-settings
 * Date: 24.11.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Components\Settings;


use Leadvertex\Plugin\Components\Form\Form;
use Leadvertex\Plugin\Components\Settings\Exceptions\IntegritySettingsException;
use RuntimeException;

final class SettingsForm extends Form
{

    /** @var Form|callable */
    private static $instance;

    private function __construct(string $title, ?string $description, array $fieldGroups, string $button)
    {
        parent::__construct($title, $description, $fieldGroups, $button);
    }

    /**
     * @param Form|callable $form
     */
    public static function config($form): void
    {
        self::$instance = $form;
    }

    public static function getInstance(): Form
    {
        if (!isset(self::$instance)) {
            throw new RuntimeException('Settings form was not configured');
        }
        return is_callable(self::$instance) ? (self::$instance)() : self::$instance;
    }

    /**
     * @throws IntegritySettingsException
     */
    public static function guardIntegrity(): void
    {
        $form = self::getInstance();
        $settings = Settings::find();

        if (!$form->validateData($settings->getData())) {
            throw new IntegritySettingsException('Settings data empty or incomplete');
        }
    }

}