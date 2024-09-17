<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetAppVersion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'version:set';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set App Version from the version file';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $version_file = storage_path('app/version.txt');

        if (file_exists($version_file)) {

            $new_version =  trim(file_get_contents($version_file));

            $env_file = base_path('.env');

            if (file_exists($env_file)) {

                $existing_version = getenv('APP_VERSION');

                echo $existing_version;
                echo ' <-- OLD | NEW --> ';
                echo $new_version;

                if($existing_version == $new_version) {
                    return 1;
                }

                file_put_contents(
                    $env_file, str_replace(
                        'APP_VERSION="'.$existing_version.'"', 
                        'APP_VERSION="'.$new_version.'"', 
                        file_get_contents($env_file)
                    )
                );

                return 1;

            }
        }

        return 0;
    }
}
