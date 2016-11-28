<?php

namespace Modules\Dashboard\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\User\Contracts\Authentication;
use Nwidart\Modules\Repository;
use Modules\Dashboard\Services\StatisticsService;

class DashboardController extends AdminBaseController {

    /**
     * @var Authentication
     */
    private $auth;

    /**
     * @param Repository $modules
     * @param Authentication $auth
     */
    public function __construct(Repository $modules, Authentication $auth) {
        parent::__construct();
        $this->auth = $auth;
    }

    public function index() {
        /**
         * Statistics data
         */
        $statistics['perMonth'] = StatisticsService::getStatisticsPerMonth();
        $statistics['lastMonthCount'] = StatisticsService::getLastMonthVisitsCount();
        $statistics['lastDayCount'] = StatisticsService::getLastDayVisitsCount();
        $statistics['all'] = StatisticsService::getAllCount();
        $statistics['uniqueIpAddresses'] = StatisticsService::getUniqueIpAddresses();
        
        return view('dashboard::dashboard', compact('customWidgets', 'statistics'));
    }

}