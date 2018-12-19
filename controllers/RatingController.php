<?php
namespace controllers;

use Carbon\Carbon;
use components\slim\Slim;
use controllers\_base\WebController;
use models\Clans;
use models\EventRating;
use models\topsites\Top;
use models\User;

/**
 * Class SiteController
 * @package controllers
 */
class RatingController extends WebController
{
	public $ratingId;
	protected $iteration;

    /**
     * SiteController constructor.
     * @param Slim $container
     * @param $action
     * @param $id
     * @param $iteration
     * @throws \Exception
     */
    public function __construct(Slim $container, $action, $id, $iteration)
    {
        $this->ratingId = (int)$id;
        if($iteration !== null) {
        	$this->iteration = (int)$iteration;
		}

        parent::__construct($container, $action);
    }

    /**
     * @param $action
     * @return bool
     * @throws \Exception
     * @throws \ReflectionException
     */
    public function beforeAction($action)
    {
        $this->cache = false;
        return parent::beforeAction($action);
    }

    /**
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    public function indexAction()
    {
        try {
        	$Rating = EventRating::find('id = ?', [$this->ratingId])->asModel();
        	$iteration = !$this->iteration ? $Rating->iteration_num : $this->iteration;
        	if($Rating->id == 2 && $iteration < 4) {
				return $this->render('notfound');
			}
        	
			$db = $this->app->db;
			$rows = $db->createQuery()
				->select('u.*, uer.value as rate_value')
				->from('user_event_rating uer')
				->join('inner join users u on u.id=uer.user_id')
				->where('rating_id = ? and iteration_num = ?', [$this->ratingId, $iteration])
				->where('u.bot=0 AND u.klan!="radminion" and u.klan!="Adminion"')
				->orderBy('rate_value desc, uer.id asc')
				->limit(500)
				->execute()
				->fetchAll();
			$params = [
				'rows' => $rows,
				'description' => $Rating->description,
				'search' => false,
				'iteration' => $Rating->iteration_num,
				'show_prev' => $this->iteration ? false : true,
				'rating_id' => $Rating->id,
			];

			if(isset($_GET['uid'])) {
				$uid = (int)$_GET['uid'];

				$UserRating = $db->createQuery()
					->select('*')
					->from('user_event_rating uer')
					->where('rating_id = ? and iteration_num = ? and user_id = ?', [$this->ratingId, $iteration, $uid])
					->execute()
					->fetch();
				$position = false;
				$value = 0;
				if($UserRating) {
					$position1 = $db->createQuery()
						->select('count(*) as cnt')
						->from('user_event_rating uer')
						->join('inner join users u on u.id=uer.user_id')
						->where('uer.rating_id = ? and uer.iteration_num = ? and uer.value > ?', [$this->ratingId, $iteration, $UserRating['value']])
						->where('u.bot=0 AND u.klan!="radminion" and u.klan!="Adminion"')
						->execute()
						->fetch();
					$position2 = $db->createQuery()
						->select('count(*) as cnt')
						->from('user_event_rating uer')
						->join('inner join users u on u.id=uer.user_id')
						->where('uer.rating_id = ? and uer.iteration_num = ? and uer.value = ?', [$this->ratingId, $iteration, $UserRating['value']])
						->where('uer.id < ?', $UserRating['id'])
						->where('u.bot=0 AND u.klan!="radminion" and u.klan!="Adminion"')
						->execute()
						->fetch();

					$position = $position1['cnt'] + $position2['cnt'] + 1;
					$value = $UserRating['value'];
				}

				$params['search'] = [
					'position' 	=> $position,
					'user' 		=> User::findByPk($uid)->asArray(),
					'value' 	=> $value,
				];
			}

        	return $this->render('index', $params);
        } catch (\Exception $exception) {
            return $this->render('notfound');
        }

    }

    /**
     * @return string
     * @throws \ReflectionException
     */
    protected function getKeyCache()
    {
        return sprintf('html_%s_%s_%s', $this->getControllerId(), $this->actionId, $this->ratingId);
    }
}