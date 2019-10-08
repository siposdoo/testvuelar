<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Subscriber;
use App\Article;
use App\Notifications\CitatiDnevnoInTheThread;

class SendCtats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comand:saljicitate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Svaki dan u isto vreme salje korisnicima po jedan citat ';

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
        $subscribers = Subscriber::where('payment', '=',1)->get();
        $subscribers->map(function($subscriber){
            $sledecicitat= ($subscriber->sent_citat)+1;
            $subscriber->sent_citat= $sledecicitat;

            $messages =  Article::where('id', '=',$sledecicitat)->first();
            if($subscriber->save())
       {
        $subscriber->notify (new CitatiDnevnoInTheThread($messages, $subscriber));
       }
           
        });
    }
}
