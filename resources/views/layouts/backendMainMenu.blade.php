<ul class="nav-main">
    <li class="nav-main-item">
        <a class="nav-main-link{{ (Route::currentRouteName() == 'admin.dashboard') ? ' active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="nav-main-link-icon si si-cursor"></i>
            <span class="nav-main-link-name">Dashboard</span>
        </a>
    </li>
    {{--
    <li class="nav-main-heading">{{ __('General settings') }}</li>
    --}}
    
    <li class="nav-main-item{{ request()->is('admin/crm*') ? ' open' : '' }}">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
            <i class="nav-main-link-icon fas fa-building"></i>
            <span class="nav-main-link-name">CRM</span>
        </a>
        <ul class="nav-main-submenu">
            <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('*/clients*') ? ' active' : '' }}" href="{{ route('clients.index') }}">
                	<span class="nav-main-link-name">{{ __('Clients') }}</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-main-item{{ request()->is('admin/company*') ? ' open' : '' }}">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
            <i class="nav-main-link-icon fas fa-building"></i>
            <span class="nav-main-link-name">Company</span>
        </a>
        <ul class="nav-main-submenu">
            <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('*/employees*') ? ' active' : '' }}" href="{{ route('employees.index') }}">
                	<span class="nav-main-link-name">{{ __('Employees') }}</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('*/divisions*') ? ' active' : '' }}" href="{{ route('divisions.index') }}">
                	<span class="nav-main-link-name">{{ __('Divisions') }}</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('*/company-info*') ? ' active' : '' }}" href="{{ route('company.index') }}">
                	<span class="nav-main-link-name">{{ __('Company info') }}</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-main-item{{ request()->is('admin/store*') ? ' open' : '' }}">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
            <i class="nav-main-link-icon fas fa-building"></i>
            <span class="nav-main-link-name">Stores</span>
        </a>
        <ul class="nav-main-submenu">
            <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('*/stores*') ? ' active' : '' }}" href="{{ route('stores.index') }}">
                	<span class="nav-main-link-name">{{ __('Stores') }}</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('*/store-groups*') ? ' active' : '' }}" href="{{ route('storeGroups.index') }}">
                	<span class="nav-main-link-name">{{ __('Store groups') }}</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('*/prices*') ? ' active' : '' }}" href="{{ route('prices.index') }}">
                	<span class="nav-main-link-name">{{ __('Prices') }}</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-main-item{{ request()->is('admin/user*') ? ' open' : '' }}">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
            <i class="nav-main-link-icon fa fa-users"></i>
            <span class="nav-main-link-name">Users</span>
        </a>
        <ul class="nav-main-submenu">
            <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('*/users*') ? ' active' : '' }}" href="{{ route('users.index') }}">
                	<span class="nav-main-link-name">{{ __('Users') }}</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('*/user-groups*') ? ' active' : '' }}" href="{{ route('userGroups.index') }}">
                	<span class="nav-main-link-name">{{ __('User groups') }}</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('*/user-acl-roles*') ? ' active' : '' }}" href="{{ route('aclRoles.index') }}">
                	<span class="nav-main-link-name">{{ __('ACL roles') }}</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-main-item{{ request()->is('admin/settings*') ? ' open' : '' }}">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
            <i class="nav-main-link-icon fa fa-cogs"></i>
            <span class="nav-main-link-name">{{ __('Settings') }}</span>
        </a>
        <ul class="nav-main-submenu">
            <li class="nav-main-item">
            	<a class="nav-main-link{{ request()->is('*/countries*') ? ' active' : '' }}" href="{{ route('countries.index') }}">
                	<span class="nav-main-link-name">{{ __('Countries') }}</span>
                </a>
            </li>
            <li class="nav-main-item">
            	<a class="nav-main-link{{ request()->is('*/cities*') ? ' active' : '' }}" href="{{ route('cities.index') }}">
                	<span class="nav-main-link-name">{{ __('Cities') }}</span>
                </a>
            </li>
            <li class="nav-main-item">
            	<a class="nav-main-link{{ request()->is('*/time-zones*') ? ' active' : '' }}" href="{{ route('timeZones.index') }}">
                	<span class="nav-main-link-name">{{ __('Time zones') }}</span>
                </a>
            </li>
            <li class="nav-main-item">
            	<a class="nav-main-link{{ request()->is('*/currencies*') ? ' active' : '' }}" href="{{ route('currencies.index') }}">
                	<span class="nav-main-link-name">{{ __('Currencies') }}</span>
                </a>
            </li>
            <li class="nav-main-item">
            	<a class="nav-main-link{{ request()->is('*/loadFiles*') ? ' active' : '' }}" href="{{ route('loadFiles.index') }}">
                	<span class="nav-main-link-name">{{ __('Load XML files') }}</span>
                </a>
            </li>
            <li class="nav-main-item">
            	<a class="nav-main-link{{ request()->is('*/settings/settings*') ? ' active' : '' }}" href="{{ route('settings.index') }}">
                	<span class="nav-main-link-name">{{ __('Settings') }}</span>
                </a>
            </li>
        </ul>
    </li>
    
</ul>