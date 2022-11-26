import Notification from "./Notification.js";

const ErrorNotify = new Notification("Произошла ошибка, попробуйте позже", true);

export default class Modal {
    _modalBackground = document.querySelector(".modal__background");

    constructor(id) {
        this.id = id;
        this.element = document.querySelector(`#${this.id}`)
    }

    closeAll() {
        try {
            document.querySelectorAll(".modal").forEach((item) => {
                item.classList.remove("active");
                this._modalBackground.classList.remove("active");
            });
            return this;
        } catch {
            console.log("Ошибка в модалках #1");
            ErrorNotify.setText('Ошибка в модалках #1').show(2500);
        }
    }

    #closeOther() {
        try {
            document.querySelectorAll(".modal").forEach((item) => {
                item.classList.remove("active");
            });
        } catch {
            console.log("Ошибка в модалках #2");
            ErrorNotify.setText('Ошибка в модалках #2').show(2500);
        }
    }

    openModal() {
        try {
            this.#closeOther();
            document.querySelector(`#${this.id}`).classList.add("active");
            this._modalBackground.classList.add("active");
            return this;
        } catch {
            console.log("Ошибка в модалках #3");
            ErrorNotify.setText('Ошибка в модалках #3').show(2500);
        }
    }

    closeModal() {
        try {
            this.#closeOther();
            document.querySelector(`#${this.id}`).classList.remove("active");
            this._modalBackground.classList.remove("active");
            return this;
        } catch {
            console.log("Ошибка в модалках #4");
            ErrorNotify.setText('Ошибка в модалках #4').show(2500);
        }
    }
}
