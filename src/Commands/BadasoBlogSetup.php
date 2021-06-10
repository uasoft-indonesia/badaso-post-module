<?php

namespace Uasoft\Badaso\Module\Blog\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\VarExporter\VarExporter;
use Uasoft\Badaso\Module\Blog\Facades\BadasoBlogModule;

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
        $this->addingBadasoEnv();
        $this->publishBadasoProvider();
        $this->updateBadasoConfigHiddenTables();
        $this->linkStorage();
        $this->generateSwagger();
    }

    protected function generateSwagger()
    {
        $this->call('l5-swagger:generate');
    }

    protected function updateBadasoConfigHiddenTables()
    {
        $hidden_tables = config('badaso-hidden-tables');
        $blog_tables = BadasoBlogModule::getProtectedTables();

        foreach ($blog_tables as $key => $table) {
            if (!in_array($table, $hidden_tables)) {
                array_push($hidden_tables, $table);
            }
        }

        $hidden_tables = json_decode(json_encode($hidden_tables));

        \File::put(config_path('hidden-tables.php'), "<?php\n return ".VarExporter::export($hidden_tables).' ;');
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

    protected function envListUpload()
    {
        return [
            'MIX_BLOG_POST_URL_PREFIX' => '',
            'MIX_ANALYTICS_ACCOUNT_ID' => '',
            'MIX_ANALYTICS_WEBPROPERTY_ID' => '',
            'MIX_ANALYTICS_VIEW_ID' => '',
        ];
    }

    protected function addingBadasoEnv()
    {
        try {
            $env_path = base_path('.env');

            $env_file = file_get_contents($env_path);
            $arr_env_file = explode("\n", $env_file);

            $env_will_adding = $this->envListUpload();

            $new_env_adding = [];
            foreach ($env_will_adding as $key_add_env => $val_add_env) {
                $status_adding = true;
                foreach ($arr_env_file as $key_env_file => $val_env_file) {
                    $val_env_file = trim($val_env_file);
                    if (substr($val_env_file, 0, 1) != '#' && $val_env_file != '' && strstr($val_env_file, $key_add_env)) {
                        $status_adding = false;
                        break;
                    }
                }
                if ($status_adding) {
                    $new_env_adding[] = "{$key_add_env}={$val_add_env}";
                }
            }

            foreach ($new_env_adding as $index_env_add => $val_env_add) {
                $arr_env_file[] = $val_env_add;
            }

            $env_file = join("\n", $arr_env_file);
            file_put_contents($env_path, $env_file);

            $this->info('Adding badaso env');
        } catch (\Exception $e) {
            $this->error('Failed adding badaso env '.$e->getMessage());
        }
    }
}
