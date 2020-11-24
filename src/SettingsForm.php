<?php
/**
 * Created for plugin-component-settings
 * Date: 24.11.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Components\Settings;


use Leadvertex\Plugin\Components\Form\Form;
use RuntimeException;

final class SettingsForm extends Form
{

    private static self $instance;

    private function __construct(string $title, ?string $description, array $fieldGroups, string $button)
    {
        parent::__construct($title, $description, $fieldGroups, $button);
    }

    /**
     * @param callable|string $title
     * @param callable|string|null $description
     * @param callable|array $fieldGroups
     * @param callable|string $button
     */
    public static function config($title, $description, $fieldGroups, $button): void
    {
        $title = is_callable($title) ? $title() : $title;
        $description = is_callable($description) ? $description() : $description;
        $fieldGroups = is_callable($fieldGroups) ? $fieldGroups() : $fieldGroups;
        $button = is_callable($button) ? $button() : $button;
        self::$instance = new self($title, $description, $fieldGroups, $button);
    }

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            throw new RuntimeException('Settings form was not configured');
        }
        return self::$instance;
    }

}