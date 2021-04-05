@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">    
                    Wprowadź nowe zwolnienie
                 </div>
                 <div class="card-body">
                    @if(Session::has('message'))
                    <div class="alert bg-success alert-success text-white" role="alert">
                        {{Session::get('message')}}
                    </div>
                @endif
                 <form action="{{route('sickleave')}}" method="get" >@csrf

                    <div class="form-group">
                        <label for="date">Data </label>
                        <input type="date" class="form-control" name="date" value="{{ old('date') }}"  />
                    </div>
                    <div class="form-group">
                        <label for="desc">Opis</label>
                        <input type="textarea" class="form-control" name="desc"  value="{{ old('desc') }}"/>
                    </div>
                    <button type="submit" class="btn btn-primary">Dodaj</button>
                  </form>

                  </div>

            </div>
        </div>
    </div>
   
    
</div>

@endsection



