<!-- НАЧАЛО ФОРМЫ -->
<style type="text/css">
.input-block{margin-bottom:15px;}

.input-block span{font-size:20px; color:red; vertical-align:sub;}
.error{color:red; margin:0; padding:0;}

textarea{max-width:400px; max-height:300px; min-width:300px; min-height:150px;}


</style>
<script src="https://www.google.com/recaptcha/api.js?onload=onLoadHandler&render=explicit"></script>
<script src="/templates/saitadmin/lib/jquery-validation-1.19.0/dist/jquery.validate.min.js"></script>
<div data-id-form="bazavii">
    <div>
        <form action="/handle_recapcha.php" enctype="multipart/form-data" method="post">
            <div class="input-block">
                <div><strong>Имя <span>*</span></strong>:</div>
                <div><input type="text" name="name" /></div>
            </div>
            <div class="input-block">
                <div><strong>Номер телефона <span>*</span></strong>:</div>
                <div><input type="tel" name="phone" /></div>
            </div>
            <div class="input-block">
                <div><strong>Электронная почта <span>*</span></strong>:</div>
                <div><input type="text" name="email" /></div>
            </div>
            <div class="input-block">
                <div><strong>Загрузить картинку</strong>:</div>
                <div><input type="file" id="image_upload" name="image_upload" /></div>
            </div>
            <div class="input-block">
                <div><strong>Услуга</strong>:</div>
                <div>
                <select multiple name="service[]">
                    <option value="Услуга 1" selected="selected">Услуга 1</option>
                    <option value="Услуга 2">Услуга 2</option>
                </select>
                </div>
            </div>
            <div class="input-block">
                <div><strong>Комментарий <span>*</span></strong>:</div>
                <div><textarea name="message"></textarea></div>
            </div>
            <div class="input-block">
                <div><strong>Проверка на спам <span>*</span></strong>:</div>
                <div class="two_third"><div class="google-recaptcha-container" id="recaptcha" style=" padding:10px 0;"></div></div>
            </div>
            <div class="input-block">
                <div class="two_third">
                <input type="submit" class="remodal-confirm" value="Отправить" data-loading="Отправляю..."/>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
var onLoadHandler = function() {
	grecaptcha.render('recaptcha', {
		'sitekey': '6Lf618UZAAAAAI0GCul5jlicz4CPmHb2VCvw10VJ',
		'theme': 'light'
	});
};
$(document).ready(function(){

var bazavii = $('[data-id-form="bazavii"]');
var form_bazavii = bazavii.find('form');

var validator = form_bazavii.validate({
rules: {
		name: {
			required: true,
			minlength: 3,
		},
		email: {
			required: true,
			email: true,
			maxlength: 50,
		},
		phone: {
			required: true,
			//digits: true,
			minlength: 6,
			maxlength: 15,
		},
		message: {
			required: true,
			minlength: 10,
			maxlength: 2000,
		}
	},
	messages: {
		name: {
			required: "Введите ваше имя",
			minlength: "Имя должно содержать не менее {0} символов",
		},
		phone: {
			required: "Введите номер вашего телефона",
			minlength: "Номер телефона должен содержать не менее {0} символов",
			maxlength: "Номер телефона не может быть более {0} символов",
			//digits: "Должны присутствовать только цифры"
		},
		email: {
			required: "Введите email",
			email: "Введите корректный email адрес",
			maxlength: "Email должен не может быть более {0} символов",
		},
		message: {
			required: "Введите текст",
			minlength: "Текст должен содержать не менее {0} символов",
			maxlength: "В тексте не может быть более {0} символов",
		}
	}
});




/////////
//////////////// Отправка формы 
	form_bazavii.submit(function(){
		event.preventDefault();
		var formData = new FormData(form_bazavii[0]);
		
		var loading = $(form_bazavii[0]).find($('input[type="submit"]'));
		var def_text = loading.val();
		
		
		if(form_bazavii.valid()){
			loading.attr('value', loading.data('loading'));
			
			$.ajax({
				url: "/handle_recapcha.php",
				type: "POST",
				data: formData,
				processData: false,
        		contentType: false,
				success: function(request){
						loading.attr('value', def_text);
						var data = $.parseJSON(request);
						if(data.recapcha){
							alert(data.result);
							
							form_bazavii.find(':input,textarea').not('input[type=submit]').val('');
							// обновляем капчу
							grecaptcha.reset();
						} else{
							alert(data.result);
						}
					}
			});
		}
		
		return false;
	});


});
</script>



<!-- КОНЕЦ ФОРМЫ -->