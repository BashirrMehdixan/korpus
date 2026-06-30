import { ref, watch } from 'vue';

const STORAGE_KEY = 'korpus-theme';
const isBrowser = typeof window !== 'undefined';

function getInitialValue(): boolean {
    if (!isBrowser) return false;
    const stored = localStorage.getItem(STORAGE_KEY);
    if (stored !== null) return stored === 'dark';
    return window.matchMedia('(prefers-color-scheme: dark)').matches;
}

function applyDark(val: boolean) {
    if (!isBrowser) return;
    document.documentElement.classList.toggle('dark', val);
}

const isDark = ref(getInitialValue());

applyDark(isDark.value);

watch(isDark, (val) => {
    if (!isBrowser) return;
    localStorage.setItem(STORAGE_KEY, val ? 'dark' : 'light');
    applyDark(val);
});

export function useDarkMode() {
    return {
        isDark,
        toggle() {
            isDark.value = !isDark.value;
        },
    };
}
