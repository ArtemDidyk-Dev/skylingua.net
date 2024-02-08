<?php


namespace App\Services;


use App\Models\Product\ProductModel;

class ModelsService
{

    public static function getProductModelName($id,$defaultLanguage)
    {

        return ProductModel::where('id',$id)
            ->where('language_id', $defaultLanguage)
            ->join('products_models_translations', 'products_models_translations.model_id', '=', 'products_models.id')
            ->first();

    }

}
