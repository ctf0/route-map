<?php

namespace ctf0\RouteMap\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;

class PackageSetup extends Command
{
    protected $file;
    protected $signature = 'rm:setup';
    protected $description = 'setup package routes & assets compiling';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        $this->file = app('files');

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // routes
        $route_file = base_path('routes/web.php');
        $search = 'RouteMap';

        if ($this->checkExist($route_file, $search)) {
            $data = "\n// RouteMap\nctf0\RouteMap\RouteMap::routes();";

            $this->file->append($route_file, $data);
        }

        // mix
        $mix_file = base_path('webpack.mix.js');
        $search = 'RouteMap';

        if ($this->checkExist($mix_file, $search)) {
            $data = "\n// RouteMap\nmix.sass('resources/assets/vendor/RouteMap/sass/style.scss', 'public/assets/vendor/RouteMap/style.css')";

            $this->file->append($mix_file, $data);
        }

        $this->info('All Done');
    }

    /**
     * [checkExist description].
     *
     * @param [type] $file   [description]
     * @param [type] $search [description]
     *
     * @return [type] [description]
     */
    protected function checkExist($file, $search)
    {
        return $this->file->exists($file) && !Str::contains($this->file->get($file), $search);
    }
}