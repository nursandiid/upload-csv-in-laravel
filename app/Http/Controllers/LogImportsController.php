<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogImportsController extends Controller
{
    /**
     * Show the page for listing of the resource.
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Display a listing of the resource as json format.
     */
    public function data() 
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * By importing csv files and inserting all the data into the database
     * 
     * @param Request $request
     */
    public function store(Request $request)
    {
        //
    }

}
