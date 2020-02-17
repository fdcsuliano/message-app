<?php 
App::uses('AppController', 'Controller');

//START of MessagesController
class MessagesController extends AppController {

    public $uses = array('User', 'Message');
    public $components = array('Paginator');
    public $paginate = [
        'limit' => 2
    ];
    
    //Start of index()
    public function index(){
        
        //Getting current user ID
        $LogUserID = $this->Auth->user('id');
        
        $userData = $this->User->find('all', array(
            'conditions' => array(
            'id !=' => $LogUserID
            )
        ));

        //Getting the id and name stored in array
        $arrData = array();
        for ($i=0; $i < count($userData); $i++) { 
            $arrData[$userData[$i]["User"]["id"]] = $userData[$i]["User"]["name"];
        }

        //Setting the array data to variable users
        $this->set('users', $arrData);

        //Setting the current session user to session_ID
        $this->set('session_ID', $LogUserID);

        //Getting the message list of the session user
        $queryMsgLst = "SELECT ml.id,
                         ml.user_id,
                         i.name,
                         i.image, 
                         ml.content, 
                         ml.created, 
                         ml.modified 
                    FROM  users AS i 
                    INNER JOIN (SELECT m.*, 
                                    ( CASE 
                                        WHEN to_id != $LogUserID THEN to_id 
                                        WHEN from_id != $LogUserID THEN from_id 
                                        END ) AS user_id 
                                FROM   messages AS m 
                                    INNER JOIN (SELECT Max(id) AS max_id 
                                                FROM   messages 
                                                WHERE  to_id = $LogUserID 
                                                        OR from_id = $LogUserID 
                                                GROUP  BY( CASE 
                                                                WHEN to_id != $LogUserID THEN to_id 
                                                                WHEN from_id != $LogUserID THEN from_id 
                                                            END )) AS lm 
                                            ON m.id = lm.max_id) AS ml 
                            ON ml.user_id = i.id ORDER BY id DESC LIMIT 0, 2";
        //Passed the query
        $messageLists = $this->Message->query($queryMsgLst);

        //Setting the query to userData
        $this->set('userDatas', $messageLists);

        $toUser = $this->request->query('user_id');
        
        if(!isset($toUser)) {
            $toUser = 0;
        }
        //set to userTarget
        $this->set('userTarget', $toUser);

        //Getting the message details of the 
        $queryMsgDtls = "SELECT * 
                         FROM messages 
                         WHERE from_id = $LogUserID AND to_id = $toUser
                         OR from_id = $toUser AND to_id = $LogUserID";

        //Passed the query
        $messageDetails = $this->Message->query($queryMsgDtls);

        //Setting the query to msgDatas
        $this->set('msgDatas', $messageDetails);
                         

    } 
    // End of index ()

    //paginate msg friend list
    public function myPaginate(){
        $this->render(false);
        $LogUserID = $this->Auth->user('id');
        $offSet = $this->request['data']['off_set'];
        $post_per_page = $this->request['data']['post_per_page'];

        $queryMsgLst = "SELECT ml.id,
                         ml.user_id,
                         i.name,
                         i.image, 
                         ml.content, 
                         ml.created, 
                         ml.modified 
                    FROM  users AS i 
                    INNER JOIN (SELECT m.*, 
                                    ( CASE 
                                        WHEN to_id != $LogUserID THEN to_id 
                                        WHEN from_id != $LogUserID THEN from_id 
                                        END ) AS user_id 
                                FROM   messages AS m 
                                    INNER JOIN (SELECT Max(id) AS max_id 
                                                FROM   messages 
                                                WHERE  to_id = $LogUserID 
                                                        OR from_id = $LogUserID 
                                                GROUP  BY( CASE 
                                                                WHEN to_id != $LogUserID THEN to_id 
                                                                WHEN from_id != $LogUserID THEN from_id 
                                                            END )) AS lm 
                                            ON m.id = lm.max_id) AS ml 
                            ON ml.user_id = i.id ORDER BY id DESC LIMIT ".$offSet .",". $post_per_page ;

        $data = $this->Message->query($queryMsgLst);
        $this->response->type('application/json');
        $this->response->body(json_encode($data));
        return;
    }

      //paginate msg details
      public function msgPaginate(){
        $this->render(false);
        $LogUserID = $this->Auth->user('id');
        $offSet = $this->request['data']['off_set'];
        $post_per_page = $this->request['data']['post_per_page'];
        $to_user = $this->request['data']['user_id'];
        
        //Getting the message details of the 
        $queryMsgDtls = "SELECT * 
                         FROM messages 
                         WHERE from_id = $LogUserID 
                         AND to_id = $to_user
                         OR from_id = $to_user
                         AND to_id = $LogUserID ORDER BY id DESC LIMIT ".$offSet .",". $post_per_page;

        $data = $this->Message->query($queryMsgDtls);
        $this->response->type('application/json');
        $this->response->body(json_encode($data));
        return;
    }

    //function to add message
    public function add(){

        $LogUserID = $this->Auth->user('id');

        $this->set('users',$this->User->find('all', array(
            'conditions' => array(
            'id !=' => $LogUserID
            )
        )));
        
            if ($this->request->is('post')) {
                date_default_timezone_set('Asia/Manila');
                $this->Message->create();
                $this->Message->set($this->request->data['Message']['from_id'] = $LogUserID);
                $this->Message->set($this->request->data['Message']['created'] = date("Y-m-d H:i:s"));
                $this->Message->set($this->request->data['Message']['modified'] = "");
                $data = $this->request->data;
                $toUser = $this->request->data['Message']['to_id'];
                $this->getID = $toUser;
                if ($this->Message->save($data)) {
                    return $this->redirect(array('controller' => 'messages', 'action' => 'index', '?' => 'user_id='.$toUser));
                }
                $error = 'Error : Saving data some fields are not properly supplied.';
                return $this->set('error', $error);
            }
     
    }
    //end of add()

    public function reply() {

        date_default_timezone_set('Asia/Manila');
         $LogUserID = $this->Auth->user('id');
        if ($this->request->is('post')) {
            $toUser = $this->request->data['to_id'];
            $msg = $this->request->data['content'];
            $this->Message->create();
            $this->Message->set($this->request->data['Message']['to_id'] = $toUser);
            $this->Message->set($this->request->data['Message']['from_id'] = $LogUserID);
            $this->Message->set($this->request->data['Message']['content'] = $msg);
            $this->Message->set($this->request->data['Message']['created'] = date("Y-m-d H:i:s"));
            $this->Message->set($this->request->data['Message']['modified'] = "");
            $data = $this->request->data;
            $this->getID = $toUser;
            if ($this->Message->save($data)) {
                return $this->redirect(array('controller' => 'messages', 'action' => 'index', '?' => 'user_id='.$toUser));
            }
            $error = 'Error : Saving data some fields are not properly supplied.';
            return $this->set('error', $error);
        }
    }

        public function delete($id = null) {
        $this->autoRender = false;
        $LogUserID = $this->Auth->user('id');
        // Prior to 2.5 use
        // $this->request->onlyAllow('post');
        $this->Message->id = $id;
            $queryDlt = "DELETE FROM messages WHERE to_id = $id && from_id = $LogUserID || to_id = $LogUserID AND  from_id = $id";

            $deleteConvo = $this->Message->query($queryDlt);
            $this->Flash->success(__('Message deleted'));
            return $this->redirect('/messages');
           
       
    }

} 
//END of MessagesController

?>