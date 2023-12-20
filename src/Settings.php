<?php
/**
 * Created for plugin-component-settings
 * Datetime: 11.02.2020 16:49
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace SalesRender\Plugin\Components\Settings;


use SalesRender\Plugin\Components\Db\Components\Connector;
use SalesRender\Plugin\Components\Db\Model;
use SalesRender\Plugin\Components\Db\SinglePluginModelInterface;
use SalesRender\Plugin\Components\Form\Form;
use SalesRender\Plugin\Components\Form\FormData;
use SalesRender\Plugin\Components\Settings\Exceptions\IntegritySettingsException;
use RuntimeException;

final class Settings extends Model implements SinglePluginModelInterface
{

    /** @var Form|callable */
    private static $form;

    protected FormData $data;

    protected function __construct()
    {
        $this->data = new FormData();
    }

    public function getData(): FormData
    {
        return $this->data;
    }

    public function setData(FormData $data)
    {
        $this->data = $data;
    }

    protected static function beforeWrite(array $data): array
    {
        $data['data'] = json_encode($data['data']);
        return $data;
    }

    protected static function afterRead(array $data): array
    {
        $data['data'] = new FormData(json_decode($data['data'], true));
        return $data;
    }

    public static function find(): Settings
    {
        return static::findById(Connector::getReference()->getId()) ?? new static();
    }

    public static function schema(): array
    {
        return [
            'data' => ['TEXT'],
        ];
    }

    public static function getForm(array $context = []): Form
    {
        if (!isset(self::$form)) {
            throw new RuntimeException('Settings form was not configured');
        }

        $form = is_callable(self::$form) ? (self::$form)($context) : self::$form;
        $form->setContext($context);
        return $form;
    }

    /**
     * @param Form|callable $form
     */
    public static function setForm($form): void
    {
        self::$form = $form;
    }

    /**
     * @throws IntegritySettingsException
     */
    public static function guardIntegrity(): void
    {
        $form = self::getForm();
        $settings = self::find();

        if (!$form->validateData($settings->getData())) {
            throw new IntegritySettingsException('Settings data empty or incomplete');
        }
    }
}