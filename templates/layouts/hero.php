<?=$this->insert('components/head', ['title' => $title])?>

<body>
	<section class="hero is-fullheight">
		<div class="hero-head">
			<?=$this->insert('components/navbar')?>
		</div>
		<div class="hero-body">
			<div class="container has-text-centered">
				<?=$this->section('content')?>
			</div>
    	</div>
		<div class="hero-foot">
			<?=$this->insert('components/footer')?>
		</div>
	</section>
</body>
</html>
