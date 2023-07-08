<?php

namespace Mixins;

use CustomExceptions\BadRequestException;
use Helpers\RequestHelper;
use Illuminate\Database\Eloquent\Model;

trait DatabaseRulesValidation
{

    /**
     * The implementation of `unique` rule.
     * @throws BadRequestException
     */
    private function validate_rule_is_unique($key, $value, $level, $model) {

        if ($value == null) {
            return;
        }

        /**
         * @var Model $model
         */
        $fetchedModel = $model::query()->where($key, $value)->first();
        if ($fetchedModel === null) {

            return;
        }

        $modelId = RequestHelper::extractResourceIdFromRequestPath();

        $isUpdatedFlag = true;
        if ($modelId) {

            $matchedModel = $model::query()->find($modelId);
            if ($matchedModel->$key == $fetchedModel->$key) {

                $isUpdatedFlag = false;
            }
        }

        if ($fetchedModel && $isUpdatedFlag) {

            throw new BadRequestException("$key (in $level) within value = $value should be unique.");
        }
    }
}