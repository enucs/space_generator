<?php

namespace App\Http\Controllers;

use App\Space;
use GrahamCampbell\DigitalOcean\Facades\DigitalOcean;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function Psy\debug;

class SpaceController extends Controller
{
    function store(Request $request) {
        Validator::make($request->all(), [
            'name' => 'required',
        ])->validate();

        $clean_name = strtolower((escapeshellcmd(preg_replace("/[^a-zA-Z0-9]+/", "", $request->name))));

        if(Space::find($clean_name) != null)
        {
            return back()->withErrors('not_unique', 'Name already exists!');
        }


        $home_path = env('SPACES_DIR')."/".$clean_name;
        $password = base64_encode(random_bytes(10));
        $nginx_config = "
            server {
                listen 80;
                listen [::]:80;
        
                root $home_path;
                index index.html index.htm index.nginx-debian.html;
        
                server_name $clean_name.enucs.org.uk;
        
                location / {
                        try_files \$uri \$uri/ =404;
                }
            }";

        if(env('APP_ENV') == 'production')
        {
            // Creates the directory
            exec('sh mkdir -m 700 $home_path');

            // Creates the user
            exec('sh useradd '.$clean_name.' -p '.$password.' -g spaceftp -d '.$home_path.' -s /bin/false');
            exec('sh chown spaceftp:'.$clean_name.' '.$home_path);

            $domain_record = DigitalOcean::domainRecord()->create('enucs.org.uk', 'A', $clean_name, env('SERVER_IPv4'));


            // Creates nginx config
            $nginx_file = fopen("/etc/nginx/sites-enabled/spaces_".$clean_name, "w");

            fwrite($nginx_file, $nginx_config);
            fclose($nginx_file);

            $index_file = fopen($home_path.'/index.html', "w");
            fwrite($index_file, 'Welcome to your space, '.$clean_name);
            fclose($index_file);
            exec('systemctl restart nginx');

        }


        $space = new Space;
        $space->name = $clean_name;
        $space->password = $password;
        $space->domain_record_id = env('APP_ENV') == 'production' ? $domain_record->id : 'local';
        $space->save();

        return back();
    }
}
