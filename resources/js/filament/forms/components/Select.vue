<script setup lang="ts">
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import type { SelectOption, SelectProps } from './types'

defineOptions({ inheritAttrs: false })

const props = defineProps<SelectProps>()

const search = ref<string>('')
const isOpen = ref<boolean>(false)
const container = ref<HTMLElement | null>(null)

const normalizedOptions = computed((): SelectOption[] => {
    const opts = props.options ?? {}
    if (Array.isArray(opts)) return opts as SelectOption[]
    return Object.entries(opts as Record<string, string>).map(([value, label]) => ({
        value,
        label: String(label),
    }))
})

const filteredOptions = computed((): SelectOption[] => {
    if (!search.value) return normalizedOptions.value
    const term = search.value.toLowerCase()
    return normalizedOptions.value.filter(o =>
        String(o.label).toLowerCase().includes(term)
    )
})

const selectedValues = computed((): unknown[] => {
    if (props.isMultiple) {
        if (!props.value) return []
        return Array.isArray(props.value) ? props.value : [props.value]
    }
    return props.value !== null && props.value !== undefined && props.value !== ''
        ? [props.value]
        : []
})

function getLabel(val: unknown): string {
    const opt = normalizedOptions.value.find(o => String(o.value) === String(val))
    return opt ? String(opt.label) : String(val)
}

function isSelected(val: unknown): boolean {
    return selectedValues.value.some(v => String(v) === String(val))
}

function selectOption(val: unknown): void {
    if (props.isDisabled || props.isReadOnly) return
    if (props.isMultiple) {
        const current = [...selectedValues.value]
        const idx = current.findIndex(v => String(v) === String(val))
        if (idx >= 0) {
            current.splice(idx, 1)
        } else {
            current.push(val)
        }
        props.onChange(current)
    } else {
        props.onChange(val)
        isOpen.value = false
        search.value = ''
    }
}

function removeOption(val: unknown, event?: Event): void {
    if (event) event.stopPropagation()
    if (props.isDisabled || props.isReadOnly) return
    if (props.isMultiple) {
        const current = selectedValues.value.filter(v => String(v) !== String(val))
        props.onChange(current)
    } else {
        props.onChange(null)
    }
}

function clearSelection(event?: Event): void {
    if (event) event.stopPropagation()
    props.onChange(props.isMultiple ? [] : null)
}

function toggleDropdown(): void {
    if (props.isDisabled || props.isReadOnly) return
    isOpen.value = !isOpen.value
    if (isOpen.value) search.value = ''
}

function handleClickOutside(event: MouseEvent): void {
    if (container.value && !container.value.contains(event.target as Node)) {
        isOpen.value = false
    }
}

onMounted(() => document.addEventListener('mousedown', handleClickOutside))
onBeforeUnmount(() => document.removeEventListener('mousedown', handleClickOutside))
</script>

