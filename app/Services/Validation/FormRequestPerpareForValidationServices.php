<?php
namespace App\Services\Validation;

class FormRequestPerpareForValidationServices{
    public static function filterNullAndEmptyFields(array $input){
        return array_filter($input,function($value){
            return !is_null($value) && $value !='';
        });
    }
}