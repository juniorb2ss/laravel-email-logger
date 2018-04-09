<?php namespace juniorb2ss\LaravelEmailLogger\Providers;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Illuminate\Cache\CacheManager
 * @see \Illuminate\Cache\Repository
 */
class EmailLoggerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'jemaillogger';
    }
}
