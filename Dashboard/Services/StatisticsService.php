<?php

namespace Modules\Dashboard\Services;

use Modules\Dashboard\Entities\Statistic;
use Carbon\Carbon;

/**
 * =============================================================================
 * Service class with static methods for dashboard statistics.
 * It gets a user IP address from $_SESSION global object and
 * returns user location attributes (by doing request to external service)
 * =============================================================================
 * 
 * @author Ivan Dublianski
 * @since 2016
 */

class StatisticsService {
    
    public static function stat($ip) {
        if(!empty($ip)){
            try {
                $location = self::locationQuery($ip);
                
                /**
                 * Set cookie to 1 month
                 */
                setcookie("Vstatistics", 1, time() +  (86400 * 30));  // 86400 = 1 day

                try {
                    self::createEntity($location);
                }catch (Exception $ex) {}
            } catch (Exception $ex) {
//                echo 'Caught exception: ',  $ex->getMessage(), "\n";
            }
        }
        
        return $location;
    }
    
    public static function locationQuery($ip){
       $location = json_decode(file_get_contents('http://freegeoip.net/json/'.$ip), true);
       
       return $location;
    }
    
    public static function createEntity($location) {
        Statistic::create($location);
    }
    
     public static function getStatisticsPerMonth() {
        $currentMonth = date('n');
        $from = date('n', strtotime('-5 month'));
        $entities = Statistic::whereBetween(\DB::raw('MONTH(created_at)'), [$from, $currentMonth])->orderBy('created_at', 'ASC')->get();
        
        $statistics = array();
        foreach ($entities as $entity) {
            $month = $entity->created_at->format('F');
            $statistics[$month][] = $entity->id;
        }
        
        $str = '[';
        foreach ($statistics as $k => $v) {
            $str .= '["'.$k.'", '.count($v).'], ';
        }
        $str .= ']';
        
        return $str;
     }
     
     public static function getLastMonthVisitsCount(){
        $currentMonth = date('n');
        $from = date('n', strtotime('-5 month'));
        $entitiesCount = Statistic::whereBetween(\DB::raw('MONTH(created_at)'), [$from, $currentMonth])->whereMonth('created_at', '=', date('n'))->count();

        return $entitiesCount;
    }
    public static function getLastDayVisitsCount(){
        $currentMonth = date('n');
        $from = date('n', strtotime('-5 month'));
        $entitiesCount = Statistic::whereDate('created_at', '=', Carbon::today()->toDateString())->count();

        return $entitiesCount;
    }
    
    public static function getUniqueIpAddresses(){
        $currentMonth = date('n');
        $from = date('n', strtotime('-5 month'));
        $entitiesCount = Statistic::whereBetween(\DB::raw('MONTH(created_at)'), [$from, $currentMonth])->groupBy('ip')->get()->count();
        
        return $entitiesCount;
    }
    
    
//    public static function getMostPopularCities(){
//        $currentMonth = date('n');
//        $from = date('n', strtotime('-5 month'));
//        $entities = Statistic::whereBetween(\DB::raw('MONTH(created_at)'), [$from, $currentMonth])->orderBy('city')->get(['city']);
//        
//        dd($entities);
//        
//    }
    
}
