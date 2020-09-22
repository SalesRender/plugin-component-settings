<?php
/**
 * Created for plugin-component-guzzle
 * Datetime: 11.02.2020 16:49
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Settings;



use Leadvertex\Plugin\Components\Db\Model;
use Leadvertex\Plugin\Components\Form\FormData;

/**
 * Class Settings
 * @package Leadvertex\Plugin\Core\Macros\Models
 *
 * @property $data FormData
 */
class Settings extends Model
{

    public function __construct(string $id, string $alias)
    {
        parent::__construct($id, $alias);
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

}