 <!-- <div>
   People find pleasure in different ways. I find it in keeping my mind clear. - Marcus Aurelius
</div>
-->


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


  <title>Alpha technologies Tz</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<!-- Google Fonts -->
<link href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

<!-- Template Main CSS File -->
<link href="{{ asset('assets/css/styless.css') }}" rel="stylesheet">



  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <img src="{{ asset('assets/img/logo.png')}}" alt="logo">
        <span class="d-none d-lg-block">Alphaforce Schools</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have 4 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Kevin Anderson</h6>
              <span>Web Designer</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="index.php">
          <i class="bi bi-grid"></i>
          <span>Home</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icon-nav"  href="{{ route ('register.create') }}">
          <i class="ri-user-add-fill"></i><span>Student Registration</span> </i>
        </a>
</li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person"></i><span>Students</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('student.create', ['class' => 'Class A']) }}">
              <i class="bi bi-circle"></i><span>Class A</span>
            </a>
          </li>
          <li>
            <a href="{{ route('student.create', ['class' => 'Class B']) }}">
              <i class="bi bi-circle"></i><span>Class B</span>
            </a>
          </li>
          <li>
            <a href="{{ route('student.create', ['class' => 'Class C']) }}">
              <i class="bi bi-circle"></i><span>Class C</span>
            </a>
          </li>

          </li>
        </ul>
      </li>    <!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Attendance</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                         <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#for-nav" data-bs-toggle="collapse"  >
          <i class="bi bi-circle"></i><span>Call Attendance</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="for-nav" class="nav-content collapse " >

        <li>
    <a href="{{ route('attendance.index', ['class' => 'Class_A']) }}">
        <i class="bi bi-circle"></i><span>Class A</span>
    </a>
</li>

          <li>
            <a href="{{ route('attendance.index', ['class' => 'Class_B']) }}">
              <i class="bi bi-circle"></i><span>Class B</span>
            </a>
          </li>

          <li>
            <a href="{{ route('attendance.index', ['class' => 'Class_C']) }}">
              <i class="bi bi-circle"></i><span>Class C</span>
            </a>
          </li>
</ul>
</li>

<li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#form-nav" data-bs-toggle="collapse"  >
          <i class="bi bi-circle"></i><span>Attendance Record</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="form-nav" class="nav-content collapse " >

        <li>
    <a href="{{ route('attendance.summary', ['class' => 'Class_A']) }}">
        <i class="bi bi-circle"></i><span>Class A</span>
    </a>
</li>

          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Class B</span>
            </a>
          </li>

          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Class C</span>
            </a>
          </li>
</ul>
                 <!--attendance class selection -->


          <!--<li>
            <a href="forms-editors.html">
              <i class="bi bi-circle"></i><span>Form Editors</span>
            </a>
          </li>
          <li>
            <a href="forms-validation.html">
              <i class="bi bi-circle"></i><span>Form Validation</span>
            </a>
          </li>-->
        </ul>
      </li><!-- End Forms Nav -->

      <!--<li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Tables</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="tables-general.html">
              <i class="bi bi-circle"></i><span>General Tables</span>
            </a>
          </li>
          <li>
            <a href="tables-data.html">
              <i class="bi bi-circle"></i><span>Data Tables</span>
            </a>
          </li>
        </ul>
      </li>--><!-- End Tables Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Exam Results</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>


        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#for-nav" data-bs-toggle="collapse"  >
          <i class="bi bi-circle"></i><span>midterm Exam Results</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="for-nav" class="nav-content collapse " >

          <li>
            <a href="{{ route('marks.show', ['examType' => 'Midterm', 'class' => 'Class_A' ]) }}">
              <i class="bi bi-circle"></i><span>Class A</span>
            </a>
          </li>

          <li>
            <a href=" {{ route('marks.show', ['examType' => 'Midterm', 'class' => 'Class_B']) }}">
              <i class="bi bi-circle"></i><span>Class B</span>
            </a>
          </li>

          <li>
            <a href=" {{ route('marks.show', ['examType' => 'Midterm', 'class' => 'Class_C']) }}">
              <i class="bi bi-circle"></i><span>Class C</span>
            </a>
          </li>
</ul>
</li>


<li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#foorm-nav" data-bs-toggle="collapse"  >
          <i class="bi bi-circle"></i><span>Terminal Exams Results</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="foorm-nav" class="nav-content collapse " >

        <li>
    <a href="{{ route('marks.show', ['class' => 'Class_A', 'examType'=> 'Terminal']) }}">
        <i class="bi bi-circle"></i><span>Class A</span>
    </a>
