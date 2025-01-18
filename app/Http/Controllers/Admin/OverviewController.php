<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class OverviewController extends Controller
{
    public function index(): View
    {
        return view('pages.admin.overview', [
            'pageTitle' => 'Ringkasan',
        ]);
    }
}
