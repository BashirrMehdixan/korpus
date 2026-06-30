<template>
    <aside
        :class="[
            'sticky top-0 flex h-screen flex-col justify-between border-r border-gray-100 bg-white transition-all duration-300 dark:border-gray-900 dark:bg-gray-950',
            collapsed ? 'w-16' : 'w-56',
        ]"
    >
        <div>
            <!-- Logo Bölməsi -->
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
                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#2B4CDE] text-white"
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

            <!-- Naviqasiya Menyusu -->
            <nav class="space-y-1 px-3">
                <div
                    v-for="item in menuItems"
                    :key="item.id"
                    class="space-y-0.5"
                >
                    <!-- Ana Menyu Düyməsi -->
                    <button
                        :class="[
                            'relative flex w-full items-center rounded-lg px-3 py-2.5 text-left text-sm font-medium transition-all',
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
                                class="h-4 w-4 shrink-0"
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

                        <!-- Dropdown Ox İşarəsi (image_8e8dd7.png-dəki kimi istiqaməti dönən) -->
                        <RiArrowDownSLine
                            v-if="
                                item.children &&
                                item.children.length > 0 &&
                                !collapsed
                            "
                            :class="[
                                'h-3 w-3 text-gray-400 transition-transform duration-200',
                                openDropdowns.includes(item.id)
                                    ? 'rotate-180 text-[#2B4CDE] dark:text-blue-400'
                                    : '',
                            ]"
                        />
                    </button>

                    <!-- Alt Menyular (Dropdown / Children) -->
                    <div
                        v-if="
                            item.children &&
                            item.children.length > 0 &&
                            !collapsed &&
                            openDropdowns.includes(item.id)
                        "
                        class="relative ml-5 space-y-0.5 border-l border-gray-200 pl-6 dark:border-gray-800"
                    >
                        <button
                            v-for="child in item.children"
                            :key="child.id"
                            :class="[
                                'relative flex w-full items-center rounded-lg px-3 py-2 text-left text-xs font-medium transition-all',
                                activeMenu === child.id
                                    ? 'font-semibold text-[#2B4CDE] dark:text-blue-400'
                                    : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200',
                            ]"
                            @click="selectChildMenu(child)"
                        >
                            <!-- image_8e8dd7.png faylındakı zərif ağac qolu (Tree branch dot) -->
                            <span
                                class="absolute top-1/2 -left-6.25 flex -translate-y-1/2 items-center"
                            >
                                <span
                                    class="h-1.5 w-1.5 rounded-full border border-gray-300 bg-white dark:border-gray-700 dark:bg-gray-950"
                                ></span>
                            </span>

                            <span class="truncate">{{
                                child.translations[currentLocale]?.title ||
                                'Submenu'
                            }}</span>
                        </button>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Alt Hissə: Ayarlar (Qaranlıq rejim & Dil) -->
        <div v-show="!collapsed" class="px-6 py-5">
            <div class="flex items-center gap-1">
                <button
                    class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:text-gray-500 dark:hover:bg-gray-800 dark:hover:text-gray-300"
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

        <!-- Sidebar Collapse Düyməsi -->
        <button
            class="absolute top-1/2 -right-3 z-20 flex h-6 w-6 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-400 shadow-sm hover:border-[#2B4CDE] hover:text-[#2B4CDE] dark:border-gray-700 dark:bg-gray-950 dark:text-gray-500 dark:hover:border-blue-400 dark:hover:text-blue-400"
            @click="toggleCollapse"
        >
            <RiArrowLeftSLine v-show="!collapsed" class="h-3 w-3" />
            <RiArrowRightSLine v-show="collapsed" class="h-3 w-3" />
        </button>
    </aside>
</template>

<script lang="ts" setup>
import { router, usePage } from '@inertiajs/vue3';
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

const props = defineProps<{
    activeMenu: string | number | null;
    collapsed: boolean;
}>();

const emit = defineEmits<{
    (e: 'update:activeMenu', menuId: string | number): void;
    (e: 'update:collapsed', value: boolean): void;
}>();

const { isDark, toggle: toggleDark } = useDarkMode();
const page = usePage();

// Aktiv dil (Mövcud proyektinizdə locale fərqlidirsə buranı uyğunlaşdırın)
const currentLocale = ref('az');

// HandleInertiaRequests-dən gələn 'menus' siyahısını çəkirik
const menuItems = computed(() => (page.props.menus as any[]) || []);

// Hansı menyunun dropdown-u açıqdırsa onun id-lərini saxlayır
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

function resolveIcon(name: string | null) {
    return iconMap[name ?? ''] || RiCommandLine;
}

// Menyu fəallığının yoxlanması (Ana və ya hər hansı bir alt menyu seçiləndə göy rəngdə qalması üçün)
function isMenuActive(item: any) {
    if (props.activeMenu === item.id) return true;

    if (item.children && item.children.length > 0) {
        return item.children.some(
            (child: any) => child.id === props.activeMenu,
        );
    }

    return false;
}

function handleMenuClick(item: any) {
    if (item.children && item.children.length > 0) {
        const index = openDropdowns.value.indexOf(item.id);

        if (index > -1) openDropdowns.value.splice(index, 1);
        else openDropdowns.value.push(item.id);
    } else {
        emit('update:activeMenu', item.id);

        if (item.route) router.visit(route(item.route));
    }
}

function selectChildMenu(child: any) {
    emit('update:activeMenu', child.id);

    if (child.route) router.visit(route(child.route));
}

function toggleLocale() {
    currentLocale.value = currentLocale.value === 'az' ? 'en' : 'az';
}

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
