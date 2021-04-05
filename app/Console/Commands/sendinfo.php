<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Mail;
use App\Mail\InfoHoliday;
use Illuminate\Console\Command;
use App\{Holiday};
use Carbon\Carbon;

class sendinfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendinfo:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send email to the client with info about holiday date';

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
        $dates = Holiday::all();
       

        foreach($dates as $date)
        {
            $currentDate = Carbon::now();
            $holidayDate = date_create($date->holiday_date);
            $result = $currentDate->diff($holidayDate);
          
            if($result->days == 7)
            {
                Mail::to('joannakosiorowski@gmail.com')->send(new InfoHoliday());
            }
        }
        // send email Mail::to($date->user->email)->send( new InfoHoliday());
        //dd(Carbon::now()->toDateString());
     

    }
}
