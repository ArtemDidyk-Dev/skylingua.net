<?php


//Diller uchun
use App\Models\Language\LanguagePhrases;
use App\Models\Setting\Setting;
use Illuminate\Support\Facades\Cache;

function language($languageKey = null)
{


    if (!empty($languageKey)) {
        $languageID = app('request')->languageID;
        $currentLang = app('request')->currentLang;


        return Cache::rememberForever($currentLang . '.' . $languageKey, function () use ($languageKey, $languageID, $currentLang) {

            $data = LanguagePhrases::join('language_groups', 'language_groups.id', '=', 'language_phrases.language_group_id')
                ->join('language_phrase_translations', 'language_phrase_translations.phrase_id', '=', 'language_phrases.id')
                ->where('language_phrase_translations.language_id', $languageID)
                ->where('language_phrases.key', $languageKey)
                ->select('value', 'key')
                ->first();

            if ($data) {
                return !empty($data->value) ? $data->value : "";
            } else {
                return $languageKey;
            }


        });

    }


}

function setting($key, $param = false)
{

    if ($param == true) {


        $languageID = request('languageID');

        Cache::rememberForever('setting-' . $key . '-' . $languageID, function () use ($key, $languageID) {
            $setting = Setting::where('settings.key', $key)
                ->where('settings_translations.language_id', $languageID)
                ->join('settings_translations', 'settings.id', '=', 'settings_translations.setting_id')
                ->first();


            if (!is_null($setting)) {
                return !empty($setting->content) ? $setting->content : '';
            }

        });

        //Eger keshde bu varsa
        if (Cache::has('setting-' . $key . '-' . $languageID)) {
            return Cache::get('setting-' . $key . '-' . $languageID);
        }


    } else {

        Cache::rememberForever('setting-' . $key, function () use ($key) {
            $setting = Setting::where('key', $key)
                ->first();

            if ($setting) {
                return !empty($setting->content) ? $setting->content : '';
            }
        });

        //Eger keshde bu varsa
        if (Cache::has('setting-' . $key)) {
            return Cache::get('setting-' . $key);
        }


    }


}

function countryFlag($codeParam = null)
{
    $countries = countries();
    $flag = '';
    foreach ($countries as $country):
        $code = strtolower($country['iso_3166_1_alpha2']);

        if ($code == 'gb') {
            $code = 'en';
        } else {
            $code = $code;
        }

        if ($codeParam == $code) {
            $flag = asset('assets/images/flags') . '/' . $code . '.svg';
        }

    endforeach;

    return $flag;

}

function countryCode($codeParam = null, $codunEksi = false)
{
    $code = '';
    if (!$codunEksi) {
        if ($codeParam == 'gb') {
            $code = 'en';
        } else {
            $code = $codeParam;
        }
    } else {
        if ($codeParam == 'en') {
            $code = 'gb';
        } else {
            $code = $codeParam;
        }
    }


    return $code;

}

function countryNameChange($name)
{
    $languageName = '';
    if ($name == 'United Kingdom') {
        $languageName = 'English';
    } elseif ($name == 'Россия') {
        $languageName = 'Russia';
    } else {
        $languageName = $name;
    }

    return $languageName;
}

function is_base64($data)
{
    $base64Parcala = explode(',', $data);


    if ($base64Parcala[0] == 'data:image/jpeg;base64') {
        if (base64_encode(base64_decode($base64Parcala[1], true)) === $base64Parcala[1]) {
//            echo 'Ok';
            return true;

        } else {
//        echo 'bae64 degil';
            return false;
        }
    } else {
//            echo 'Foto formati sehvdir';
        return false;
    }


}

function compressImgFile($source, $destination, $quality)
{

    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);

    imagejpeg($image, $destination, $quality);

    return $destination;
}


