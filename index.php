<?php

require_once('includes/Class/User.php');

$db = new DB();

$companyList = $db->query('SELECT * FROM company');
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AdAurum | Тестовое задание</title>

    <link rel="stylesheet" href="assets/css/normilize.css?<?= time() ?>" />
    <link rel="stylesheet" href="assets/css/style.css?<?= time() ?>" />
</head>

<body>
    <header class="header">
        <div class="container">
            <a href="index.php" class="header__logo">
                Logo
            </a>

            <div class="header__menu">
                <nav class="menu">
                    <ul class="menu-list">
                        <li class="menu-list__item"><a href="index.php">Компании</a></li>
                    </ul>
                </nav>

                <div class="auth-menu">
                    <?php
                    if ($User->is_Auth()) {
                    ?>
                        <div class="auth-menu__item button--icon" id="logout">
                            <span class="button--icon__title">Выйти</span>
                            <div class="button--icon__img">
                                <img src="assets/img/icons/login.svg" alt="" />
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="auth-menu__item button--icon" id="auth">
                            <span class="button--icon__title">Войти</span>
                            <div class="button--icon__img">
                                <img src="assets/img/icons/login.svg" alt="" />
                            </div>
                        </div>

                        <div class="auth-menu__item button--icon" id="reg">
                            <span class="button--icon__title">Зарегистрироваться</span>
                            <div class="button--icon__img">
                                <img src="assets/img/icons/register.svg" alt="" />
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </header>

    <main>
        <section class="catalog">
            <div class="container">
                <div class="row row--3">
                    <?php
                    if (count($companyList) > 0) {
                    ?>
                        <?php
                        foreach ($companyList as $item) {
                        ?>
                            <a href="company.php?company_id=<?= $item['id'] ?>" class="item" data-id="<?= $item['id'] ?>" title="Открыть карточку компании">
                                <div class="item-content">
                                    <?php
                                    if ($User->is_Auth()) {
                                    ?>
                                        <div class="item-content__delete">
                                            <img src="assets/img/icons/trash.svg" alt="" />
                                        </div>
                                    <?php
                                    }
                                    ?>

                                    <div class="item-content__title"><?= $item['name'] ?></div>
                                    <div class="item-content__row">
                                        <span>Адрес: </span>
                                        <span><?= $item['address'] ?></span>
                                    </div>

                                    <div class="item-content__row">
                                        <span>Телефон: </span>
                                        <span><?= $item['phone'] ?></span>
                                    </div>

                                    <div class="item-content__row">
                                        <span>Генеральный директор: </span>
                                        <span><?= $item['ceo'] ?></span>
                                    </div>
                                </div>
                            </a>
                        <?php
                        }
                        ?>
                    <?php
                    } else {
                    ?>
                        <?php
                        if ($User->is_Auth()) {
                        ?>
                            <div class="placeholder">
                                Тут пока ничего нет!
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="placeholder">
                                Тут пока пусто, авторизуйтесь, чтобы добавить!
                            </div>
                        <?php
                        }
                        ?>
                    <?php
                    }
                    ?>


                </div>
            </div>
        </section>

        <?php
        if ($User->is_Auth()) {
        ?>
            <section class="catalog-add">
                <div class="container">
                    <div class="catalog-add__button" id="catalog_add">
                        Добавить компанию
                    </div>
                </div>
            </section>
        <?php
        }
        ?>


    </main>

    <div class="modal__background">

        <?php
        if (!$User->is_Auth()) {
        ?>
            <div class="modal" id="login">
                <div class="modal__inner">
                    <form method="POST" class="form">
                        <p class="form__error"></p>
                        <div class="form__inputs">
                            <div class="form__input">
                                <input type="text" name="login" placeholder="Ваш логин:" maxlength="250" />
                            </div>
                            <div class="form__input">
                                <input type="password" name="password" placeholder="Ваш пароль:" maxlength="250" />
                            </div>
                        </div>
                        <button class="form__button" type="submit">Войти</button>
                        <span class="form__note">Нету аккаунта? <a id="reg">Создайте его!</a></span>
                    </form>
                </div>
            </div>

            <div class="modal" id="register">
                <div class="modal__inner">
                    <form method="POST" class="form">
                        <p class="form__error"></p>
                        <div class="form__inputs">
                            <div class="form__input">
                                <input type="text" name="login" placeholder="Придумайте логин:" maxlength="250" />
                            </div>
                            <div class="form__input">
                                <input type="password" name="password" placeholder="Новый пароль:" maxlength="250" />
                            </div>

                            <div class="form__input">
                                <input type="password" name="retry_password" placeholder="Повторите новый пароль:" maxlength="250" />
                            </div>
                        </div>
                        <button class="form__button" type="submit">Создать аккаунт</button>
                    </form>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="modal" id="new_company">
                <div class="modal__inner">
                    <form method="POST" class="form">
                        <div class="form__inputs">
                            <div class="form__input">
                                <input type="text" name="company_name" placeholder="Название компании:" maxlength="250" />
                            </div>
                            <div class="form__input">
                                <input type="text" name="company_address" placeholder="Адрес компании:" maxlength="250" />
                            </div>
                            <div class="form__input">
                                <input type="text" name="company_phone" placeholder="Телефон компании:" maxlength="250" />
                            </div>
                            <div class="form__input">
                                <input type="text" name="company_ceo" placeholder="Ген. Директор компании:" maxlength="250" />
                            </div>
                            <div class="form__input">
                                <input type="text" name="company_inn" placeholder="ИНН компании:" maxlength="250" />
                            </div>
                            <div class="form__input">
                                <textarea name="company_detail" rows="3" placeholder="Описание компании:" maxlength="250"></textarea>
                            </div>
                        </div>
                        <button class="form__button" type="submit">Добавить компанию</button>
                    </form>
                </div>
            </div>

            <div class="modal" id="delete_confirm">
                <div class="modal__inner">
                    <div class="confirm">
                        <p class="confirm__title">Вы уверены, что хотите удалить компанию <span></span>?</p>
                        <div class="confirm-buttons">
                            <div class="confirm-buttons__item" data-value="true">Да</div>
                            <div class="confirm-buttons__item" data-value="false">Нет</div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <div class="notification">
        <div class="notification__text"></div>
    </div>
</body>

<script type="text/javascript">
    const user_id = <?= $User->getId() ?>;
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="assets/js/App.js?<?= time() ?>" type="module"></script>

</html>