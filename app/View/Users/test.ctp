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
                <a href="#" class="nav-item nav-link active">Home</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Messages</a>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item">Inbox</a>
                        <a href="#" class="dropdown-item">Sent</a>
                        <a href="#" class="dropdown-item">Drafts</a>
                    </div>
                </div>
            </div>
            <form class="form-inline ml-auto">
                
                <?php 
                 if (AuthComponent::user()):
                    // The user is logged in, show the logout link
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

<div class="margin-10">
    <h1>User</h1>
    <p><?php echo $this->Html->link('Add Post', array('action' => 'add')); ?></p>

    <table class="table responsive ">
    <thead class="thead-dark">
        <tr>
        <th scope="col">ID</th>
        <th scope="col">Fullname</th>
        <th scope="col">Email</th>
        <th scope="col">Created</th>
        <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
    
    <?php foreach ($users as $user): ?>
        <tr>
            <th scope="row"><?php echo $user['User']['id']; ?></th> 
            <td><?php echo $user['User']['name']; ?></td>
            <td>
                <?php
                    echo $this->Html->link(
                        $user['User']['email'],
                        array('action' => 'view', $user['User']['id'])
                    );
                ?>
            </td>
            <td>
                <?php echo $user['User']['created']; ?>
            </td>
            <td> 
                <?php
                    echo $this->Html->link(
                        'Edit', 
                        array('action' => 'edit', $user['User']['id']),
                        array('class' => 'btn btn-outline-warning')
                    );
                ?>
                <?php
                    echo $this->Form->postLink(
                        'Delete',
                        array('action' => 'delete', $user['User']['id']),
                        array('class' => 'btn btn-outline-danger',
                              'confirm' => __('Are you sure you want to delete'))
                    );
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</div>