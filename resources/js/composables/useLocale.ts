import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue'; // <-- computed-ı əlavə edin

interface PageProps {
    locale: string;
    translations: Record<string, string>;
    availableLocales: string[];
}

export function useLocale() {
    const page = usePage<PageProps>();

    const locale = computed((): string => page.props.locale ?? 'az');

    function t(key: string): string {
        return page.props.translations?.[key] ?? key;
    }

    function localeUrl(target: string): string {
        const current = window.location.pathname.replace(
            /^\/?(az|en|ru)\/?/,
            '',
        );

        return target === 'az' ? `/${current}` : `/${target}/${current}`;
    }

    function rn(name: string): string {
        const currentLoc = page.props.locale ?? 'az';
        const prefix = currentLoc === 'az' ? 'front' : currentLoc;

        return `${prefix}.${name.replace(/^front\./, '')}`;
    }

    return {
        locale,
        availableLocales: page.props.availableLocales ?? ['az', 'en', 'ru'],
        t,
        localeUrl,
        rn,
    };
}
