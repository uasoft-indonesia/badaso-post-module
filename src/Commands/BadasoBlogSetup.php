<?php

namespace Uasoft\Badaso\Module\Blog\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Uasoft\Badaso\Module\Blog\Facades\BadasoBlogModule;
use Uasoft\Badaso\Module\Blog\Helpers\ConfigHelper;
use Illuminate\Support\Facades\Config;
use Symfony\Component\VarExporter\VarExporter;
use Uasoft\Badaso\Helpers\ApiDocs;
use Illuminate\Filesystem\Filesystem as LaravelFileSystem;
use Uasoft\Badaso\Module\Blog\Models\Post;
use Uasoft\Badaso\Module\Blog\Models\Category;
use Uasoft\Badaso\Module\Blog\Models\Tag;
use Uasoft\Badaso\Module\Blog\Models\Comment;

class BadasoBlogSetup extends Command
{
    protected $file;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'badaso-blog:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup Badaso Modules For Blog';

    /**
     * Create a new command instance.
     *
     * @return void
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
        $this->publishBadasoProvider();
        $this->updateBadasoConfigHiddenTables();
        $this->linkStorage();
    }

    protected function updateBadasoConfigHiddenTables()
    {
        $hidden_tables = config('hidden-tables');
        $blog_tables = BadasoBlogModule::getProtectedTables();

        foreach ($blog_tables as $key => $table) {
            if (!in_array($table, $hidden_tables)) {
                array_push($hidden_tables, $table);
            }
        }
        
        $hidden_tables = json_decode(json_encode($hidden_tables));

        \File::put(config_path('hidden-tables.php'), "<?php\n return " . VarExporter::export($hidden_tables) . " ;");
        $this->info('badaso.php configuration updated');
    }

    protected function publishBadasoProvider()
    {
        Artisan::call('vendor:publish', ['--tag' => 'BadasoBlogModule']);
        Artisan::call('vendor:publish', ['--tag' => 'BadasoBlogSwagger', '--force' => true]);

        $this->info('Badaso blog provider published');
    }

    protected function linkStorage()
    {
        Artisan::call('storage:link');
    }
}
