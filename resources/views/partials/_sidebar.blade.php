<div id="sidebar-menu">
    <ul class="metismenu list-unstyled" id="side-menu">

        <li>
            <a href="#" class="waves-effect">
                <i class="bx bxs-dashboard"></i>
                <span key="t-chat">Dashboard</span>
            </a>
        </li>

        <li>

        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="bx bx-git-pull-request"></i>
                <span key="t-crypto">Stock Requisition </span>
            </a>
            <ul class="sub-menu" aria-expanded="false">

                    <li>
                        <a href="{{route('stock-requisition')}}" key="t-wallet"> Number Plate Request
                        </a>
                    </li>

                <li><a href="{{route('approve-stock-requisition')}}" key="t-wallet">Approve Request</a></li>
                <li><a href="{{route('print-stock-requisition')}}" key="t-wallet">Print Request</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="bx bxs-store-alt"></i>
                <span key="t-crypto"> Inventory </span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
               <li><a href="{{route('stock-receipt')}}" key="t-wallet">Stock Receipt</a></li>
                    <li><a href="{{route('manage-stock-receipt')}}" key="t-wallet">Manage Receipt</a></li>
                    <li><a href="#" key="t-wallet">Approve Receipt</a></li>
                    <li class="menu-title" key="t-pages">Dispense</li>
                    <li><a href="{{route('dispense-to-mlo')}}" key="t-wallet">Dispense to MLOs</a></li>
                    <li><a href="{{route('approve-dispense-to-mlo-items')}}" key="t-wallet">Approve Dispense</a></li>
                    <li class="menu-title" key="t-pages">Report</li>
                    <li><a href="#" key="t-wallet">Stock Balance Report</a></li>
                    <li><a href="#" key="t-wallet">Stock Movement Report</a></li>
            </ul>
        </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-subdirectory-right"></i>
                        <span key="t-crypto"> Directory </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="menu-title" key="t-pages">Vehicle Owners</li>
                        <li><a href="#" key="t-wallet">Dispense to MLOs</a></li>
                        <li><a href="#" key="t-wallet">Approve Dispense</a></li>
                        <li class="menu-title" key="t-pages">Report</li>
                        <li><a href="#" key="t-wallet">Stock Balance Report</a></li>
                        <li><a href="#" key="t-wallet">Stock Movement Report</a></li>
                    </ul>
                </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bx-car"></i>
                    <span key="t-crypto"> Vehicle Reg. </span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{route('vehicle-registration')}}" key="t-wallet">New Registration</a></li>
                    <li><a href="{{ route("approve-vehicle-registration") }}" key="t-wallet">Approve Reg.</a></li>
                    <li><a href="{{ route("manage-invoice") }}" key="t-wallet">Manage Invoice</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bxs-user-voice"></i>
                    <span key="t-crypto"> Trans. Ownership </span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li class="menu-title" key="t-pages">Vehicle Owners</li>
                    <li><a href="#" key="t-wallet">Dispense to MLOs</a></li>
                    <li><a href="#" key="t-wallet">Approve Dispense</a></li>
                    <li class="menu-title" key="t-pages">Report</li>
                    <li><a href="#" key="t-wallet">Stock Balance Report</a></li>
                    <li><a href="#" key="t-wallet">Stock Movement Report</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bx-repeat"></i>
                    <span key="t-crypto"> Renewals </span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li class="menu-title" key="t-pages">Vehicle Owners</li>
                    <li><a href="#" key="t-wallet">Dispense to MLOs</a></li>
                    <li><a href="#" key="t-wallet">Approve Dispense</a></li>
                    <li class="menu-title" key="t-pages">Report</li>
                    <li><a href="#" key="t-wallet">Stock Balance Report</a></li>
                    <li><a href="#" key="t-wallet">Stock Movement Report</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bx-align-justify"></i>
                    <span key="t-crypto"> Fleet Management </span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li class="menu-title" key="t-pages">Vehicle Owners</li>
                    <li><a href="#" key="t-wallet">Dispense to MLOs</a></li>
                    <li><a href="#" key="t-wallet">Approve Dispense</a></li>
                    <li class="menu-title" key="t-pages">Report</li>
                    <li><a href="#" key="t-wallet">Stock Balance Report</a></li>
                    <li><a href="#" key="t-wallet">Stock Movement Report</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bx-transfer-alt"></i>
                    <span key="t-crypto"> Dealership </span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li class="menu-title" key="t-pages">Vehicle Owners</li>
                    <li><a href="#" key="t-wallet">Dispense to MLOs</a></li>
                    <li><a href="#" key="t-wallet">Approve Dispense</a></li>
                    <li class="menu-title" key="t-pages">Report</li>
                    <li><a href="#" key="t-wallet">Stock Balance Report</a></li>
                    <li><a href="#" key="t-wallet">Stock Movement Report</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bx-lock-alt"></i>
                    <span key="t-crypto"> Insurance </span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li class="menu-title" key="t-pages">Vehicle Owners</li>
                    <li><a href="#" key="t-wallet">Dispense to MLOs</a></li>
                    <li><a href="#" key="t-wallet">Approve Dispense</a></li>
                    <li class="menu-title" key="t-pages">Report</li>
                    <li><a href="#" key="t-wallet">Stock Balance Report</a></li>
                    <li><a href="#" key="t-wallet">Stock Movement Report</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bx-cog"></i>
                    <span key="t-crypto"> Settings </span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{route('lgas-settings')}}" key="t-wallet">LGA Codes</a></li>
                    <li><a href="{{route('plate-type')}}" key="t-wallet">Plate Types</a></li>
                    <li><a href="{{route('show-product-category')}}" key="t-wallet">Product Category</a></li>
                    <li><a href="{{route('all-products')}}" key="t-wallet">Products</a></li>
                    <li><a href="{{route('mlo-stations')}}" key="t-wallet">Station</a></li>
                    <li><a href="{{route('mlo-setups')}}" key="t-wallet">MLO Setup</a></li>
                    <li><a href="{{route('vehicle-brands')}}" key="t-wallet">Vehicle Brand</a></li>
                    <li><a href="{{route('vehicle-models')}}" key="t-wallet">Vehicle Model</a></li>
                    <li><a href="{{route('pastors')}}" key="t-wallet">Manage Users</a></li>
                    <li><a href="{{route('settings')}}" key="t-wallet">User Profile</a></li>
                </ul>
            </li>

        <li>
            <a href="{{route('logout')}}" class="waves-effect">
                <i class="bx bx-log-out-circle"></i>
                <span key="t-chat">Logout</span>
            </a>
        </li>
    </ul>
</div>
