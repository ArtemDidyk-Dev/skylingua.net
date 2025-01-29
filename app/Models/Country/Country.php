<?php

namespace App\Models\Country;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function CountriesTranlations()
    {
        return $this->hasMany('App\Models\Country\CountryTranslation','country_id','id');
    }

    public static function getCountries($data = []) {

        $countries = Country::where('language_id', $data['languageID'])
            ->where('status', 1)
            ->join('countries_translations', 'countries.id', '=', 'countries_translations.country_id')
            ->orderBy('sort', 'ASC')
            ->limit( isset($data['limit']) && $data['limit'] > 0 ? (int)$data['limit'] : 9 )
            ->get();

        return $countries;

    }


    public static function getCountryByIso($data = []) {

        $country = Country::where('language_id', $data['languageID'])
            ->where('iso', $data['iso'])
            ->join('countries_translations', 'countries.id', '=', 'countries_translations.country_id')
            ->first();

        return $country;

    }

}
