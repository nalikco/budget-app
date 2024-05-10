declare namespace App.Dto.Account {
export type AccountData = {
id: number;
currency: App.Dto.Currency.CurrencyData;
name: string;
balance: number;
icon: string;
created_at: string;
updated_at: string;
};
export type CreateAccountData = {
currency: string;
name: string;
balance: number;
icon: string;
};
}
declare namespace App.Dto.Currency {
export type CurrencyData = {
iso_code: string;
name: string;
format: string;
};
}
declare namespace App.Dto.MovementCategory {
export type CreateMovementCategoryData = {
type: App.Enums.MovementCategoryType;
name: string;
icon: string;
};
export type MovementCategoryData = {
id: number;
is_default: boolean;
type: App.Enums.MovementCategoryType;
name: string;
icon: string;
created_at: string;
updated_at: string;
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
created_at: string;
updated_at: string;
};
}
declare namespace App.Enums {
export enum MovementCategoryType { 'DEBIT' = 'debit', 'CREDIT' = 'credit' };
}
