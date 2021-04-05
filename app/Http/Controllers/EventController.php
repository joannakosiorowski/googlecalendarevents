<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;
use Config;
use App\{User, Holiday, Holidayjackpot};
use App\Mail\JackpotMail;
use Illuminate\Support\Collection;

class EventParams
{
    //public $key;

    public $date;
    public $start;
    public $end;
    public $hour;
    public $summary;
    public $holiday;
    public $user;
    public $user_id;
    public $email;
}

class ReportParams
{
    public $email;
    public $user_id;
    public $user;
    public $sumhour;
    public $sumholiday;
}


class EventController extends Controller
{

    public function index(Request $request)
    {
        if ($request->userCalendarId == null) {
            $users = User::all();
            $tabs = [];
            $hours = [];

            return view('workhours', compact('tabs', 'hours', 'users'));
        } else {

            $users = User::all();
            $userCalendarId = $request->userCalendarId;
            Config::set('google-calendar.service_account_credentials_json', storage_path('app/google-calendar/service-account-credentials.json'));
            Config::set('google-calendar.calendar_id', $userCalendarId);
            $events = Event::get();
            $startDate = $request->startdate;
            $endDate = $request->enddate;
            $tabs = [];
            $hours = [];

            foreach ($events as $event) {
                if (($event->startDateTime > $startDate) && ($event->startDateTime < $endDate)) {

                    //$tabs[$event->id] = $event; //daty
                    $end = Carbon::parse($event->endDateTime);
                    $start = Carbon::parse($event->startDateTime);
                    $hour = ($end->diffInHours($start));
                    $firstpart = floor((strtotime($end) - strtotime($start)) / 3600);
                    $secondpart = floor(((strtotime($end) - strtotime($start)) / 60) % 60);
                    $fullhour = "$firstpart.$secondpart";

                    //$hours[$event->id] = $subtraction;
                    $starttime = 0;
                    $newEvent = new EventParams();
                    //$newEvent->key = $event->id;
                    $newEvent->start = $start->format('H:i');
                    $newEvent->end = $end->format('H:i');
                    $newEvent->date = $start->format('d-m-Y');
                    $newEvent->hour = $fullhour;

                    if ($event->summary == "#work") {
                        $newEvent->summary = $event->summary;
                    } else if ($event->summary == "#holiday") {
                        $newEvent->holiday = $event->summary;
                    }

                    $tabs[$event->id] = $newEvent;
                }
            }
            $holidaysum = 0;
            $sum = 0;
            foreach ($tabs as $element) {
                if ($element->summary == "#work") {
                    $sum = $sum + $element->hour;
                } else if ($element->holiday == "#holiday") {
                    $holidaysum = $holidaysum + $element->hour;
                }
            }


            return view('workhours', compact('tabs', 'hours', 'users', 'sum', 'holidaysum'));
        }
    }




    public function getAll(Request $request)
    {
        $users = User::all();

        $tabs = [];
        $hours = [];

        for ($i = 0; $i < count($users); $i++) {
            $userCalendarId = $users[$i]->calendar_id;
            Config::set('google-calendar.service_account_credentials_json', storage_path('app/google-calendar/service-account-credentials.json'));
            Config::set('google-calendar.calendar_id', $userCalendarId);
            $events = Event::get();
            $startDate = $request->startdate;
            $endDate = $request->enddate;

            foreach ($events as $event) {
                if (($event->startDateTime > $startDate) && ($event->startDateTime < $endDate)) {
                    $end = Carbon::parse($event->endDateTime);
                    $start = Carbon::parse($event->startDateTime);
                    $hour = ($end->diffInHours($start));
                    $firstpart = floor((strtotime($end) - strtotime($start)) / 3600);
                    $secondpart = floor(((strtotime($end) - strtotime($start)) / 60) % 60);
                    $fullhour = "$firstpart.$secondpart"; //godzina za 1 event
                    $newEvent = new EventParams();

                    if ($event->summary == "#work") {
                        $newEvent->hour = $fullhour;
                    } else if ($event->summary == "#holiday") {
                        $newEvent->holiday = $fullhour;
                    }
                    $newEvent->user = $users[$i]->name;
                    $newEvent->user_id = $users[$i]->id;
                    $newEvent->email = $users[$i]->email;
                    $tabs[$event->id] = $newEvent;
                }
            }
        }

        $sumHour = 0;
        $sumHoliday = 0;
        $hours = [];
        foreach ($tabs as $tab) {
            $newReport = new ReportParams();
            if (array_key_exists($tab->user, $hours)) {
                $sumHour = $sumHour + $tab->hour;
                $sumHoliday = $sumHoliday + $tab->holiday;
            } else {
                $sumHour = $tab->hour;
                $sumHoliday = $tab->holiday;
            }
                $newReport->email = $tab->email;
                $newReport->name = $tab->user;
                $newReport->user_id = $tab->user_id;
                $newReport->sumhour = $sumHour;
                $newReport->sumholiday = $sumHoliday;
                $hours[$tab->user] = $newReport;
                
        }



        if($request->isMethod('post'))
        {
  
            $this->validate($request, [
                'user' => 'required' ,
                'hashtag' => 'required',
                'amount' => 'required'
            ]);
                Holidayjackpot::create([
                    'user_id' => $request->user ,
                    'hashtag' => $request->hashtag,
                    'amount' => $request->amount,
                ]);

                $sum = 0;
                $jackpots = Holidayjackpot::all()->where('user_id', $request->user);
                foreach($jackpots as $jackpot)
                {
                    $sum = $sum + $jackpot->amount;
                 
                }
                

                $data = array(
                    'amount' => $request->amount,
                    'sum' => $sum,
                );
                       
               Mail::to($request->email)->send(new JackpotMail($data));
           

            return redirect()->back()->with('message','Pula została zaktualizowana');
            
        //return response()->json($users, 201);
       
        }
        else {

            return view('report', compact('hours'));
           

        }

    }

    public function showHolidayJacpot(Request $request)
    {
        $users = User::all();
        $jackpots = Holidayjackpot::all()->where('user_id', $request->user_id);
        if ($request->user_id == null)
        {

            $sum = 0;
            $tabs = [];
            return view('holidayjackpot', compact('jackpots','sum', 'tabs', 'users'));
        }
        else {
            $userCalendarId = $users[$request->user_id - 1]->calendar_id;
            Config::set('google-calendar.service_account_credentials_json', storage_path('app/google-calendar/service-account-credentials.json'));
            Config::set('google-calendar.calendar_id', $userCalendarId);
            $user_id = $request->user_id;
            $tabs = [];
        $events = Event::get();
        foreach($events as $event)
        {
            if($event->summary == "#holiday") 
            {
            $tabs[$event->id] = $event;
            }
        }

        $sum = 0;
        foreach($jackpots as $jackpot)
        {
            $sum = $sum + $jackpot->amount; 
        }
       
        return view('holidayjackpot', compact('jackpots', 'sum', 'tabs','user_id', 'users'));
        }

        

    }

    public function destroyjackpot($id)
    {
        $jackpotposition = Holidayjackpot::find($id);
        $jackpotposition->delete();
        return redirect()->back();
    }




}
