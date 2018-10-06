<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close m-aside-left-close--skin-dark" id="m_aside_left_close_btn">
	<i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
	<!-- BEGIN: Aside Menu -->
	<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark m-aside-menu--dropdown " data-menu-vertical="true"data-menu-dropdown="true" data-menu-scrollable="true" data-menu-dropdown-timeout="500" >
		<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
			<li class="m-menu__item  m-menu__item--active" aria-haspopup="true" >
				<a  href="{{ route('dashboard') }}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon flaticon-line-graph"></i>
					<span class="m-menu__link-text">
						Dashboard
					</span>
				</a>
			</li>
			<li class="m-menu__item" aria-haspopup="true" >
				<a  href="{{ route('profile') }}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon flaticon-settings"></i>
					<span class="m-menu__link-text">
						Profile
					</span>
				</a>
			</li>
			@if (Auth::user()->role == 1)
			<li class="m-menu__item  m-menu__item--submenu m-menu__item--bottom-2" aria-haspopup="true"  data-menu-submenu-toggle="hover">
				<a  href="#" class="m-menu__link m-menu__toggle">
					<i class="m-menu__link-icon flaticon-settings"></i>
					<span class="m-menu__link-text">
						Users
					</span>
					<i class="m-menu__ver-arrow la la-angle-right"></i>
				</a>
				<div class="m-menu__submenu m-menu__submenu--up">
					<span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li class="m-menu__item  m-menu__item--parent m-menu__item--bottom-2" aria-haspopup="true" >
							<span class="m-menu__link">
								<span class="m-menu__link-text">
									Users
								</span>
							</span>
						</li>
						<li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
							<a  href="{{ url(config('adminlte.all_users_url')) }}" class="m-menu__link ">
								<i class="m-menu__link-bullet m-menu__link-bullet--line">
									<span></span>
								</i>
								<span class="m-menu__link-text">
									All users
								</span>
							</a>
						</li>
						<li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
							<a  href="{{ url(config('adminlte.add_user_url')) }}" class="m-menu__link ">
								<i class="m-menu__link-bullet m-menu__link-bullet--line">
									<span></span>
								</i>
								<span class="m-menu__link-text">
									Add new
								</span>
							</a>
						</li>

					</ul>
				</div>
			</li>
			@endif
		</ul>
	</div>
	<!-- END: Aside Menu -->
</div>
<!-- END: Left Aside -->
