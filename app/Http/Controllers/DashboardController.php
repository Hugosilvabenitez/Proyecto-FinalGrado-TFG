<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

/**
* Class DashboardController (Controller)
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-04-08
* 
* This class contains all the necessary functions for the Dashboard's data.
*/

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('stats');

        return Inertia::render('Dashboard', [
            'auth' => [
                'user' => $user
            ]
        ]);

        //HACER PARTE FRONT & LOGÍCA GUARDAR DATOS
    }
}
