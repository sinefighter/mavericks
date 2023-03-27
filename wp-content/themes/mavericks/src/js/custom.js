$(document).ready(function() {
	// AJAX loading events on front-page
	$('#load-events').on('click', function(e){
		e.preventDefault();
		const btn = $(this);
		const countPosts = parseInt($(this).attr('data-count'));
		const perPage = parseInt($(this).attr('data-per-page'));
		const currentShow = parseInt($(this).attr('data-current'));

		$.ajax({
			url: frontendAjax.ajaxurl,
			type: 'post',
			data: {
				action:"ajax_more_events",
				offset: currentShow,
				perPage: perPage,
			},
			beforeSend: function() {
				btn.text('Завантаження...');
			},
			success: function( posts ) {
				$('#list-events').append(posts);

				btn.attr('data-current', currentShow + perPage);

				if(currentShow + perPage >= countPosts) { //прячем кнопку
					btn.hide();
				}else{
					btn.text('Ще заходи');
				}
			},
			error: function(jqXHR) {
				throw 'Some problems with AJAX request';
			}
		})
	});

	// AJAX loading news with pagination
	$(document).on('click', '.pagination a', function(e){
		e.preventDefault();
		const link = $(this).attr('href'); //достаем нажатый урл

		$('html, body').animate({
			scrollTop: $('#list-posts').offset().top,
		}, 1000);
		$('#list-posts').animate({
			opacity: 0,
		}, 1000)

		$('#list-posts').load(link + ' #list-posts', function() { // грузим посты с этого урла
			$('#list-posts').animate({
				opacity: 1,
			}, 1000)
			history.pushState(null, null, link); // меняем урл в строке браузера
		});
	});

	// AJAX send form
	$('#send-form').on('click', function(e){
		e.preventDefault();
		const form = $(this).closest('form');
		const formData = form.serialize(); // собираем данные из формы
		let flag = true;

		form.find('*[required]').each(function(){ // валидация
			if($(this).val().length < 2){
				$(this).addClass('error');
				flag = false;
			}else{
				$(this).removeClass('error');
			}
		})

		if(flag) { // если валидация продена - шлем запрос
			$.ajax({
				url: frontendAjax.ajaxurl,
				type: 'post',
				data: {
					action:"insert_order",
					orderData: formData,
				},
				beforeSend: function() {
					if($('.response-success').length) {
						$('.response-success').remove();
					}
				},
				success: function( response ) {
					const json = JSON.parse(response); // парсим джейсон

					// console.log(json);
					
					// выводим ответ
					for(key in json) {
						form.append(`
							<div class="response-${key}">
								${json[key]}
							</div>
						`);
					}
					
					form[0].reset(); // очищаем форму

				},
				error: function(jqXHR) {
					throw 'Some problems with AJAX request';
				}
			})
		}
	});

	// AJAX set cookie
	if (document.cookie.indexOf('country=') === -1) { // если куки еще нет - показываем модалку
		$('.modal').fadeIn(200)
	}
	$('.modal-country button').on('click', function(e){
		e.preventDefault();
		const country = $(this).data('country'); // берем значение из кнопки на которую нажали

		$.ajax({
			url: frontendAjax.ajaxurl,
			type: 'post',
			data: {
				action:"add_country_cookie",
				country: country,
			},
			success: function(response) {
				$('.modal').fadeOut(200) // закрываем модалку
				if(country === 'ru') {
					window.location.replace(response); // если страна ру - делаем редирект
				}else{
					$('.menu-nav').html(response); // иначе выводим меню
				}
			},
			error: function(jqXHR) {
				throw 'Some problems with AJAX request';
			}
		})
	});
});