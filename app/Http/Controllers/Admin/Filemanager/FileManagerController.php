<?php

namespace App\Http\Controllers\Admin\Filemanager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileManagerController extends Controller
{

    public function index(Request $request)
    {
        return view('admin.file-manager.index');
    }


}
