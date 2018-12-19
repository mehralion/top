<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 25.11.2015
 */

namespace models;
use components\Config;
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
class TopList extends AbstractCapitalModel
{
    private static $menu_ids = array(
        'main_index'    => 1,
        'main_ruines'   => 2,
        'main_dt'       => 3,
        'main_wars'     => 4,
        'main_ppl'      => 5,
        'main_castles'  => 6,
        'march8_index'  => 7,
        'maslo_index'   => 8,
        'may_index'     => 9,
        'main_loto'     => 10,
        'main_marafon'  => 11,
    );

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
        return array(
            'id', 'name', 'description', 'description2', 'is_enabled', 'updated_at', 'controller', 'action'
        );
    }

    public static function tableName()
    {
        return 'top_list';
    }

    public static function pkField()
    {
        return 'id';
    }

    public function getPk()
    {
        return $this->id;
    }

    public function isEnable($id)
    {
        return self::count('id = ? and is_enabled = 1', array($id)) ? true : false;
    }

    /**
     * @param $controller
     * @param $action
     * @return array|null|static
     */
    public static function findCurrent($controller, $action)
    {
		if($controller == 'rating') {
			return null;
		}
        $key = sprintf('%s_%s', $controller, $action);
        if(!isset(self::$menu_ids[$key])) {
//            return null;
            $key = 'main_index';
        }

        return self::findByPk(self::$menu_ids[$key])->asModel();
    }
}