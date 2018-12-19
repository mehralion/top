<?php
namespace controllers;

use Carbon\Carbon;
use components\slim\Slim;
use controllers\_base\WebController;
use models\Clans;
use models\topsites\Top;

/**
 * Class SiteController
 * @package controllers
 */
class SiteController extends WebController
{
    protected $site_id;
    protected $action_type = 'site';

    /**
     * SiteController constructor.
     * @param Slim $container
     * @param $action
     * @param $id
     * @throws \Exception
     */
    public function __construct(Slim $container, $action, $id)
    {
        $this->site_id = (int)$id;

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

            $site = Top::find('memberid = ?', $this->site_id)->asArray();

            throw_unless($site, \Exception::class);

            if (str_contains($site['url'], '.')) {
                $site['url'] = starts_with($site['url'], ['http://', 'https://'])
                    ? trim($site['url'], '/')
                    : 'http://'.trim($site['url'], '/');

                $site['url'] = strtolower($site['url']);
            } else {
                $site['url'] = null;
            }

            $site['klan'] = $site['klan'] != 'align_1.99' ? $site['klan'] : 'pal';
            $site['klan_type'] = $site['klan'] != 'pal' ? 'Клан' : 'Орден';

            $clan = Clans::find('short=?', $site['klan'], ['short', 'align'])->asArray();

            $site['short'] = $clan && $clan['short']
                ? $clan['short']
                : null;

            $site['encicl'] = !is_null($site['short'])
                ? Clans::htmlFullFromArray($site['short'], $clan['align'])
                : null;

            $List = Top::findAll(array(
                'condition' => 'cat = 0 and ban=0 and memberid!=7 and date like "%'.(Carbon::now()->format('dmY')).' | %"',
                'order' => 'hoststoday DESC, hitsin DESC, allhosts DESC'
            ))->asArray();

            $rank = 0;

            foreach ($List as $k => $l) {
                if ($l['memberid'] === $site['memberid']) {
                    $rank = $k + 1;
                    break;
                }
            }

            return $this->render('index', compact('site','rank'));

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
        return sprintf('html_%s_%s_%s', $this->getControllerId(), $this->actionId, $this->site_id);
    }
}