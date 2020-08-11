<footer class="section footer-classic context-dark bg-image">
    <div class="container">
        <div class="row row-30">
            <div class="col-md-4 col-xl-5">
                <div class="pr-xl-4"><a class="brand"></a>
                    <p><span class="descriptionr">2020</span><span> </span><span>Automated Leave management System</span><span>. </span> <br><br><span>A K M Naharul Hayat</span></p>
                </div>
            </div>
            <div class="col-md-4 pb-4">
                <h5>Contacts</h5>
                <dl class="contact-list">
                    <dt>email:</dt>
                    <dd><a href="mailto:#">naharulhayat@gmail.com</a></dd>
                </dl>
                <dl class="contact-list">
                    <dt>phones:</dt>
                    <dd><a href="tel:#">##########</a>
                    </dd>
                </dl>

            </div>
            <div class="col-md-4 col-xl-3">
                <h5>Links</h5>
                <ul class="nav-list">
                    <!-- If no user is logged in -->
                    @guest
                    <li><a href="/">Home</a></li>
                    @endguest
                    @auth
                    <!-- If user is student -->
                    @if(Auth::user()->role != "manager")
                    <li><a href="/user_area/index">View Previous Requests</a></li>
                    <li><a href="/user_area/request_new_holiday/">Request New Holiday</a></li>
                    @else
                    <li><a href="/staff_area/admin">Manage Staff</a></li>
                    <li><a href="/staff_area/admin/approved_requests">View Approved Requests</a></li>
                    <li><a href="/staff_area/admin/rejected_requests">View Rejected Requests</a></li>
                    <li><a href="/staff_area/admin/filter_by_month">Filter By Month</a></li>
                    @endif
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</footer>