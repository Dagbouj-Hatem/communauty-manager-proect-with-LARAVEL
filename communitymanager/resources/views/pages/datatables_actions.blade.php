{!! Form::open(['route' => ['pages.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'> 
	<a class="btn btn-primary btn-xs pull-right" style="margin-left: 5px" href="{!! route('posts.create1', $id) !!}"><i class="glyphicon glyphicon-plus"></i>Add Post</a>

    <a href="{{ route('pages.edit', $id) }}" class='btn btn-info btn-xs' style="margin-left: 5px;">
        <i class="glyphicon glyphicon-edit"></i>
    </a>
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'style'=>'margin-left: 5px;',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!} 

</div>
{!! Form::close() !!}
