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
 * @property int $id
 * @property int $num
 * @property int $nlevel
 * @property int $status
 * @property int $dayofweek
 * @property int $hourofday
 * @property int $timeouta
 * @property string $clanshort
 * @property string $clanashort1
 * @property string $clanashort2
 * @property int $lastpagegen
 * @property int $lastcoingen
 * @property int $pagenum
 * @property int $pagecolor
 * @property int $battle
 * @property int $tur_log
 *
 */
class Castles extends AbstractCapitalModel
{
    /**
     * @param string $className
     * @return Castles
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function tableName()
    {
        return 'castles';
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
        return array('id','num','nlevel','status','dayofweek','hourofday','timeouta','clanshort','clanashort1',
            'clanashort2','lastpagegen','lastcoingen','pagenum','pagecolor','battle','tur_log');
    }
}