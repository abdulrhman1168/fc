
<a href="{{ route('group_permissions', ['id' => $id])  }}" class="btn btn-xs btn-primary">
  <i class="fa fa-key"></i> {{ __('messages.permissions') }}
</a>

<a href="{{ route('groups.edit', ['id' => $id])  }}" class="btn btn-xs btn-info">
  <i class="fa fa-pencil"></i> {{ __('messages.action_edit') }}
</a>


<a href="{{ route('groups.show', ['id' => $id]) }}" class="btn btn-xs btn-default">
  <i class="fa fa-eye"></i>{{ __('messages.action_show') }}
</a>


{!! Form::model($id, ['method' => 'delete', 'route' => ['groups.destroy', $id], 'class' =>'form-inline form-delete-modal', 'style' => 'display: inline;']) !!}
    {!! Form::hidden('id', $id) !!}
    <button type="submit" class="btn btn-xs btn-danger delete-object-modal-button" >
      <i class="fa fa-trash-o"></i>
      {{ __('messages.action_delete') }}
    </button>
{!! Form::close() !!}
