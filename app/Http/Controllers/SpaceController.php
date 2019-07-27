<?php

namespace App\Http\Controllers;

use GrahamCampbell\DigitalOcean\Facades\DigitalOcean;
use Illuminate\Http\Request;

class SpaceController extends Controller
{
    function store(Request $request) {
        $domain_record = DigitalOcean::domainRecord()->create('enucs.org.uk', 'A', 'hello', env('SERVER_IPv4'));
        dd($domain_record->id);

    }
}
