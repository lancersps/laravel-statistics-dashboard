<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Page\Entities\Page;
use Modules\Page\Repositories\PageRepository;
use Request;
use Modules\Dashboard\Services\StatisticsService;

class PublicController extends BasePublicController {

    /**
     * @var PageRepository
     */
    private $page;

    /**
     * @var Application
     */
    private $app;

    public function __construct(PageRepository $page, Application $app) {
        parent::__construct();
        $this->page = $page;
        $this->app = $app;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function homepage() {
        
        /**
         * Executing statistics
         */
        if (!isset($_COOKIE['Vstatistics'])) {
            StatisticsService::stat($_SERVER['REMOTE_ADDR']); // warning: not working on locale
        }

        return view('page::homepage', compact());
    }

}
