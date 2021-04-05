@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="card">

                 <div class="card-body">
                    @if(Session::has('message'))
                    <div class="alert bg-success alert-success text-white" role="alert">
                        {{Session::get('message')}}
                    </div>
                     @endif

                     @if(count($errors) > 0)
                    <div class="alert bg-danger alert-success text-white" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    </div>
                @endif
                 <form action="{{route('report')}}" method="GET" >@csrf

                    <div class="form-group">
                        <label for="enddate" class="text-uppercase">Data początkowa</label>
                        <input type="date" class="form-control inputDate" placeholder="Data początkowa" name="startdate" value="{{ old('startdate') }}"  />
                    </div>
                    <div class="form-group">
                        <label for="enddate" class="text-uppercase">Data końcowa</label>
                        <input type="date" class="form-control inputDate" placeholder="Data końcowa" name="enddate"  value="{{ old('enddate') }}"/>
                    </div>
                    <button type="submit" class="btn btn-primary">Wyszukaj</button>
                  </form>

                  </div>

                  <table class="table">
                    <thead class="bg-white">
                        <tr>
                        <th scope="col">Pracownik</th>
                        <th scope="col">Rodzaj umowy</th>
                        <th scope="col">Suma godzin #work</th>
                        <th scope="col">Godziny urlopowe #holiday</th>
                        <th scope="col">Wypracowany urlop</th>
                        <th scope="col">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                
                @foreach($hours as $hour)
                    <tr>
                        <td>{{$hour->name}}</td>
                        <td>UZ</td>
                        <td>{{$hour->sumhour}}</td>
                        <td>{{$hour->sumholiday}} ({{($hour->sumholiday)/8}} dni) </td>
                        <td>{{round(((2*($hour->sumhour))/160),1)}}</td>
                        <td><form action="{{route('report')}}" method="POST" >@csrf
                        <input type="hidden"  name="user" value="{{$hour->user_id}}">
                        <input type="text" placeholder="identyfikator" name="hashtag" value="">
                        <input type="hidden"  name="amount" value="{{round(((2*($hour->sumhour))/160),1)}}">
                        <input type="hidden"  name="email" value="{{$hour->email}}">
                        <button type="submit"  class="btn btn-primary">Zatwierdź pulę urlopową</button>
                        </form>
                        </td>
                    </tr> 

                @endforeach
                    </tbody>
                    </table>


            </div>
        </div>
    </div> 
</div>
@include('modals/holidayjackpotmodal') 
@endsection



