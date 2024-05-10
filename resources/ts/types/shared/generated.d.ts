declare namespace App.Dto.Currency {
export type CurrencyData = {
iso_code: string;
name: string;
format: string;
};
}
declare namespace App.Dto.Telegram {
export type TelegramUserData = {
id: number;
telegram_id: number;
first_name: string;
last_name: string;
username: string;
language_code: string;
allows_write_to_pm: boolean;
};
}
declare namespace App.Dto.User {
export type UserData = {
id: number;
username: string;
currency: App.Dto.Currency.CurrencyData;
telegramUser: App.Dto.Telegram.TelegramUserData;
};
}
