<?php

App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
   
    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Fullname is required'
            ),
            'name Length' => array(
                'rule' => array('between', 5, 20),
                'message' => "Name should between 5 to 20 characters."
            )    
        ),
        'image' => array(
                'extension' => array(
                    'rule' => array('extension', array('jpeg', 'jpg', 'png', 'gif')),
                    'message' => "The extension of the sent image is not valid"
                )
            ),
        'email' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Email is required'
            ),
            'Valid Email' => array(
                'rule' => 'email',
                'message' => 'Please enter a valid email address.'
            ),
            'Email Unique' => array(
                'rule' => 'isUnique',
                'message' => 'The email is already taken.'
            ),
            'Email Length' => array(
                'rule' => array('between', 5, 20),
                'message' => "Email should between 5 to 20 characters."
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Password is required'
            ),
            'Match Passwords' => array(
                'rule' => 'matchPasswords',
                'message' => 'Your passwords do not match'
            )
        ),
        'confirm_password' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Confirm password is required'
            )
        )
    );
    public function matchPasswords($data){
        if ($this->data['User']['password'] !== $this->data['User']['confirm_password']){
            $this->invalidate('confirm_password', 'Your passwords do not match');
            return false;     
        } 
        return true;
    }

    public function beforeSave($options = array()) {
        if (!empty($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }
}

?>