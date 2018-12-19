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
 * @property string $var
 * @property int $val
 *
 */
class DtUserVars extends AbstractCapitalModel
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
        return 'dt_usersvar';
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
        return array('owner','var','val');
    }
}