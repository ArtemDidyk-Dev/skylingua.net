<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\MenuNameAdd;
use App\Http\Requests\Menu\MenuPositionAdd;
use App\Models\Language\Languages;
use App\Models\Menu\Menu;
use App\Models\Menu\MenuPosition;
use App\Models\Menu\MenuTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MenuController extends Controller
{

    //Ozum yaratdim
    public $validatorCheck;

    public function __construct(Request $request)
    {

        $languages = Languages::where('status',1)
            ->get();


        if(!is_null(config('menu.menu_position_name'))){
            foreach ($languages as $language):

                foreach (config('menu.menu_position_name') as $key => $item):

                    //eger keshde varsa sil
                    if (Cache::has('menu-all-'.$language->id.'-'.$key)) {
                        Cache::forget('menu-all-'.$language->id.'-'.$key);
                    }

                endforeach;

            endforeach;

        }



    }



    public function index(Request $request)
    {
        $menuPositions = MenuPosition::orderBy('id','DESC')
        ->paginate(10);

        return view('admin.menu.index', compact('menuPositions'));

    }

    public function add(Request $request)
    {
        return view('admin.menu.add');
    }

    public function addMenuName(MenuNameAdd $request)
    {

        $menuAdd = MenuPosition::create([
            'name' => $request->name,
            'position' => '{"0":0}'
        ]);


        return redirect()->route('admin.menu.edit',$menuAdd->id);
    }

    public function edit(Request $request)
    {

        $ref = [];
        $items = [];

        $datas = Menu::where('languages.default', 1)
            ->where('menus.menu_position_id', $request->id)
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
                'languages.default as languageDefault'
            )
            ->orderBy('sort','ASC')
            ->get();

        $menuPOsitionCheck = MenuPosition::where('id',$request->id)
            ->first();




        if (!$menuPOsitionCheck) {
            return redirect()->route('admin.menu.index');
        }


        $languages = Languages::where('status', 1)->get();

        foreach ($datas as $data):


            $thisRef = &$ref[$data->id];

            $thisRef['parent'] = $data->parent;
            $thisRef['label'] = $data->label;
            $thisRef['link'] = $data->link;
            $thisRef['id'] = $data->id;

            if ($data->parent == 0) {
                $items[$data->id] = &$thisRef;
            } else {
                $ref[$data->parent]['child'][$data->id] = &$thisRef;
            }
        endforeach;

        $menus = $this->get_menu($items);


        $menuPosition = MenuPosition::where('id', $request->id)
            ->first();


        return view('admin.menu.edit', compact('menus', 'languages', 'menuPosition'));
    }

    public function storeAjax(Request $request)
    {

        $label = $request->label;
        $link = $request->link;
        $menuID = intval($request->id);
        $menuPositionID = intval($request->menu_position_id);

        if (!empty($menuID)) {

            $menuTranslation = '';
            foreach ($request->label as $key => $item):

                MenuTranslation::where('menu_id', $menuID)
                    ->where('language', $key)
                    ->update([
                        'label' => $item,
                        'link' => $link[$key]
                    ]);

            endforeach;


            $menuTranslation = Menu::where('menu_id', $menuID)
                ->where('languages.default', 1)
                ->join('menu_translations', 'menus.id', '=', 'menu_translations.menu_id')
                ->join('languages', 'languages.id', '=', 'menu_translations.language')
                ->select(
                    'menu_translations.*',
                    'menus.id',
                    'menus.sort',
                    'menus.parent',
                    'languages.id as languageID',
                    'languages.default as languageDefault'
                )
                ->first();


            $arr['type'] = 'edit';
            $arr['label'] = $menuTranslation->label;
            $arr['link'] = $menuTranslation->link;
            $arr['id'] = $menuID;

        } else {


            $menu = Menu::create([
                'menu_position_id' => $menuPositionID
            ]);
            $menuTranslation = '';
            foreach ($request->label as $key => $item):

                MenuTranslation::create([
                    'menu_id' => $menu->id,
                    'language' => $key,
                    'label' => $item,
                    'link' => $link[$key]
                ]);

            endforeach;


            $menuTranslation = Menu::where('menu_id', $menu->id)
                ->where('languages.default', 1)
                ->join('menu_translations', 'menus.id', '=', 'menu_translations.menu_id')
                ->join('languages', 'languages.id', '=', 'menu_translations.language')
                ->select(
                    'menu_translations.*',
                    'menus.id',
                    'menus.sort',
                    'menus.parent',
                    'languages.id as languageID',
                    'languages.default as languageDefault'
                )
                ->first();

            $arr['menu'] = '<li class="dd-item dd3-item" data-id="' . $menu->id . '" >
	                    <div class="dd-handle dd3-handle"></div>
	                    <div class="dd3-content">
	                    <div class="menuLabelAndRIght">
	                     <div class="menuLabel">
	                        <span id="label_show' . $menu->id . '">' . $menuTranslation->label . '</span>
	                         <span class="borderBottomMenu"></span>
	                        <span id="link_show' . $menu->id . '">' . $menuTranslation->link . '</span>
	                        </div>
	                        <span class="span-right">
	                        	<a class="edit-button " id="' . $menu->id . '" label="' . $menuTranslation->label . '" link="' . $menuTranslation->link . '" ><i class="flaticon-edit text-primary"></i></a>
                           		<a class="del-button" id="' . $menu->id . '"><i class="flaticon2-trash text-danger ml-3"></i></a>
	                        </span>
	                        </div>

	                    </div>';

            $arr['type'] = 'add';

        }


        return response()->json($arr);

    }

    public function editAjax(Request $request)
    {

        $menuTranslation = Menu::where('menu_id', $request->id)
            ->join('menu_translations', 'menus.id', '=', 'menu_translations.menu_id')
            ->join('languages', 'languages.id', '=', 'menu_translations.language')
            ->select(
                'menu_translations.*',
                'menus.id',
                'menus.sort',
                'menus.parent',
                'languages.id as languageID',
                'languages.default as languageDefault'
            )
            ->get();


        return response()->json($menuTranslation);
    }

    public function changeAjax(Request $request)
    {
        $data = json_decode($request->data);

        $readbleArray = $this->parseJsonArray($data);

        $i = 0;
        foreach ($readbleArray as $row) {
            $i++;

            $menu = Menu::where('id', $row['id'])->update([
                'parent' => $row['parentID'],
                'sort' => $i,
            ]);


        }

        return response()->json($i);

    }

    public function deleteAjax(Request $request)
    {
        $this->recursiveDelete($request->id);
    }

    public function positionAdd(MenuPositionAdd $request)
    {

        $rules = [];
        $customMessages = [];

        $emptyPosition = [];
        if (!$request->menu_position) {
            $emptyPosition[] = 0;
        } else {
            $emptyPosition = $request->menu_position;
        }


        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);

        foreach ($emptyPosition as $item):
            if (!in_array($item, config('menu.menu_position'))) {
                $this->validateCheck('menu_position', 'Bu mövqey bazada yoxdur.');
            }
        endforeach;

        $this->validatorCheck->validate();


        MenuPosition::where('id', $request->menu_position_id)
            ->update([
                'name' => $request->name,
                'position' => json_encode($emptyPosition, JSON_FORCE_OBJECT)
            ]);


        return redirect()->back();

    }


    public function positionDeletAjax(Request $request)
    {
        $positionID = intval($request->id);

        $menuPosition = MenuPosition::where('id',$positionID)
            ->first();

        return response()->json(['success' => true, 'name' => $menuPosition->name], 200);

    }

    public function delete(Request $request)
    {
        $positionID = intval($request->id);

        MenuPosition::where('id',$positionID)
            ->delete();

        return response()->json(['success' => true], 200);

    }


    public function validateCheck($inputName, $text)
    {
        $this->validatorCheck->after(function ($validator) use ($inputName, $text) {
            $validator->errors()->add($inputName, $text);
        });
    }

    public function get_menu($items, $class = 'dd-list')
    {

        $html = "<ol class=\"" . $class . "\" id=\"menu-id\">";

        foreach ($items as $key => $value) {
            $html .= '<li class="dd-item dd3-item" data-id="' . $value['id'] . '" >
                    <div style="cursor: all-scroll" class="dd-handle dd3-handle"></div>
                    <div class="dd3-content">
                    <div class="menuLabelAndRIght">
                 <div class="menuLabel">
                    <span id="label_show' . $value['id'] . '">' . $value['label'] . '</span>
                    <span class="borderBottomMenu"></span>
                    <span id="link_show' . $value['id'] . '">' . $value['link'] . '</span>
                </div>
                        <span class="span-right">
                            <a class="edit-button" id="' . $value['id'] . '" label="' . $value['label'] . '" link="' . $value['link'] . '" >
                            <i class="flaticon-edit text-primary"></i>
                            </a>
                            <a class="del-button" id="' . $value['id'] . '"><i class="flaticon2-trash text-danger ml-3"></i></a>
                            </span>
                            </div>
                    </div>';
            if (array_key_exists('child', $value)) {
                $html .= $this->get_menu($value['child'], 'child');
            }
            $html .= "</li>";
        }
        $html .= "</ol>";

        return $html;

    }


    public function parseJsonArray($jsonArray, $parentID = 0)
    {

        $return = array();
        foreach ($jsonArray as $subArray) {
            $returnSubSubArray = array();
            if (isset($subArray->children)) {
                $returnSubSubArray = $this->parseJsonArray($subArray->children, $subArray->id);
            }

            $return[] = array('id' => $subArray->id, 'parentID' => $parentID);
            $return = array_merge($return, $returnSubSubArray);
        }
        return $return;
    }

    public function recursiveDelete($id)
    {

        $query = Menu::where('parent', $id)->get();
        if (count($query) > 0) {
            foreach ($query as $item):

            endforeach;
            $this->recursiveDelete($item['id']);

        }
        //DELETE
        Menu::where('id', $id)->delete();
    }

}
