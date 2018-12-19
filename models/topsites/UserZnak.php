<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.11.2015
 */

namespace models\topsites;
use models\_base\AbstractTopModel;

/**
 * Class Bank
 * @package components\Model
 *
 * @method $this|$this[] asModel()
 *
 * @property int $id
 * @property int $user_id
 * @property int $znak
 * @property int $year
 *
 */
class UserZnak extends AbstractTopModel
{
    /**
     * @param string $className
     * @return Top
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function tableName()
    {
        return 'user_znak';
    }

    public static function pkField()
    {
        return 'id';
    }

    public function getPk()
    {
        return $this->id;
    }

    protected function fieldMap()
    {
        return array('id','user_id','znal','year');
    }
}