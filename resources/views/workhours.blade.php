@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">    
                    Wyszukiwarka godzin i urlopów
                 </div>
                 <div class="card-body">
                    @if(Session::has('message'))
                    <div class="alert bg-success alert-success text-white" role="alert">
                        {{Session::get('message')}}
                    </div>
                @endif
                 <form action="{{route('workhours')}}" method="GET" >@csrf
                    <div class="form-group">
                            <select name="userCalendarId" class="form-control">
                                @foreach($users as $user)
                                <option value="{{$user->calendar_id}}">{{$user->name}}</option>
                                @endforeach
                         
                             </select>
                    </div>
                    <div class="form-group">
                        <label for="startdate">Data od</label>
                        <input type="date" class="form-control" name="startdate" value="{{ old('startdate') }}"  />
                    </div>
                    <div class="form-group">
                        <label for="enddate">Data do</label>
                        <input type="date" class="form-control" name="enddate"  value="{{ old('enddate') }}"/>
                    </div>
                    <button type="submit" class="btn btn-primary">Wyszukaj</button>
                  </form>

                  </div>

            </div>
        </div>
    </div>

    <div class="row justify-content-center">
    <div class="col-md-10  bg-white">
    <span><strong>Godziny pracy</strong></span>
        <table class="table">
    <thead class="bg-white">
        <tr>
        <th scope="col">Tag</th>
        <th scope="col">Data</th>
        <th scope="col">Czas od</th>
        <th scope="col">Czas do</th>
        <th scope="col">Ilość godzin</th>
        </tr>
    </thead>
    <tbody>
  
    @foreach($tabs as $tab)
    @if($tab->summary == "#work")
    <tr>
        <td>{{$tab->summary }}</td>
        <td>{{ $tab->date }}</td>
        <td>{{ $tab->start }}</td>
        <td>{{ $tab->end }}</td>
        <td>{{$tab->hour }}</td>

    </tr> 
    @endif
    @endforeach


    </tbody>
    </table>
    @foreach($hours as $hour)
    <span>{{$hour}}</span>
        @endforeach
    
    
    <span><strong>Dni urlopowe</strong></span>
        <table class="table">

    <tbody>
  
    @foreach($tabs as $tab)
    @if($tab->holiday)
    <tr>
        <td>{{$tab->holiday }}</td>
        <td>{{ $tab->date }}</td>
        <td>{{ $tab->start }}</td>
        <td>{{ $tab->end }}</td>
        <td>{{$tab->hour }}</td>

    </tr> 
    @endif
    @endforeach


    </tbody>
    </table>
    @foreach($hours as $hour)
    <span>{{$hour}}</span>
        @endforeach
    
    </div>
    </div>
    <div class="row justify-content-center">
    <div class="col-md-10 mt-2">
        <button data-toggle="modal" data-target="#userIdModal" class="btn btn-secondary">Dodaj nowy kalendarz</button>
    </div>
    </div>
    
</div>
@include('modals/addnewuseridmodal') 
@endsection



