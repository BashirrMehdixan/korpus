<script setup lang="ts">
import { ref } from 'vue'

defineOptions({ inheritAttrs: false })

export interface SerializedEntry {
    type: 'entry'
    name: string
    label?: string
    state?: any
    isBadge?: boolean
    color?: string
    icon?: string
    isCopyable?: boolean
    columns?: any
    columnSpan?: any
    [key: string]: any
}

export interface SerializedInfolistSection {
    type: 'section' | 'fieldset' | 'grid' | 'group'
    heading?: string
    description?: string
    columns?: any
    columnSpan?: any
    schema: Array<SerializedInfolistSection | SerializedEntry>
    [key: string]: any
}

const props = defineProps<{
    configuration?: {
        columns?: any
        columnSpan?: any
        schema?: Array<SerializedInfolistSection | SerializedEntry>
        [key: string]: any
    }
    utilities?: any
    id?: string | null
}>()

const isFullscreen = ref(false)
const copiedField = ref<string | null>(null)

function copyToClipboard(name: string, text: string): void {
    if (!text) return
    navigator.clipboard?.writeText(String(text))
    copiedField.value = name
    setTimeout(() => {
        if (copiedField.value === name) {
            copiedField.value = null
        }
    }, 2000)
}

function getGridStyle(cols: any): Record<string, string> {
    let count = 1
    if (typeof cols === 'number') {
        count = cols
    } else if (cols && typeof cols === 'object') {
        count = cols.lg ?? cols.md ?? cols.default ?? 1
    }
    return {
        display: 'grid',
        gridTemplateColumns: `repeat(${count}, minmax(0, 1fr))`,
        gap: '1.5rem',
    }
}

function getColumnSpanStyle(span: any): Record<string, string> {
    if (!span) return {}
    if (span === 'full' || (typeof span === 'object' && span.default === 'full')) {
        return { gridColumn: '1 / -1' }
    }
    const val = typeof span === 'object' ? (span.lg ?? span.md ?? span.default) : span
    if (val === 'full') {
        return { gridColumn: '1 / -1' }
    }
    const num = Number(val)
    if (!isNaN(num) && num > 0) {
        return { gridColumn: `span ${num} / span ${num}` }
    }
    return {}
}

function getBadgeClass(val: any): string {
    const s = String(val).toLowerCase()
    if (s.includes('aktiv') || s.includes('ödanildi') || s.includes('ödənildi') || s.includes('paid') || s.includes('true')) {
        return 'is-success'
    }
    if (s.includes('passiv') || s.includes('deaktiv') || s.includes('failed') || s.includes('false')) {
        return 'is-danger'
    }
    if (s.includes('gözləyir') || s.includes('pending') || s.includes('waiting')) {
        return 'is-warning'
    }
    return 'is-primary'
}
</script>

<template>
    <div class="fi-js-dynamic-infolist" :class="{ 'is-fullscreen': isFullscreen }">
        <div v-for="(item, index) in props.configuration?.schema || []" :key="index"
            :style="getColumnSpanStyle(item.columnSpan)">
            
            <!-- INFOLIST SECTION -->
            <div v-if="item.type === 'section'" class="fi-infolist-card">
                <!-- Section Header -->
                <div v-if="item.heading" class="fi-infolist-header">
                    <div class="fi-header-left">
                        <div class="fi-header-badge-icon">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="fi-infolist-title">{{ item.heading }}</h3>
                            <p v-if="item.description" class="fi-infolist-desc">{{ item.description }}</p>
                        </div>
                    </div>

                    <div class="fi-header-right">
                        <button type="button" class="fi-infolist-pill-btn" :title="isFullscreen ? 'Pəncərəyə qayıt' : 'Tam ekran rejimi'"
                            @click="isFullscreen = !isFullscreen">
                            <svg v-if="isFullscreen" style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 9L4 4m0 0l5 0m-5 0l0 5m11 0l0-5m0 0l-5 0m5 0l5 5M9 15l-5 5m0 0l5 0m-5 0l0-5m11 0l0 5m0 0l-5 0m5 0l5-5" />
                            </svg>
                            <svg v-else style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 8V4m0 0h4M4 4l5 5m11-5h-4m4 0v4m0 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                            </svg>
                            <span>{{ isFullscreen ? 'Kiçilt' : 'Tam ekran' }}</span>
                        </button>
                    </div>
                </div>

                <!-- Grid entries -->
                <div :style="getGridStyle(item.columns)">
                    <template v-for="(entry, entryIdx) in item.schema || []" :key="entryIdx">
                        <div v-if="entry.type === 'entry'" class="fi-infolist-entry" :style="getColumnSpanStyle(entry.columnSpan)">
                            <div class="fi-entry-label-row">
                                <span class="fi-entry-label">{{ entry.label || entry.name }}</span>
                                <button v-if="entry.isCopyable && entry.state" type="button" class="fi-copy-btn"
                                    :title="copiedField === entry.name ? 'Kopyalandı!' : 'Kopyala'"
                                    @click="copyToClipboard(entry.name, entry.state)">
                                    <svg v-if="copiedField === entry.name" style="width: 0.85rem; height: 0.85rem; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <svg v-else style="width: 0.85rem; height: 0.85rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="fi-entry-value-box">
                                <!-- Badge mode -->
                                <template v-if="entry.isBadge">
                                    <template v-if="Array.isArray(entry.state)">
                                        <div class="fi-entry-chips-row">
                                            <span v-for="(tag, tagIdx) in entry.state" :key="tagIdx" class="fi-entry-badge" :class="getBadgeClass(tag)">
                                                {{ tag }}
                                            </span>
                                        </div>
                                    </template>
                                    <span v-else-if="entry.state !== null && entry.state !== undefined && entry.state !== ''"
                                        class="fi-entry-badge" :class="getBadgeClass(entry.state)">
                                        {{ entry.state }}
                                    </span>
                                    <span v-else class="fi-entry-empty">-</span>
                                </template>

                                <!-- Array list mode -->
                                <template v-else-if="Array.isArray(entry.state)">
                                    <div v-if="entry.state.length > 0" class="fi-entry-chips-row">
                                        <span v-for="(tag, tagIdx) in entry.state" :key="tagIdx" class="fi-entry-chip">
                                            {{ tag }}
                                        </span>
                                    </div>
                                    <span v-else class="fi-entry-empty">-</span>
                                </template>

                                <!-- Regular text mode -->
                                <template v-else>
                                    <span v-if="entry.state !== null && entry.state !== undefined && entry.state !== ''" class="fi-entry-text">
                                        {{ entry.state }}
                                    </span>
                                    <span v-else class="fi-entry-empty">-</span>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

