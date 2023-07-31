<?php

namespace Helpers;
use CustomExceptions\ResourceNotFound;
use Illuminate\Database\Eloquent\Model;
use Exception;
class ResourceHelper
{
    public static function findResource($model,$resourceId){

        if(! ((new $model) instanceof Model)){
            throw new Exception("[Bad usage] the passed `model` within `findResource` method should be subclass of Eloquent\Model.");

        }
        return $model::query()->find($resourceId);
    }
    public static function findResourceOr404Exception($model, $resourceId) {

        $resource = self::findResource($model, $resourceId);
        if (! $resource) {

            throw new ResourceNotFound();
        }

        return $resource;
    }
}