function myErrors($errors)
{
    if ($errors->any()):
        ?>
        <div class="alert alert-my-danger"> <?php
            ?>
            <ul> <?php
                foreach ($errors->all() as $key => $error) {
                    ?>
                    <li> <?php
                        preg_match('@<span>\[\[\@(.*?).(.*?)\@\]\]</span>@', $error, $fotolar);
                        //Eger array boshdursa dil yoxdur
                        if (!in_array('', $fotolar)) {
                            echo $error;
                        } else {
                            //dil id sini almaqcun parchaladim
                            $parchala = explode('.', $fotolar[2])[1];
                            foreach (cache('key-all-languages') as $item):
                                if ($parchala == $item->id) {
                                    $photo = preg_replace('@<span>\[\[\@(.*?).(.*?)\@\]\]</span>@', '(' . mb_strtolower($item->short_name) . ')', $error);
                                    echo $photo;
                                }

                            endforeach;

                        }

                        ?>  </li> <?php
                }

                ?>
            </ul>
        </div>
    <?php

    endif;
}

function myError($error)
{


    preg_match('@<span>\[\[\@(.*?).(.*?)\@\]\]</span>@', $error, $fotolar);
    //Eger array boshdursa dil yoxdur
    if (!in_array('', $fotolar)) {
        echo $error;
    } else {
        //dil id sini almaqcun parchaladim
        $parchala = explode('.', $fotolar[2])[1];
        foreach (cache('key-all-languages') as $item):
            if ($parchala == $item->id) {
                $photo = preg_replace('@<span>\[\[\@(.*?).(.*?)\@\]\]</span>@', '(' . mb_strtolower($item->short_name) . ')', $error);
                echo $photo;
            }

        endforeach;

    }


}

function uniqueSlug($model, $title = '')
{
    $slug = \Illuminate\Support\Str::slug($title);
    //get unique slug...
    $nSlug = $slug;
    $i = 0;


    $model = str_replace(' ', '', $model);

    while (($model::whereSlug($nSlug)->count()) > 0) {
        $i++;
        $nSlug = $slug . '-' . $i;
    }
    if ($i > 0) {
        $newSlug = substr($nSlug, 0, strlen($slug)) . '-' . $i;
    } else {
        $newSlug = $slug;
    }
    return $newSlug;
}

function getTranslateData($array,$languageID,$field)
{
    /**
     * Bu function databaseden gelen datalarin blade
     * icersinde duzgun inputlara yazilmaqi uchundur
     */

    foreach ($array as $tranlationData):
        if ($tranlationData->language_id == $languageID):
            return $tranlationData->$field;
        endif;
    endforeach;

}

function getTranslateAttributeData($array,$languageID,$attributeID,$field)
{
    /**
     * Bu function databaseden gelen datalarin blade
     * icersinde duzgun inputlara yazilmaqi uchundur
     */


    foreach ($array as $tranlationData):
        if($attributeID == $tranlationData->attribute_id){
            if ($tranlationData->language_id == $languageID):
                return $tranlationData->$field;
            endif;
        }

    endforeach;

}

function updateDate($updateDate,$translateUpdateDate){
    $updateAt = '';
    foreach ($translateUpdateDate as $item):
        if($updateDate > $item->updated_at){
            $updateAt = $updateDate;
        }else{
            $updateAt = $item->updated_at;
        }
    endforeach;

    return \Illuminate\Support\Carbon::parse($updateAt)->format('Y-m-d H:i');

}

function str_limit($text,$limit = 100,$delimiter = '...'){

    $textLan  = mb_strlen($text);
    if($textLan > $limit){
        $text = mb_substr($text,0,$limit).' '.$delimiter;
    }


    return $text;

}

function stripinput($text) {
    if (!is_array($text)) {
        $text = stripslashes(trim($text));
        $text = preg_replace("/(&amp;)+(?=\#([0-9]{2,3});)/i", "&", $text);
        $search = array("&", "\"", "'", "\\", '\"', "\'", "<", ">", "&nbsp;");
        $replace = array("&amp;", "&quot;", "&#39;", "&#92;", "&quot;", "&#39;", "&lt;", "&gt;", " ");
        $text = str_replace($search, $replace, $text);
    } else {
        foreach ($text as $key => $value) {
            $text[$key] = stripinput($value);
        }
    }
    return $text;
}

