<?php

namespace Modules\Dashboard\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\User\Contracts\Authentication;
use Nwidart\Modules\Repository;
use Modules\Dashboard\Services\StatisticsService;
use Modules\Atraction\Entities\Atraction;

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
        $this->bootWidgets($modules);
        $this->auth = $auth;
    }

    public function index() {
        /**
         * Statistics data
         */
        $statistics['perMonth'] = $statisticsPerMonth = StatisticsService::getStatisticsPerMonth();
        $statistics['lastMonthCount'] = $statisticsLastMonthCount = StatisticsService::getLastMonthVisitsCount();
        $statistics['lastDayCount'] = $statisticsLastDayCount = StatisticsService::getLastDayVisitsCount();
        $statistics['uniqueIpAddresses'] = $statisticsUniqueIpAddresses = StatisticsService::getUniqueIpAddresses();
        $statistics['atractionCount'] = $statisticsAtractionCount = Atraction::all()->count();
        
        return view('dashboard::dashboard', compact('customWidgets', 'statistics'));
    }

}