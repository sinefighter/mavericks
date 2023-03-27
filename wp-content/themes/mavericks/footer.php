<footer class="footer" id="footer">
	<a href="#" class="logo">
		<img src="<?php echo get_template_directory_uri(); ?>/dist/img/logo-primary.png" alt="">
	</a>
	<nav class="footer-nav">
		<ul class="footer-menu">
			<li><a href="#">Курси</a></li>
			<li><a href="#">Заходи</a></li>
			<li><a href="#">Про хаб </a></li>
			<li><a href="#">Контакти </a></li>
		</ul>
	</nav>

	<div class="footer-bottom">
		<span class="footer-copyright">&copy; Київський освітній хаб 2019. Усі права захищені</span>
		<div class="soc-menu">
			<span class="soc-name caption">
				Ми в соцмережах
			</span>
			<ul class="soc-links">
				<li>
					<a href="#">
						<svg class="icon">
							<use xlink:href="#facebook">
						</svg>
					</a>
				</li>
				<li>
					<a href="#">
						<svg class="icon">
							<use xlink:href="#instagram">
						</svg>
					</a>
				</li>
				<li>
					<a href="#">
						<svg class="icon">
							<use xlink:href="#linkedin">
						</svg>
					</a>
				</li>
				<li>
					<a href="#">
						<svg class="icon">
							<use xlink:href="#twitter">
						</svg>
					</a>
				</li>
			</ul>
		</div>
	</div>
</footer>

<div class="modal">
	<div class="modal-pop-up">
		<h2>Оберіть вашу країну</h2>
		<div class="modal-country">
			<div class="modal-country__button">
				<button class="btn-sm" type="button" data-country="ua">Україна</button>
				<button class="btn-sm" type="button" data-country="pl">Польща</button>
				<button class="btn-sm" type="button" data-country="ru">росія</button>
			</div>
		</div>
	</div>
</div>

<?php wp_footer(); ?>

</body>
</html>