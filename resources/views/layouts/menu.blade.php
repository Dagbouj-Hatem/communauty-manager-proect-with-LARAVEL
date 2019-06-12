<li class="{{ Request::is('home*') ? 'active' : '' }}">
    <a href="{!! route('home') !!}"><i class="fa fa-dashboard"></i><span>Tableau de bord</span></a>
</li>

<!-- menu  -->
@role('Administrateur') 

<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{!! route('users.index') !!}"><i class="fa fa-users"></i><span>Utilisateurs</span></a>
</li>

<li class="{{ Request::is('pages*') ? 'active' : '' }}">
    <a href="{!! route('pages.index') !!}"><i class="fa fa-facebook-square"></i><span>Gestion des pages</span></a>
</li>

<li class="{{ Request::is('posts*') ? 'active' : '' }}">
    <a href="{!! route('posts.index') !!}"><i class="fa fa-list-alt"></i><span>Publications</span></a>
</li>

<li class="{{ Request::is('comments*') ? 'active' : '' }}">
    <a href="{!! route('comments.index') !!}"><i class="fa fa-comments"></i><span>Commentaires</span></a>
</li>

<li class="{{ Request::is('authenticationLogs*') ? 'active' : '' }}">
    <a href="{!! route('authenticationLogs.index') !!}"><i class="fa fa-history"></i><span>Historiques des connexions</span></a>
</li>
@endrole
<!-- end menu  -->
<li class="{{ Route::is('settings*') ? 'active' : '' }}">
    <a href="{!! route('settings.profile') !!}"><i class="fa fa-cogs"></i><span>Paramétres</span></a>
    <ul class="treeview-menu">
            <li class="{{ Route::is('settings.profile') ? 'active' : '' }}">
            	<a href="{!! route('settings.profile') !!}"><i class="fa fa-cog"></i> Paramètres de profil</a>
            </li>
            @role('Administrateur')
            <li class="{{ Route::is('settings') ? 'active' : '' }}">
            	<a href="{!! route('settings') !!}"><i class="fa fa-cog"></i> Paramètres généraux</a>
            </li>
            @endrole
     </ul>
</li>

<!-- end menu -->



