<?php
namespace controllers;
use controllers\_base\WebController;
use helpers\Json;
use models\TopList;
use models\User;

/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 18.11.2015
 *
 */
abstract class GetGiveRateController extends WebController
{
    protected $action_type;
    protected $image;
    protected $year = null;

    protected abstract function prepareImg($user, $position);

    public function indexAction()
    {
        $db = $this->app->db;

        $get_rows = $db->createQuery()
            ->select('u.login, u.align, u.id, u.klan, u.level, u.sex, tr.value as rate_value, u.block')
            ->from('top_rate tr')
            ->join('LEFT JOIN users u on tr.user_id=u.id')
            ->where('u.bot=0 and u.klan!="radminion" and u.klan!="Adminion"')
            ->where('tr.action_type=? and tr.rate_type=?', array($this->action_type, 2))
            ->orderBy('rate_value desc, updated_at desc')
            ->limit(100)
            ->execute()
            ->fetchAll();

        $give_rows = $db->createQuery()
            ->select('u.login, u.align, u.id, u.klan, u.level, u.sex, tr.value as rate_value, u.block')
            ->from('top_rate tr')
            ->join('LEFT JOIN users u on tr.user_id=u.id')
            ->where('u.bot=0 and u.klan!="radminion" and u.klan!="Adminion"')
            ->where('tr.action_type=? and tr.rate_type=?', array($this->action_type, 1))
            ->orderBy('rate_value desc, updated_at desc')
            ->limit(100)
            ->execute()
            ->fetchAll();

        $html = $this->render('index', array(
            'get_rows'  => $get_rows,
            'give_rows' => $give_rows,
            'image'     => $this->image,
            'user_id'   => $this->app->webUser->isGuest() ? false : $this->app->webUser->getUser()->id,
            'year'      => $this->year,
        ));
        $this->app->cache->set($this->getKeyCache(), $html, 360);

        return $html;
    }

    public function searchAction()
    {
        $login = $this->app->request->post('login');
//        $login = iconv('utf-8', 'windows-1251', $login);
        $user = User::find('login = ?', array($login))->asArray();
        if(!$user) {
            return $this->renderJSON(array('message' => sprintf('%s не входит в топ 100', $login)));
        }
        $type = $this->app->request->post('r');
        $db = $this->app->db;
        $UserPosition = $db->createQuery()
            ->select('tr.value, tr.updated_at')
            ->from('top_rate tr')
            ->where('tr.action_type = ? and tr.rate_type = ? and tr.user_id = ?', array($this->action_type, $type, $user['id']))
            ->execute()
            ->fetch();
        if(!$UserPosition) {
            return $this->renderJSON(array('message' => sprintf('%s не входит в топ 100', $login)));
        }

        $value = $UserPosition['value'];
        $updated_at = $UserPosition['updated_at'];

        $UserPosition = $db->createQuery()
            ->select('count(tr.user_id) as cnt')
            ->from('top_rate tr')
            ->join('left join users u on u.id = tr.user_id')
            ->where('u.bot=0 AND u.klan!="radminion" and u.klan!="Adminion"')
            ->where('tr.action_type = ? and tr.rate_type = ? and tr.value > ?', array($this->action_type, $type, $value))
            ->execute()
            ->fetch();
        $position_temp = $UserPosition['cnt'];

        $UserPosition = $db->createQuery()
            ->select('count(tr.user_id) as cnt')
            ->from('top_rate tr')
            ->join('left join users u on u.id = tr.user_id')
            ->where('u.bot=0 AND u.klan!="radminion" and u.klan!="Adminion"')
            ->where('tr.action_type = ? and tr.rate_type = ? and tr.value = ? and tr.updated_at > ?',
                array($this->action_type, $type, $value, $updated_at))
            ->execute()
            ->fetch();
        $rate_position = $position_temp + $UserPosition['cnt'] + 1;

        if($rate_position == 0 || $rate_position > 100) {
            return $this->renderJSON(array('message' => sprintf('%s не входит в топ 100', $login)));
        }

        $img_num = 1;
        if ($rate_position > 10 && $rate_position < 51) {
            $img_num = 2;
        } elseif ($rate_position > 50 && $rate_position < 101) {
            $img_num = 3;
        }

        $html = $this->renderPartial('search', array(
            'image' => $this->prepareImg($user, $img_num),
            'user' => $user,
            'value' => $value,
            'position' => $rate_position,
            'year'      => $this->year,
        ));

        return $this->renderJSON(array(
            'html' => $html
        ));
    }
}