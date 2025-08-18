<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CommonService
{

    public static function refererError($id)
    {
        $lastSlashData = Str::afterLast(request()->headers->get('referer'), '/');

        if ($lastSlashData != $id) {
             return true;
        }
    }

    public static function socialIcons()
    {

        /**
         * QEYD: bunlar eslinde bashliqlarinda bele ishleyir
         * socicon- meselen <i class="socicon-youtube"></i>
         */

        return [
            '500px',
            '8tracks',
            'airbnb',
            'alliance',
            'amazon',
            'amplement',
            'android',
            'angellist',
            'apple',
            'appnet',
            'baidu',
            'bandcamp',
            'battlenet',
            'beam',
            'bebee',
            'bebo',
            'behance',
            'blizzard',
            'blogger',
            'buffer',
            'chrome',
            'coderwall',
            'curse',
            'dailymotion',
            'deezer',
            'delicious',
            'deviantart',
            'diablo',
            'digg',
            'discord',
            'disqus',
            'douban',
            'draugiem',
            'dribbble',
            'drupal',
            'ebay',
            'ello',
            'endomodo',
            'envato',
            'etsy',
            'facebook',
            'feedburner',
            'filmweb',
            'firefox',
            'flattr',
            'flickr',
            'formulr',
            'forrst',
            'foursquare',
            'friendfeed',
            'github',
            'goodreads',
            'google',
            'googlegroups',
            'googlephotos',
            'googleplus',
            'grooveshark',
            'hearthstone',
            'hellocoton',
            'heroes',
            'hitbox',
            'horde',
            'houzz',
            'icq',
            'identica',
            'imdb',
            'instagram',
            'issuu',
            'istock',
            'itunes',
            'keybase',
            'lanyrd',
            'lastfm',
            'line',
            'linkedin',
            'livejournal',
            'lyft',
            'macos',
            'mail',
            'medium',
            'meetup',
            'mixcloud',
            'modelmayhem',
            'mumble',
            'myspace',
            'newsvine',
            'nintendo',
            'odnoklassniki',
            'openid',
            'opera',
            'outlook',
            'overwatch',
            'patreon',
            'paypal',
            'periscope',
            'persona',
            'pinterest',
            'play',
            'player',
            'playstation',
            'pocket',
            'qq',
            'quora',
            'raidcall',
            'ravelry',
            'reddit',
            'renren',
            'researchgate',
            'reverbnation',
            'rss',
            'sharethis',
            'skype',
            'slideshare',
            'smugmug',
            'snapchat',
            'songkick',
            'soundcloud',
            'spotify',
            'stackexchange',
            'stackoverflow',
            'starcraft',
            'stayfriends',
            'steam',
            'storehouse',
            'strava',
            'streamjar',
            'stumbleupon',
            'swarm',
            'teamspeak',
            'teamviewer',
            'technorati',
            'telegram',
            'tripadvisor',
            'tripit',
            'triplej',
            'tumblr',
            'twitch',
            'twitter',
            'uber',
            'ventrilo',
            'viadeo',
            'viber',
            'viewbug',
            'vimeo',
            'vine',
            'vkontakte',
            'warcraft',
            'wechat',
            'weibo',
            'whatsapp',
            'wikipedia',
            'windows',
            'wordpress',
            'wykop',
            'xbox',
            'xing',
            'yahoo',
            'yammer',
            'yandex',
            'yelp',
            'younow',
            'youtube',
            'zapier',
            'zerply',
            'zomato',
            'zynga'
        ];
    }

    public static function encryptSecurityData($data,$param = false)
    {
        if($param == true){
            $cipher = 'AES-128-ECB';
            return openssl_encrypt($data, $cipher, env('OPEN_ENCRUPT_KEY'));
        }else{
            $cipher = 'AES-128-ECB';
            return openssl_decrypt($data, $cipher, env('OPEN_ENCRUPT_KEY'));
        }

    }


    public static function telText($tel) {
        $tel_arr = [];
        if ($tel) {

            $tel_arr = explode("|", $tel);
            if (!isset($tel_arr[1])) {
                $tel_arr[1] = $tel_arr[0];
            }

        } // if

        return $tel_arr;

    }

    public static function userRoleId($user_id) {
        $user_id = (int)$user_id;
        if ($user_id < 1) {
            return false;
        } else {
            $user_id = Auth::id();

            $user = User::getUser($user_id);
            if ($user) {
                return $user->role_id;
            } else {
                return false;
            }
        }
    }


}
