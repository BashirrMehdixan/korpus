<template>
    <aside
        :class="[
            'sticky top-0 flex h-screen flex-col justify-between border-r border-gray-100 bg-white transition-all duration-300 dark:border-gray-900 dark:bg-gray-950',
            collapsed ? 'w-16' : 'w-56',
        ]"
    >
        <div>
            <div
                :class="[
                    'flex items-center py-6',
                    collapsed ? 'justify-center' : 'px-6',
                ]"
            >
                <div
                    class="flex items-center gap-2.5 font-semibold text-[#2B4CDE]"
                >
                    <div
                        class="flex size-8 items-center justify-center rounded-lg bg-[#2B4CDE] text-white"
                    >
                        <RiCommandLine class="h-4 w-4" />
                    </div>
                    <span v-show="!collapsed" class="text-sm tracking-tight"
                        >Korpus</span
                    >
                </div>
            </div>

            <div
                v-show="!collapsed"
                class="mx-6 mb-4 h-px bg-gray-100 dark:bg-gray-800"
            ></div>

            <nav class="space-y-1 px-3">
                <div
                    v-for="item in menuItems"
                    :key="item.id"
                    class="space-y-0.5"
                >
                    <Link
                        v-if="!item?.children?.length"
                        :class="[
                            'relative flex w-full cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-left text-sm font-medium',
                            route().current() === item.route
                                ? 'bg-blue-50 text-[#2B4CDE] dark:bg-blue-950 dark:text-blue-400'
                                : 'text-gray-500 transition-all duration-300 hover:bg-gray-50 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-900 dark:hover:text-gray-300',
                        ]"
                        :href="route(item.route)"
                    >
                        <component
                            :is="resolveIcon(item.icon)"
                            class="size-4 shrink-0"
                        />
                        {{ item.translations[currentLocale]?.title }}
                    </Link>
                    <div
                        v-else
                        :class="[
                            'relative flex w-full cursor-pointer items-center rounded-lg px-3 py-2.5 text-left text-sm font-medium transition-all duration-300',
                            isMenuActive(item)
                                ? 'bg-blue-50 text-[#2B4CDE] dark:bg-blue-950 dark:text-blue-400'
                                : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-900 dark:hover:text-gray-300',
                            collapsed ? 'justify-center' : 'gap-3',
                        ]"
                        @click="handleMenuClick(item)"
                    >
                        <div
                            :class="
                                isMenuActive(item)
                                    ? 'text-[#2B4CDE] dark:text-blue-400'
                                    : 'text-gray-400 dark:text-gray-500'
                            "
                        >
                            <component
                                :is="resolveIcon(item.icon)"
                                class="size-4 shrink-0"
                            />
                        </div>
                        <span
                            v-show="!collapsed"
                            class="flex-1 truncate text-left"
                        >
                            {{
                                item.translations[currentLocale]?.title ||
                                'Menu'
                            }}
                        </span>

                        <RiArrowDownSLine
                            v-if="
                                item.children &&
                                item.children.length > 0 &&
                                !collapsed
                            "
                            :class="[
                                'size-3 text-gray-400 transition-transform duration-200',
                                openDropdowns.includes(item.id)
                                    ? 'rotate-180 text-[#2B4CDE] dark:text-blue-400'
                                    : '',
                            ]"
                        />
                    </div>

                    <div
                        v-if="
                            item.children &&
                            item.children.length > 0 &&
                            !collapsed &&
                            openDropdowns.includes(item.id)
                        "
                        class="relative ml-5 space-y-0.5 border-l border-gray-200 pl-6 dark:border-gray-800"
                    >
                        <Link
                            v-for="child in item.children"
                            :key="child.id"
                            :class="[
                                'relative flex w-full items-center rounded-lg px-3 py-2 text-left text-xs font-medium transition-all',
                                activeMenu === child.id
                                    ? 'font-semibold text-[#2B4CDE] dark:text-blue-400'
                                    : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200',
                            ]"
                            :href="route(child.route)"
                        >
                            <span
                                class="absolute top-1/2 -left-6.25 flex -translate-y-1/2 items-center"
                            >
                                <span
                                    class="size-1.5 rounded-full border border-gray-300 bg-white dark:border-gray-700 dark:bg-gray-950"
                                ></span>
                            </span>

                            <span class="truncate">{{
                                child.translations[currentLocale]?.title ||
                                'Submenu'
                            }}</span>
                        </Link>
                    </div>
                </div>
            </nav>
        </div>

        <div v-show="!collapsed" class="px-6 py-5">
            <div class="flex items-center gap-1">
                <button
                    class="flex size-8 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:text-gray-500 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                    @click="toggleDark"
                >
                    <RiSunLine v-if="isDark" class="h-4 w-4" />
                    <RiMoonLine v-else class="h-4 w-4" />
                </button>
                <button
                    class="rounded-lg px-3 py-1.5 text-sm font-medium text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:text-gray-500 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                    @click="toggleLocale"
                >
                    {{ currentLocale.toUpperCase() }}
                </button>
            </div>
        </div>

        <button
            class="absolute top-1/2 -right-3 z-20 flex size-6 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-400 shadow-sm hover:border-[#2B4CDE] hover:text-[#2B4CDE] dark:border-gray-700 dark:bg-gray-950 dark:text-gray-500 dark:hover:border-blue-400 dark:hover:text-blue-400"
            @click="toggleCollapse"
        >
            <RiArrowLeftSLine v-show="!collapsed" class="size-3" />
            <RiArrowRightSLine v-show="collapsed" class="size-3" />
        </button>
    </aside>
