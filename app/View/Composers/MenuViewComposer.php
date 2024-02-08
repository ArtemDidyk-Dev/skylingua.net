<?php

namespace App\View\Composers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use App\Models\Menu\Menu;
use Illuminate\Support\Facades\Cache;
class MenuViewComposer
{   
    protected static $footerMenu;
    protected static $headerMenu;
    protected static $footerMenuHeaderItem;

    public $languageID;
    public $httpHost;
    const HEADER_ID = 1;
    const FOOTER_ID = 2;
    public function __construct()
    {
        $this->languageID = request()->get('languageID');
        $this->httpHost = request()->getSchemeAndHttpHost();
    }
    public function getFooterMenu(int $languageID, int $position): Collection
    {
        return Menu::where('languages.status', 1)
            ->where('languages.id', $languageID)
            //            ->where('menus.menu_position_id', $position)
            ->where(function ($query) use ($position) {
                //0 ci indexi yoxlayir where olduqu uchun
                $query->where('position->0', $position);
                foreach (config('menu.menu_position') as $key => $menuPosition): //o dan sonraki qalan indexleri yoxlayir orWhere() ile
                    if ($key != 0) {
                        $query->orWhere('position->' . $key, $position);
                    }
                endforeach;

            })

            ->where('menus.parent', 0)
            ->join('menu_positions', 'menus.menu_position_id', '=', 'menu_positions.id')
            ->join('menu_translations', 'menus.id', '=', 'menu_translations.menu_id')
            ->join('languages', 'languages.id', '=', 'menu_translations.language')
            ->select(
                'menu_translations.*',
                'menus.id',
                'menus.sort',
                'menus.menu_position_id',
                'menus.parent',
                'languages.id as languageID',
                'languages.default as languageDefault',
                'menu_positions.position as position',
            )
            ->orderBy('sort', 'ASC')
            ->get();
    }

    public function getMenu(
        string $HTTP_HOST,
        string $languageID,
        int $position = 0,
        int $parent_id = 0,
        array $parents = [],
        bool $subMenu = true
    ): string {
        //Aktiv dilleri aldim
        Cache::rememberForever('menu-all-' . $languageID . '-' . $position, function () use ($languageID, $position) {
            return Menu::where('languages.status', 1)
                ->where('languages.id', $languageID)
                //                ->where('menus.menu_position_id', $position)
                ->where(function ($query) use ($position) {
                    //0 ci indexi yoxlayir where olduqu uchun
                    $query->where('position->0', $position);
                    foreach (config('menu.menu_position') as $key => $menuPosition): //o dan sonraki qalan indexleri yoxlayir orWhere() ile
                        if ($key != 0) {
                            $query->orWhere('position->' . $key, $position);
                        }
                    endforeach;

                })
                ->join('menu_positions', 'menus.menu_position_id', '=', 'menu_positions.id')
                ->join('menu_translations', 'menus.id', '=', 'menu_translations.menu_id')
                ->join('languages', 'languages.id', '=', 'menu_translations.language')
                ->select(
                    'menu_translations.*',
                    'menus.id',
                    'menus.sort',
                    'menus.menu_position_id',
                    'menus.parent',
                    'languages.id as languageID',
                    'languages.default as languageDefault',
                    'menu_positions.position as position'
                )
                ->orderBy('sort', 'ASC')
                ->get()->toArray();
        });

        if ($parent_id == 0) {
            foreach (cache('menu-all-' . $languageID . '-' . $position) as $element) {
                if (($element['parent'] != 0) && !in_array($element['parent'], $parents)) {
                    $parents[] = $element['parent'];
                }
            }
        }
        $menu_html = '';

        foreach (cache('menu-all-' . $languageID . '-' . $position) as $element) {

            if ($element['parent'] == $parent_id) {

                $http_host_url_full = str_replace($HTTP_HOST, '', url()->full());
                if (empty($http_host_url_full)) {
                    $http_host_url_full = "/";
                }

                if (in_array($element['id'], $parents) && $subMenu) {
                    $isActive = $http_host_url_full == $element['link'] ? "active" : null;
                    $menu_html .= '<li class="has-submenu ' . $isActive . '">';

                    $menu_html .= '<a class="btn-menu" href="' . $element['link'] . '">' . $element['label'] . '</a> <span class="arrow"></span>';

                } else {

                    $isActive = $http_host_url_full == $element['link'] ? " class='active'" : null;
                    $menu_html .= '<li' . $isActive . '>';

                    $menu_html .= '<a class="btn-menu" href="' . $element['link'] . '" >' . $element['label'] . '</a>';
                }
                if (in_array($element['id'], $parents) && $subMenu) {
                    $menu_html .= '<ul  class="submenu">';
                    $menu_html .= self::getMenu($HTTP_HOST, $languageID, $position, $element['id'], $parents);
                    $menu_html .= '</ul>';
                }
                $menu_html .= '</li>';
            }
        }
        return $menu_html;

    }

    
    public function compose(View $view): void
    {

        if (!self::$headerMenu) {
            self::$headerMenu = $this->getMenu($this->httpHost, $this->languageID, self::HEADER_ID);
        }
        if (!self::$footerMenu) {
            self::$footerMenu = $this->getFooterMenu($this->languageID, self::FOOTER_ID);
        }
        if(!self::$footerMenuHeaderItem) {
            self::$footerMenuHeaderItem = $this->getFooterMenu($this->languageID, self::HEADER_ID);
        }
        $view->with('footerMenu', self::$footerMenu);
        $view->with('headerMenu', self::$headerMenu);
        $view->with('footerMenuHeaderItem', self::$footerMenuHeaderItem);

    }
}