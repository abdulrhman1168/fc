<div class="form-group">
    {{ Form::label('name_ar', 'اسم الإدارة', ['class' => 'control-label']) }}
    {{ Form::text('name_ar', old('name_ar') , ['class' => 'form-control', 'required' => true]) }}
</div>

<div class="form-group">
    {{ Form::label('parent_id', 'فرع من', ['class' => 'control-label']) }}
    {{ Form::select('parent_id', $departments, old('parent_id', $parent) , ['class' => 'form-control']) }}
</div>

<div class="form-group">
    {{ Form::label('user_id', 'مدير الإدارة', ['class' => 'control-label']) }} - {{ optional (Modules\Auth\Entities\Core\User::find($department->user_id))->user_name }}
    {{ Form::select('user_id', $users, old('user_id', $users) , ['class' => 'form-control']) }}
</div>

<div class="d-flex justify-content-end mainbuttons mt-4 mb-4">
    {{ Form::submit('حفظ', ['class' => 'btn btn-info']) }}
    <a href="{{ route('departments.index') }}" class="btn btn-danger">إلغاء</a>
</div>