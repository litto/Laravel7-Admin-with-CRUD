@include('admin_layouts.header')
@section('content')
<div id="main" role="main">

      <!-- MAIN CONTENT -->

      <form class="lockscreen animated flipInY" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>/auth/login/">
        <div class="logo">
          <h1 class="semi-bold"><!-- <img src="oldimg/logo-o.png" alt="" />  --><span style="color:#4FACE5">Admin</span>Panel</h1>
        </div>
        <div>
          <img src="{{asset('admin_theme')}}/oldimg/avatars/logo1.png" alt="" width="120" height="120" />
          <div>
            <h1><i class="fa fa-user fa-3x text-muted air air-top-right hidden-mobile"></i>Admin Login </h1>
                <div class="input-group">
              <input class="form-control" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Username">
              <div class="input-group-btn">
                <a class="btn btn-primary" type="submit">
                  <i class="fa fa-user"></i>
                </a>
              </div>
            </div>
</br>
            <div class="input-group">
              <input class="form-control" type="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
              <div class="input-group-btn">
                <a class="btn btn-primary" type="submit">
                  <i class="fa fa-key"></i>
                </a>
              </div>
            </div>
            </br>

<div class="input-group">
            <input type="checkbox" class="ace" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/>

                                <span class="lbl"> Remember Me | 
                                                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif

                                </span>
            </div>
            </br>


            <div class="input-group">
          <button type="submit" class="btn btn-primary" name="submit">
                    Sign in
                  </button>
            </div>
          
          </div>

        </div>
        <p class="font-xs margin-top-5">
        Version: V.2.0.1  Copyright &copy;  2020

        </p>
      </form>

    </div>
    @endsection
@include('admin_layouts.footer')
