<?php

if(!isset($showForm) || $showForm == true) {
	//Create the form
	echo $this->Form->create(
		'User',
		array(
			'type' => 'POST',
			'inputDefaults' => array(
				'div' => 'form-group',
				'wrapInput' => false,
				'class' => 'form-control',
				'autocomplete' => 'off'
			),
			'id'=>"form",
			'class' => 'well'
		)
	);

	/**
	 * Show any errors or create a placeholder for them
	 */
	echo '<div id="errors">';
	if(!empty($errors)){
		echo $errors;
	}
	echo '<!--PlaceHolder--></div>';

	/**
	 * Create a fieldset with all the basic information, taken from the model
	 */
	echo $this->Form->inputs(
		null,
		array('id','stripeToken','customerId'),
		array(
			'legend' => 'Personal Info'
		)
	);
	echo $this->form->input(
		"password2",
		array(
			'type' => 'password',
			'class' => 'form-control',
			'label' => 'Repeat Password'
		)
	);

	/**
	 * Create another fieldset for the credit card information
	 */
	echo $this->Form->inputs(
		array(
			'card-number' => array(
				'label' => 'Card Number',
				'class' => 'form-control card-info',
			),
			'expiration-month' => array(
				'label' => 'Expiration Date',
				// Complete the options with the 12 months
				'options' => array(
					'' => "",
					'01' => "January",
					'02' => "February",
					'03' => "March",
					'04' => "April",
					'05' => "May",
					'06' => "June",
					'07' => "July",
					'08' => "August",
					'09' => "September",
					'10' => "October",
					'11' => "November",
					'12' => "December"
				),
				'class' => 'form-control card-info',
			),
			'expiration-year' => array(
				'label' => false,
				// Complete the options with the next 15 years
				'options' => array(
					'' => '',
					'2014' => '2014',
					'2015' => '2015',
					'2016' => '2016',
					'2017' => '2017',
					'2018' => '2018',
					'2019' => '2019',
					'2020' => '2020',
					'2021' => '2021',
					'2022' => '2022',
					'2023' => '2023',
					'2024' => '2024',
					'2025' => '2025',
					'2026' => '2026',
					'2027' => '2027',
					'2028' => '2028',
					'2029' => '2029'
				), 
				'class' => 'form-control card-info',
			),
			'cvv' => array(
				'label' => 'CVV2 / CVC2',
				'class' => 'form-control input-cvv',
				'class' => 'form-control card-info',
			)
		),
		null,
		array(
			'legend' => 'Credit Card Info'
		)
	);

	echo '<fieldset><legend>Save</legend>';
		echo $this->Form->submit(
			'Save',
			array(
				'class' => 'btn btn-default',
				'id' => 'btnSubmit'
			)
		);
	echo '</fieldset>';

	//Close the form
	echo $this->Form->end();
}else{

}
?>