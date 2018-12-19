<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 25.11.2015
 */

namespace models;
use models\_base\AbstractCapitalModel;

/**
 * Class TopList
 * @package components\Model
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $description2
 * @property int $is_enabled
 * @property int $updated_at
 * @property string $controller
 * @property string $action
 */
class EventRating extends AbstractCapitalModel
{
    /**
     * @param string $className
     * @return TopList
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    protected function fieldMap()
    {
        return [
			'id', 'key', 'name', 'description', 'icon', 'link', 'is_enabled', 'enable_type',
			'iteration_num', 'updated_at', 'created_at'
		];
    }

    public static function tableName()
    {
        return 'event_rating';
    }

    public static function pkField()
    {
        return 'id';
    }

    public function getPk()
    {
        return $this->id;
    }
}