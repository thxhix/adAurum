export default class Notification {
    _defaultText = "Действие успешно выполнено!";

    _notificationContainer = document.querySelector(".notification");
    _notificationValue = document.querySelector(".notification .notification__text");

    constructor(text = this._defaultText, is_Error = false) {
        this._defaultText = text;
        this.text = text;
        this.is_Error = is_Error;
    }

    setText(newText = this._defaultText) {
        try {
            this.text = newText;
            return this;
        } catch {
            console.log("Ошибка в уведомлениях #1");
        }
    }

    show(time = 2500) {
        try {
            if (this.is_Error) {
                this._notificationContainer.classList.add("error");
            } else {
                this._notificationContainer.classList.remove("error");
            }

            this._notificationValue.textContent = this.text;
            this._notificationContainer.classList.add("active");

            let is_ready = false;
            let interval = setInterval((e) => {
                is_ready = true;
                is_ready ? clearInterval(interval) : console.log("no");
                this._notificationContainer.classList.remove("active");
            }, time);
        } catch {
            console.log("Ошибка в уведомлениях #2");
        }
    }
}
