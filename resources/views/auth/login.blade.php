@extends('layouts.front')

@section('content')
<div class="col-lg-4 col-md-6 col-sm-6 ml-auto mr-auto">
  <form class="form" method="POST" action="{!! route('do_login') !!}">
    {{ csrf_field() }}
    <div class="card card-login card-hidden">
      <div class="card-header card-header-rose text-center">
        <h4 class="card-title">Login</h4>
      </div>
      <div class="card-body ">
        <p class="card-description text-center">Or Be Classical</p>
        <span class="bmd-form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="material-icons">email</i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="Username..." name="username">
          </div>
        </span>
        <span class="bmd-form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="material-icons">lock_outline</i>
              </span>
            </div>
            <input type="password" class="form-control" placeholder="Password..." name="password">
          </div>
        </span>
      </div>
      <div class="card-footer justify-content-center">
        <button type="submit" class="btn btn-primary btn-link btn-lg">Login</button>
      </div>
    </div>
  </form>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
      setTimeout(function() {
        // after 1000 ms we add the class animated to the login/register card
        $('.card').removeClass('card-hidden');
      }, 500);
    });
</script>
@endsection