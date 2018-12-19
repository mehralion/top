<?php
namespace controllers;

use Carbon\Carbon;
use components\slim\Slim;
use controllers\_base\WebController;
use models\Castles;
use models\Clans;
use models\topsites\Top;

/**
 * Class MainController
 * @package controllers
 */
class MainController extends WebController
{
    protected $year = null;
    protected $cache = false;

    /**
     * MainController constructor.
     * @param Slim $container
     * @param $action
     * @param int $year
     * @throws \Exception
     */
    public function __construct(Slim $container, $action, $year = 201609)
    {
        $this->year = (int)$year;
        parent::__construct($container, $action);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function indexAction()
    {
        $rows = array();
        $Pal = Top::find('memberid=7')->asArray();
        $rows[] = array(
            'id'            => 7,
            'url'           => starts_with($Pal['url'], ['http://', 'https://']) ? $Pal['url'] : 'http://'.ltrim($Pal['url'], '/'),
            'gif'           => filled($Pal['klan']) ? $Pal['klan'] : 0,
            'sitename'      => $Pal['sitename'],
            'hoststoday'    => $Pal['hoststoday'],
            'hitsin'        => $Pal['hitsin'],
        );

        /*
         * Для просмотра рейтинга за определенную дату
         * /rate?date=11.03.2018
         */
        $date = $this->app->request->get('date', Carbon::now()->format('dmY'));

        if (!Carbon::hasFormat($date, 'dmY')) {
            try {
                $date = Carbon::parse($date)->format('dmY');
            } catch (\Exception $exception) {
                $date = Carbon::now()->format('dmY');
            }
        }

        $List = Top::findAll(array(
            'condition' => 'cat = 0 and ban=0 and memberid!=7 and date like "%'.$date.' | %"',
            'order' => 'hoststoday DESC, hitsin DESC, allhosts DESC'
        ))->asArray();

        foreach ($List as $_item) {
            if($_item['hoststoday'] == 0 || $_item['hitsin'] == 0) {
                continue;
            }

            $rows[] = array(
                'id'            => $_item['memberid'],
                'url'           => starts_with($_item['url'], ['http://', 'https://']) ? $_item['url'] : 'http://'.ltrim($_item['url'], '/'),
                'gif'           => $_item['klan'] == '' ? 0 : $_item['klan'],
                'sitename'      => $_item['sitename'],
                'hoststoday'    => $_item['hoststoday'],
                'hitsin'        => $_item['hitsin'],
            );
        }
        
        $html = $this->render('vizits', compact('rows'));
        $this->app->cache->set($this->getKeyCache(), $html, 360);

        return $html;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function ruinesAction()
    {
        $db = $this->app->db;
        $rows = $db->createQuery()
            ->select('r.val AS rwcount,  u.*')
            ->from('ruines_var AS r, users AS u')
            ->where('r.var = "wins" AND u.id = r.owner')
            ->orderBy('rwcount DESC, u.login ASC')
            ->limit(100)
            ->execute()
            ->fetchAll();

        $html = $this->render('ruines', array(
            'rows' => $rows,
        ));
        $this->app->cache->set($this->getKeyCache(), $html, 360);

        return $html;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function warsAction()
    {
        $db = $this->app->db;
        $rows = $db->createQuery()
            ->select('co.*, cw.short as cwshort, cw.align as cwalign, cw.name as cwname, co.voinst+ifnull(cw.voinst,0) as allvoinst')
            ->from('clans co')
            ->join('left join clans cw on co.rekrut_klan=cw.id')
            ->where('(co.voinst+ifnull(cw.voinst,0)) > 0  AND co.base_klan=0')
            ->orderBy('co.voinst+ifnull(cw.voinst,0) desc')
            ->execute()
            ->fetchAll();

        $html = $this->render('wars', array(
            'rows' => $rows,
        ));
        $this->app->cache->set($this->getKeyCache(), $html, 360);

        return $html;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function pplAction()
    {
        $db = $this->app->db;
        $rows = $db->createQuery()
            ->select('*')
            ->from('users_voin uv')
            ->join('LEFT JOIN users u on u.id=uv.owner')
            ->where('u.bot=0 AND u.klan!="radminion" and u.klan!="Adminion"')
            ->orderBy('uv.voin desc')
            ->limit(100)
            ->execute()
            ->fetchAll();

        $html = $this->render('ppl', array(
            'rows' => $rows,
        ));
        $this->app->cache->set($this->getKeyCache(), $html, 360);

        return $html;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function castlesAction()
    {
        $placeholder = array(
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0,
            13 => 0,
            14 => 0,
        );

        $castles = array();
        $clans = array();

        $List = Castles::findAll('id != 155 and clanshort != ""')->asArray();
        foreach ($List as $_item) {
            if(!isset($castles[$_item['clanshort']])) {
                $castles[$_item['clanshort']] = $placeholder;
            }
            $castles[$_item['clanshort']][$_item['nlevel']]++;
        }

        if ($castles) {

            $ClanList = Clans::findAll('short in ('.Clans::getIN(array_keys($castles)).')', array_keys($castles))->asArray();
            foreach ($ClanList as $_item) {
                $clans[$_item['short']] = $_item;
            }

            uasort($castles, function($a, $b) {
                for($i = 9; $i < 15; $i++) {
                    if(!isset($a[$i])) {
                        $a[$i] = 0;
                    }
                    if(!isset($b[$i])) {
                        $b[$i] = 0;
                    }
                }
                if ($a[9]+$a[10]+$a[11]+$a[12]+$a[13]+$a[14] == $b[9]+$b[10]+$b[11]+$b[12]+$b[13]+$b[14]) {
                    return 0;
                }
                return ($a[9]+$a[10]+$a[11]+$a[12]+$a[13]+$a[14] > $b[9]+$b[10]+$b[11]+$b[12]+$b[13]+$b[14]) ? -1 : 1;
            });

        }

        $html = $this->render('castle', array(
            'clans'     => $clans,
            'castles'   => $castles,
        ));
        $this->app->cache->set($this->getKeyCache(), $html, 360);

        return $html;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function dtAction()
    {
        $db = $this->app->db;
        $rows = $db->createQuery()
            ->select('r.val AS rwcount,  u.*')
            ->from('dt_usersvar AS r, users AS u')
            ->where('r.var = "wins" AND u.id = r.owner')
            ->orderBy('rwcount DESC, u.login ASC')
            ->limit(100)
            ->execute()
            ->fetchAll();

        $html = $this->render('dt', array(
            'rows' => $rows,
        ));
        $this->app->cache->set($this->getKeyCache(), $html, 360);

        return $html;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function lotoAction()
    {
        $db = $this->app->db;
        $rows = array();
        try {
            $CurrentLoto = $db->createQuery()
                ->select('t.id')
                ->from('item_loto_ras t')
                ->where('status = 1')
                ->execute()
                ->fetch();
            if(!$CurrentLoto) {
                throw new \Exception;
            }

            $rows = $db->createQuery()
                ->select('t.id as ticket_id, t.item_name,  u.*')
                ->from('item_loto t, users u')
                ->where('u.id = t.owner and t.loto = ?', $CurrentLoto['id'] - 1)
                ->where('u.bot=0 AND u.klan!="radminion" and u.klan!="Adminion"')
                ->orderBy('t.cost_ekr desc, t.cost_kr desc')
                ->limit(100)
                ->execute()
                ->fetchAll();
        } catch (\Exception $ex) {

        }

        $html = $this->render('loto', array(
            'rows' => $rows,
        ));
        $this->app->cache->set($this->getKeyCache(), $html, 360);

        return $html;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function marafonAction()
    {
        $db = $this->app->db;
        $rows = array();
        try {
            $rows = $db
                ->select('uqe.count as rate_value, u.*')
                ->from('user_quest_event uqe, users u')
                ->where('u.id = uqe.user_id')
                ->where('u.bot=0 AND u.klan!="radminion" and u.klan!="Adminion"')
                ->where('uqe.date_event = ?', $this->year)
                ->orderBy('rate_value desc, id asc')
                ->limit(100)
                ->execute()
                ->fetchAll();

        } catch (\Exception $ex) {

        }

        $html = $this->render('marafon', array(
            'rows'      => $rows,
            'image'     => 'https://i.oldbk.com/i/badge/event_sept2016_icon%d.gif',
            'user_id'   => $this->app->webUser->isGuest() ? false : $this->app->webUser->getUser()->id,
            'year'		=> $this->year,
        ));


        $this->app->cache->set($this->getKeyCache(), $html, 360);

        return $html;
    }

    /**
     * @return string
     * @throws \ReflectionException
     */
    protected function getKeyCache()
    {
        return sprintf('html_%s_%s_%s', $this->getControllerId(), $this->actionId, $this->year);
    }

}