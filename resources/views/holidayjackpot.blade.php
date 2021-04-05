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
                    <form action="{{ route('holidayjackpot') }}" method="GET" >@csrf
                        <div class="form-group">
                            <label for="worker">Wybierz usera</label>
                            <select name="user_id" class="form-control">
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="mb-4 btn btn-primary">Zatwierdź</button>
                    </form>

                    <table class="table">
                        <thead class="bg-white">
                            <tr>
                                <th scope="col">Tag</th>
                                <th scope="col">Ilość</th>
                                <th scope="col">Data utworzenia </th>
                                <th scope="col">Akcje </th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        @foreach($jackpots as $jackpot)
                        <tr>
                            <td>{{$jackpot->hashtag}}</td>
                            <td>{{$jackpot->amount}}</td>
                            <td>{{$jackpot->created_at}}</td>
                            <td>
                                <form action="{{route('destroy.holidayjackpot', [$jackpot->id])}}" method="POST">@csrf
                                    <button class="btn btn-danger">Usuń pozycję</button>            
                                </form>
                            </td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                    Suma urlopów w puli : {{$sum}}

                    <table class="table">
                        <thead class="bg-white">
                            <tr>
                                <th scope="col">Tag</th>
                                <th scope="col">Data urlopu</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        @foreach($tabs as $tab)
                        <tr>
                            <td>{{$tab->summary}}</td>
                            <td>{{$tab->start->dateTime}}</td>

                        </tr>
                        @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div> 
</div>

@endsection


