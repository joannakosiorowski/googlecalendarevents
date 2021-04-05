@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <table class="table">
    <thead class="bg-white">
        <tr>
        <th scope="col">Pracownik</th>
        <th scope="col">Data</th>
        <th scope="col">Status</th>
        <th scope="col">Akcje</th>
        <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
  
@foreach($dates as $date)
    <tr>
        <td>{{$date->user->name}}</td>
        <td>{{$date->holiday_date}}</td>
        @if($date->confirmed==0)
        <td>Urlop niepotwierdzony</td>
        <td>
        <form action="{{route('confirm', [$date->id])}}" method="POST">@csrf
            <button type="submit" class="btn btn-success">Potwierdź </button>            
        </form>
        </td>
        <td>
        <form action="" method="POST">@csrf
            <button type="submit" class="btn btn-danger">Odrzuć </button>            
        </form>
        </td>
        @else
        <td>Urlop potwierdzony</td>
        <td>
        <form action="{{route('confirm', [$date->id])}}" method="POST">@csrf
            <button disabled type="submit" class="btn btn-secondary">Potwierdź </button>            
        </form>
        </td>
        <td>
        <form action="" method="POST">@csrf
            <button disabled type="submit" class="btn btn-warning">Anuluj urlop </button>            
        </form>
        </td>
        @endif

@endforeach
    </tr> 


    </tbody>
    </table>
    {!! $dates->links() !!}
        </div>
    </div>
</div>

@endsection



