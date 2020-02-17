<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');  
		echo $this->Html->css('bootstrap/css/bootstrap.min'); 
		echo $this->Html->css('fonts/font-awesome-4.7.0/css/font-awesome.min.css');
		echo $this->Html->css('fonts/Linearicons-Free-v1.0.0/icon-font.min.css');
		echo $this->Html->css('css-hamburgers/hamburgers.min.css');
		echo $this->Html->css('datepicker/datepicker.css');
		echo $this->Html->css('datepicker/datepicker.css');
		echo $this->Html->css('select2/select2.css');
		echo $this->Html->css('animate/animate.css');

		echo $this->Html->css('util');
		echo $this->Html->css('main');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="content"> 
			<?php echo $this->Flash->render(); ?> 
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer"> 
		 <?php 
			echo $this->Html->script('/js/jquery/jquery-3.2.1.min.js');
			echo $this->Html->script('/js/bootstrap/js/popper.js');
			echo $this->Html->script('/js/bootstrap/js/bootstrap.min.js');
			echo $this->Html->script('/js/datepicker/datepicker.js');
			echo $this->Html->script('/js/main.js');
		    echo $this->Html->script('/js/animation/js/animation.min.js');
			echo $this->Html->script('/js/select2/select2.min.js');
			echo $this->Html->script('/js/countdowntime/countdowntime.js');
		 ?>
		</div>
		<script>
		
		</script>
	</div>
</body>
</html>
