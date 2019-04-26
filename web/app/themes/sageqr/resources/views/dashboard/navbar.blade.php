<!-- ============================================================== -->
<!-- navbar -->
<!-- ============================================================== -->
<div class="dashboard-header">
    <nav class="navbar navbar-expand-lg fixed-top">
        <!-- <a class="navbar-brand" href="index.html">Concept</a> -->
        <a class="navbar-brand" href="/"><img src="@asset('images/logo-big.png')"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto navbar-right-top">

                <li class="nav-item dropdown nav-user">
                    <?php $current_user = wp_get_current_user(); ?>
                    <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $current_user->display_name }} <i class="fas fa-angle-down"></i></a>
                    <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                        <a class="dropdown-item" href="/my-profile/"><i class="fa fa-user mr-2"></i>My Profile</a>
                        <a class="dropdown-item" href="<?php echo wp_logout_url( get_permalink() ); ?>"><i class="fas fa-key mr-2"></i>Logout</a>

                    </div>
                </li>

            </ul>
        </div>
    </nav>
</div>
<!-- ============================================================== -->
<!-- end navbar -->
<!-- ============================================================== -->