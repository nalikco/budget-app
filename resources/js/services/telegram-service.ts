import {TelegramWebApp} from "@/types/telegram-web-app";

export interface TelegramServiceInterface {
    getInitData(): string;
}

export class TelegramService implements TelegramServiceInterface {
    private tg: TelegramWebApp;

    constructor() {
        // eslint-disable-next-line @typescript-eslint/ban-js-comment
        // @js-expect-error
        this.tg = window.Telegram.WebApp

        this.tg.MainButton.setParams({
            text: 'Добавить операцию',
            is_visible: true,
            is_enabled: true,
        });
        this.tg.MainButton.onClick(() => {
            alert('В разработке...');
        })
    }

    getInitData() {
        return this.tg.initData;
    }
}

export class FakeTelegramService implements TelegramServiceInterface {
    getInitData() {
        return 'auth_date=1712603287&query_id=QoCJwq2LEOltYeZ0&user=%7B%22id%22%3A3453455%2C%22first_name%22%3A%22John%22%2C%22last_name%22%3A%22Doe%22%2C%22username%22%3A%22johndoe%22%2C%22language_code%22%3A%22en%22%2C%22allows_write_to_pm%22%3Atrue%7D&hash=a572c00d30c1407ec9d7357241b1558c6ec5fcc41cffe6484d0efca54423511b';
    }
}
