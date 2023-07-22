<?php

namespace Mixins;

use CustomExceptions\BadRequestException;
use Helpers\RequestHelper;

trait DatabaseRulesValidation
{
    /**
     * @throws BadRequestException
     */
    private function validateRuleIsUnique($key, $value, $level, $model): void
    {

        if ($value == null)
        {
            return;
        }

        $fetchedModel = $model::query()->where($key, $value)->first();

        if ($fetchedModel === null)
        {
            return;
        }

        $modelId = RequestHelper::extractResourceIdFromRequestPath();

        $isUpdatedFlag = true;

        if ($modelId)
        {
            $matchedModel = $model::query()->find($modelId);

            if ($matchedModel->$key == $fetchedModel->$key)
            {
                $isUpdatedFlag = false;
            }
        }

        if ($fetchedModel && $isUpdatedFlag)
        {

            throw new BadRequestException(" $key (in $level) within value = $value should be unique dear user :) ");
        }
    }
}
