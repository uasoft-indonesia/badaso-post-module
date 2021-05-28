<?php

namespace Uasoft\Badaso\Module\Blog\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\VarExporter\VarExporter;
use Uasoft\Badaso\Module\Blog\Facades\BadasoBlogModule;
use Uasoft\Badaso\Module\Blog\Seeder\BadasoModuleBlogSeeder;

class BadasoBlogSeed extends Command
{
    protected $file;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'badaso-blog:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run db:seed for badaso blog module';

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
        $this->seedBadasoBlog();
    }

    protected function seedBadasoBlog()
    {
        Artisan::call('db:seed', ['--class' => BadasoModuleBlogSeeder::class]);

        $this->info('Badaso blog seeder pushed');
    }
}
