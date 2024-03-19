<div class="main-settings__sidebar-container">
    <div class="modal-header">
        <h6 class="modal-title text-uppercase">Settings</h6>
    </div>
    <div class="sidebar-section mt-5">
        <div class="settings-section-header">
            <div class="section-title text-uppercase">
                <h6>Features</h6>
            </div>
        </div>
        <a href="{{route('lgas-settings')}}" class="{{  Request::routeIs('lgas-settings') ? 'is-active-setting' : ''}}">
            <div class="sidebar-item">
                <span class="">LGA Codes</span>
            </div>
        </a>
        <a href="{{route('plate-type')}}" class="{{  Request::routeIs('plate-type') ? 'is-active-setting' : ''}}">
            <div class="sidebar-item">
                <span class="">Plate Types</span>
            </div>
        </a>
        <a href="{{route('show-product-category')}}" class="{{  Request::routeIs('show-product-category') ? 'is-active-setting' : ''}}">
            <div class="sidebar-item">
                <span class="">Product Category</span>
            </div>
        </a>
        <a href="{{route('all-products')}}" class="{{  Request::routeIs('all-products') ? 'is-active-setting' : ''}}">
            <div class="sidebar-item">
                <span class="">Products</span>
            </div>
        </a>
        <a href="{{route('mlo-stations')}}" class="{{  Request::routeIs('mlo-stations') ? 'is-active-setting' : ''}}">
            <div class="sidebar-item">
                <span class="">Station</span>
            </div>
        </a>
        <a href="{{route('mlo-setups')}}" class="{{  Request::routeIs('mlo-setups') ? 'is-active-setting' : ''}}">
            <div class="sidebar-item">
                <span class="">MLO Setups</span>
            </div>
        </a>
        <a href="{{route('vehicle-brands')}}" class=" {{  request()->routeIs('vehicle-brands') ? 'is-active-setting' : ''}}">
            <div class="sidebar-item">
                <span>Vehicle Brands</span>
            </div>
        </a>
        <a href="{{route('vehicle-models')}}" class=" {{  request()->routeIs('vehicle-models') ? 'is-active-setting' : ''}}">
            <div class="sidebar-item">
                <span>Vehicle Model</span>
            </div>
        </a>
        <a href="{{route('settings')}}" class=" {{  request()->routeIs('settings') ? 'is-active-setting' : ''}}">
            <div class="sidebar-item">
                <span>User Profile</span>
            </div>
        </a>
        <a href="{{route('change-password')}}" class=" {{  request()->routeIs('change-password') ? 'is-active-setting' : ''}}">
            <div class="sidebar-item">
                <span>Change Password</span>
            </div>
        </a>
    </div>
</div>
