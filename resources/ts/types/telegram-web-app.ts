export type TelegramWebApp = {
    initData: string;
    MainButton: {
        onClick: (callback: () => void) => void;
        setParams: (params: {
            text?: string;
            color?: string;
            text_color?: string;
            is_visible?: boolean;
            is_enabled?: boolean;
        }) => void;
    };
};
