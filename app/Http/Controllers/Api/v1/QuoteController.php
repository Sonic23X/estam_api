<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    function myQuote()
    {
        return response()->json([
            'quotes' => [],
        ]);
    }

    function index()
    {
        return response()->json([
            'quotes' => [],
        ]);
    }

    function store(Request $request)
    {
        return response()->json([
            'quote' => [],
        ]);
    }
}
