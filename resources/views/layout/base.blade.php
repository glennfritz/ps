<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{env('APP_NAME','Laravel')}}  @yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img')}}/favicon.png">
    <link rel="stylesheet" href="{{asset('assets/css')}}/normalize.css">
    <link rel="stylesheet" href="{{asset('assets/css')}}/main.css">
    <link rel="stylesheet" href="{{asset('assets/css')}}/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('assets/css')}}/all.min.css">
    <link rel="stylesheet" href="{{asset('assets/fonts')}}/flaticon.css">
    <link rel="stylesheet" href="{{asset('assets')}}/toastr/toastr.min.css">
    <link rel="stylesheet" href="{{asset('assets/css')}}/animate.min.css">
    <link rel="stylesheet" href="{{asset('assets/css')}}/select2.min.css">
    <link rel="stylesheet" href="{{asset('assets/css')}}/datepicker.min.css">
    @yield('style')
    <link rel="stylesheet" href="{{asset('assets/css')}}/style.css">
    <script src="{{asset('assets/js')}}/modernizr-3.6.0.min.js"></script>
</head>

<body>
<div id="preloader"></div>
<div id="wrapper" class="wrapper bg-ash">
    <div class="navbar navbar-expand-md header-menu-one bg-light">
        <div class="nav-bar-header-one">
            <div class="header-logo">
                <a href="{{route('dashboard')}}">
                    <img style="height :50px;" src="{{asset('assets/img')}}/logo.png" alt="logo">
                </a>
            </div>
            <div class="toggle-button sidebar-toggle">
                <button type="button" class="item-link">
                        <span class="btn-icon-wrap">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                </button>
            </div>
        </div>
        <div class="d-md-none mobile-nav-bar">
            <button class="navbar-toggler pulse-animation" type="button" data-toggle="collapse" data-target="#mobile-navbar" aria-expanded="false">
                <i class="far fa-arrow-alt-circle-down"></i>
            </button>
            <button type="button" class="navbar-toggler sidebar-toggle-mobile">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <div class="header-main-menu collapse navbar-collapse" id="mobile-navbar">
            <ul class="navbar-nav">
                <li class="navbar-item header-admin">
                    Powered by Nishang System
                </li>
            </ul>
            <ul class="navbar-nav">
                @if(\Auth::user()->class(getYear()))
                    <li class="navbar-item header-admin">
                        <div class="input-group stylish-input-group">
                            <a href="{{route('student.index')}}?class={{\Auth::user()->class(getYear())->id}}">{{\Auth::user()->class(getYear())->class->name}} {{\Auth::user()->class(getYear())->section_id}}</a>
                        </div>
                    </li>
                @endif

                <li class="navbar-item dropdown header-admin">
                    <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-expanded="false">
                        <div class="admin-title">
                            <h5 class="item-title">{{request()->user()->name}}</h5>
                            <span>{{request()->user()->roles()->first()->byLocale()->name}}</span>
                        </div>
                        <div class="admin-img">
                            <img style="height: 50px;" src="{{route('image.render', Auth::user()->photo?Auth::user()->photo:'')}}">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="item-header">
                            <h6 class="item-title">{{request()->user()->name}}</h6>
                        </div>
                        <div class="item-content">
                            <ul class="settings-list">
                                <li><a href="{{route('user.show',\Auth::user()->slug)}}"><i class="flaticon-user"></i>My Profile</a></li>
                                <li><a href="{{route('user.edit',\Auth::user()->slug)}}"><i class="flaticon-gear-loading"></i>Account Settings</a></li>
                                <li><a href="{{route('user.password')}}"><i class="flaticon-gear-loading"></i>Change Password</a></li>
                                <li><a href="{{route('logout')}}"><i class="flaticon-turn-off"></i>Log Out</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
                @if(request()->user()->hasUnreadMessages())
                <li class="navbar-item dropdown header-message">
                    <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-expanded="false">
                        <i class="far fa-envelope"></i>
                        <div class="item-title d-md-none text-16 mg-l-10">Message</div>
                         <span>{{request()->user()->unreadMessageCount()}}</span>
                    </a>
                </li>
                @endif
                <li class="navbar-item dropdown header-language">
                    <a class="navbar-nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-expanded="false"><i class="fas fa-globe-americas"></i>{{ strtoupper(app()->getLocale()) }}</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{route('locale','en')}}">English</a>
                        <a class="dropdown-item" href="{{route('locale','fr')}}">French</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="dashboard-page-one">
        <div class="sidebar-main sidebar-menu-one sidebar-expand-md sidebar-color">
            <div class="mobile-sidebar-header d-md-none">
                <div class="header-logo">
                    <a href="{{route('dashboard')}}"><img style="height: 45px;" src="{{asset('assets/img')}}/logo1.png" alt="logo"></a>
                </div>
            </div>
            <div class="sidebar-menu-content">
                <ul class="nav nav-sidebar-menu sidebar-toggle-view">
                    <li class="nav-item">
                        <a href="{{route('dashboard')}}" class="nav-link"><i class="flaticon-dashboard"></i><span>Dashboard</span></a>
                    </li>
                    @if(\Auth::user()->can('select_fee','update_fee','create_fee') )
                        <li class="nav-item sidebar-nav-item">
                            <a href="{{route('fee')}}" class="nav-link"><i class="flaticon-technological"></i><span>Fees & Expenses</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <a href="{{route('fee')}}" class="nav-link"><i class="fas fa-angle-right"></i>Today's Fee</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('expenses.type.post')}}" class="nav-link"><i class="fas fa-angle-right"></i>Expense Type</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('fee.type')}}" class="nav-link"><i class="fas fa-angle-right"></i>Create Income Type</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('fee.student')}}?action=fee" class="nav-link"><i class="fas fa-angle-right"></i>Receive Fees</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('fee')}}" class="nav-link"><i class="fas fa-angle-right"></i>Undo Fee</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('fee.print')}}?action=reciept" class="nav-link"><i class="fas fa-angle-right"></i>Print Receipts</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('expenses')}}" class="nav-link"><i class="fas fa-angle-right"></i>Record Expenses</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('fee.student')}}?action=completed" class="nav-link"><i class="fas fa-angle-right"></i>Fee Reports</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('fee.student')}}?action=giftscholarship" class="nav-link"><i class="fas fa-angle-right"></i>Give scholarship</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('class.fee')}}" class="nav-link"><i class="fas fa-angle-right"></i>Configure Class Fee</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('fee.student')}}?action=scholarship" class="nav-link"><i class="fas fa-angle-right"></i>Scholarship Reports</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('fee.income')}}" class="nav-link"><i class="fas fa-angle-right"></i>Income Statement</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('fee.monthly.report')}}" class="nav-link"><i class="fas fa-angle-right"></i>Monthly Report</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('fee.monthly.receipt')}}" class="nav-link"><i class="fas fa-angle-right"></i>Monthly Receipt</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (\Auth::user()->can('create_class','see_class','delete_class'))
                        <li class="nav-item">
                            <a href="{{route('class.index')}}" class="nav-link"><i class="flaticon-maths-class-materials-cross-of-a-pencil-and-a-ruler"></i><span>Class</span></a>
                        </li>
                    @endif
                    @if (\Auth::user()->can('create_student'))
                        <li class="nav-item sidebar-nav-item">
                            <a href="{{route('student.index')}}" class="nav-link"><i class="flaticon-classmates"></i><span>Pupils Center</span></a>
                            <ul class="nav sub-group-menu">
                                @if (\Auth::user()->can('create_student'))
                                    <li class="nav-item">
                                        <a href="{{route('student.create')}}" class="nav-link"><i class="fas fa-angle-right"></i>Enroll Pupil</a>
                                    </li>
                                @endif
                                    <li class="nav-item">
                                        <a href="{{route('class.index')}}?action=student" class="nav-link"><i class="fas fa-angle-right"></i>Class List</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('student.promote')}}" class="nav-link"><i class="fas fa-angle-right"></i>Promote Pupil</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('student.changeClass')}}" class="nav-link"><i class="fas fa-angle-right"></i>Change Class</a>
                                    </li>
                            </ul>
                        </li>
                    @endif

                    @if(\Auth::user()->hasRole('admin'))
                        <li class="nav-item sidebar-nav-item">
                            <a href="{{route('user.index')}}?type=parent" class="nav-link"><i class="flaticon-couple"></i><span>Parents Center</span></a>
                            <ul class="nav sub-group-menu">

                                @if (\Auth::user()->can('create_user'))
                                    <li class="nav-item">
                                        <a href="{{route('user.create')}}?type=parent" class="nav-link"><i class="fas fa-angle-right"></i>Create Parent</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{route('user.index')}}?type=assign_parent" class="nav-link"><i class="fas fa-angle-right"></i>Assign to Pupil</a>
                                    </li>
                                @endif

                                <li class="nav-item">
                                    <a href="{{route('user.index')}}?type=parent" class="nav-link"><i class="fas fa-angle-right"></i>All Parents</a>
                                </li>
                                    <li class="nav-item">
                                        <a href="{{route('pupil.parent')}}" class="nav-link"><i class="fas fa-angle-right"></i>Pupil Parent</a>
                                    </li>
                            </ul>
                        </li>
                    @endif

                    @if (\Auth::user()->can('create_subject','see_class','delete_class'))
                        <li class="nav-item sidebar-nav-item">
                            <a href="{{route('subject.index')}}?type=parent" class="nav-link"><i class="flaticon-open-book"></i><span>Subjects</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <a  href="{{route('subject.create')}}" class="nav-link"><i class="fas fa-angle-right"></i><span>Create Subject</span></a>
                                </li>
                                @if (\Auth::user()->hasRole('admin'))
                                    <li class="nav-item">
                                        <a href="{{route('subject.index')}}"  class="nav-link"><i class="fas fa-angle-right"></i><span>All Subjects</span></a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    <li class="nav-item sidebar-nav-item">
                        <a href="{{route('fee')}}" class="nav-link"><i class="flaticon-technological"></i><span>Result</span></a>
                        <ul class="nav sub-group-menu">
                           @if(\Auth::user()->hasRole('admin'))
                                <li class="nav-item">
                                    <a href="{{route('result.class')}}" class="nav-link"><i class="fas fa-angle-right"></i>Class</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('result.fee_control')}}" class="nav-link"><i class="fas fa-angle-right"></i>Fee Control Print</a>
                                </li>
                           @elseif(\Auth::user()->hasRole('teacher'))
                                <li class="nav-item">
                                    <a href="{{route('result.class.student','teacher')}}?action=recordmarks" class="nav-link"><i class="fas fa-angle-right"></i>Record Marks</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('result.ranksheet')}}" class="nav-link"><i class="fas fa-angle-right"></i>Rank Students</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('result.class.student','teacher')}}?action=print" class="nav-link"><i class="fas fa-angle-right"></i>Print Results</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('result.fee_control')}}?year={{getYear()}}&class=0" class="nav-link"><i class="fas fa-angle-right"></i>Fee Controlled Print</a>
                                </li>
                           @else
                                <li class="nav-item">
                                    <a href="{{route('result.class.student','parent')}}" class="nav-link"><i class="fas fa-angle-right"></i>Student</a>
                                </li>
                           @endif

                           @if(\Auth::user()->students->count() > 0)
                               <li class="nav-item">
                                   <a href="{{route('result.class.student','mine')}}" class="nav-link"><i class="fas fa-angle-right"></i>My Children</a>
                               </li>
                           @endif

                        </ul>
                    </li>
                    @if(\Auth::user()->class(getYear()))
                        <li class="nav-item">
                            <a href="{{route('student.index')}}?class={{\Auth::user()->class(getYear())->id}}" class="nav-link"><i class="flaticon-dashboard"></i><span>Class List</span></a>
                        </li>
                    @endif
                   @if(\Auth::user()->hasRole('admin'))


                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-settings"></i><span>Users & Accounts</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <a href="{{route('user.create')}}" class="nav-link"><i class="fas fa-angle-right"></i>Create New User</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('roles.index')}}" class="nav-link"><i class="fas fa-angle-right"></i>Roles</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('user.index')}}?action=password" class="nav-link"><i class="fas fa-angle-right"></i>Change User Password</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('user.index')}}" class="nav-link"><i class="fas fa-angle-right"></i>View Users</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-settings-work-tool"></i><span>Setting</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <a href="{{route('settings.session')}}" class="nav-link"><i class="fas fa-angle-right"></i>Accademic Year</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('settings.terms')}}" class="nav-link"><i class="fas fa-angle-right"></i>Terms</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('settings.sequences')}}" class="nav-link"><i class="fas fa-angle-right"></i>Sequences</a>
                                </li>
                                <li class="nav-item">
                                    <span onclick="ShowModal()" class="nav-link"><i class="fas fa-angle-right"></i>Configure Year and Sequence</span>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="fas fa-inbox"></i><span>SMS</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <a href="{{route('message.index')}}" class="nav-link"><i class="fas fa-angle-right"></i><span>SMS Center</span></a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{route('message.create')}}" class="nav-link"><i class="fas fa-angle-right"></i><span>New SMS</span></a>
                                </li>
                            </ul>
                        </li>

                   @endif
                </ul>
            </div>
        </div>

        @if(\Auth::user()->hasRole('admin'))
            <div class="modal fade" id="yearModal"  role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog" role="document">
                    <form method="post" class="modal-content" action="{{route('config.set')}}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Please Enter the following config settings</h5>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 form-group">
                                <label>Current Academic year *</label>
                                <select class="select2" name="year" required>
                                    <option value="">Please Select Year *</option>
                                    @foreach(\App\Session::get() as $session)
                                         <option {{$session->id == getYear() ? 'selected':''}} value="{{$session->id}}">{{$session->name}}</option>
                                    @endforeach
                                </select>

                                <label>Current Sequence *</label>
                                <select class="select2" name="sequence" required>
                                    <option value="">Please Select Sequence *</option>
                                    @foreach(\App\Sequence::get() as $session)
                                        <option {{$session->id == getTerm() ? 'selected':''}}  value="{{$session->id}}">{{$session->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-gradient-yellow text-white">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
        <div class="dashboard-content-one">
            <div class="breadcrumbs-area">
                <h3>@yield('title')</h3>
            </div>
            @yield('section')
        </div>
    </div>
</div>


<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
               Powered by Nishang System
            </div><!-- .col-12 -->
        </div><!-- .row -->
    </div><!-- .container -->
</div><!-- .footer-bar -->
</footer><!-- .site-footer -->

<script src="{{asset('assets/js')}}/jquery-3.3.1.min.js"></script>
<script src="{{asset('assets/js')}}/plugins.js"></script>
<script src="{{asset('assets/js')}}/popper.min.js"></script>
<script src="{{asset('assets/js')}}/bootstrap.min.js"></script>
<script src="{{asset('assets/js')}}/moment.min.js"></script>
<script src="{{asset('assets/js')}}/jquery.scrollUp.min.js"></script>
<script src="{{asset('assets/js')}}/main.js"></script>
<script src="{{asset('assets')}}/toastr/toastr.min.js"></script>
<script src="{{asset('assets/js')}}/select2.min.js"></script>
<script src="{{asset('assets/js')}}/datepicker.min.js"></script>
<script>
    @if(Session::has('success'))
        toastr.success('{{Session::get('success')}}');
    @endif

    @if(Session::has('error'))
        toastr.error('{{Session::get('error')}}');
    @endif

    @if(count($errors)>0)
    @foreach ($errors->all() as $e)
        toastr.error('{{$e}}');
    @endforeach
    @endif

    @if(\Auth::user()->hasRole('admin') && (getYear()==0 || getTerm() == 0))
        $('#yearModal').modal({
            backdrop: 'static',
            keyboard: false
        });
    @endif

    function ShowModal(){
        $('#yearModal').modal().show()
    }
</script>
@yield('script')
</body>

</html>
