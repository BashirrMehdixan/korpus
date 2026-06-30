<template>
    <div>
        <div class="mb-8">
            <h1
                class="mb-1 text-xl font-semibold text-gray-900 dark:text-white"
            >
                Axşamınız xeyir, Jalə!
            </h1>
            <p class="text-sm text-gray-400 dark:text-gray-500">
                Bu gün nə etmək istərdiniz?
            </p>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="card in dashboardCards"
                :key="card.title"
                class="group cursor-pointer rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100 transition-all hover:shadow-md dark:bg-gray-800 dark:ring-gray-700 dark:hover:bg-gray-700/50"
            >
                <div
                    class="mb-4 flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-500 transition-colors dark:bg-gray-700 dark:text-gray-400"
                >
                    <component :is="card.icon" class="h-5 w-5" />
                </div>
                <h3
                    class="mb-1 text-sm font-medium text-gray-900 dark:text-gray-100"
                >
                    {{ card.title }}
                </h3>
                <p class="text-sm text-gray-400 dark:text-gray-500">
                    {{ card.description }}
                </p>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {
    RiBookOpenLine,
    RiCoinsLine,
    RiPresentationLine,
    RiTeamLine,
    RiUser3Line,
} from '@remixicon/vue';
import { shallowRef } from 'vue';

const dashboardCards = shallowRef([
    {
        title: 'Tələbələr',
        description: 'Tələbə qeydlərini görüntüləyin və idarə edin',
        icon: RiTeamLine,
    },
    {
        title: 'Müəllimlər',
        description: 'Müəllim profillərini görüntüləyin və idarə edin',
        icon: RiUser3Line,
    },
    {
        title: 'Qruplar',
        description: 'Sinf qruplarını və qeydiyyatları idarə edin',
        icon: RiPresentationLine,
    },
    {
        title: 'Kurslar',
        description: 'Kurs kataloqunu görüntüləyin və redaktə edin',
        icon: RiBookOpenLine,
    },
    {
        title: 'Maliyyə',
        description: 'Ödənişləri və fakturaları izləyin',
        icon: RiCoinsLine,
    },
]);
</script>
