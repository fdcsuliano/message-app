<?php

App::uses('AppModel', 'Model');

class Message extends AppModel {
   
    public $validate = array(
        'to_id' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Receiver must have value.'
            )
        ),
        'content' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Please input a message.'
            )
        )
    );
}

?>