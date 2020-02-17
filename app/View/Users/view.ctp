<div class="bs-example">
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a href="#" class="navbar-brand">Chata</a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav">
            <a href="#" class="nav-item nav-link active">Welcome <?php echo $current_user['name']; ?></a>
            <a href="/Task/users" class="nav-item nav-link active">Home</a>
            <a href="<?php echo $this->webroot;?>messages?user_id=0" class="nav-item nav-link">Messages</a>
        </div>
        <form class="form-inline ml-auto">
            <?php echo $this->Html->link(
                        'Account Setting', 
                        array('action' => 'edit', $user['User']['id']),
                        array('class' => 'btn btn-outline-warning  mr-2')); 

                if (AuthComponent::user()):
                // The user is logged in, show the logout link
                echo $this->Html->link('Log out',
                                  array('controller' => 'users', 'action' => 'logout'),
                                  array('class' => 'btn btn-outline-danger  mr-2'));
                else:
                // The user is not logged in, show login link
                echo $this->Html->link('Log in', array('controller' => 'users', 'action' => 'login'));
                endif;
            ?>
        </form>
    </div>
</nav>
</div>
<div class="container mt-5">
<div class="row">
    <div class="col-lg-4 pb-5">
        <!-- Account Sidebar-->
        <div class="author-card pb-3">
            <div class="author-card-cover" style="background-image: url(https://demo.createx.studio/createx-html/img/widgets/author/cover.jpg);"></div>
            <div class="author-card-profile">
                <div class="author-card-avatar"><img src="<?php echo $this->webroot.'img/'.$user['User']['image']; ?>">
                </div>
                <div class="author-card-details">
                    <h5 class="author-card-name text-lg"><?php echo $user['User']['name']; ?>
                    </h5><span class="author-card-position">Joined <?php echo $user['User']['created']; ?></span>
                </div>
            </div>
        </div>
        <div class="wizard">
            <nav class="list-group list-group-flush">
                <a class="list-group-item active" href="JavaScript:void(0)"><i class="fe-icon-user text-muted"></i>Profile View</a>
            </nav>
        </div>
    </div>
    <!-- Profile Settings-->
    <div class="col-lg-8 pb-5">
        <div class="limiter">
            <div class="container-login0">
                <div class="wrap-loginmax">
                    <div class="login100-form-title" style="background-image: url(<?php echo $this->webroot; ?>/img/bg-01.jpg);">
                        <span class="login100-form-title-1">Profile : <?php echo $user['User']['name'] ?></span>
                    </div>
                    <form class="login100-form validate-form">
                    <div class="col-md-5">
                                <div class="wrap-input100 validate-input m-b-26" data-validate="Fullname is required">
                                    <span class="label-input100">Fullname</span>
                                    <?php   echo $this->Form->input('name', array(
                                                        'type' => 'text',
                                                        'class' => 'input100',
                                                        'div' => false,
                                                        'label' => false,
                                                        'value' => $user['User']['name'],
                                                        'disabled' => true
                                                        )); 
                                         ?>
                                        <span class="focus-input100"></span>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="wrap-input100 validate-input m-b-26" data-validate="Email is required">
                                    <span class="label-input100">Email</span>
                                    <?php   echo $this->Form->input('email', array( 
                                                        'minlength' => '5',
                                                        'maxlength' => '20',
                                                        'type' => 'email',
                                                        'class' => 'input100',
                                                        'div' => false,
                                                        'label' => false,
                                                        'value' => $user['User']['email'],
                                                        'disabled' => true
                                                        )); 
                                          ?>
                                        <span class="focus-input100"></span>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="wrap-input100 validate-input m-b-26" data-validate="Email is required">
                                        <span class="label-input100">Birthday</span>
                                        <?php   echo $this->Form->text('birthdate', array(
                                            'label' => false, 
                                            'class' => 'input100',
                                            'value' => $user['User']['birthdate'],
                                            'disabled' => true
                                        ));
                                        ?>
                                        <span class="focus-input100"></span>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="wrap-input100 validate-input m-b-26" data-validate="Email is required">
                                    <span class="label-input100">Gender</span>
                                    <?php $options = array('1' => 'Male', '2' => 'Female');
                                        echo $this->Form->select('gender', $options,array(
                                        'label' => false, 
                                        'class' => 'form-control',
                                        'value' => $user['User']['gender'],
                                        'disabled' => true
                                    ));
                                    ?>
                                        <span class="focus-input100"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="wrap-input100 validate-input m-b-18" data-validate="Confirm Password is required">
                                    <span class="label-input100">Hobby</span>
                                    <?php   echo $this->Form->textarea('hobby', array(
                                                    'class' => 'input100',
                                                    'div' => false,
                                                    'label' => false,
                                                    'value' => $user['User']['hobby'],
                                                    'disabled' => true
                                                    )); 
                                    ?>
                                        <span class="focus-input100"></span>
                                </div>
                                </form>
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>