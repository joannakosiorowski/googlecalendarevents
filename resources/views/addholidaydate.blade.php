@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">    
                    Wprowadź nową date urlopu. Gdy status urlopu zostanie potwierdzony, zostaniesz o tym poinformowany mailem.
                 </div>
                 <div class="card-body">
                    @if(Session::has('message'))
                    <div class="alert bg-success alert-success text-white" role="alert">
                        {{Session::get('message')}}
                    </div>
                    @endif
                    <form action="{{ route('adddate') }}" method="POST" >@csrf
                        <div class="form-group">
                            <label for="holidaydate">Data</label>
                            <input type="date" class="form-control inputDate" name="holidaydate" value=""  required/>
                        </div>
                        <button type="submit" class="mb-4 btn btn-primary">Zatwierdź</button>
                    </form>

                    
                  <table class="table">
            <thead class="bg-white">
                <tr>
                <th scope="col">Data urlopu</th>
                <th scope="col">Status</th>
                <th scope="col">Akcje</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @foreach($dates as $date)
            <tr>
                <td>{{$date->holiday_date}}</td>
                @if($date->confirmed==0)
                <td>Urlop oczekuje na potwierdzenie</td>
                <td>
                <form action="{{route('destroy.holidaydate', [$date->id])}}" method="POST">@csrf
                    <button class="btn btn-danger">Usuń </button>            
                </form>
                </td>
                <td></td>
                @else
                <td>Urlop potwierdzony</td>
            
                <td>
                <form action="" method="POST">@csrf
                    <button disabled type="submit" class="btn btn-danger">Usuń </button>            
                </form>
                </td>
                <td>                
                    <a class="btn btn-warning"  data-toggle="modal" data-target="#testModal"><i class="fa fa-reply" aria-hidden="true"></i><span>Zgłoś błąd</span></a>         
                </td>
               
                @endif
            </tr> 
            @endforeach
            </tbody>
             </table>

             <div class="card-header">    
                    Filtruj po dacie
                 </div>
                    <form action="{{ route('setdate') }}" method="GET" >@csrf
                        <div class="form-group mt-4">
                            <label for="startdate">Data początkowa</label>
                            <input type="date" class="form-control inputDate" name="startdate" value=""  required/>
                        </div>
                        <div class="form-group">
                            <label for="enddate">Data końcowa</label>
                            <input type="date" class="form-control inputDate" name="enddate" value=""  required/>
                        </div>
                        <button type="submit" class="mb-4 btn btn-primary">Pokaż</button>
                    </form>

                  </div>

            </div>

        </div>
    </div>
</div>
@include('modals/sendmailmodal') 
@endsection



