@extends('layouts.main.index')



@section('page')

@include('transport::activities.flash-message')


      <div class="panel panel-default">
          <div class="panel-heading">
      {{ __('transport::app.phenomenonـprovided') }}
          </div>
          <div class='panel-body'>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bubble font-hide hide"></i>
                        <span class="caption-subject font-hide bold uppercase"><a href=""></a></span>
                    </div>
                    <div class="actions">
                        <div class="portlet-input input-inline">
                            <div class="input-icon right">
                              <a href="{{route('phenomenons_create')}}">
                                <input type="button" class="btn green"  value="{{ __('transport::app.Report_on_an_aerial_phenomenon') }}">
                              </a>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="portlet-body" id="chats">

                    <table class='table table-bordered table-hover' id="table2">
                      <thead>
                        <tr>
                            <th>
                              {{ __('transport::app.date_of_submission') }}

                            </th>
                            <th>
                              {{ __('transport::app.phenomenon_status') }}
                          </th>
                            <th>
                              {{ __('transport::app.phenomenon_type') }}
                            </th>
                            <th>
                              {{ __('transport::app.the_name_of_informer') }}
                            </th>
                            <th>
                              {{ __('transport::app.mobile') }}
                            </th>
                            <th>
                              {{ __('transport::app.Place_of_the_author') }}
                            </th>
                            <th>
                              {{ __('transport::app.actualtime') }}
                            </th>
                            <th>
                              {{ __('transport::app.dayreality') }}
                            </th>
                            <th>
                              {{ __('transport::app.Line_affected') }}
                            </th>
                            <th>
                              {{ __('transport::app.Attachments') }}
                            </th>

                            </tr>
                            </thead>

                            <tbody>

                              @foreach($phenomenon as $item)

                              <tr>

                                <td> {{$item->created_at}} </td>
                                <td>
                                  @if($item->phenomenon_status == 0)
                                  {{ __('transport::app.incident') }}
                                  @else
                                  {{ __('transport::app.Expected') }}
                                  @endif
                                </td>
                                <td>
                                  @if($item->phenomenon_type == 0)
                                  {{ __('transport::app.highـrain') }}
                                  @elseif($item->phenomenon_type == 1)
                                  {{ __('transport::app.torrents_sweeping') }}
                                  @elseif($item->phenomenon_type == 2)
                                  {{ __('transport::app.strong_wind') }}
                                  @elseif($item->phenomenon_type == 3)
                                  {{ __('transport::app.Sandstorm') }}
                                  @else
                                  {{ __('transport::app.thunderstorm') }}
                                  @endif
                                 </td>
                                <td> {{ Modules\Auth\Entities\Core\User::find($item->user_id)->user_name }} </td>
                                <td> {{ Modules\Auth\Entities\Core\User::find($item->user_id)->user_mobile }} </td>
                                <td> {{$item->place}} </td>
                                <td> {{$item->actualtime}} </td>
                                <td> {{$item->dayreality}} </td>
                                <td>
                                    @if(app()->getLocale() == 'ar')
                                    {{$item->city_name_ar . "-" . $item->district_name_ar . "-" . $item->college_name}}
                                    @else
                                    {{$item->city_name_en . "-" . $item->district_name_en . "-" . $item->college_name}}
                                    @endif

                                 </td>
                                <td> <a href="../uploads/transport/{{$item->attachment}}"> المرفق </a> </td>





                              </tr>

                              @endforeach





                          </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>







@stop
