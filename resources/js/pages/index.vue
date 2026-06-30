<template>
    <div class="flex min-h-screen bg-[#fcfcfd] font-sans text-slate-800">
        <!-- SIDEBAR -->
        <aside
            class="fixed z-10 flex h-full w-64 flex-col justify-between border-r border-slate-100 bg-white p-4"
        >
            <div>
                <!-- Logo -->
                <div class="mb-8 flex items-center justify-between px-2">
                    <div class="flex items-center gap-2">
                        <div
                            class="flex items-center gap-2 text-xl font-bold text-[#2b3cd4]"
                        >
                            <RiApps2Line class="h-6 w-6 text-[#2b3cd4]" />
                            <span>Korpus</span>
                        </div>
                    </div>
                    <button class="text-slate-400 hover:text-slate-600">
                        <RiArrowLeftSLine class="h-5 w-5" />
                    </button>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-1">
                    <a
                        class="flex items-center justify-between rounded-xl bg-[#eeeffd] px-3 py-2.5 font-medium text-[#2b3cd4] transition-colors"
                        href="#"
                    >
                        <div class="flex items-center gap-3">
                            <RiLayoutGridLine class="h-5 w-5" />
                            <span>Mənim Panelim</span>
                        </div>
                    </a>

                    <div
                        v-for="item in menuItems"
                        :key="item.title"
                        class="group"
                    >
                        <button
                            class="flex w-full items-center justify-between rounded-xl px-3 py-2.5 font-medium text-slate-600 transition-colors hover:bg-slate-50"
                        >
                            <div class="flex items-center gap-3">
                                <component
                                    :is="item.icon"
                                    class="h-5 w-5 text-slate-400 group-hover:text-slate-600"
                                />
                                <span>{{ item.title }}</span>
                            </div>
                            <RiArrowDownSLine
                                v-if="item.hasDropdown"
                                class="h-4 w-4 text-slate-400"
                            />
                        </button>
                    </div>
                </nav>
            </div>

            <!-- Sidebar Footer -->
            <div
                class="flex items-center gap-3 border-t border-slate-100 px-2 pt-4"
            >
                <button
                    class="rounded-full border border-slate-200 p-2 text-slate-600 hover:bg-slate-50"
                >
                    <RiMoonLine class="h-5 w-5" />
                </button>
                <button
                    class="rounded-full border border-slate-200 px-3 py-1.5 text-sm font-semibold text-slate-600 hover:bg-slate-50"
                >
                    EN
                </button>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex flex-1 flex-col pl-64">
            <!-- TOPBAR -->
            <header
                class="fixed top-0 right-0 left-64 z-10 flex h-16 items-center justify-end border-b border-slate-100 bg-white px-8"
            >
                <div class="group flex cursor-pointer items-center gap-3">
                    <span
                        class="text-sm font-medium text-slate-700 group-hover:text-slate-900"
                        >jale.salmanova</span
                    >
                    <div
                        class="flex h-8 w-8 items-center justify-center overflow-hidden rounded-full bg-blue-600 text-sm font-bold text-white"
                    >
                        <RiUser3Fill class="h-5 w-5" />
                    </div>
                </div>
            </header>

            <!-- MAIN CONTENT -->
            <main class="flex-1 px-12 pt-24 pb-12">
                <!-- Greetings -->
                <div class="mb-8">
                    <h1 class="mb-1 text-2xl font-bold text-slate-900">
                        Axşamınız xeyir, Jalə!
                    </h1>
                    <p class="text-sm text-slate-400">
                        Bu gün nə etmək istərdiniz?
                    </p>
                </div>

                <!-- DASHBOARD GRID CARDS -->
                <div
                    class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
                >
                    <div
                        v-for="card in dashboardCards"
                        :key="card.title"
                        class="flex cursor-pointer flex-col items-start rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition-shadow hover:shadow-md"
                    >
                        <!-- Card Icon with Custom Background -->
                        <div :class="`mb-4 rounded-xl p-3 ${card.bgClass}`">
                            <component
                                :is="card.icon"
                                :class="`h-6 w-6 ${card.iconColor}`"
                            />
                        </div>

                        <h3 class="mb-1 text-lg font-bold text-slate-900">
                            {{ card.title }}
                        </h3>
                        <p class="text-sm leading-relaxed text-slate-400">
                            {{ card.description }}
                        </p>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {
    RiApps2Line,
    RiArrowDownSLine,
    RiArrowLeftSLine,
    RiBookOpenLine,
    RiCoinsLine,
    RiLayoutGridLine,
    RiMoonLine,
    RiPresentationLine,
    RiTeamLine,
    RiUser3Fill,
    RiUser3Line
} from '@remixicon/vue';
import { ref } from 'vue';

// Sidebar Menusü
const menuItems = ref([
    { title: 'Tələbələr', icon: RiTeamLine, hasDropdown: true },
    { title: 'Müəllimlər', icon: RiUser3Line, hasDropdown: false },
    { title: 'Tədris', icon: RiBookOpenLine, hasDropdown: true },
    { title: 'Maliyyə', icon: RiCoinsLine, hasDropdown: true },
]);

// Əsas Səhifə Kartları (Dizayna tam uyğunlaşdırılmış rənglər)
const dashboardCards = ref([
    {
        title: 'Tələbələr',
        description: 'Tələbə qeydlərini görüntüləyin və idarə edin',
        icon: RiTeamLine,
        bgClass: 'bg-[#eeeffd]',
        iconColor: 'text-[#4f5ced]',
    },
    {
        title: 'Müəllimlər',
        description: 'Müəllim profillərini görüntüləyin və idarə edin',
        icon: RiUser3Line,
        bgClass: 'bg-[#f5eefa]',
        iconColor: 'text-[#bd59ed]',
    },
    {
        title: 'Qruplar',
        description: 'Sinf qruplarını və qeydiyyatları idarə edin',
        icon: RiPresentationLine,
        bgClass: 'bg-[#eefaf2]',
        iconColor: 'text-[#28c76f]',
    },
    {
        title: 'Kurslar',
        description: 'Kurs kataloqunu görüntüləyin və redaktə edin',
        icon: RiBookOpenLine,
        bgClass: 'bg-[#fef4ea]',
        iconColor: 'text-[#ff9f43]',
    },
    {
        title: 'Maliyyə',
        description: 'Ödənişləri və fakturaları izləyin',
        icon: RiCoinsLine,
        bgClass: 'bg-[#eefaee]',
        iconColor: 'text-[#28c76f]',
    },
]);
</script>
