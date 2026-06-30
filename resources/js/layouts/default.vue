<template>
    <div
        class="flex min-h-screen bg-gray-50 text-gray-900 antialiased dark:bg-gray-900 dark:text-gray-100"
    >
        <Sidebar
            v-model:activeMenu="currentMenu"
            v-model:collapsed="isCollapsed"
        />
        <div class="flex min-h-screen flex-1 flex-col">
            <HeaderComponent />
            <main class="flex-1 p-8">
                <slot />
            </main>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import HeaderComponent from '@/components/layouts/header.vue';
import Sidebar from '@/components/layouts/sidebar.vue';

const currentMenu = ref<number | string | null>(null);
const isCollapsed = ref(false);
</script>
