<?php

require_once('includes/Class/User.php');

$db = new DB();


if (!isset($_GET['company_id'])) {
    header('Location: index.php');
}

$info = $db->query('SELECT * FROM company WHERE id = :id', ['id' => $_GET['company_id']])[0];

if (!$info) {
    header('Location: index.php');
}

$comments = $db->query('SELECT * FROM comments WHERE from_user = :user AND to_company = :company', ['user' => $User->getId(), 'company' => $_GET['company_id']]);

function getFieldComments(array $comments, String $field)
{
    $result = [];
    foreach ($comments as $item) {
        if ($item['for_field'] == $field) {
            $result[] = $item;
        }
    }
    return $result;
}

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
    <link rel="stylesheet" href="assets/css/company.css?<?= time() ?>" />
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
        <section class="company">
            <div class="container">

                <div class="company-item" data-name="name">
                    <div class="company-item-head">
                        <p class="company-item-head__title">Название:</p>
                        <?php
                        if ($User->is_Auth()) {
                        ?>
                            <p class="company-item-head__add" data-target="name">Добавить комментарий</p>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="company-item-body">
                        <div class="company-item__value"><?= $info['name'] ?></div>
                        <ul class="company-comments">
                            <?php
                            if (count(getFieldComments($comments, 'name')) > 0) {
                            ?>
                                <?php
                                foreach (getFieldComments($comments, 'name') as $item) {
                                ?>
                                    <li class="company-comments__item">
                                        <span class="date"><?= $item['date'] ?></span>
                                        <span class="author"><?= $User->getLogin() ?>:</span>
                                        <span class="details"><?= $item['text'] ?></span>
                                    </li>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="company-item" data-name="inn">
                    <div class="company-item-head">
                        <p class="company-item-head__title">ИНН:</p>
                        <?php
                        if ($User->is_Auth()) {
                        ?>
                            <p class="company-item-head__add" data-target="inn">Добавить комментарий</p>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="company-item-body">
                        <div class="company-item__value"><?= $info['inn'] ?></div>
                        <ul class="company-comments">
                            <?php
                            if (count(getFieldComments($comments, 'inn')) > 0) {
                            ?>
                                <?php
                                foreach (getFieldComments($comments, 'inn') as $item) {
                                ?>
                                    <li class="company-comments__item">
                                        <span class="date"><?= $item['date'] ?></span>
                                        <span class="author"><?= $User->getLogin() ?>:</span>
                                        <span class="details"><?= $item['text'] ?></span>
                                    </li>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="company-item" data-name="detail">
                    <div class="company-item-head">
                        <p class="company-item-head__title">Детальная информация:</p>
                        <?php
                        if ($User->is_Auth()) {
                        ?>
                            <p class="company-item-head__add" data-target="detail">Добавить комментарий</p>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="company-item-body">
                        <div class="company-item__value"><?= $info['detail'] ?></div>
                        <ul class="company-comments">
                            <?php
                            if (count(getFieldComments($comments, 'detail')) > 0) {
                            ?>
                                <?php
                                foreach (getFieldComments($comments, 'detail') as $item) {
                                ?>
                                    <li class="company-comments__item">
                                        <span class="date"><?= $item['date'] ?></span>
                                        <span class="author"><?= $User->getLogin() ?>:</span>
                                        <span class="details"><?= $item['text'] ?></span>
                                    </li>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="company-item" data-name="ceo">
                    <div class="company-item-head">
                        <p class="company-item-head__title">Генеральный директор:</p>
                        <?php
                        if ($User->is_Auth()) {
                        ?>
                            <p class="company-item-head__add" data-target="ceo">Добавить комментарий</p>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="company-item-body">
                        <div class="company-item__value"><?= $info['ceo'] ?></div>
                        <ul class="company-comments">
                            <?php
                            if (count(getFieldComments($comments, 'ceo')) > 0) {
                            ?>
                                <?php
                                foreach (getFieldComments($comments, 'ceo') as $item) {
                                ?>
                                    <li class="company-comments__item">
                                        <span class="date"><?= $item['date'] ?></span>
                                        <span class="author"><?= $User->getLogin() ?>:</span>
                                        <span class="details"><?= $item['text'] ?></span>
                                    </li>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="company-item" data-name="address">
                    <div class="company-item-head">
                        <p class="company-item-head__title">Адрес:</p>
                        <?php
                        if ($User->is_Auth()) {
                        ?>
                            <p class="company-item-head__add" data-target="address">Добавить комментарий</p>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="company-item-body">
                        <div class="company-item__value"><?= $info['address'] ?></div>
                        <ul class="company-comments">
                            <?php
                            if (count(getFieldComments($comments, 'address')) > 0) {
                            ?>
                                <?php
                                foreach (getFieldComments($comments, 'address') as $item) {
                                ?>
                                    <li class="company-comments__item">
                                        <span class="date"><?= $item['date'] ?></span>
                                        <span class="author"><?= $User->getLogin() ?>:</span>
                                        <span class="details"><?= $item['text'] ?></span>
                                    </li>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="company-item" data-name="phone">
                    <div class="company-item-head">
                        <p class="company-item-head__title">Телефон:</p>
                        <?php
                        if ($User->is_Auth()) {
                        ?>
                            <p class="company-item-head__add" data-target="phone">Добавить комментарий</p>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="company-item-body">
                        <div class="company-item__value"><?= $info['phone'] ?></div>
                        <ul class="company-comments">
                            <?php
                            if (count(getFieldComments($comments, 'phone')) > 0) {
                            ?>
                                <?php
                                foreach (getFieldComments($comments, 'phone') as $item) {
                                ?>
                                    <li class="company-comments__item">
                                        <span class="date"><?= $item['date'] ?></span>
                                        <span class="author"><?= $User->getLogin() ?>:</span>
                                        <span class="details"><?= $item['text'] ?></span>
                                    </li>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>


                <div class="company-item company-item--comments" data-name="company">
                    <div class="company-item-head">
                        <p class="company-item-head__title">Коментарии компании:</p>
                        <?php
                        if ($User->is_Auth()) {
                        ?>
                            <p class="company-item-head__add" data-target="company">Прокомментировать компанию</p>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="company-item-body">
                        <ul class="company-comments">
                            <?php
                            if (count(getFieldComments($comments, 'company')) > 0) {
                            ?>
                                <?php
                                foreach (getFieldComments($comments, 'company') as $item) {
                                ?>
                                    <li class="company-comments__item">
                                        <span class="date"><?= $item['date'] ?></span>
                                        <span class="author"><?= $User->getLogin() ?>:</span>
                                        <span class="details"><?= $item['text'] ?></span>
                                    </li>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>


            </div>

        </section>
    </main>

    <div class="modal__background">


        <?php
        if ($User->is_Auth()) {
        ?>
            <div class="modal" id="new_comment">
                <div class="modal__inner">
                    <form method="POST" class="form">
                        <div class="form__inputs">
                            <div class="form__input">
                                <textarea name="comment" id="" cols="30" rows="10" placeholder="Введите ваш комментарий:" maxlength="250"></textarea>
                            </div>
                        </div>
                        <button class="form__button" type="submit">Добавить комментарий</button>
                    </form>
                </div>
            </div>
        <?php
        } else {
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
        }
        ?>
    </div>

    <div class="notification">
        <div class="notification__text"></div>
    </div>
</body>

<script type="text/javascript">
    const user_id = <?= $User->getId() ?>;
    const user_login = '<?= $User->getLogin() ?>';

    const company_id = <?= $_GET['company_id'] ?>;
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="assets/js/App.js?<?= time() ?>" type="module"></script>

</html>