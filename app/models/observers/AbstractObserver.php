<?php 
namespace observers;

use \Cache;

abstract class AbstractObserver {

    protected function clearCacheTags($tags) {
        Cache::tags($tags)->flush();
    }

    protected function clearCacheSections($section) {
        Cache::section($section)->flush();
    }

}