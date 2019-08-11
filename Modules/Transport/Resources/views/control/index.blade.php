
@extends('layouts.main.index')



@section('page')

@include('transport::activities.flash-message')


    <div class="panel-heading">
        {{ __('transport::app.districts') }}
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
                            <a href="{{route('trans.createDistrict')}}">
                            
                               <button type="button"  class="btn green" data-toggle="modal" data-target=".bs-district">{{  __('transport::app.add_district') }}</button>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet-body" id="chats">

                <table class='table table-bordered table-hover' id ="table2">

                    <thead>
                    <tr>
                        <th>
                            {{ __('transport::app.district_id') }}

                        </th>
                        <th>
                            {{ __('transport::app.district_name') }}
                        </th>
                        <th>
                            {{ __('transport::app.city_name') }}
                        </th>
                        <th></th>


                    </tr>
                    </thead>
                    <tbody>
                    @foreach($districts as $item)
                        <tr>
                            <td>
                                {{$item->id}}
                            </td>
                            <td>
                                {{ (App::getLocale() == 'ar') ? $item->name_ar : $item->name_en }}

                            </td>
                            
                            <td>
                            {{ (App::getLocale() == 'ar') ? $item->city_name_ar : $item->city_name_en }}

                            </td>
                            <td>
                            </td>
                        </tr>



                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <?// end district  ***************************************************************************************************?>


    <?// start track  ***************************************************************************************************?>


    <div class="panel-heading">
        {{ __('transport::app.tracks') }}
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
                            <button type="button"  class="btn green" data-toggle="modal" data-target=".bs-track">{{ __('transport::app.add_track') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet-body" id="chats">

                <table class='table table-bordered table-hover' id ="table5">
                    <thead>
                    <tr>
                        <th>
                            {{ __('transport::app.track_no') }}

                        </th>
                        <th>
                            {{ __('transport::app.city_name') }}
                        </th>
                        <th>
                            {{ __('transport::app.district_name') }}
                        </th>
                        <th>
                            {{ __('transport::app.college') }}
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($track as $item)

                        <tr>
                            <td>
                                {{$item->track_id}}
                            </td>
                            <td>
                                {{ (App::getLocale() == 'ar') ? $item->city_name_ar
                                : $item->city_name_en }}

                            </td>
                            <td>
                                {{ (App::getLocale() == 'ar') ?
                                $item->district_name_ar :
                                $item->district_name_en }}

                            </td>
                            <td>
                                {{ $item->college_name }}

                            </td>


                        </tr>


                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>









    <?// end track *************************************************************************************************** ?>

    <?// start vehicle *************************************************************************************************** ?>


    <div class="panel-heading">
        {{ __('transport::app.vehicles') }}
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
                            <a href="{{route('trans.createDistrict')}}">
                            
                               <button type="button"  class="btn green" data-toggle="modal" data-target=".bs-vehicle">{{  __('transport::app.add_vehicle') }}</button>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet-body" id="chats">

                <table class='table table-bordered table-hover' id ="table2">

                    <thead>
                    <tr>
                        <th>
                            {{ __('transport::app.serial') }}

                        </th>
                        <th>
                            {{ __('transport::app.vehicle_number') }}
                        </th>
                        <th>
                            {{ __('transport::app.plate_number') }}
                        </th>
                        <th></th>


                    </tr>
                    </thead>
                    <tbody>
                    @foreach($vehciles as $item)
                        <tr>
                            <td>
                                {{$item->id}}
                            </td>
                            <td>
                                {{ $item->vehicle_number }}

                            </td>
                            
                            <td>
                            {{ $item->plate_number }}
                            </td>
                            <td>
                            </td>
                        </tr>



                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <?// end vehicle  ***************************************************************************************************?>

    <?// star driver *************************************************************************************************** ?>
    <div class="panel-heading">
        {{ __('transport::app.drivers') }}
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
                            <a href="{{route('trans.createDriver')}}">
                            <button type="button"  class="btn green" data-toggle="modal" data-target=".bs-driver">{{  __('transport::app.add_driver') }}</button>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet-body" id="chats">

                <table class='table table-bordered table-hover' id ="table4">
                    <thead>
                    <tr>
                        <th>
                            {{ __('transport::app.driver_no') }}

                        </th>
                        <th>
                            {{ __('transport::app.driver_name') }}
                        </th>
                        <th>
                            {{ __('transport::app.mobile') }}
                        </th>
                        <th>
                            {{ __('transport::app.bus_no') }}
                        </th>
                        <th>
                            {{ __('transport::app.plate_no') }}
                        </th>

                        <th>
                            {{ __('transport::app.companion') }}
                        </th>

                        <th>
                            {{ __('transport::app.companion_no') }}
                        </th>

                        <th>
                            {{ __('transport::app.track') }}
                        </th>


                    </tr>
                    </thead>
                    <tbody>
                    @foreach($drivers as $item)
                       @if($item->name)
                        <tr>
                            <td>
                                {{$item->id}}
                            </td>
                            <td>
                                {{$item->name}}

                            </td>
                            <td>
                                {{$item->mobile}}

                            </td>
                            <td>
                                {{$item->vehicle_number}}


                            </td>

                            <td>
                                {{$item->plate_number}}


                            </td>
                            <td>
                                {{$item->companion}}


                            </td>
                            <td>
                                {{$item->companion_no}}


                            </td>

                            <td>
                            {{$item->city_name_ar . "/" . $item->district_name_ar . "/" . $item->college_name}}
                            </td>


                        </tr>
                        @endif

                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <?// end driver  ***************************************************************************************************?>

<!-- Large modal city -->
<div class="modal fade bs-city" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">        {{ __('transport::app.add_city') }}</h4>
      </div>
      <div class="modal-body">
        <add-city></add-city>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('transport::app.close')}}</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- Large modal city -->
<div class="modal fade bs-district" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">        {{ __('transport::app.add_district') }}</h4>
      </div>
      <div class="modal-body">
        <add-district 
        lang= "{{app()->getLocale()}}"
        ></add-district>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('transport::app.close')}}</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Large modal track -->
<div class="modal fade bs-track" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">        {{ __('transport::app.add_track') }}</h4>
      </div>
      <div class="modal-body">
        <add-track lang= "{{app()->getLocale()}}"></add-track>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('transport::app.close')}}</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- Large modal vehicle -->
<div class="modal fade bs-vehicle" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">        {{ __('transport::app.add_vehicle') }}</h4>
      </div>
      <div class="modal-body">
        <add-vehicle></add-vehicle>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('transport::app.close')}}</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- Large modal vehicle -->


<!-- Large modal driver -->
<div class="modal fade bs-driver" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">        {{ __('transport::app.add_vehicle') }}</h4>
      </div>
      <div class="modal-body">
        <add-driver></add-driver>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('transport::app.close')}}</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- Large modal driver -->
@endsection

@section('scripts')
<script>

    $(".edit-action").on('click', function(event){
        
        console.log('clicked');
});
</script>
@endsection