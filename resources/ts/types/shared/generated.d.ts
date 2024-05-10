declare namespace App.Dto.Account {
export type AccountData = {
id: number;
currency: App.Dto.Currency.CurrencyData;
name: string;
balance: number;
icon: string;
createdAt: string;
updatedAt: string;
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
isoCode: string;
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
isDefault: boolean;
type: App.Enums.MovementCategoryType;
name: string;
icon: string;
createdAt: string;
updatedAt: string;
};
}
declare namespace App.Dto.Telegram {
export type TelegramUserData = {
id: number;
telegramId: number;
firstName: string;
lastName: string;
username: string;
languageCode: string;
allowsWriteToPm: boolean;
};
}
declare namespace App.Dto.Transaction {
export type CreateTransactionData = {
account: any;
movementCategory: any;
outAmount: number;
inAmount: number;
date: string;
description: string | null;
};
export type CreateTransferData = {
from: any;
to: any;
outAmount: number;
inMount: number;
};
}
declare namespace App.Dto.User {
export type UserData = {
id: number;
username: string;
currency: App.Dto.Currency.CurrencyData;
telegramUser: App.Dto.Telegram.TelegramUserData;
createdAt: string;
updatedAt: string;
};
}
declare namespace App.Enums {
export enum MovementCategoryType { 'INCOME' = 'income', 'OUTCOME' = 'outcome' };
}
