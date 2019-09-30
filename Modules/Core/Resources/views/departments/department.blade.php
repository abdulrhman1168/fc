<li style="background: #ebebeb; padding: 10px; padding-bottom: 10px">
    {{ Form::open(['route' => ['departments.destroy', $department->id], 'method' => 'delete', 'id' => $department->id]) }}
    {{ $department->name_ar }} - {{optional (Modules\Auth\Entities\Core\User::find($department->user_id))->user_name }}
    <div class="pull-left">
        <a href="{{ route('departments.create', 'id=' . $department->id) }}" class="btn btn-success btn-sm">
            <i class="fa fa-plus"></i>
        </a>
        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-warning btn-sm">
            <i class="fa fa-edit"></i>
        </a>
        <button type="submit" onclick="return confirm('متأكد من الخذف؟')" class="btn btn-danger btn-sm">
            <i class="fa fa-trash-o"></i>
        </button>
    </div>
    {{ Form::close() }}
</li>

@if (count($department->children) > 0)
    <ul class="mb-2 mt-2" style="    background: #ebebeb;
        padding-bottom: 10px;">
        @foreach($department->children as $department)
            @include('core::departments.department', $department)
           
        @endforeach
    </ul>
@endif