</li>

          <li>
            <a href="{{ route('marks.show', ['class' => 'Class_B', 'examType'=> 'Terminal']) }}">
              <i class="bi bi-circle"></i><span>Class B</span>
            </a>
          </li>

          <li>
            <a href="{{ route('marks.show', ['class' => 'Class_C', 'examType'=> 'Terminal']) }}">
              <i class="bi bi-circle"></i><span>Class C</span>
            </a>
          </li>
</ul>



            <!--selection of class -uploading marks -->


</ul>
          </li>

          <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forr-nav" data-bs-toggle="collapse"  >
          <i class="bi bi-bar-chart"></i><span>Upload Exam Results</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forr-nav" class="nav-content collapse " >

          <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forrmr-nav" data-bs-toggle="collapse"  >
          <i class="bi bi-circle"></i><span>Midterm</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forrmr-nav" class="nav-content collapse " >

        <li>
        <a href="{{ route('marks.create', ['examType' => 'Midterm', 'class' => 'Class_A']) }}">
        <i class="bi bi-circle"></i><span>Class A</span>
    </a>
</li>

          <li>
            <a href=" {{ route('marks.create', ['examType' => 'Midterm', 'class' => 'Class_B']) }}">
              <i class="bi bi-circle"></i><span>Class B</span>
            </a>
          </li>

          <li>
            <a href="{{ route('marks.create', ['examType' => 'Midterm', 'class' => 'Class_C']) }}">
              <i class="bi bi-circle"></i><span>Class C</span>
            </a>
          </li>
</ul>
</li>
<li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forrrr-nav" data-bs-toggle="collapse"  >
          <i class="bi bi-circle"></i><span>Terminal</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forrrr-nav" class="nav-content collapse " >

          <li>
            <a href="{{ route('marks.create', ['examType' => 'Terminal', 'class' => 'Class_A']) }}">
              <i class="bi bi-circle"></i><span>Class A</span>
            </a>
          </li>

          <li>
            <a href=" {{ route('marks.create', ['examType' => 'Terminal', 'class' => 'Class_B']) }}">
              <i class="bi bi-circle"></i><span>Class B</span>
            </a>
          </li>

          <li>
            <a href="{{ route('marks.create', ['examType' => 'Terminal', 'class' => 'Class_C']) }}">
              <i class="bi bi-circle"></i><span>Class C</span>
            </a>
          </li>
</ul>
</li>
</ul>
</li>

         <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icon-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gem"></i><span>Assignment</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icon-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav" >

<li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#fooorm-nav" data-bs-toggle="collapse"  >
          <i class="bi bi-circle"></i><span>Homework</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="fooorm-nav" class="nav-content collapse " >

        <li>
    <a href="{{ route('assignments.index', ['type' => 'homework', 'class' => 'Class_A']) }}">
        <i class="bi bi-circle"></i><span>Class A</span>
    </a>
</li>

          <li>
            <a href="{{ route('assignments.index', ['type' => 'homework', 'class' => 'Class_B']) }}">
              <i class="bi bi-circle"></i><span>Class B</span>
            </a>
          </li>

          <li>
            <a href="{{ route('assignments.index', ['type' => 'homework', 'class' => 'Class_C']) }}">
              <i class="bi bi-circle"></i><span>Class C</span>
            </a>
          </li>
</ul>


<!-- HOMEPACKEAGE -->


<li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forrmmm-nav" data-bs-toggle="collapse"  >
          <i class="bi bi-circle"></i><span>Home Package</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forrmmm-nav" class="nav-content collapse " >

        <li>
    <a href="{{ route('assignments.index', ['type' => 'homepackage', 'class' => 'Class_A']) }}">
        <i class="bi bi-circle"></i><span>Class A</span>
    </a>
</li>

          <li>
            <a href="{{ route('assignments.index', ['type' => 'homepackage', 'class' => 'Class_B']) }}">
              <i class="bi bi-circle"></i><span>Class B</span>
            </a>
          </li>

          <li>
            <a href="{{ route('assignments.index', ['type' => 'homepackage', 'class' => 'Class_C']) }}">
              <i class="bi bi-circle"></i><span>Class C</span>
            </a>
          </li>
</ul>
        </ul>
      </li>     <!-- End Assignment Nav -->

<!-- UPLOAD ASSIGNMENT -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#formrm-nav" data-bs-toggle="collapse"  >
          <i class="bi bi-bar-chart"></i><span>Upload Assignment</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="formrm-nav" class="nav-content collapse " >

          <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#homework-nav" data-bs-toggle="collapse"  >
          <i class="bi bi-circle"></i><span>Homework</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="homework-nav" class="nav-content collapse " >

        <li>
        <a href="{{ route('assignments.create', ['type' => 'homework', 'class' => 'Class_A']) }}">
        <i class="bi bi-circle"></i><span>Class A</span>
    </a>
