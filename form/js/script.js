// "use strict"

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form'); 
    // в константу form записываем содержимое всего тега form из html
    form.addEventListener('submit', formSend);
    // прослушиваем событие клика на кнопку "Отправить"

    async function formSend(e) {
        e.preventDefault();
        
        let error = formValidate(form);

        let formData = new FormData(form);
        // formData.append('image', formImagefiles[0]);

        if (error === 0) {
            
            let response = await fetch('sendmail.php', {
                method: 'POST',
                body: formData
            });
            
            if (response.ok) {
                let result = await response.json();
                alert(result.message);
                form.reset();
                // formPreview.innerHTML = '';
                
            } else {
                alert('Ошибка');
            }

            localStorage.removeItem('order_text');
            localStorage.clear();
            location.reload();
            window.history.back();


        } else {
            alert ('Заполните обязательные поля');
        }
    }

    // функция валидации формы заказа. в нее передаем все данные из константы form, которая содержит все данные из тега form html



    function formValidate(form) {
        let error = 0;
        let formReq = document.querySelectorAll('._req');
        // создаем переменную formReq, в которую передаем все объекты с классом req из нашего html (это имя, e-mail и согласие на перс данные)

        for (let index = 0; index < formReq.length; index++) {
            const input = formReq[index];
            formRemoveError (input);

            if (input.classList.contains('_email')) {
                if (emailTest(input)) {
                    formAddError (input);
                    error++;
                }
            } else if (input.getAttribute("type") === "checkbox" && input.checked === false) {
                formAddError(input);
                error++;
            } else {
                if (input.value === '') {
                    formAddError(input);
                    error++;
                }
            }
        }
        return error;
    }

    function formAddError (input) {
        input.parentElement.classList.add('_error');
        input.classList.add('_error');
    }

    function formRemoveError (input) {
        input.parentElement.classList.remove('_error');
        input.classList.remove('_error');
    }

    //функция теста правильности заполнения e-mail
    function emailTest(input) {
        return !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.test(input.value);
    }


});