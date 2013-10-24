@if (Acl::isAdmin() && Acl::getUser()->id != $member->id)
<div class="span2">
        <div class="btn-group btn-block">
            <button class="btn"><i class="icon-asterisk"></i> Controls</button>
            <button class="btn dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                @if ($member->isSuspended())
                    <li><a href="{{ route('members_unsuspend', $member->id) }}"><i class="icon-ban-circle"></i> Unsuspend member</a></li>
                @else
                    <li><a href="{{ route('members_suspend', $member->id) }}"><i class="icon-ban-circle"></i> Suspend member</a></li>
                @endif
                <li class="divider"></li>
                <li><a href="{{ route('members_group', array('uid' => $member->id,'do' => 'change')) }}"><i class="icon-edit"></i> Change group</a></li>
                <li class="divider"></li>
                <li><a href="{{ route('members_delete', $member->id) }}"><i class="icon-remove"></i> Delete member</a></li>
            </ul>
        </div>
</div>
@endif