<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AlphabetAndLanguages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:AlphabetAndLanguages {model} {settings} {options?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Allows MultiLingual Models';

    protected $validSettings = ['a', 'l', 'al'];
    protected $validForModel = [null, 's', '-seed', 'c', '-controller', 'crR', '-controller --resource --requests', '-policy', 'sc', 'a', '-all', 'p', '-pivot'];
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $settings = $this->argument('settings');
        $settingsPassed = false;
        if(in_array($settings, $this->validSettings)){
            $settingsPassed = true;
        }
        $options = $this->argument('options');
        $modelPassed = false;
        if(in_array($options, $this->validForModel)){
            $modelPassed = true;
        }
        if(($settingsPassed === true)&&($modelPassed === true)){
            $model = $this->argument('model');
            $seed = false;
            $controller = false;
            $resource = false;
            $request = false;
            $policy = false;
            $pivot = false;
            if(($options == 'all') || ($options == 'a')){
                $seed = true;
                $controller = true;
                $policy = true;
                $request = true;
            }
            else if(($options == 's') || ($options == '-seed')){
                $seed = true;
            }
            else if(str_contains($options, 'c')){
                $controller = true;
                if(($options == 'crR') || (((str_contains($options, '--resource')) && (str_contains($options, '--request'))))){
                    $resource = true;
                    $request = true;
                }
                else if($options == 'cr'){
                    $resource = true;
                }
            }
            else if($options == '--policy'){
                $policy = true;
            }
            else if(($options == 'p') || ($options == '--pivot')){
                $pivot = true;
            }
            $this->call('make:model', [
                'name' => $model,
                '-m' => true,
                '-f' => true,
                '--seed' => $seed,
                '-c' => $controller,
                '-r' => $resource,
                '-R' => $request,
                '--policy' => $policy,
                '-p' => $pivot
            ]);
            if(str_contains($settings, 'a')){
                $modelAlphabet = $model.'Alphabet';
                $this->call('make:model', [
                    'name' => $modelAlphabet,
                    '-m' => true,
                    '-f' => true
                ]);
            }
            if(str_contains($settings, 'l')){
                $modelLanguage = $model.'Language';
                $this->call('make:model', [
                    'name' => $modelLanguage,
                    '-m' => true,
                    '-f' => true
                ]);
            }
        }
        else{
            $this->fail('Settings must be a l or al.'."\n".'a means Alphabet'."\n".'l means Language'."\n".'al means both Alphabet and Language');
        }
        
    }
}