</template>

<script lang="ts" setup>
import { Link, usePage } from '@inertiajs/vue3';
import {
    RiArrowDownSLine,
    RiArrowLeftSLine,
    RiArrowRightSLine,
    RiBookOpenLine,
    RiCoinsLine,
    RiCommandLine,
    RiLayoutGridFill,
    RiMoneyDollarCircleLine,
    RiMoonLine,
    RiPresentationLine,
    RiSunLine,
    RiTeamLine,
    RiUser3Line,
    RiUserLine,
} from '@remixicon/vue';
import { computed, ref, watch } from 'vue';
import { route } from 'ziggy-js';
import { useDarkMode } from '@/composables/useDarkMode';
import { useLocale } from '@/composables/useLocale';

const props = defineProps<{
    activeMenu: string | number | null;
    collapsed: boolean;
}>();

const emit = defineEmits<{
    (e: 'update:activeMenu', menuId: string | number): void;
    (e: 'update:collapsed', value: boolean): void;
}>();

const { isDark, toggle: toggleDark } = useDarkMode();
const { locale: currentLocale } = useLocale();
const page = usePage();

const menuItems = computed(() => (page.props.menus as any[]) || []);

const openDropdowns = ref<Array<number | string>>([]);

const iconMap: Record<string, any> = {
    RiLayoutGridFill,
    RiTeamLine,
    RiUserLine,
    RiBookOpenLine,
    RiMoneyDollarCircleLine,
    RiCommandLine,
    RiCoinsLine,
    RiPresentationLine,
    RiUser3Line,
};

const resolveIcon = (name: string | null) => {
    return iconMap[name ?? ''] || RiCommandLine;
};

const isMenuActive = (item: any) => {
    if (props.activeMenu === item.id) return true;

    if (item.children && item.children.length > 0) {
        return item.children.some(
            (child: any) => child.id === props.activeMenu,
        );
    }

    return false;
};

const handleMenuClick = (item: any) => {
    const index = openDropdowns.value.indexOf(item.id);

    if (index > -1) openDropdowns.value.splice(index, 1);
    else openDropdowns.value.push(item.id);
};

const toggleLocale = () => {
    const next = currentLocale.value === 'az' ? 'en' : 'az';
    const remaining = window.location.pathname
        .replace(/^\/(az|en|ru)(\/|$)/, '')
        .replace(/^\/+/, '');

    const prefix = next === 'az' ? '' : `/${next}`;

    window.location.href = remaining ? `${prefix}/${remaining}` : `${prefix}/`;
};

const toggleCollapse = () => {
    emit('update:collapsed', !props.collapsed);
};

watch(
    () => props.activeMenu,
    (newActiveId) => {
        if (!newActiveId) return;

        menuItems.value.forEach((item) => {
            if (item.children && item.children.length > 0) {
                const hasActiveChild = item.children.some(
                    (child: any) => child.id === newActiveId,
                );

                if (hasActiveChild && !openDropdowns.value.includes(item.id)) {
                    openDropdowns.value.push(item.id);
                }
            }
        });
    },
    { immediate: true },
);
</script>
