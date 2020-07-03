<?php

namespace App\Console\Commands;

use App\Models\News;
use App\Models\User;
use Illuminate\Console\Command;

class ElasticsearchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:list {type} {query}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'elasticsearch test';

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
     * @return int
     */
    public function handle()
    {
        $type = $this->argument('type');
        $query = $this->argument('query');

        if ($type == 'news') {
            $news = News::search($query)->get();
            $this->info($news);
        } else {
            $user = User::search($query)->get();
            $this->info($user);
        }
    }
}
