<!-- start of navbar menu -->
<div class="bs-example">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a href="#" class="navbar-brand">Chata</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav">
                <a href="#" class="nav-item nav-link active">Welcome
                    <?php
                        if(AuthComponent::user()):
                            echo $current_user['name'];
                        else:
                            echo "Guest User! ";
                        endif;
                    ?>
                    </a>
                <a href="<?php echo $this->webroot;?>users" class="nav-item nav-link active">Home</a>
                <a href="<?php echo $this->webroot;?>messages?user_id=0" class="nav-item nav-link">Messages</a>
            </div>
            <form class="form-inline ml-auto">
                
                <?php 
                 if (AuthComponent::user()):
                    // The user is logged in, show the logout link
                    echo $this->Html->link(
                        'Account Setting', 
                        array('action' => 'edit', $user['id']),
                        array('class' => 'btn btn-outline-warning  mr-2')); 

                    echo $this->Html->link('Logout',
                                      array('controller' => 'users', 'action' => 'logout'),
                                      array('class' => 'btn btn-outline-danger  mr-2'));
                    else:
                    // The user is not logged in, show login & register link
                    echo $this->Html->link('Register',
                                      array('controller' => 'users', 'action' => 'add'),
                                      array('class' => 'btn btn-outline-warning  mr-2')); 

                    echo $this->Html->link('Log in', 
                    array('controller' => 'users', 'action' => 'login'),
                    array('class' => 'btn btn-outline-success  mr-2'));
                    endif;
                ?>
            </form>
        </div>
    </nav>
</div>
<!-- end of navbar menu -->
<!-- start of div class limiter -->
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-form-title" style="background-image: url(<?php echo $this->webroot; ?>/img/bg-01.jpg);">
                <span class="login100-form-title-1">
						Profile Page
					</span>
            </div>
            <?php  echo $this->Form->create('User', array('class'=>'login100-form validate-form'))  ?>

                <div class="col-7">
                    <div class="wrap-input100 validate-input m-b-26" data-validate="Email is required">
                        <span class="label-input100 text-left">Email :</span>
                        <?php   echo $this->Form->input('email', array(
                                                        'type' => 'email',
                                                        'class' => 'input100',
                                                        'div' => false,
                                                        'disabled' =>true,
                                                        'value' => $user['email'],
                                                        'label' => false,
                                                        'placeholder' => 'Enter Email'
                                                        )); 
                        ?>
                    </div>
                    <div class="wrap-input100 validate-input m-b-26" data-validate="Email is required">
                        <span class="label-input100 text-left">Birthdate :</span>
                        <?php   echo $this->Form->input('birthdate', array(
                                                        'class' => 'input100',
                                                        'div' => false,
                                                        'disabled' =>true,
                                                        'value' => $user['birthdate'],
                                                        'label' => false,
                                                        'placeholder' => 'Enter Email'
                                                        )); 
                        ?>
                    </div>
                    <div class="wrap-input100 validate-input m-b-26" data-validate="Email is required">
                        <span class="label-input100 text-left">Gender :</span>
                        <div class="wrap-input100 validate-input m-b-26" data-validate="Gender is required">
                                    <?php $options = array('1' => 'Male', '2' => 'Female');
                                        echo $this->Form->select('gender', $options,array(
                                        'label' => false, 
                                        'class' => 'form-control',
                                        'value' => $user['gender'],
                                        'disabled' => true));
                                    ?>
                                        <span class="focus-input100"></span>
                                </div>
                                <p>Created at: <?php echo $user['created']; ?></p>
                    </div>
                </div>
                <div class="col-4">
                    <img src="<?php echo $this->webroot.'img/'.$user['image']; ?>" alt="<?php echo $user['image']; ?>" class="mx-auto rounded-circle img-fluid">
                    <span>Name: </span><h5><?php echo $user['name']; ?></h5>
                    <p>Last Login : <b><br> <?php echo $user['last_login_time']; ?></b></p>
                </div>
                <div class="col-md-12">
                <span class="label-input100 text-left">Hobby :</span>
                        <?php   echo $this->Form->textarea('hobby', array(
                                                        'class' => 'input100',
                                                        'div' => false,
                                                        'disabled' =>true,
                                                        'value' => $user['hobby'],
                                                        'label' => false,
                                                        'col' => 4,
                                                        'rows' => 5,
                                                        'placeholder' => 'Enter Email'
                                                        )); 
                        ?>
                </div>

                <div class="container-login100-form-btn center">
                    <?php  echo $this->Html->link(
                        'Update Profile', 
                        array('action' => 'edit', $user['id']),
                        array('class' => 'btn btn-outline-success  mr-2 text-center')); 
                        ?>
                </div>
        </div>
    </div>
</div>
<!-- end of div class limiter -->