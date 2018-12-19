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
 * @property string $short
 * @property string $name
 * @property string $descr
 * @property int $glava
 * @property string $vozm
 * @property string $align
 * @property string $mshadow
 * @property string $wshadow
 * @property string $homepage
 * @property string $chat
 * @property string $rekrut1
 * @property string $rekrut2
 * @property int $rekrut_klan
 * @property int $base_klan
 * @property int $voinst
 * @property int $messages
 * @property int $defch
 * @property int $tax_date
 * @property int $tax_timer
 * @property int $msg
 * @property int $time_to_del
 * @property int $warcancel
 *
 */
class Clans extends AbstractCapitalModel
{
    /**
     * @param string $className
     * @return Clans
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function tableName()
    {
        return 'clans';
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
        return array('id','short','name','descr','glava','vozm','align','mshadow','wshadow','homepage','chat','rekrut1',
            'rekrut2','rekrut_klan','base_klan','voinst','messages','defch','tax_date','tax_timer','msg','time_to_del',
            'warcancel');
    }

    public static function htmlFullFromArray($short, $align)
    {
        $align = sprintf('<img alt="" src="https://i.oldbk.com/i/align_%s.gif">', $short=='pal'?'1.99':$align);
        $klan = sprintf('<img title="%s" src="https://i.oldbk.com/i/klan/%s.gif">',
            $short=='pal'?'Орден паладинов':$short, $short);
        $name = sprintf('<b>%s</b>', $short=='pal'?'Орден паладинов':$short);
        $link = sprintf('<a target="_blank" style="text-decoration: none;" href="https://oldbk.com/encicl/clans.html?clan=%s"> <img alt="" src="https://i.oldbk.com/i/inf.gif"> </a>',
            $short);

        return sprintf('%s%s%s%s', $align, $klan, $name, $link);
    }
}