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
 * @property int $user_id
 * @property string $action_type
 * @property int $rate_type
 * @property int $value
 * @property int $created_at
 * @property int $updated_at
 *
 */
class TopRate extends AbstractCapitalModel
{
    /**
     * @param string $className
     * @return TopRate
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function tableName()
    {
        return 'top_rate';
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
        return array('user_id','action_type','rate_type','value','created_at','updated_at',);
    }
}