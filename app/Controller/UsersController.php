<?php
/**
 * Users Controller
 *
 * This file lets you register an user and save its cc information
 *
 * @author        Nazareno Lorenzo
 */

App::uses('AppController', 'Controller');

/**
 * User controller
 *
 * This controller lets you create a new user and store it's personal and CC information
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController {

	public function index(){

	    if ($this->request->is('post')) {

			//Try to validate and save it
	        if ($save = $this->User->save($this->request->data)) {
			    $this->set('showForm', false);
			    try {
			    	//Create the customer
				    $result = PaymentUtility::createCustomer($save['User']['name'] ." " .$save['User']['surname'], $save['User']['stripeToken'], $save['User']['email']);
				    //PaymentUtility doesn't have any way to retrieve the new customer id, as it's stored in a protected value.
				    //You could extend that class and add a getter or use the reflection property.
				    //I choose the second way, as it's shorter 


				    //Retrieve the new customer id
				    $custId = $this->_getReflectedPropertyValue($result,'_values');
				    $custId = $custId['id'];

				    //Get the user from that id
				    $user = $this->User->findById($save['User']['id']);
				    //Change the customer id in the user
				    $user['User']['customerId'] = $custId;

				    //Save the changes
				    $this->User->save($user['User']);

				    $this->Session->setFlash('Costumer saved! <strong>The costumer id is: ' . $custId .'</strong>', 'alert', array(
						'plugin' => 'BoostCake',
						'class' => 'alert-success'
					));
			    } catch (Exception $e) {

			    	$this->Session->setFlash('Unable to save the customer information: ' . $e->getMessage(), 'alert', array(
						'plugin' => 'BoostCake',
						'class' => 'alert-danger'
					));
			    }
			} else {
			    $this->set('showForm', true);
			}
		}else{
			$this->set('showForm', true);
		}
	}

	/**
	* Get the value of a property using reflection.
	*
	* @param object|string $class
	*     The object or classname to reflect. An object must be provided
	*     if accessing a non-static property.
	* @param string $propertyName The property to reflect.
	* @return mixed The value of the reflected property.
	*/

	private static function _getReflectedPropertyValue($class, $propertyName)
	{
	    $reflectedClass = new ReflectionClass($class);
	    $property = $reflectedClass->getProperty($propertyName);
	    $property->setAccessible(true);
	 
	    return $property->getValue($class);
	}
}
