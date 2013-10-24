@section('content')
<div class="container">
        <div class="row">
            <div class="span2">
               <div class="thumbnail"> {{ $member->getGravatar(array('img' => true, 's' => 128)) }}</div>
            </div>
            <div class="span10">
                <ul class="unstyled">
                    <li><strong>{{ $member->username }}</strong></li>
                    <li><a href="mailto:{{ $member->email }}">{{ $member->email }}</a></li>
                    <li>@foreach ($member->listGroups() as $id => $group)
                        {{ $group }}
                    @endforeach</li>
                    <li>Last active {{ $member->lastActive() }}</li>
                </ul>
            </div>
        </div>
        <hr />
        
        <fieldset>
            <legend>Change Member's Group</legend>
            {{ Form::open(array('route' => 'members_group_post')) }}
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td width="10%">Select Group</td>
                            {{ Form::hidden('uid',$member->id) }}
                            {{ Form::hidden('do', 'change') }}
                            <td width="60%">{{ Form::select('group', $groups, $id) }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{ Form::submit('Save', array('class' => 'btn')) }}</td>
                        </tr>
                    </tbody>
                </table>
            {{ Form::close() }}
        </fieldset>

</div> <!-- /container -->
@stop