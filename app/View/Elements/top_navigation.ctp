<script type="text/javascript" src="<?php echo ABSOLUTE_URL;?>/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo ABSOLUTE_URL;?>/js/bootstrapValidator.min.js"></script>
<div class="templatemo-top-bar" id="templatemo-top">
            <div class="container">
                <div class="subheader">
                    <div id="phone" class="pull-left">
                            <img src="<?php echo ABSOLUTE_URL;?>/img/phone.png" alt="phone"/>
                            090-080-0110
                    </div>
                    <div id="email" class="pull-right">
                            <img src="<?php echo ABSOLUTE_URL;?>/img/email.png" alt="email"/>
                            help@agrawalbeejbhandar.com
                    </div>
                </div>
            </div>
        </div>
        <div class="templatemo-top-menu">
            <div class="container">
                <!-- Static navbar -->
                <div class="navbar navbar-default row" role="navigation">
                    <div class="container">
                        <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                </button>

                                <a href="#" class="navbar-brand"><img src="<?php echo ABSOLUTE_URL;?>/img/logo/logo1.jpg" class="img-responsive" style="max-width: 35%; padding-left:10px;" alt="Urbanic Template" title="Urbanic Template" /></a>
                        </div>
                        <div class="navbar-collapse collapse" id="templatemo-nav-bar">
                            
                            <?php if ($this->params['controller'] == 'home_pages' && $this->action != 'deshBoard') { ?> 
                              <ul class="nav navbar-nav navbar-right" style="margin-top: 40px;">
                                <li class="active"><a href="<?php echo ABSOLUTE_URL;?>/home_pages/deshBoard">HOME</a></li>
                                <li><a href="#templatemo-about">ABOUT</a></li>
                                <li><a href="#templatemo-portfolio">PORTFOLIO</a></li>
                                <li><a href="#templatemo-blog">BLOG</a></li>
                                <li><a rel="nofollow" 
                                        class="external-link" data-toggle="modal" data-target="#login">LOGIN</a></li>
                                        <li><a rel="nofollow" 
                                        class="external-link" id="register" data-toggle="modal" data-target="#signUpForm">REGISTER</a></li>
                                <li><a href="#templatemo-contact">CONTACT</a></li></ul>
                                <?php } else {  ?>
                                  <ul class="nav navbar-nav navbar-right" style="margin-top: 40px;">

                               <li class="active" ><a id="bank"  
                                        href="<?php echo ABSOLUTE_URL;?>/home_pages/deshBoard">Home</a></li>
                                        <li class="active">&nbsp;&nbsp;</li> 
                                <li class="active margin-left-10"><a href="<?php echo ABSOLUTE_URL;?>/home_pages/logout">Logout</a></li>
                                </ul>

                               <?php } ?>
                            
                        </div><!--/.nav-collapse -->
                    </div><!--/.container-fluid -->
                </div><!--/.navbar -->
            </div> <!-- /container -->
        </div>
       
  <div id="login"  class="modal fade" role="dialog">
      <div class="modal-content modal-dialog">
          <div class="modal-header">
              <button id="close" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
              <h4 class="modal-title" id="myModalLabel">Login to site.com</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-xs-6">
                      <div class="well">
                          <form id="loginForm" method="POST" action="javascript:void(0);" data-toggle="validator" >
                              <div class="form-group control-group" id="emailid">
                                  <label for="email" class="control-label" >Email</label>
                                  <input type="text" class="form-control" id="email" name="email" title="Please enter a valid email" placeholder="example@gmail.com" required="">
                                  
                                  <span class="help-block"></span>
                              </div>
                              <div class="form-group control-group" id="pass">
                                  <label for="password" class="control-label">Password</label>
                                  <input type="password" class="form-control" id="password" name="password" value="" required=" title="Please enter your password">
                                  <span class="help-block"></span>
                              </div>
                              <div id="loginNotifications" class="alert alert-danger hide"  role="alert"></div>
                              <div id="loginErrorMsg" class="alert alert-error hide">Wrong username og password</div>
                              <div class="checkbox">
                                  <label>
                                      <input type="checkbox" name="remember" id="remember"> Remember login
                                  </label>
                                  <p class="help-block">(if this is a private computer)</p>
                              </div>
                              <button type="submit" class="btn btn-success btn-block">Login</button>
                              <a href="/forgot/" class="btn btn-default btn-block">Help to login</a>
                          </form>
                      </div>
                  </div>
                  <div class="col-xs-6">
                      <p class="lead">Register now for <span class="text-success">FREE</span></p>
                      <ul class="list-unstyled" style="line-height: 2">
                          <li><span class="fa fa-check text-success"></span> See all your orders</li>
                          <li><span class="fa fa-check text-success"></span> Fast re-order</li>
                          <li><span class="fa fa-check text-success"></span> Save your favorites</li>
                          <li><span class="fa fa-check text-success"></span> Fast checkout</li>
                          <li><span class="fa fa-check text-success"></span> Get a gift <small>(only new customers)</small></li>
                          <li><a href="/read-more/"><u>Read more</u></a></li>
                      </ul>
                      <p><a id="reg" href="" class="btn btn-info btn-block">Yes please, register now!</a></p>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <input type="hidden" id="tempLoginVar" value="0" /> 
