<ul class="nav-main">
    <li class="nav-main-item">
        <a class="nav-main-link<?php echo e((Route::currentRouteName() == 'admin.dashboard') ? ' active' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>">
            <i class="nav-main-link-icon si si-cursor"></i>
            <span class="nav-main-link-name">Dashboard</span>
        </a>
    </li>
    
    
    <li class="nav-main-item<?php echo e(request()->is('admin/crm*') ? ' open' : ''); ?>">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
            <i class="nav-main-link-icon fas fa-building"></i>
            <span class="nav-main-link-name">CRM</span>
        </a>
        <ul class="nav-main-submenu">
            <li class="nav-main-item">
                <a class="nav-main-link<?php echo e(request()->is('*/clients*') ? ' active' : ''); ?>" href="<?php echo e(route('clients.index')); ?>">
                	<span class="nav-main-link-name"><?php echo e(__('Clients')); ?></span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-main-item<?php echo e(request()->is('admin/company*') ? ' open' : ''); ?>">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
            <i class="nav-main-link-icon fas fa-building"></i>
            <span class="nav-main-link-name">Company</span>
        </a>
        <ul class="nav-main-submenu">
            <li class="nav-main-item">
                <a class="nav-main-link<?php echo e(request()->is('*/employees*') ? ' active' : ''); ?>" href="<?php echo e(route('employees.index')); ?>">
                	<span class="nav-main-link-name"><?php echo e(__('Employees')); ?></span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link<?php echo e(request()->is('*/divisions*') ? ' active' : ''); ?>" href="<?php echo e(route('divisions.index')); ?>">
                	<span class="nav-main-link-name"><?php echo e(__('Divisions')); ?></span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link<?php echo e(request()->is('*/company-info*') ? ' active' : ''); ?>" href="<?php echo e(route('company.index')); ?>">
                	<span class="nav-main-link-name"><?php echo e(__('Company info')); ?></span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-main-item<?php echo e(request()->is('admin/store*') ? ' open' : ''); ?>">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
            <i class="nav-main-link-icon fas fa-building"></i>
            <span class="nav-main-link-name">Stores</span>
        </a>
        <ul class="nav-main-submenu">
            <li class="nav-main-item">
                <a class="nav-main-link<?php echo e(request()->is('*/stores*') ? ' active' : ''); ?>" href="<?php echo e(route('stores.index')); ?>">
                	<span class="nav-main-link-name"><?php echo e(__('Stores')); ?></span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link<?php echo e(request()->is('*/store-groups*') ? ' active' : ''); ?>" href="<?php echo e(route('storeGroups.index')); ?>">
                	<span class="nav-main-link-name"><?php echo e(__('Store groups')); ?></span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link<?php echo e(request()->is('*/prices*') ? ' active' : ''); ?>" href="<?php echo e(route('prices.index')); ?>">
                	<span class="nav-main-link-name"><?php echo e(__('Prices')); ?></span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-main-item<?php echo e(request()->is('admin/user*') ? ' open' : ''); ?>">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
            <i class="nav-main-link-icon fa fa-users"></i>
            <span class="nav-main-link-name">Users</span>
        </a>
        <ul class="nav-main-submenu">
            <li class="nav-main-item">
                <a class="nav-main-link<?php echo e(request()->is('*/users*') ? ' active' : ''); ?>" href="<?php echo e(route('users.index')); ?>">
                	<span class="nav-main-link-name"><?php echo e(__('Users')); ?></span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link<?php echo e(request()->is('*/user-groups*') ? ' active' : ''); ?>" href="<?php echo e(route('userGroups.index')); ?>">
                	<span class="nav-main-link-name"><?php echo e(__('User groups')); ?></span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link<?php echo e(request()->is('*/user-acl-roles*') ? ' active' : ''); ?>" href="<?php echo e(route('aclRoles.index')); ?>">
                	<span class="nav-main-link-name"><?php echo e(__('ACL roles')); ?></span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-main-item<?php echo e(request()->is('admin/settings*') ? ' open' : ''); ?>">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
            <i class="nav-main-link-icon fa fa-cogs"></i>
            <span class="nav-main-link-name"><?php echo e(__('Settings')); ?></span>
        </a>
        <ul class="nav-main-submenu">
            <li class="nav-main-item">
            	<a class="nav-main-link<?php echo e(request()->is('*/countries*') ? ' active' : ''); ?>" href="<?php echo e(route('countries.index')); ?>">
                	<span class="nav-main-link-name"><?php echo e(__('Countries')); ?></span>
                </a>
            </li>
            <li class="nav-main-item">
            	<a class="nav-main-link<?php echo e(request()->is('*/cities*') ? ' active' : ''); ?>" href="<?php echo e(route('cities.index')); ?>">
                	<span class="nav-main-link-name"><?php echo e(__('Cities')); ?></span>
                </a>
            </li>
            <li class="nav-main-item">
            	<a class="nav-main-link<?php echo e(request()->is('*/time-zones*') ? ' active' : ''); ?>" href="<?php echo e(route('timeZones.index')); ?>">
                	<span class="nav-main-link-name"><?php echo e(__('Time zones')); ?></span>
                </a>
            </li>
            <li class="nav-main-item">
            	<a class="nav-main-link<?php echo e(request()->is('*/currencies*') ? ' active' : ''); ?>" href="<?php echo e(route('currencies.index')); ?>">
                	<span class="nav-main-link-name"><?php echo e(__('Currencies')); ?></span>
                </a>
            </li>
            <li class="nav-main-item">
            	<a class="nav-main-link<?php echo e(request()->is('*/loadFiles*') ? ' active' : ''); ?>" href="<?php echo e(route('loadFiles.index')); ?>">
                	<span class="nav-main-link-name"><?php echo e(__('Load XML files')); ?></span>
                </a>
            </li>
            <li class="nav-main-item">
            	<a class="nav-main-link<?php echo e(request()->is('*/settings/settings*') ? ' active' : ''); ?>" href="<?php echo e(route('settings.index')); ?>">
                	<span class="nav-main-link-name"><?php echo e(__('Settings')); ?></span>
                </a>
            </li>
        </ul>
    </li>
    
</ul>