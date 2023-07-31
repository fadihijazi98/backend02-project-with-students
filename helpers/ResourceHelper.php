<?php

namespace Helpers;

use CustomExceptions\ResourceNotFound;
use Illuminate\Database\Eloquent\Model;
use Exception;

class ResourceHelper
{

    public static function loadOnly($attributes, $resource) {

        if (!is_array($attributes)) {

            throw new Exception("[Bad usage] the passed `attributes` should be array.");
        }
        if (! ($resource instanceof Model)) {

            throw new Exception("[Bad usage] the passed `resource` method should be instance of Eloquent\Model.");
        }

        $loaded_data = [];
        foreach ($attributes as $attribute) {

            $loaded_data[$attribute] = $resource->$attribute;
        }

        return $loaded_data;
    }

    public static function loadOnlyForList($attributes, $resources) {

        $loaded_collection = [];
        foreach ($resources as $resource) {

            $loaded_collection[] = self::loadOnly($attributes, $resource);
        }
        return $loaded_collection;
    }

    /**
     * @throws Exception when model isn't subclass of Eloquent\Model.
     */
    public static function findResource($model, $resourceId, $with = []) {

        if (! ((new $model) instanceof Model)) {

            throw new Exception("[Bad usage] the passed `model` within `findResource` method should be subclass of Eloquent\Model.");
        }

        return $model::query()->with($with)->find($resourceId);
    }

    /**
     * @throws ResourceNotFound when corresponding model match by resourceId isn't exists.
     * @throws Exception
     */
    public static function findResourceOr404Exception($model, $resourceId, $with = []) {

        $resource = self::findResource($model, $resourceId, $with);
        if (! $resource) {

            throw new ResourceNotFound();
        }

        return $resource;
    }
}