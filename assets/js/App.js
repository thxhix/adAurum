import Modal from "./modules/Modals.js";
import Notification from "./modules/Notification.js";
import { htmlEntities } from "./modules/functions.js";

document.addEventListener("DOMContentLoaded", () => {
    // Модалки
    const ModalRouter = new Modal();
    const loginModal = new Modal("login");
    const registerModal = new Modal("register");
    const confirmModal = new Modal("delete_confirm");
    const commentModal = new Modal("new_comment");
    const companyModal = new Modal("new_company");

    // Уведомления
    const SuccessNotification = new Notification();
    const ErrorNotification = new Notification("Произошла ошибка, попробуйте позже", true);

    // Все события по кликам
    document.addEventListener("click", (e) => {
        let target = e.target;

        // Открыть/закрыть модалки
        if (target.closest("#auth")) {
            loginModal.openModal();
        }
        if (target.closest("#reg")) {
            registerModal.openModal();
        }
        if (target.closest("#catalog_add")) {
            companyModal.openModal();
        }
        if (target.closest(".modal__background") && target.classList.contains("modal__background")) {
            ModalRouter.closeAll();
            if(commentModal.element){
                commentModal.element.removeAttribute("data-target");
            }
        }

        // Регистрация
        if (target.closest("#register button")) {
            e.preventDefault();

            let loginInput = document.querySelector("#register input[name=login]");
            let passwordInput = document.querySelector("#register input[name=password]");
            let retryPasswordInput = document.querySelector("#register input[name=retry_password]");

            let validate_Login = false;
            let validate_Pass = false;
            let validate_RePass = false;

            function validateUsername(username) {
                const res = /^[a-z0-9]+$/i.exec(username);
                const valid = !!res;
                return valid;
            }

            if (loginInput.value == "" || loginInput.value == null) {
                loginInput.classList.add("error");
                validate_Login = false;
            } else {
                loginInput.classList.remove("error");
                validate_Login = true;
            }

            if (passwordInput.value == "" || passwordInput.value == null) {
                passwordInput.classList.add("error");
                validate_Pass = false;
            } else {
                passwordInput.classList.remove("error");
                validate_Pass = true;
            }

            if (retryPasswordInput.value == "" || retryPasswordInput.value == null) {
                retryPasswordInput.classList.add("error");
                validate_RePass = false;
            } else {
                retryPasswordInput.classList.remove("error");
                validate_RePass = true;
            }

            if (validate_Login && validate_Pass && validate_RePass) {
                let formErrors = document.querySelector("#register .form__error");

                if (!validateUsername(loginInput.value)) {
                    loginInput.classList.add('error');
                    formErrors.classList.add("active");
                    formErrors.textContent = "Логин может содержать только буквы и цифры";
                    return;
                }else{
                    formErrors.classList.remove("active");
                    formErrors.textContent = "";
                }

                let login = loginInput.value;
                let pass = passwordInput.value;
                let re_pass = retryPasswordInput.value;

                $.ajax({
                    url: "includes/register.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        login: login,
                        password: pass,
                        retry_password: re_pass,
                    },
                    success: function (data) {
                        if (data.status == "error") {
                            formErrors.classList.add("active");
                            formErrors.textContent = data.errorText;
                        } else {
                            formErrors.classList.remove("active");
                            formErrors.textContent = "";
                            loginModal.openModal();
                            SuccessNotification.setText("Аккаунт успешно создан!").show(5000);

                            loginInput.value = "";
                            passwordInput.value = "";
                            retryPasswordInput.value = "";
                        }
                    },
                    error: function (data) {
                        console.log(data);
                        ErrorNotification.setText("Ошибка в аяксе").show(2500);
                    },
                });
            }
        }

        // Авторизация
        if (target.closest("#login button")) {
            e.preventDefault();

            let loginInput = document.querySelector("#login input[name=login]");
            let passwordInput = document.querySelector("#login input[name=password]");

            let validate_Login = false;
            let validate_Pass = false;

            if (loginInput.value == "" || loginInput.value == null) {
                loginInput.classList.add("error");
                validate_Login = false;
            } else {
                loginInput.classList.remove("error");
                validate_Login = true;
            }

            if (passwordInput.value == "" || passwordInput.value == null) {
                passwordInput.classList.add("error");
                validate_Pass = false;
            } else {
                passwordInput.classList.remove("error");
                validate_Pass = true;
            }

            if (validate_Login && validate_Pass) {
                let formErrors = document.querySelector("#login .form__error");

                let login = loginInput.value;
                let pass = passwordInput.value;

                $.ajax({
                    url: "includes/auth.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        login: login,
                        password: pass,
                    },
                    success: function (data) {
                        if (data.status == "error") {
                            formErrors.classList.add("active");
                            formErrors.textContent = data.errorText;
                        } else {
                            window.location.reload();
                        }
                    },
                    error: function (data) {
                        console.log(data);
                        ErrorNotification.setText("Ошибка в аяксе").show(2500);
                    },
                });
            }
        }

        // Авторизация
        if (target.closest("#new_company button")) {
            e.preventDefault();

            let nameInput = document.querySelector("#new_company input[name=company_name]");
            let addressInput = document.querySelector("#new_company input[name=company_address]");
            let phoneInput = document.querySelector("#new_company input[name=company_phone]");
            let ceoInput = document.querySelector("#new_company input[name=company_ceo]");
            let innInput = document.querySelector("#new_company input[name=company_inn]");
            let detailInput = document.querySelector("#new_company textarea[name=company_detail]");

            let validate_Name = false;
            let validate_Address = false;
            let validate_Phone = false;
            let validate_Ceo = false;
            let validate_Inn = false;
            let validate_Detail = false;

            if (nameInput.value == "" || nameInput.value == null) {
                nameInput.classList.add("error");
                validate_Name = false;
            } else {
                nameInput.classList.remove("error");
                validate_Name = true;
            }

            if (addressInput.value == "" || addressInput.value == null) {
                addressInput.classList.add("error");
                validate_Address = false;
            } else {
                addressInput.classList.remove("error");
                validate_Address = true;
            }

            if (phoneInput.value == "" || phoneInput.value == null) {
                phoneInput.classList.add("error");
                validate_Phone = false;
            } else {
                phoneInput.classList.remove("error");
                validate_Phone = true;
            }

            if (ceoInput.value == "" || ceoInput.value == null) {
                ceoInput.classList.add("error");
                validate_Ceo = false;
            } else {
                ceoInput.classList.remove("error");
                validate_Ceo = true;
            }

            if (innInput.value == "" || innInput.value == null) {
                innInput.classList.add("error");
                validate_Inn = false;
            } else {
                innInput.classList.remove("error");
                validate_Inn = true;
            }

            if (detailInput.value == "" || detailInput.value == null) {
                detailInput.classList.add("error");
                validate_Detail = false;
            } else {
                detailInput.classList.remove("error");
                validate_Detail = true;
            }

            if (validate_Name && validate_Address && validate_Phone && validate_Ceo && validate_Inn && validate_Detail) {
                let Company = {
                    name: nameInput.value,
                    address: addressInput.value,
                    phone: phoneInput.value,
                    ceo: ceoInput.value,
                    inn: innInput.value,
                    detail: detailInput.value,
                };

                $.ajax({
                    url: "includes/createCompany.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        company: Company,
                    },
                    success: function (data) {
                        if(document.querySelector('.catalog .placeholder') && document.querySelectorAll('.catalog .item').length < 1){
                            document.querySelector('.catalog .placeholder').remove();
                        }

                        let list = document.querySelector(`.catalog .row`);

                        let new_company = document.createElement("a");
                        new_company.classList.add("item");
                        new_company.setAttribute("data-id", data.new_id);
                        new_company.setAttribute("href", `company.php?company_id=${data.new_id}`);
                        new_company.setAttribute("title", `Открыть карточку компании`);

                        let company_text = `
                            <div class="item-content">
                                <div class="item-content__delete">
                                    <img src="assets/img/icons/trash.svg" alt="">
                                </div>
                                
                                <div class="item-content__title">${htmlEntities(Company.name)}</div>
                                <div class="item-content__row">
                                    <span>Адрес: </span>
                                    <span>${htmlEntities(Company.address)}</span>
                                </div>

                                <div class="item-content__row">
                                    <span>Телефон: </span>
                                    <span>${htmlEntities(Company.phone)}</span>
                                </div>

                                <div class="item-content__row">
                                    <span>Генеральный директор: </span>
                                    <span>${htmlEntities(Company.ceo)}</span>
                                </div>
                            </div>
                        `;

                        new_company.innerHTML = company_text;
                        list.appendChild(new_company);

                        companyModal.closeModal();

                        nameInput.value = "";
                        addressInput.value = "";
                        phoneInput.value = "";
                        ceoInput.value = "";
                        innInput.value = "";
                        detailInput.value = "";

                        SuccessNotification.setText("Компания успешно добавлена!").show(2500);
                    },
                    error: function (data) {
                        console.log(data);
                        ErrorNotification.setText("Ошибка в аяксе").show(2500);
                    },
                });
            }
        }

        // Выход из учетки
        if (target.closest("#logout")) {
            $.ajax({
                url: "includes/Class/User.php",
                method: "POST",
                dataType: "json",
                data: {
                    type: "logout",
                },
                success: function (data) {
                    window.location.reload();
                },
                error: function (data) {
                    console.log(data);
                    ErrorNotification.setText("Ошибка в аяксе").show(2500);
                },
            });
        }

        // Открыть модалку "Оставить комментарий"
        if (target.closest(".company-item-head__add")) {
            commentModal.openModal();
            commentModal.element.setAttribute("data-target", target.closest(".company-item-head__add").getAttribute("data-target"));
        }

        // Оставить комментарий
        if (target.closest("#new_comment button")) {
            e.preventDefault();

            let textarea = document.querySelector("#new_comment textarea");

            let validate_Text = false;

            if (textarea.value == "" || textarea.value == null) {
                textarea.classList.add("error");
                validate_Text = false;
            } else {
                textarea.classList.remove("error");
                validate_Text = true;
            }

            if (validate_Text) {
                let text = textarea.value;

                $.ajax({
                    url: "includes/sendComment.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        user_id: user_id,
                        user_login: user_login,
                        company_id: company_id,
                        for: commentModal.element.getAttribute("data-target"),
                        text: text,
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.status == "success") {
                            let list = document.querySelector(`.company-item[data-name=${commentModal.element.getAttribute("data-target")}] .company-comments`);
                            let new_comment = document.createElement("li");
                            new_comment.classList.add("company-comments__item");

                            let new_comment_date = document.createElement("span");
                            new_comment_date.classList.add("date");
                            new_comment_date.textContent = data.pub_date;

                            let new_comment_author = document.createElement("span");
                            new_comment_author.classList.add("author");
                            new_comment_author.textContent = data.user_login + ":";

                            let new_comment_details = document.createElement("span");
                            new_comment_details.classList.add("details");
                            new_comment_details.textContent = data.text;

                            new_comment.appendChild(new_comment_date);
                            new_comment.appendChild(new_comment_author);
                            new_comment.appendChild(new_comment_details);

                            list.appendChild(new_comment);

                            SuccessNotification.setText("Комментарий успешно добавлен!").show(2500);

                            textarea.value = "";
                            commentModal.closeModal();
                            commentModal.element.removeAttribute("data-target");
                        }
                    },
                    error: function (data) {
                        console.log(data);
                        ErrorNotification.setText("Ошибка в аяксе").show(2500);
                    },
                });
            }
        }

        // Окно подтверждения (удаление)
        if (target.closest(".item .item-content__delete")) {
            try {
                e.preventDefault();

                let item = target.closest(".item .item-content__delete").parentNode;
                let confirm = document.querySelector(".confirm");
                let confirmValue = confirm.querySelector(".confirm__title span");

                confirmValue.textContent = item.querySelector(".item-content__title").textContent;
                confirm.setAttribute("data-target", item.parentNode.getAttribute("data-id"));

                confirmModal.openModal();
            } catch {
                console.log("Ошибка в подтверждении удаления #1");
                ErrorNotification.setText("Ошибка в подтверждении удаления #1").show(2500);
            }
        }

        if (target.closest(".confirm .confirm-buttons .confirm-buttons__item")) {
            let button = target.closest(".confirm .confirm-buttons .confirm-buttons__item");
            if (button.getAttribute("data-value") == "true") {
                try {
                    let confirm = target.closest(".confirm");
                    $.ajax({
                        url: "includes/deleteCompany.php",
                        method: "POST",
                        dataType: "json",
                        data: {
                            company_id: confirm.getAttribute("data-target"),
                        },
                        success: function (data) {
                            
                            if (data.company_id == confirm.getAttribute("data-target")) {
                                SuccessNotification.setText("Компания успешно удалена!").show(2500);

                                let itemTarget = document.querySelector(`.catalog .item[data-id='${confirm.getAttribute("data-target")}']`);
                                itemTarget.remove();

                                if(document.querySelectorAll('.catalog .item').length < 1){
                                    console.log(1);
                                    if(!document.querySelector('.catalog .placeholder') ){
                                        console.log(2);
                                        let parent = document.querySelector('.catalog .container .row'); 
                                        let placeholder = document.createElement('div')
                                        placeholder.classList.add('placeholder')
                                        placeholder.textContent = 'Тут пока ничего нет!'

                                        parent.appendChild(placeholder)
                                    }
                                }

                                confirmModal.closeModal();
                            }
                        },
                        error: function (data) {
                            console.log(data);
                            ErrorNotification.setText("Ошибка в аяксе").show(2500);
                        },
                    });
                } catch {
                    console.log("Ошибка в подтверждении удаления #2");
                    ErrorNotification.setText("Ошибка в подтверждении удаления #2").show(2500);
                }
            } else {
                try {
                    confirmModal.closeModal();
                } catch {
                    console.log("Ошибка в подтверждении удаления #3");
                    ErrorNotification.setText("Ошибка в подтверждении удаления #3").show(2500);
                }
            }
        }
    });

    document.addEventListener("input", (e) => {
        let target = e.target;

        if (target.parentNode.classList.contains("form__input")) {
            target.classList.remove("error");
        }
    });
});
