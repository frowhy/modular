<?php
/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2017/11/28
 * Time: 上午10:16
 */

namespace Modules\Core\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Core\Abstracts\TransformerAbstract;
use Modules\Core\Supports\Response;
use Session;

trait TransformerStructureTrait
{
    private $transform;
    private $field;

    public function transform($transform)
    {
        $this->transform = $transform;
        $this->field = $this->fields($transform);
        $this->parseRequestedFields();
        $this->parseExcludeFields();

        return $this->field;
    }

    protected function parseRequestedFields()
    {
        $class = class_basename($this->transform);
        $param = Response::param('requested_fields') ?? Session::get("{$class}.requested_fields");
        if (!is_null($param)) {
            if (is_array($param)) {
                $requestedFields = $param;
            } else {
                $requestedFields = explode(',', $param);
            }

            if ($requestedFields) {

                foreach ($requestedFields as $requestedField) {

                    if ($this instanceof TransformerAbstract) {

                        $scope = null;

                        if (Str::contains($requestedField, '.')) {
                            $requestedFieldArray = explode('.', $requestedField);
                            $length = count($requestedFieldArray);
                            $requestedField = Arr::last($requestedFieldArray);
                            Arr::forget($requestedFieldArray, $length - 1);
                            $scope = implode('.', $requestedFieldArray);
                        }

                        if ($scope === $this->getCurrentScope()->getIdentifier()) {
                            $this->field = Arr::only($this->field, $requestedField);
                        }
                    }
                }
            }
        }
    }

    protected function parseExcludeFields()
    {
        $class = class_basename($this->transform);
        $param = Response::param('exclude_fields') ?? Session::get("{$class}.exclude_fields");

        if (!is_null($param)) {
            if (is_array($param)) {
                $excludeFields = $param;
            } else {
                $excludeFields = explode(',', $param);
            }

            if ($excludeFields) {

                foreach ($excludeFields as $excludeField) {

                    if ($this instanceof TransformerAbstract) {

                        $scope = null;

                        if (Str::contains($excludeField, '.')) {
                            $excludeFieldArray = explode('.', $excludeField);
                            $length = count($excludeFieldArray);
                            $excludeField = Arr::last($excludeFieldArray);
                            Arr::forget($excludeFieldArray, $length - 1);
                            $scope = implode('.', $excludeFieldArray);
                        }

                        if ($scope === $this->getCurrentScope()->getIdentifier()) {
                            if (Arr::has($this->field, $excludeField)) {
                                $this->field = Arr::except($this->field, $excludeField);
                            }
                        }
                    }
                }
            }
        }
    }
}
