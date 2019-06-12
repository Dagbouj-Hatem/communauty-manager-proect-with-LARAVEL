{!! Form::open(['route' => ['comments.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>  

    <a href="{{ route('comments.edit', $id) }}" class='btn btn-primary btn-xs' style="margin-left: 5px">
        <i class="glyphicon glyphicon-edit"></i>
    </a>
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'style' => 'margin-left: 5px',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
