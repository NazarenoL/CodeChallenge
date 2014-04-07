<?php
class User extends AppModel {
	public $name = 'User';

	public $validate = array(
		'name' => array(
			'alphaNumeric' => array(
				'rule'     => 'alphaNumeric',
				'required' => true,
				'message'  => 'Alphabets and numbers only'
			),
			'between' => array(
				'rule'    => array('between', 3, 100),
				'message' => 'Between 3 to 100 characters'
			)
		),
		'surname' => array(
			'alphaNumeric' => array(
				'rule'     => 'alphaNumeric',
				'required' => true,
				'message'  => 'Alphabets and numbers only'
			),
			'between' => array(
				'rule'    => array('between', 3, 100),
				'message' => 'Between 3 to 100 characters'
			)
		),
		'password' => array(
			'required' => true,
			'rule'    => array('between', 6, 10),
			'message' => 'Between 6 to 10 characters'
		),
		'email' => 'email',
		'stripeToken' => array(
			'required' => true,
			'rule' => 'notEmpty',
			'message' => 'The payment couldn\'t be processed.'
		)
	);

	/**
	 * Callback functions.
	 * It runs before saving data to the DB
	 */
	public function beforeSave($options = array()) {
	    if (!empty($this->data['User']['password']))
	    {
	    	//Hash the password before saving it. Include the app salt
	        $this->data['User']['password'] = Security::hash($this->data['User']['password'], null, true);
	        
	    }
	    return true;
	}

}