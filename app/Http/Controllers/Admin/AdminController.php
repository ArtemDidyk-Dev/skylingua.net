<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use App\Models\Attribute\Attribute;
use App\Models\Attribute\AttributeGroup;
use App\Models\Product\Product;
use App\Services\Alert;
use App\Services\AlertSweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function permission(Request $request)
    {
        abort('403', 'Sizin buna icazəniz yoxdur');
    }


    public function cacheClear(Request $request)
    {

        \Illuminate\Support\Facades\Artisan::call('optimize:clear');

        ImageService::removeFiles();

        return response()->json(['success' => true], 200);


    }


}
