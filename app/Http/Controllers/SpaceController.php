<?php

namespace App\Http\Controllers;

use App\Space;
use GrahamCampbell\DigitalOcean\Facades\DigitalOcean;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpaceController extends Controller
{
    function store(Request $request) {
        Validator::make($request->all(), [
            'name' => 'required|unique:spaces',
            'domain' => 'required|unique:spaces',
        ])->validate();

        $clean_name = escapeshellcmd($request->name);
        $home_path = env('SPACES_DIR')."/".$clean_name;
        $password = base64_encode(random_bytes(10));

        if(!env('APP_ENV') == 'production')
        {
            // Creates the directory
            mkdir($home_path, 0700);

            // Creates the user
            exec('useradd '.$clean_name.' -p '.$password.' -g spaceftp -d '.$home_path.' -s /bin/false');

            $domain_record = DigitalOcean::domainRecord()->create('enucs.org.uk', 'A', 'hello', env('SERVER_IPv4'));
        } else {
            $domain_record = ['id'=>'1'];
        }

        Space::create([
            'name' => $clean_name,
            'password' => $password,
            'domain_record_id' => $domain_record->id
        ])->save();
    }
}
