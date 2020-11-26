<?php
/**
 * Created for plugin-component-settings
 * Datetime: 11.02.2020 16:49
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Settings;


use Leadvertex\Plugin\Components\Db\Components\Connector;
use Leadvertex\Plugin\Components\Db\Model;
use Leadvertex\Plugin\Components\Db\SinglePluginModelInterface;
use Leadvertex\Plugin\Components\Form\FormData;

final class Settings  extends Model implements SinglePluginModelInterface
{

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

    public static function find(): self
    {
        return static::findById(Connector::getReference()->getId()) ?? new static();
    }

    public static function schema(): array
    {
        return [
            'data' => ['TEXT'],
        ];
    }
}