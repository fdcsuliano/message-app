<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
                <div class="login100-form-title" style="background-image: url(<?php echo $this->webroot; ?>/img/bg-01.jpg);"> 
					<span class="login100-form-title-1">
						Registration
					</span>
				</div>
                <?php if(isset($error)) { ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?php echo $error; ?>
                  </div>
                <?php
                } echo $this->Form->create('User', array('class'=>'login100-form validate-form'))  ?>
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
                    <?php   
                        echo $this->Form->input('created_ip', array('type' => 'hidden', 'value' => $this->request->clientIp())); 
                    ?>
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
					<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
						<span class="label-input100">Password</span> 
                        <?php   echo $this->Form->input('password', array(
                                                        'class' => 'input100',
                                                        'div' => false,
                                                        'label' => false,
                                                        'placeholder' => 'Enter password'
                                                        )); 
                        ?>
						<span class="focus-input100"></span>
					</div>
                    <div class="wrap-input100 validate-input m-b-18" data-validate = "Confirm Password is required">
                        <span class="label-input100">Confirm Password</span>
                        <?php   echo $this->Form->input('confirm_password', array(
                                                        'type' => 'password',
                                                        'class' => 'input100',
                                                        'div' => false,
                                                        'label' => false,
                                                        'placeholder' => 'Enter confirm password'
                                                        )); 
                        ?> 
						<span class="focus-input100"></span>
					</div>

					<div class="flex-sb-m w-full p-b-30">
						<div>
							<a href="../users/login" class="txt1">
								Have account already Sign in here?
							</a>
						</div>
					</div>

					<div class="container-login100-form-btn center">
                        <?php $options = array('label' => 'Register', 'class' => 'login100-form-btn', 'div' => false);
                        echo $this->Form->end($options); 
                        ?>
						
					</div>
			</div>
		</div>
	</div>