function bytesToHuman($bytes)
{
    $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];

    for ($i = 0; $bytes > 1024; $i++) {
        $bytes /= 1024;
    }

    return round($bytes, 2) . ' ' . $units[$i];
}

function price_format($price) {
    $price = (float)$price;
    $price = number_format($price, 2, ".", " ") . config('pay.currencyIcon');

    return $price;
}



function array_values_recursive_empty($object) {
    foreach ($object as $key => $value)
    {
        if (is_object($value))
        {
            $object->$key = array_values_recursive_empty($value);
        } else {
            $object->$key = "";
        }
    }

    return  $object;
}


function sentenceText($text) {
    $arr = preg_split('/(?=[A-Z])/',$text);

    $text = implode(" ", $arr);
    $text = ucfirst($text);

    return $text;
}

function is_json($string) {
    try {
        json_decode($string);
    } catch (Exception $msg) {
        return false;
    }
    return json_last_error() === JSON_ERROR_NONE;

}


function key_get_parents($subject, $array)
{
    foreach ($array as $key => $value)
    {
        if (is_array($value))
        {
            if (in_array($subject, array_keys($value))) {
                return array($key);
            } else {
                $chain = key_get_parents($subject, $value);
                if (!is_null($chain))
                    return array_merge(array($key), $chain);
            }
        } else if (is_object($value)) {
            $value = (array) $value;
            if (in_array($subject, array_keys($value))) {
                return array($key);
            } else {
                $chain = key_get_parents($subject, $value);
                if (!is_null($chain))
                    return array_merge(array($key), $chain);
            }
        }
    }

    return null;
}

