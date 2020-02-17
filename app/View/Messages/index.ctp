<!-- start of navbar menu -->
<div class="bs-example">
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a href="#" class="navbar-brand">Chata</a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav">
            <a href="#" class="nav-item nav-link active">Welcome <?php echo $current_user['name']; ?></a>
            <a href="users" class="nav-item nav-link">Home</a>
            <a href="messages?user_id=0" class="nav-item nav-link active">Messages</a>
        </div>
        <form class="form-inline ml-auto">
            <?php echo $this->Html->link(
                        'Account Setting', 
                        array('controller' => 'users', 'action' => 'edit', $session_ID),
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
<!-- end of navbar menu -->
</div>
<!-- start of div container -->
<div class="container py-5 px-4">
  <div class="row rounded-lg overflow-hidden shadow mt-4">
    <!-- Users box-->
    <div class="col-5 px-0">
      <div class="bg-white">

        <div class="bg-gray px-4 py-2 bg-light">
          <p class="h5 mb-0 py-1">Welcome to Chata!</p>
          <div class="input-group mb-3">
            <h2 style="color:green"><?php echo $current_user['name'];?></h2>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="searchData" placeholder="Search here..." aria-describedby="basic-addon2">
            <div class="input-group-append">
              <button class="btn btn-outline-warning" type="button"><i class="fa fa-search"></i></button>
            </div>
          </div>
          <button class="btn btn-outline-success" id="addMessage" type="button"><i class="fa fa-envelope"></i> Add New Message</button>
          <button class="btn btn-outline-primary" id="msgViewMore" value="5" type="button"><i class="fa fa-envelope-open-o"></i> View more</button>
        </div>

        <div class="messages-box" id="message_box">
          <div class="list-group rounded-0">
            <?php
              //check if userdata is not empty
              if(!empty($userDatas)) :
               //looping through the values of userDatas
              foreach ($userDatas as $key => $data) {
             ?>
             <div class="friendItem">
              <a href="messages?user_id=<?php echo $data['ml']['user_id'] ?>" class="list-group-item list-group-item-action list-group-item-light rounded-0" id="flist">
              <div class="media"><img src="<?php echo (!empty($data['i']['image']) ?  $this->webroot.'img/'.$data['i']['image']  : $this->webroot.'img/default.png')
               ?>" alt="user" width="50" class="rounded-circle">
                <div class="media-body ml-4">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="mb-0"><?php echo $data['i']['name']; ?></h6><small class="small font-weight-bold">
                    <?php
                      $date = date_create($data['ml']['created']);
                      echo date_format($date, 'M-d-Y H:i:s');
                    ?>
                    </small>
                  </div>
                  <p class=" text-muted mb-0 text-small text-overflow"><?php echo $data['ml']['content']; ?></p>
                </div>
              </div>
            </a>
          <?php
            echo $this->Form->postLink(
              $this->Html->tag('i', '', array('class' => 'fa fa-trash btn btn-outline-danger side')),
                   array('controller' => 'messages', 'action' => 'delete', $data['ml']['user_id']),
                   array('escape'=>false),
               __('Are you sure you want to delete this conversation with  %s?', $data['i']['name']),
           );
           ?>
           <a href="users/view/<?php echo $data['ml']['user_id'] ?>">
           <button class="btn btn-outline-primary side view"><i class="fa fa-eye"></i></button>
           </a>
           </div>
           <?php
          }// close foreach()
              else: ?>
                <div class="text-center">
                 <img src="<?php echo $this->webroot.'img/wierd.gif' ?>" style="width:200px;" alt="wierd.gif">
                 <h6 class="m-4">No current friends start chatting by clicking <br><span class="badge badge-success">Add New Message Button</span></h6>
                </div>
              <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <!-- Chat Box-->
    <div class="col-7 px-0 pt-20" style="background-color:white;height: 500px;">
    <div class="input-group mb-3 mt-3 mr-3">
        <input type="text" class="form-control" id="searchMessage" placeholder="Search here..." aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-outline-warning" type="button"><i class="fa fa-search"></i></button>
        </div>
      </div>
      <div class="px-4 py-5 chat-box  bg-white">
        <?php 
        //check if msg data is empty
        if(!empty($msgDatas)) :
               //looping through the values of msgDatas
              foreach ($msgDatas as $key => $data) {
                if($session_ID == $data['messages']['from_id']) { ?>

                <!-- Sender Message-->
                <div class="msg" id="sender">
                  <div class="media w-50 ml-auto mb-3">
                    <div class="media-body">
                      <div class="bg-primary rounded py-2 px-3 mb-2">
                        <p class="text-small mb-0 text-white lh-25"><?php echo $data['messages']['content']; ?></p>
                      </div>
                      <p class="small text-muted lh-25"><?php  
                        $date = date_create($data['messages']['created']);
                        echo date_format($date, 'h:i A'); ?>  | <?php $date = date_create($data['messages']['created']);
                        echo date_format($date, 'M:d');  ?></p>
                    </div>
                  </div>
                </div>
               <?php } else { ?>
                   <!--Receiver  Message-->
                <div class="msg" id="receiver">
                  <div class="media w-50 mb-3"><img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle">
                    <div class="media-body ml-3">
                    <div class="bg-light rounded py-2 px-3 mb-2">
                      <p class="text-small mb-0 text-muted lh-25"><?php echo $data['messages']['content']; ?></p>
                    </div>
                      <p class="small text-muted">
                        <?php $date = date_create($data['messages']['created']);
                          echo date_format($date, 'h:i A'); ?>  | <?php $date = date_create($data['messages']['created']);
                          echo date_format($date, 'M:d');  ?>
                      </p>
                    </div>
                  </div>
               </div>
                <?php 
               } //close else
              } // close foreach()
              else: ?>
                <div class="text-center">
                 <img src="<?php echo $this->webroot.'img/chatting.png' ?>" alt="chatting.png">
                 <h6 class="m-4">No current conversation start chatting by clicking <br><span class="badge badge-success">Add New Message Button</span></h6>
                 </div>
              <?php endif; ?>
      </div>
      <!-- <button class="btn btn-outline-primary" id="msgDetailMore" value="<?php echo $userTarget ?>" type="button"><i class="fa fa-envelope-open-o"></i> View more</button> -->
      <!--Form Start Typing area -->
      <?php echo $this->Form->create('Message',array('url' => array('controller' => 'Messages','action' => 'reply'), 'id' => 'message_form', 'class'=>'bg-light'));?>
       <input type="hidden" name="to_id" value="<?php echo $userTarget; ?>">
        <div class="input-group">
          <input type="text" id="msg_content" required name="content" placeholder="Type a message" aria-describedby="button-addon2" class="form-control rounded-0 border-0 py-4 bg-light typebar">
          <div class="input-group-append">
            <button id="button-addon2" type="submit" class="btn btn-link"> <i class="fa fa-paper-plane"></i></button>
          </div>
        </div>
        <?php echo $this->Form->end();?>
      <!-- End of form -->
    </div>
  </div>
</div>
<!-- end of div container -->

<!-- Modal -->
<div class="modal fade" id="addNewMessage"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="exampleModalLabel"><i class="fa fa-envelope"></i>  New message</h5>
        <button type="button" id="button-id" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo $this->Form->create('Message',array('url' => array('controller' => 'Messages','action' => 'add'), 'class'=>'form-control'));?>
        
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <div class="input-group mb-3">
            <?php   echo $this->Form->input('to_id', array(
           'options' => array($users),
           'empty' => 'Please select recipient.',
                                                    'class' => 'input100 form-control',
                                                    'div' => false,
                                                    'label' => false
                                                    )); 
            ?>
            </div>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <?php   echo $this->Form->textarea('content', array(
                                                    'class' => 'input100',
                                                    'div' => false,
                                                    'label' => false,
                                                    'placeholder' => 'Write your message here...',
                                                    'rows' => '5', 
                                                    'cols' => '5'
                                                    )); 
              ?>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <?php $options = array('label' => 'Send Message', 'class' => 'btn btn-primary', 'div' => false);
            echo $this->Form->end($options); 
          ?>
        </button>
      </div>
    </div>
  </div>
</div> 
<!-- end of modal -->
