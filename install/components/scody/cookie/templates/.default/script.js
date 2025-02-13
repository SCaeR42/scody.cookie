class CookieManager {
    constructor(customSettings = {}) {
        // Устанавливаем настройки по умолчанию
        this.settings = {
            containerId: 'cookieDiv',
            cookieName: 'acceptCookie',
            cookieValue: 'accepted',
            cookieExpireDays: 30,
            checkCookieTimeout: 1000,
            ...customSettings,  // Перезаписываем настройки, если они переданы
        };

        this.settings.cookieDiv = document.getElementById(this.settings.containerId);

        // Инициализация при загрузке страницы
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => this.checkCookie(), this.settings.checkCookieTimeout);
        });
    }

    // Установка cookie
    setCookie(name, value, days) {
        const expires = new Date(Date.now() + days * 864e5).toUTCString();
        document.cookie = `${name}=${value}; expires=${expires}; path=/;`;
    }

    // Получение cookie
    getCookie(name) {
        const match = document.cookie.match(new RegExp(`(^| )${name}=([^;]+)`));
        return match ? decodeURIComponent(match[2]) : '';
    }

    // Проверка наличия куки
    checkCookie() {
        if (this.getCookie(this.settings.cookieName) !== this.settings.cookieValue) {
            this.settings.cookieDiv.style.display = 'flex';
            this.setCookie(this.settings.cookieName, '', this.settings.cookieExpireDays);
            this.settings.cookieDiv.classList.remove('cookie__hide');
        } else {
            this.closeCookieDiv();
        }
    }

    // Принятие cookies
    acceptCookies() {
        this.setCookie(this.settings.cookieName, this.settings.cookieValue, this.settings.cookieExpireDays);
        this.closeCookieDiv();
    }

    // Скрытие сообщения о cookie
    closeCookieDiv() {
        if (this.settings.cookieDiv) {
            this.settings.cookieDiv.classList.add('cookie__hide');
            setTimeout(() => this.settings.cookieDiv.remove(), 1000);
        }
    }
}

