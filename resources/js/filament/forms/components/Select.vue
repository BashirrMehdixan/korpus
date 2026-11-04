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
    if (Array.isArray(opts)) {
        return opts.map(item => {
            if (typeof item === 'object' && item !== null && 'value' in item) {
                return item as SelectOption
            }
            return { value: item, label: String(item) }
        })
    }
    return Object.entries(opts as Record<string, string>).map(([value, label]) => ({
        value: !isNaN(Number(value)) && String(Number(value)) === String(value) ? Number(value) : value,
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

const effectiveValue = computed(() => {
    if (props.value !== undefined && props.value !== null && props.value !== '') {
        return props.value
    }
    return props.default ?? null
})

const selectedValues = computed((): unknown[] => {
    const raw = effectiveValue.value
    if (props.isMultiple) {
        if (!raw) return []
        const arr = Array.isArray(raw) ? raw : [raw]
        return arr.map(v => (!isNaN(Number(v)) && String(Number(v)) === String(v) ? Number(v) : v))
    }
    if (raw !== null && raw !== undefined && raw !== '') {
        return [!isNaN(Number(raw)) && String(Number(raw)) === String(raw) ? Number(raw) : raw]
    }
    return []
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
    const parsedVal = !isNaN(Number(val)) && String(Number(val)) === String(val) ? Number(val) : val

    if (props.isMultiple) {
        const current = [...selectedValues.value]
        const idx = current.findIndex(v => String(v) === String(parsedVal))
        if (idx >= 0) {
            current.splice(idx, 1)
        } else {
            current.push(parsedVal)
        }
        props.onChange(current)
    } else {
        props.onChange(parsedVal)
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

onMounted(() => {
    document.addEventListener('mousedown', handleClickOutside)
    if ((props.value === undefined || props.value === null) && props.default !== undefined && props.default !== null) {
        props.onChange(props.default)
    }
})

onBeforeUnmount(() => document.removeEventListener('mousedown', handleClickOutside))
</script>

<template>
    <div
        ref="container"
        style="position: relative; width: 100%;"
        :id="props.id"
    >
        <!-- Hidden input for HTML5 form validation when required -->
        <input
            type="text"
            tabindex="-1"
            aria-hidden="true"
            :required="props.isRequired"
            :value="selectedValues.length ? 'selected' : ''"
            style="position: absolute; opacity: 0; pointer-events: none; width: 0; height: 0;"
        />

        <button
            type="button"
            :disabled="props.isDisabled"
            :aria-invalid="props.isInvalid"
            :aria-describedby="props.ariaDescribedBy ?? undefined"
            :aria-required="props.isRequired"
            class="fi-select-trigger"
            :class="{
                'is-invalid': props.isInvalid,
                'is-disabled': props.isDisabled,
                'is-open': isOpen
            }"
            @click="toggleDropdown"
            @blur="props.onBlur()"
        >
            <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.375rem; flex: 1; min-width: 0;">
                <template v-if="props.isMultiple && selectedValues.length > 0">
                    <span
                        v-for="val in selectedValues"
                        :key="String(val)"
                        class="fi-select-badge"
                    >
                        {{ getLabel(val) }}
                        <span
                            class="fi-select-badge-remove"
                            @click="removeOption(val, $event)"
                        >&times;</span>
                    </span>
                </template>
                <template v-else-if="!props.isMultiple && selectedValues.length > 0">
                    <span style="font-size: 0.875rem;">{{ getLabel(selectedValues[0]) }}</span>
                </template>
                <span v-else style="color: #9ca3af; font-size: 0.875rem;">
                    {{ props.placeholder ?? 'Seçin...' }}
                </span>
            </div>

            <div style="display: flex; align-items: center; gap: 0.375rem; margin-left: 0.5rem;">
                <button
                    v-if="selectedValues.length > 0"
                    type="button"
                    style="background: transparent; border: none; color: #9ca3af; cursor: pointer; font-size: 1rem; padding: 0 0.25rem;"
                    @click="clearSelection($event)"
                    title="Təmizlə"
                >&times;</button>
                <svg
                    style="width: 1rem; height: 1rem; color: #9ca3af; transition: transform 0.2s;"
                    :style="isOpen ? 'transform: rotate(180deg);' : ''"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </button>

        <div v-if="isOpen" class="fi-select-dropdown">
            <div v-if="props.isSearchable" class="fi-select-dropdown-search">
                <input
                    v-model="search"
                    type="text"
                    placeholder="Axtarın..."
                    class="fi-select-search-input"
                    @click.stop
                />
            </div>

            <ul style="list-style: none; margin: 0; padding: 0.25rem 0;">
                <li
                    v-for="opt in filteredOptions"
                    :key="String(opt.value)"
                    class="fi-select-item"
                    :class="{ 'is-selected': isSelected(opt.value) }"
                    @click="selectOption(opt.value)"
                >
                    <span
                        v-if="props.isMultiple"
                        style="width: 1rem; height: 1rem; border-radius: 0.25rem; border: 1px solid rgba(255, 255, 255, 0.3); display: flex; align-items: center; justify-content: center; flex-shrink: 0;"
                        :style="isSelected(opt.value) ? 'background-color: #f59e0b; border-color: #f59e0b;' : ''"
                    >
                        <svg v-if="isSelected(opt.value)" style="width: 0.75rem; height: 0.75rem; color: #ffffff;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                    <span>{{ opt.label }}</span>
                </li>
                <li v-if="filteredOptions.length === 0" style="padding: 0.75rem; font-size: 0.875rem; color: #9ca3af; text-align: center;">
                    Heç nə tapılmadı
                </li>
            </ul>
        </div>
    </div>
</template>
