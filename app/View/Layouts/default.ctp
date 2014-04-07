<?php
/**
 * Bootstrap basic default template
 *
 * Used for CodeChallenge
 * 
 * @author        Nazareno Lorenzo
 */

$cakeDescription = __d('cake_dev', 'CodeChallenge basic description');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css');
		echo $this->Html->css('custom.css');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<?php
		echo $this->Html->script('//code.jquery.com/jquery-1.11.0.min.js');
		echo $this->Html->script('//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js');
		echo $this->Html->script('//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js');
		echo $this->Html->script('https://js.stripe.com/v2/');
		echo $this->Html->script('main.js');
	?>
	<script>
		//Stripe setup
		Stripe.setPublishableKey('<?=Configure::read('Stripe.keys.public');?>');
	</script>
</head>
<body>
	<div class="container">

		<!-- Static navbar -->
		<div class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">CodeChallenge</a>
				</div>
			</div><!--/.container-fluid -->
		</div>
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
