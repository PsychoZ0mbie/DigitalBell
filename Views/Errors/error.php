<?php
    headerPage($data);
?>
	<div class="container error">
		<div>
			<h1><?=$data['page_title']?></h1>
			<p>La página consultada no existe</p>
		</div>
		<div>
			<a href="<?=base_url()?>" class="form-btn">Regresar</a>
		</div>
	</div>
	
<?php
   footerPage($data);
?>