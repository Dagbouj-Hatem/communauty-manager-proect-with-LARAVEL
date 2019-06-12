{!! Form::open(['route' => ['posts.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>

     <a class="btn btn-primary pull-right btn-xs" style="margin-left: 5px" href="{!! route('comments.create1', $id) !!}"><i class="glyphicon glyphicon-plus"></i>Add Comment</a>
 
    <a href="{{ route('posts.edit', $id) }}" class='btn btn-info btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>
    </a>
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'style' => 'margin-top: 5px',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}

</div>
{!! Form::close() !!}
