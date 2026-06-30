<template>
    <header class="sticky top-0 z-10 flex h-14 items-center justify-end border-b border-gray-100 bg-white/70 px-8 backdrop-blur-lg dark:border-gray-800 dark:bg-gray-950/70">
        <div class="flex items-center gap-3">
            <span class="text-sm text-gray-400 dark:text-gray-500">jale.salmanova</span>
            <div class="flex h-7 w-7 items-center justify-center overflow-hidden rounded-full bg-gray-100 text-xs text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                <RiUser3Fill class="h-3.5 w-3.5" />
            </div>
        </div>
    </header>
</template>
<script lang="ts" setup>
import { RiUser3Fill } from '@remixicon/vue';
</script>