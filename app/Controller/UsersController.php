<?php 
App::uses('AppController', 'Controller');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
use Cake\Utility\Security;

//START of UsersController
class UsersController extends AppController {

    // beforeFilter() user privilege to pages
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add','welcome');
    }
    
    //start of login function
    public function login() {
        //checking if session started
        $sessionID = $this->Auth->user('id');
        if(!is_null($sessionID)){
            return $this->redirect($this->Auth->redirectUrl());
        }
        //check if this request is a post
        if ($this->request->is('post')) {

            //hashing a password
            $passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));

            //setting up variable and query
            $email = $this->request->data['User']['email'];
            $pass = $this->request->data['User']['password'];
            $user = $this->User->find('first', array(
                'conditions' => array(
                'email' => $email,
                'password' => $passwordHasher->hash($pass)
                )
            ));
            if($user){
                $currentTime = date("Y-m-d H:i:s");
                $this->User->id = $this->User->field('id', array('email' => $email));
                if ($this->User->id) {
                    $this->User->saveField('last_login_time', $currentTime);
                    $this->Auth->login($user['User']);
                    return $this->redirect($this->Auth->redirectUrl());
                }
            }
            $error = 'Invalid username or password, try again';
            return $this->set('error', $error);
        }
    } 
    // end of login function
    
    //logout function
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
    // end of logout function    

    //start of index function
    public function index($id = null) {
        $id = $this->Auth->user('id');
        if (!$id) {
            throw new NotFoundException(__('Invalid user'));
        }
         $user = $this->User->findById($id);
         $currentUser = $user['User'];
       $this->set('user', $currentUser);
    }
    //end of index function

    // for welcome page function
    public function welcome() {
    }
    //end of welcomefunction

    // start of view function
    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->findById($id));
    }
    // end of view function

    //start of add function
    public function add() {
        $sessionID = $this->Auth->user('id');
        if(!is_null($sessionID)){
            return $this->redirect($this->Auth->redirectUrl());
        }
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved'));
                return $this->redirect(array('controller' => 'users', 'action' => 'welcome'));
            }
            $error = 'Error : Saving data some fields are not properly supplied.';
            return $this->set('error', $error);
        }
    }
    //end of add function

    //start of edit function
    public function edit($id = null) {
        $sessionID = $this->Auth->user('id');
        if (!$id) {
            throw new NotFoundException(__('Invalid user'));
        }
    
        $user = $this->User->findById($id);
        if (!$user) {
            throw new NotFoundException(__('Invalid user'));
        }

        if($id != $sessionID ) {
            return $this->redirect(array('controller' => 'users', 'action' => 'index'));
        }
    
        if ($this->request->is(array('post', 'put'))) {
            if(!empty($this->request->data['User']['image']['name'])){
                $this->User->set($this->request->data);
                if ($this->User->validates()) {
                    $this->request->data['User']['image'] = $this->request->data['User']['image']['name'];
                
                        $fileName = $this->request->data['User']['image'];
                        $uploadPath = WWW_ROOT.''.'img/'.$fileName;
                        $fileUpload = $_FILES['data']['tmp_name']['User']['image'];
                        
                        
                        if(move_uploaded_file($fileUpload,$uploadPath)){
                            $this->User->id = $id;
                            $this->User->set($this->request->data['User']['modified'] = date("Y-m-d H:i:s"));
                            if($this->User->save($this->request->data)) {
                                $success = 'Success : Profile has been updated successfully.';
                                return $this->set('result', $success);
                            } else{
                                $error = 'Failed : There is an error while updating.';
                                return $this->set('error', $error);
                            }
                        } else{
                            $error = 'Failed : Unable to upload file, please try again.';
                            return $this->set('result', $error);
                         }
                } 
            
            }
            else{
                
                $this->User->id = $id;
                if(!empty($this->User->field('image'))){
                    $this->User->set($this->request->data['User']['image'] = $this->User->field('image'));
                    $this->User->set($this->request->data['User']['modified'] = date("Y-m-d H:i:s"));
                    if($this->User->save($this->request->data)) {
                        $success = 'Success : File has been uploaded and inserted successfully.';
                        return $this->set('result', $success);
                    } else{
                        debug($this->User->validationErrors); die();
                        $error = 'Failed : There is an error while updating.';
                        return $this->set('error', $error);
                    }
                }
                else{
                    $this->User->set($this->request->data['User']['image'] = "default.png");
                    $this->User->set($this->request->data['User']['modified'] = date("Y-m-d H:i:s"));
                    if($this->User->save($this->request->data)) {
                        $success = 'Success : File has been uploaded and inserted successfully.';
                        return $this->set('result', $success);
                    } else{
                        debug($this->User->validationErrors); die();
                        $error = 'Failed : There is an error while updating.';
                        return $this->set('error', $error);
                    }
                }
            }
         }
    
        if (!$this->request->data) {
            $this->request->data = $user;
        }
    }

}
//END of UsersController
?>