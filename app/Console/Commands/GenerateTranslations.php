<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:locales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate translations script';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $messages = [];
        foreach (glob(base_path('lang/**')) as $localePath) {
            $exp = explode(DIRECTORY_SEPARATOR, $localePath);
            $locale = array_pop($exp);
            foreach (glob(base_path('lang/' . $locale) . "/*.php") as $filepath) {
                $exp = explode(DIRECTORY_SEPARATOR, $filepath);
                $filename = array_pop($exp);
                $content = require_once($filepath);
                $messages[str_replace('_', '-', $locale) . "." . substr($filename, 0, strlen($filename) - 4)] = $content;
            }
        }

        $path = resource_path('js/locales.js');
        $body = 'const locales = ' . json_encode($messages) . ";\n\n export default locales;";
        file_put_contents($path, $body);

        $this->info('File generate succefully at: ' . $path);

        return Command::SUCCESS;
    }
}
