<div class="login-page">
 <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>
  <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card ">
                    <form method="POST" action="<?= base_url('admin/login/user_login');?>" class="form-submit">
                        <?= csrf();?>

                        <div class="card-body login-card-body">
                        <p class="login-box-msg">Sign in to start your session</p>
                            <div class="card-content">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="email" placeholder="Email" value="">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                                    <span class="text-danger"></span>
                                </div>
                                    
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <div class="icheck-primary">
                                        <input type="checkbox" name="is_check" id="remember">
                                        <label for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right"> 
                            <button type="submit" class="btn btn-secondary">Submit</button>
                        </div>
                    </form>
                </div>
        
            </div>
        </div>
  </div>
</div>