function custom_input($arr, $title = "", $global = []) {

    $global = $global ? $global : $arr;

    $return = '
        <div class="card mb-4">
            <div class="card-body row">
    ';

    $return2 = "";

    $say = 0;

    if($arr) {
        $amountFee = "";
        $amountOrginal = "";
        foreach ($arr as $key_info => $val_info) {
            if ($key_info == "amountFee"){
                $amountFee = $val_info;
            }
            if ($key_info == "amountOrginal") {
                $amountOrginal = $val_info;
            }
        } // foraech info
        foreach ($arr as $key => $val) {

            if (is_object($val)) {
                $return2 .= custom_input($val, $key, $global);
            } else {

                $parent = [];
                $key_get_parents = key_get_parents($key, $global);
                if($key_get_parents) {
                    foreach ($key_get_parents as $key_get_vel) {
                        $parent[] = "[". $key_get_vel ."]";
                        if($key == "address") {
                            $parent[] = "[address]";
                        }
                    }
                }

                if ($title && !empty($title) && $say == 0) {
                    if ($title == "corporateReceiver" || $title == "individualReceiver") {
                        $return .= '<h3>Account Holder</h3>';
                    } else {
                        $return .= '<h3>' . sentenceText($title) . '</h3>';
                    }
                }


                if ($key == "receiverCountry" || $key == "country") {
                    $return .= '
                        <div class="col-12 col-md-6 mt-0">
                            <div class="form-group ">
                                <label for="paymentField_' . $key . '" class="mb-2">' . sentenceText($key) . '</label>
                                <select
                                    name="paymentField'. (isset($parent) && is_array($parent) ? implode("", $parent) : "") .'[' . $key . ']"
                                    class="form-control w-100 my-select-option"
                                    id="paymentField_' . $key . '"
                                    required="required"
                                >
                    ';
//                                    <option value="">' . language('frontend.common.select') . '</option>

//                    $countries = countries();
//                    foreach ($countries as $country) {
////                        if ($country['iso_3166_1_alpha2'] != 'AM' && $country['iso_3166_1_alpha2'] != 'RU') {
//                        if (in_array($country['name'], config('pay.countryWhiteList'))) {
//                            $return .= '<option value="' . $country['iso_3166_1_alpha2'] . '"' . ($country['iso_3166_1_alpha2'] == $val ? " selected" : "") . '>' . $country['name'] . '</option>';
//                        } // if Filter
//                    }

                    $filter_countries = [
                        'languageID' => 1,
                        'limit' => 9999,
                        'sort' => "name",
                        'order' => "ASC"
                    ];
                    $countries = \App\Models\Country\Country::getCountries($filter_countries);
                    foreach ($countries as $country) {
                        if ($country->iso == $val) {
                            $return .= '<option value="' . $country->iso . '"' . ($country->iso == $val ? " selected" : "") . '>' . $country->name . '</option>';
                        }
                    }

                    $return .= '
                                </select>
                            </div>
                        </div>
                    ';
                } elseif ($key == "paymentDetails") {
                    $return .= '
                    <div class="col-12 col-md-12">
                        <label for="paymentField_' . $key . '" class="form-label">' . sentenceText($key) . '</label>
                        <div class="input-group mb-3">
                            <textarea
                                name="paymentField'. (isset($parent) && is_array($parent) ? implode("", $parent) : "") .'[' . $key . ']"
                                class="form-control"
                                id="paymentField_' . $key . '"
                                rows="5"
                            >' . $val . '</textarea>
                        </div>
                    </div>
                    ';
                } elseif ($key == "clientOrderId" || $key == "currency" || $key == "senderIban" || $key == "amountFee" || $key == "amountOrginal") {
                    $return .= '
                    <input
                        name="paymentField'. (isset($parent) && is_array($parent) ? implode("/", $parent) : "") .'[' . $key . ']"
                        type="hidden"
                        value="' . $val . '"
                    >
                    ';
                } else {
                    $return .= '
                    <div class="col-12 col-md-6">
                        <label for="paymentField_' . $key . '" class="form-label">' . sentenceText($key) . '</label>
                        <div class="input-group mb-3">
                            <input
                                name="paymentField'. (isset($parent) && is_array($parent) ? implode("", $parent) : "") .'[' . $key . ']"
                                type="text"
                                class="form-control"
                                id="paymentField_' . $key . '"
                                value="' . $val . '"
                                required="required"
                                ' . ($key == "amount" ? ' readonly' : '') . '
                                ' . ($key == "amount" ? ' style="background-color: #fff"' : '') . '
                            >
                            ' . ($key == "amount" ? '<span class="input-group-text">&pound;</span>' : '') . '
                        </div>
                        ' . ($key == "amount" ? '<span class="feeProsent text-muted">'. language('Orginal amount:') .' '. price_format($amountOrginal) .' | '. language('Fee:') .' '. price_format($amountFee) .'</span>' : '') . '
                    </div>
                    ';
                }

            }

            $say++;

        } // foreach

        $return .= '
                </div>
            </div>
        ';


    }
    return $return . $return2;
}

