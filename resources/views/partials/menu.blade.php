<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">
            @can('users_manage')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
						<i class="fa-fw fas fa-user nav-icon"></i>
                        	Customer Management
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-unlock-alt nav-icon"></i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-briefcase nav-icon"></i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-user nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @if(auth()->user()->user_type == "A")
            <li class="nav-item">
                <a href="{{ route('admin.home') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt"></i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.category.index') }}" class="nav-link">
                   <i class=" nav-icon fas fa-layer-group"></i>
                    Categories
                </a>
            </li>

             <li class="nav-item">
                <a href="{{ route('admin.vendor-category.index') }}" class="nav-link">
                   <i class=" nav-icon fas fa-layer-group"></i>
                    Vendor Categories
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.product.index') }}" class="nav-link">
                 <i class="nav-icon fas fa-book-reader nav-icon"></i>
                   Products
                </a> 
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.provider.index') }}" class="nav-link">
                   <i class="fa fa-industry nav-icon"></i>
                   Vendors
                </a>
            </li>
            <li class="nav-item"> 
                <a href="{{ route('admin.orders') }}" class="nav-link">
                 <i class="nav-icon fas fa-book-reader nav-icon"></i>
                   Orders
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users') }}" class="nav-link">
                   <i class="fa fa-user-tie nav-icon" aria-hidden="true"></i>
                   Users
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.brand.index') }}" class="nav-link">
                   <i class="fa fa-address-book nav-icon" aria-hidden="true"></i>
                   Brands
                </a>
            </li>

             <!-- <li class="nav-item"> <i class="fa-solid fa-address-book"></i>
                <a href="{{ route('admin.tag.index') }}" class="nav-link">
                   <i class="fas fa-star nav-icon" aria-hidden="true"></i>
                   Tag vendor-category
                </a>
            </li> -->

            <li class="nav-item">
                <a href="{{ route('admin.testimonial.index') }}" class="nav-link">
                   <i class="fa fa-quote-left nav-icon" aria-hidden="true"></i>
                   Testimonials
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.contact') }}" class="nav-link">
                   <i class="fas fa-star nav-icon" aria-hidden="true"></i>
                   Contact us
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.index') }}" class="nav-link">
                   <i class="fa-fw fas fa-unlock-alt nav-icon"></i>
                   Update Profile
                </a>
            </li>
            @endif

            @if(auth()->user()->user_type == "V" || auth()->user()->user_type == "CH" || auth()->user()->user_type == "R")
                <li class="nav-item">
                    <a href="{{ route('vendor.home') }}" class="nav-link">
                        <i class="nav-icon fas fa-fw fa-tachometer-alt"></i>
                        {{ trans('global.dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('vendor.product.index') }}" class="nav-link">
                     <i class="nav-icon fas fa-book-reader nav-icon"></i>
                       Products
                    </a>
                </li>
                <li class="nav-item"> 
                    <a href="{{ route('vendor.orders') }}" class="nav-link">
                     <i class="nav-icon fas fa-book-reader nav-icon"></i>
                       Orders
                    </a>
                </li>
                 <li class="nav-item"> 
                    <a href="{{ route('vendor.sold-product') }}" class="nav-link">
                     <i class="nav-icon fas fa-book-reader nav-icon"></i>
                       Sold Products
                    </a>
                </li>
                <li class="nav-item"> 
                    <a href="{{ route('vendor.setting') }}" class="nav-link">
                     <i class="nav-icon fas fa-book-reader nav-icon"></i>
                       Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('vendor.index') }}" class="nav-link">
                       <i class="fa-fw fas fa-unlock-alt nav-icon"></i>
                       Update Profile
                    </a>
                </li>
            @endif






            <!-- @if(auth()->user()->user_type == "A")
			 <li class="nav-item">
                <a href="{{ route('admin.category.index') }}" class="nav-link">
                   <i class=" nav-icon fas fa-layer-group"></i>
                    Category Listing
                </a>
            </li>
            @endif
            @if(auth()->user()->user_type == "A" || auth()->user()->user_type == "V")
			 <li class="nav-item">
                <a href="{{ route('admin.product.index') }}" class="nav-link">
                 <i class="nav-icon fas fa-book-reader nav-icon"></i>
                   Product Listing
                </a>
            </li>
            @endif
            @if(auth()->user()->user_type == "A")    
            <li class="nav-item">
                <a href="{{ route('admin.provider.index') }}" class="nav-link">
                   <i class="fa fa-warning nav-icon" aria-hidden="true"></i>
                   Vendor
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.brand.index') }}" class="nav-link">
                   <i class="fa fa-warning nav-icon" aria-hidden="true"></i>
                   Brand
                </a>
            </li>
            @endif
			 <li class="nav-item">
                <a href="{{ route('admin.index') }}" class="nav-link">
                   <i class="fa-fw fas fa-unlock-alt nav-icon"></i>
                   Update Admin Profile
                </a>
            </li> -->

           <!-- <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li> -->
        </ul>

    </nav>
    <!--
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>-->
</div>
