<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;
use Config;
use App\{User, Holiday};
use App\Mail\ConfirmHoliday;
use App\Mail\ErrorMessage;
use Illuminate\Support\Facades\Mail;

class HolidayController extends Controller
{
    
    public function addDate(Request $request)
    {
            $userCalendarId = Auth::user()->calendar_id;
            Config::set('google-calendar.service_account_credentials_json', storage_path('app/google-calendar/service-account-credentials.json'));
            Config::set('google-calendar.calendar_id', $userCalendarId );

            $date = Carbon::parse($request->input('holidaydate').' '.'08:00:00', 'Europe/Paris');
            $holiday = new Event;
            $holiday->name = '#holiday';
            $holiday->startDateTime = $date;
            $holiday->endDateTime = clone($date)->addHours(8);
            $holiday->save();
            $holidayId = $holiday->start->dateTime;
         
            Holiday::create([
                'user_id' => Auth::user()->id,
                'holiday_date' => $request->input('holidaydate'),
                'confirmed' => false,
                'code'=> $holidayId,
            ]);
            
        
            return redirect()->back()->with('message','Urlop został zapisany');
    }

    public function test()
    {
        return view('addholidaydate');
  
    }

    public function manageHolidays()
    {
        $dates = Holiday::orderBy('id','desc')->paginate(10);
        return view('manageholidays', compact('dates'));
    }

    public function confirm($id)
    {
        $date = Holiday::find($id);
        $date->confirmed = 1;
        $date->save();
        Mail::to($date->user->email)->send( new ConfirmHoliday());
        return redirect()->back()->with('message','Urlop został potwierdzony' );
    }

    public function show()
    {
        $user_id = Auth::user()->id;
        $dates = Holiday::all()->where('user_id', $user_id)->sortByDesc('created_at');
        
        return view('addholidaydate', compact('dates'));    
    }

    public function destroy($id)
    {
        $holidaydate = Holiday::find($id);
        $userCalendarId = Auth::user()->calendar_id;
        Config::set('google-calendar.service_account_credentials_json', storage_path('app/google-calendar/service-account-credentials.json'));
        Config::set('google-calendar.calendar_id', $userCalendarId );
        $events = Event::get();
    
        //dd($events[42]->startDateTime);
 
        foreach($events as $event)
        {
            if($event->startDateTime > $holidaydate->holiday_date)
            {
                $event->delete();
                  
            }
        }
        $holidaydate->delete();
        return redirect('/holiday');
 
    }

    public function setDate(Request $request)
    {
        $user_id = Auth::user()->id;
        $holidays = Holiday::all()->where('user_id', $user_id);

        $startDate = $request->input('startdate');
        $endDate = $request->input('enddate');
        $dates = [];

        foreach($holidays as $date)
        {

            if($date->holiday_date >= $startDate && $date->holiday_date <= $endDate)
            {
               array_push($dates, $date);
               
            }


        }

        return view('addholidaydate', compact('dates'));

    }

    public function sendErrorMsg(Request $request)
    {
        $details = [
            'body'=> $request->body,
            'user'=> Auth::user()->name,
        ];

        Mail::to('kosiorowska1996@gmail.com')->send( new ErrorMessage($details));
        return redirect()->back()->with('message','Email z wiadomością został przekazany do biura' );
    }

}
