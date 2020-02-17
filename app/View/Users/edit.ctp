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
                        array('action' => 'edit', $this->data['User']['id']),
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
                <div class="author-card-avatar"><img src="<?php echo (!empty($this->data['User']['image']) ? $this->webroot.'img/'.$this->data['User']['image'] : $this->webroot.'img/default.png'); ?>">
                </div>
                <div class="author-card-details">
                    <h5 class="author-card-name text-lg"><?php echo $this->data['User']['name']; ?>
                    </h5><span class="author-card-position">Joined <?php echo $this->data['User']['created']; ?></span>
                    
                </div>
            </div>
        </div>
        <div class="wizard">
            <nav class="list-group list-group-flush">
                <a class="list-group-item active" href="#"><i class="fe-icon-user text-muted"></i>Account Setting</a>
            </nav>
        </div>
    </div>
    <!-- Profile Settings-->
    <div class="col-lg-8 pb-5">
        <div class="limiter">
            <div class="container-login0">
                <div class="wrap-loginmax">
                    <div class="login100-form-title" style="background-image: url(<?php echo $this->webroot; ?>/img/bg-01.jpg);">
                        <span class="login100-form-title-1">
                    Update Profile
                </span>
                    </div>
                    <?php if(isset($result)) { ?>
                        <div class="alert alert-success text-center" role="alert">
                            <?php echo $result; ?>
                        </div>
                    <?php }if(isset($error)) { ?>
                        <div class="alert alert-danger text-center" role="alert">
                            <?php echo $error; ?>
                        </div>
                        <?php
            } echo $this->Form->create('User', array('class'=>'login100-form validate-form', 'enctype' =>'multipart/form-data'));
                echo $this->Form->input('modified_ip', array('type' => 'hidden', 'value' => $this->request->clientIp()));
                echo $this->Form->input('id', array('type' => 'hidden'));
                echo $this->Form->input('created', array('type' => 'hidden', 'value' => $this->request->data['User']['created']));
            ?>
            <!-- <?php echo $this->validationErrors['User']['image'][0] ?> -->
                            <div class="col-md-12">
                            <img id="image" style="width:200px;" src="<?php echo (!empty($this->data['User']['image']) ? $this->webroot.'img/'.$this->data['User']['image'] : $this->webroot.'img/default.png'); ?>" alt="<?php echo (!empty($this->data['User']['image']) ? $this->webroot.'img/'.$this->data['User']['image'] : $this->webroot.'img/default.png'); ?>" class="img-thumbnail mx-auto d-block">
                                <div class="wrap-input100 validate-input m-b-18" data-validate="Confirm Password is required">
                                    <span class="label-input100">Update Profile</span>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->file('image', array(
                                                        'class' => 'form-group',
                                                        'id' => 'files',
                                                        'div' => false,
                                                        'label' => false,
                                                        'required' =>false
                                                        ));
                                        
                                        ?>
                                    </div>
                                    <span class="focus-input100"></span>  
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="wrap-input100 validate-input m-b-26" data-validate="Fullname is required">
                                    <span class="label-input100">Fullname</span>
                                    <?php   echo $this->Form->input('name', array(
                                                        'type' => 'text',
                                                        'class' => 'input100',
                                                        'div' => false,
                                                        'label' => false,
                                                        'placeholder' => 'Enter Fullname'
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
                                                        'placeholder' => 'Enter Email'
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
                                            'class' => 'birthdate',
                                            'data-date-format' => 'dd-mm-yyyy' ));
                                        ?>
                                        <span class="focus-input100"></span>
                                        
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="wrap-input100 validate-input m-b-26" data-validate="Gender is required">
                                    <span class="label-input100">Gender</span>
                                    <?php $options = array('1' => 'Male', '2' => 'Female');
                                        echo $this->Form->select('gender', $options,array(
                                        'label' => false, 
                                        'class' => 'form-control',));
                                    ?>
                                        <span class="focus-input100"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="wrap-input100 validate-input m-b-18" data-validate="Hobby is required">
                                    <span class="label-input100">Hobby</span>
                                    <?php   echo $this->Form->textarea('hobby', array(
                                                    'class' => 'input100',
                                                    'div' => false,
                                                    'label' => false,
                                                    'placeholder' => 'Write your hobby here...',
                                                    'rows' => '5', 
                                                    'cols' => '5'
                                                    )); 
                                    ?>
                                        <span class="focus-input100"></span>
                                </div>
                                <div class="container-login100-form-btn center">
                                    <?php $options = array('label' => 'Update Profile', 'class' => 'login100-form-btn', 'div' => false);
                                     echo $this->Form->end($options); 
                                    ?>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById("files").onchange = function () {
                
    const fileType = this.files[0]['type'];
    const validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
    if (!validImageTypes.includes(fileType)) {
        alert('Invalid Image Type');
        $('#files').val('');
    }
    else {
    var reader = new FileReader();
        reader.onload = function (e) {
        // get loaded data and render thumbnail.
        document.getElementById("image").src = e.target.result;
    };

    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
    }
    
};
</script>