function payment_info($arr, $title = "", $global = []) {

    $global = $global ? $global : $arr;

    $return = '
        <div class="card mb-4">
            <div class="card-body row">
    ';

    $return2 = "";

    $say = 0;

    if($arr) {
        foreach ($arr as $key => $val) {

            if (is_object($val) || is_array($val)) {
                $return2 .= payment_info($val, $key, $global);
            } else {

                $parent = [];
                $key_get_parents = key_get_parents($key, $global);
                if($key_get_parents) {
                    foreach ($key_get_parents as $key_get_vel) {
                        $parent[] = "[". $key_get_vel ."]";
                        if($key == "address") {
                            $parent[] = "[address]";
                        }
                    }
                }

                if ($title && !empty($title) && $say == 0) {
                    $return .= '<h3>' . sentenceText($title) . '</h3>';
                }


                if ($key == "receiverCountry" || $key == "country") {
                    $return .= '
                        <div class="col-12 col-md-6 mt-0">
                            <div class="form-group ">
                                <label for="paymentField_' . $key . '" class="mb-2">' . sentenceText($key) . '</label>
                                <div class="input-group mb-3">
                    ';
                    $countries = countries();
                    foreach ($countries as $country) {
                        if ($country['iso_3166_1_alpha2'] == $val) {
                            $return .= ''. $country['name'] .'';
                        }
                    }
                    $return .= '
                                </div>
                            </div>
                        </div>
                    ';
                } elseif ($key == "paymentDetails") {
                    $return .= '
                    <div class="col-12 col-md-6">
                        <label for="paymentField_' . $key . '" class="form-label">' . sentenceText($key) . '</label>
                        <div class="input-group mb-3">
                            '. $val .'
                        </div>
                    </div>
                    ';
                } elseif ($key == "clientOrderId" || $key == "currency" || $key == "senderIban" || $key == "amountFee" || $key == "amountOrginal") {
                    $return .= "";
                } else {
                    $return .= '
                    <div class="col-12 col-md-6">
                        <label for="paymentField_' . $key . '" class="form-label">' . sentenceText($key) . '</label>
                        <div class="input-group mb-3">
                            '. $val .'
                            ' . ($key == "amount" ? '&pound;' : '') . '
                        </div>
                    </div>
                    ';
                }

            }

            $say++;

        } // foreach

        $return .= '
                </div>
            </div>
        ';


    }
    return $return . $return2;
}

function payment_info_admin($arr, $title = "", $global = []) {

    $global = $global ? $global : $arr;

    $return = '
        <div class="card mb-4">
            <div class="card-body row">
    ';

    $return2 = "";

    $say = 0;

    if($arr) {
        foreach ($arr as $key => $val) {

            if (is_object($val) || is_array($val)) {
                $return2 .= payment_info_admin($val, $key, $global);
            } else {

                $parent = [];
                $key_get_parents = key_get_parents($key, $global);
                if($key_get_parents) {
                    foreach ($key_get_parents as $key_get_vel) {
                        $parent[] = "[". $key_get_vel ."]";
                        if($key == "address") {
                            $parent[] = "[address]";
                        }
                    }
                }

                if ($title && !empty($title) && $say == 0) {
                    $return .= '<h4 style="width:100%; display: block">' . sentenceText($title) . '</h4>';
                }


                if ($key == "receiverCountry" || $key == "country") {
                    $return .= '
                        <div class="col-12 col-md-6 mt-0">
                            <div class="form-group ">
                                <label for="paymentField_' . $key . '" class="mb-2">' . sentenceText($key) . '</label>
                                <div class="input-group mb-3">
                    ';
                    $countries = countries();
                    foreach ($countries as $country) {
                        if ($country['iso_3166_1_alpha2'] == $val) {
                            $return .= '<b>'. $country['name'] .'</b>';
                        }
                    }
                    $return .= '
                                </div>
                            </div>
                        </div>
                    ';
                } elseif ($key == "paymentDetails") {
                    $return .= '
                    <div class="col-12 col-md-6">
                        <label for="paymentField_' . $key . '" class="form-label">' . sentenceText($key) . '</label>
                        <div class="input-group mb-3">
                            <b>'. $val .'</b>
                        </div>
                    </div>
                    ';
                } elseif ($key == "clientOrderId" || $key == "currency") {
                    $return .= "";
                } else {
                    $return .= '
                    <div class="col-12 col-md-6">
                        <label for="paymentField_' . $key . '" class="form-label">' . sentenceText($key) . '</label>
                        <div class="input-group mb-3">
                            <b>'. $val .'
                            ' . ($key == "amount" ? '&pound;' : '') . '</b>
                        </div>
                    </div>
                    ';
                }

            }

            $say++;

        } // foreach

        $return .= '
                </div>
            </div>
        ';


    }
    return $return . $return2;
}






