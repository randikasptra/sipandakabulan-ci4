<?php

if (!function_exists('getFileFieldsFromModel')) {
    function getFileFieldsFromModel($modelInstance)
    {
        $fields = $modelInstance->allowedFields;
        $fileFields = [];

        foreach ($fields as $field) {
            if (str_ends_with($field, '_file')) {
                $indikator = str_replace('_file', '', $field);
                $label = ucwords(str_replace('_', ' ', $indikator));
                $fileFields[$indikator] = $label;
            }
        }

        return $fileFields;
    }
}
