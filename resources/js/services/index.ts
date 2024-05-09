import {FakeTelegramService, TelegramService, TelegramServiceInterface} from "@/services/telegram-service.ts";
import {configuration} from "@/config";

const telegramService: TelegramServiceInterface =
    configuration.APP_ENV !== 'local' ? new TelegramService() : new FakeTelegramService();

export {
    telegramService,
}
