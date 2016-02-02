<?php
class Message extends AppModel {
  public $validate = array(
    'email' => 'email',
    'subject' => 'notEmpty',
    'message' => array(
      'rule' => array('maxLength', 512),
    ),
  );
}