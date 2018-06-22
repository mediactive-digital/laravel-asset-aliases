<?php

namespace MediactiveDigital\LaravelAssetAliases;

use \Illuminate\Support\Facades\Facade;

class LaravelAssetAliasesFacade extends Facade {

    protected static function getFacadeAccessor()
    {
        return AssetManager::class;
    }

}