</li>

          <li>
            <a href="{{ route('assignments.create', ['type' => 'homework', 'class' => 'Class_B']) }}">
              <i class="bi bi-circle"></i><span>Class B</span>
            </a>
          </li>

          <li>
            <a href="{{ route('assignments.create', ['type' => 'homework', 'class' => 'Class_C']) }}">
              <i class="bi bi-circle"></i><span>Class C</span>
            </a>
          </li>
</ul>
</li>
<li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#homepackage-nav" data-bs-toggle="collapse"  >
          <i class="bi bi-circle"></i><span>Homepackage</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="homepackage-nav" class="nav-content collapse " >

          <li>
            <a href="{{ route('assignments.create', ['type' => 'homepackage', 'class' => 'Class_A']) }}">
              <i class="bi bi-circle"></i><span>Class A</span>
            </a>
          </li>

          <li>
            <a href="{{ route('assignments.create', ['type' => 'homepackage', 'class' => 'Class_B']) }}">
              <i class="bi bi-circle"></i><span>Class B</span>
            </a>
          </li>

          <li>
            <a href="{{ route('assignments.create', ['type' => 'homepackage', 'class' => 'Class_C']) }}">
              <i class="bi bi-circle"></i><span>Class C</span>
            </a>
          </li>
</ul>
</li>
</ul>
</li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gem"></i><span>Fees</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">



          <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#for-nav" data-bs-toggle="collapse"  >
          <i class="bi bi-circle"></i><span>Confirm Payment</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="for-nav" class="nav-content collapse " >

          <li>
            <a href="{{ route('payments.create', ['class' => 'Class_A']) }}">
              <i class="bi bi-circle"></i><span>Class A</span>
            </a>
          </li>

          <li>
            <a href="{{ route('payments.create', ['class' => 'Class_B']) }}">
              <i class="bi bi-circle"></i><span>Class B</span>
            </a>
          </li>

          <li>
            <a href="{{ route('payments.create', ['class' => 'Class_C']) }}">
              <i class="bi bi-circle"></i><span>Class C</span>
            </a>
          </li>
</ul>
</li>

<li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#fform-nav" data-bs-toggle="collapse"  >
          <i class="bi bi-circle"></i><span>Payment Record</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="fform-nav" class="nav-content collapse " >

        <li>
    <a href="{{ route('payments.index', ['class' => 'Class_A']) }}">
        <i class="bi bi-circle"></i><span>Class A</span>
    </a>
</li>

          <li>
            <a href="{{ route('payments.index', ['class' => 'Class_B']) }}">
              <i class="bi bi-circle"></i><span>Class B</span>
            </a>
          </li>

          <li>
            <a href="{{ route('payments.index', ['class' => 'Class_C']) }}">
              <i class="bi bi-circle"></i><span>Class C</span>
            </a>
          </li>
</ul>
</ul>

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route ('contact')}}">
          <i class="bi bi-envelope"></i>
          <span>Contact Us</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.create')}}">
          <i class="bi bi-card-list"></i>
          <span>Add New teacher</span>
        </a>
      </li><!-- End Register Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Logout</span>
        </a>
      </li><!-- End Login Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-error-404.html">
          <i class="bi bi-dash-circle"></i>
          <span>Error 404</span>
        </a>
      </li><!-- End Error 404 Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Welcome</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title"><b> number of Teachers we have</b></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-person"></i>
                    </div>
                    <div class="ps-3">
                      <h6>145</h6>
                      <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">



                <div class="card-body">
                  <h5 class="card-title"><b>Total Students</b> <span>| This Month</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-person"></i>
                    </div>
                    <div class="ps-3">
                      <h6>3,264</h6>
                      <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title"><b>Our Necta Exams Results</b><span>| This Year</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>1244</h6>
                      <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->



                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Sales',
                          data: [31, 40, 28, 51, 42, 82, 56],
                        }, {
                          name: 'Revenue',
                          data: [11, 32, 45, 32, 34, 52, 41]
                        }, {
                          name: 'Customers',
                          data: [15, 11, 32, 18, 9, 24, 11]
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'datetime',
                          categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                        },
                        tooltip: {
                          x: {
                            format: 'dd/MM/yy HH:mm'
                          },
                        }
                      }).render();
                    });
                  </script>
                  <!-- End Line Chart -->

                </div>

              </div>
            </div><!-- End Reports -->


      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>EAlphaforce</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('assets/vendor/quill/quill.js')}}"></script>
  <script src="{{asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('assets/js/main.js')}}"></script>

  <script>
  function loadPage(page) {
    const content = document.getElementById('main-content');
    fetch(page)
      .then(response => response.text())
      .then(data => {
        content.innerHTML = data;
      })
      .catch(error => console.error('Error:', error));
  }
</script>


</body>

</html>
