@extends('layouts.main.index')

@section('page')
  <div class="panel panel-default">
      <div class="panel-heading">اللاعبين

        <div class="btn-group pull-right">

          <a class="btn btn-xs btn-primary" href="{{route('players/create')}}">إضافة لاعب جديد </a>
  
          </div>
      </div>
    
      <table id="table-ajax" class="table panel-body"
             data-url="/egate/players"
             data-fields='[
                 {"data": "name","title":"{{ __('messages.name') }}","searchable":"true"},
                 {"data": "number","title":"رقم اللاعب","searchable":"true"},
                 {"data": "age","title":"العمر","searchable":"true"},
                 {"data": "length","title":"الطول","searchable":"true"},
                 {"data": "weight","title":"الوزن","searchable":"true"},
                 {"data": "number_of_goals","title":"عدد الأهداف","searchable":"true"},
                 {"data": "date_of_join","title":"تاريخ الإنضمام","searchable":"true"}


             ]'>
           </table>
  </div>

@endsection