<template>
    <div
        ref="container"
        class="custom-select-container"
        :id="props.id"
    >
        <button
            type="button"
            :disabled="props.isDisabled"
            :aria-invalid="props.isInvalid"
            :aria-describedby="props.ariaDescribedBy"
            :aria-required="props.isRequired"
            class="custom-select-trigger"
            :class="{
                'is-invalid': props.isInvalid,
                'is-disabled': props.isDisabled,
                'is-open': isOpen
            }"
            @click="toggleDropdown"
            @blur="props.onBlur()"
        >
            <div class="custom-select-content">
                <template v-if="props.isMultiple && selectedValues.length > 0">
                    <span
                        v-for="val in selectedValues"
                        :key="String(val)"
                        class="select-badge"
                    >
                        {{ getLabel(val) }}
                        <span
                            class="badge-remove"
                            @click="removeOption(val, $event)"
                        >&times;</span>
                    </span>
                </template>
                <template v-else-if="!props.isMultiple && selectedValues.length > 0">
                    <span class="select-single-value">{{ getLabel(selectedValues[0]) }}</span>
                </template>
                <span v-else class="select-placeholder">
                    {{ props.placeholder ?? 'Seçin...' }}
                </span>
            </div>

            <div class="select-actions">
                <button
                    v-if="selectedValues.length > 0"
                    type="button"
                    class="btn-clear"
                    @click="clearSelection($event)"
                    title="Təmizlə"
                >&times;</button>
                <svg
                    class="chevron-icon"
                    :class="{ 'rotate-180': isOpen }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </button>

        <div v-if="isOpen" class="custom-select-dropdown">
            <div v-if="props.isSearchable" class="dropdown-search">
                <input
                    v-model="search"
                    type="text"
                    placeholder="Axtarın..."
                    class="search-input"
                    @click.stop
                />
            </div>

            <ul class="dropdown-list">
                <li
                    v-for="opt in filteredOptions"
                    :key="String(opt.value)"
                    class="dropdown-item"
                    :class="{ 'is-selected': isSelected(opt.value) }"
                    @click="selectOption(opt.value)"
                >
                    <span v-if="props.isMultiple" class="item-checkbox" :class="{ 'checked': isSelected(opt.value) }">
                        <svg v-if="isSelected(opt.value)" class="check-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                    <span class="item-label">{{ opt.label }}</span>
                </li>
                <li v-if="filteredOptions.length === 0" class="dropdown-empty">
                    Heç nə tapılmadı
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped>
.custom-select-container {
    position: relative;
    width: 100%;
}
.custom-select-trigger {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    min-height: 2.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 0.5rem;
    border: 1px solid rgba(255, 255, 255, 0.15);
    background-color: rgba(255, 255, 255, 0.05);
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    transition: border-color 0.15s, box-shadow 0.15s;
    text-align: left;
    cursor: pointer;
}
:root:not(.dark) .custom-select-trigger {
    border: 1px solid #d1d5db;
    background-color: #ffffff;
}
.custom-select-trigger:focus,
.custom-select-trigger.is-open {
    outline: none;
    border-color: #f59e0b;
    box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.25);
}
.custom-select-trigger.is-invalid {
    border-color: #ef4444;
}
.custom-select-trigger.is-disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
.custom-select-content {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.375rem;
    flex: 1;
    min-width: 0;
}
.select-placeholder {
    color: #6b7280;
    font-size: 0.875rem;
}
.select-single-value {
    color: #ffffff;
    font-size: 0.875rem;
}
:root:not(.dark) .select-single-value {
    color: #111827;
}
.select-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.125rem 0.5rem;
    background-color: rgba(245, 158, 11, 0.2);
    color: #fbbf24;
    border: 1px solid rgba(245, 158, 11, 0.3);
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 500;
}
.badge-remove {
    cursor: pointer;
    font-size: 0.875rem;
    line-height: 1;
    color: #f59e0b;
}
.badge-remove:hover {
    color: #ffffff;
}
.select-actions {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    margin-left: 0.5rem;
}
.btn-clear {
    background: transparent;
    border: none;
    color: #9ca3af;
    cursor: pointer;
    font-size: 1rem;
    padding: 0 0.25rem;
}
.btn-clear:hover {
    color: #ffffff;
}
.chevron-icon {
    width: 1rem;
    height: 1rem;
    color: #9ca3af;
    transition: transform 0.2s;
}
.chevron-icon.rotate-180 {
    transform: rotate(180deg);
}
.custom-select-dropdown {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    right: 0;
    z-index: 50;
    background-color: #18181b;
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 0.5rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
    max-height: 15rem;
    overflow-y: auto;
}
:root:not(.dark) .custom-select-dropdown {
    background-color: #ffffff;
    border: 1px solid #d1d5db;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}
.dropdown-search {
    padding: 0.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}
:root:not(.dark) .dropdown-search {
    border-bottom: 1px solid #e5e7eb;
}
.search-input {
    width: 100%;
    padding: 0.375rem 0.5rem;
    border-radius: 0.375rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    background-color: rgba(255, 255, 255, 0.05);
    color: #ffffff;
    font-size: 0.8125rem;
    outline: none;
}
:root:not(.dark) .search-input {
    border: 1px solid #d1d5db;
    background-color: #f9fafb;
    color: #111827;
}
.search-input:focus {
    border-color: #f59e0b;
}
.dropdown-list {
    list-style: none;
    margin: 0;
    padding: 0.25rem 0;
}
.dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    color: #e5e7eb;
    cursor: pointer;
    transition: background-color 0.1s;
}
:root:not(.dark) .dropdown-item {
    color: #374151;
}
.dropdown-item:hover {
    background-color: rgba(245, 158, 11, 0.15);
    color: #ffffff;
}
:root:not(.dark) .dropdown-item:hover {
    background-color: #fef3c7;
    color: #92400e;
}
.dropdown-item.is-selected {
    background-color: rgba(245, 158, 11, 0.25);
    color: #f59e0b;
    font-weight: 500;
}
.item-checkbox {
    width: 1rem;
    height: 1rem;
    border-radius: 0.25rem;
    border: 1px solid rgba(255, 255, 255, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.item-checkbox.checked {
    background-color: #f59e0b;
    border-color: #f59e0b;
}
.check-icon {
    width: 0.75rem;
    height: 0.75rem;
    color: #ffffff;
}
.dropdown-empty {
    padding: 0.75rem;
    font-size: 0.875rem;
    color: #6b7280;
    text-align: center;
}
</style>
