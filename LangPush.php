<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class LangPush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:push';

    protected $apikey = 'YOUR_API_KEY';
    protected $project = 'YOUR_PROJECT_ID';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send english translation to lokali.se';

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
        $client = new \GuzzleHttp\Client();
        $file = file_get_contents('./resources/lang/en/app.php');
        $response = $client->request('POST', 'https://lokali.se/api/project/import', [
            'multipart' => [
                [
                    'name'     => 'api_token',
                    'contents' => $this->apikey
                ],
                [
                    'name'     => 'id',
                    'contents' => $this->project
                ],
                [
                    'name'     => 'replace',
                    'contents' => '1'
                ],
                [
                    'name'     => 'lang_iso',
                    'contents' => 'en'
                ],
                [
                    'name'     => 'file',
                    'contents' => $file,
                    'filename' => 'app.php',
                ]
            ],
            'verify' => './resources/assets/cacert.pem',
        ]);
        $body = $response->getBody();

        echo $body;

    }
}
