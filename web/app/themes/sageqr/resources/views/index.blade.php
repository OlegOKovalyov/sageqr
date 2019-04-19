@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  

<?php  if ( !is_user_logged_in() ) { ?>

    <section class="login-form">
        <div class="row container">
            <div class="col-lg-12">
                <h2 class="login-form__ttl">
                    Login to employee account
                </h2>
                <?php

                    wp_login_form();
                    
                ?>
            </div>
        </div>
    </section>

<?php } else { 

  echo "You are logged in";
  
}
?>

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'sage') }}
    </div>
    {!! get_search_form(false) !!}
  @endif

  @while (have_posts()) @php the_post() @endphp
    @include('partials.content-'.get_post_type())
  @endwhile

  {!! get_the_posts_navigation() !!}
@endsection
