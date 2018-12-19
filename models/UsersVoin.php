<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.11.2015
 */

namespace models;
use models\_base\AbstractCapitalModel;

/**
 * Class Bank
 * @package components\Model
 *
 * @method $this|$this[] asModel()
 *
 * @property int $owner
 * @property int $voin
 *
 */
class UsersVoin extends AbstractCapitalModel
{
    /**
     * @param string $className
     * @return DtUserVars
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function tableName()
    {
        return 'users_voin';
    }

    public static function pkField()
    {
        return false;
    }

    public function getPk()
    {
        return false;
    }

    protected function fieldMap()
    {
        return array('owner','voin');
    }
}