<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue'

defineOptions({ inheritAttrs: false })

export interface SerializedField {
    type: 'field'
    fieldType: 'text' | 'select' | 'toggle-buttons' | 'textarea' | 'date-time-picker' | 'date-picker'
    name: string
    statePath?: string
    label?: string
    required?: boolean
    disabled?: boolean
    readOnly?: boolean
    placeholder?: string
    helperText?: string
    hint?: string
    default?: any
    inputType?: string
    maxLength?: number
    prefix?: string
    suffix?: string
    multiple?: boolean
    searchable?: boolean
    options?: Array<{ value: number | string; label: string }>
    inline?: boolean
    rows?: number
    columns?: any
    columnSpan?: any
    [key: string]: any
}

export interface SerializedContainer {
    type: 'section' | 'fieldset' | 'grid' | 'group'
    heading?: string
    description?: string
    collapsible?: boolean
    collapsed?: boolean
    columns?: any
    columnSpan?: any
    schema: Array<SerializedContainer | SerializedField>
    [key: string]: any
}

const props = defineProps<{
    configuration?: {
        columns?: any
        columnSpan?: any
        schema?: Array<SerializedContainer | SerializedField>
        roles?: Array<{ value: number | string; label: string }>
        [key: string]: any
    }
    utilities?: {
        $get: (path: string, isAbsolute?: boolean) => any
        $set: (path: string, value: any, isAbsolute?: boolean, isLive?: boolean) => Promise<any>
        $wire: any
        $state: any
        $statePath: string | null
    }
    id?: string | null
}>()

// Reactive form state
const form = ref<Record<string, any>>({})
const isFullscreen = ref(false)
const revealedPasswords = ref<Record<string, boolean>>({})
const openDropdowns = ref<Record<string, boolean>>({})
const searchQueries = ref<Record<string, string>>({})

// Collect all fields recursively
function collectFields(items?: Array<SerializedContainer | SerializedField>): SerializedField[] {
    if (!items) return []
    const result: SerializedField[] = []
    for (const item of items) {
        if (item.type === 'field') {
            result.push(item)
        } else if (item.schema) {
            result.push(...collectFields(item.schema))
        }
    }
    return result
}

const allFields = computed(() => collectFields(props.configuration?.schema))

// Initialize form values from Livewire state or field defaults
onMounted(() => {
    initFormState()
})

watch(() => props.configuration, () => {
    initFormState()
}, { deep: true })

function initFormState() {
    for (const field of allFields.value) {
        let val = props.utilities?.$get(field.name)

        if (val === undefined || val === null) {
            val = field.default ?? (field.fieldType === 'select' && field.multiple ? [] : '')
            if (val !== '' && val !== null && val !== undefined) {
                updateField(field.name, val)
            }
        }
        form.value[field.name] = val
    }
}

function updateField(name: string, val: any): void {
    form.value[name] = val
    if (props.utilities?.$set) {
        props.utilities.$set(name, val)
    }
}

function togglePassword(name: string): void {
    revealedPasswords.value[name] = !revealedPasswords.value[name]
}

function toggleDropdown(name: string, event: Event): void {
    event.stopPropagation()
    openDropdowns.value[name] = !openDropdowns.value[name]
}

function closeDropdowns(): void {
    openDropdowns.value = {}
}

function toggleSelectOption(name: string, optionValue: number | string, isMultiple?: boolean): void {
    if (isMultiple) {
        const current = Array.isArray(form.value[name]) ? [...form.value[name]] : []
        const idx = current.findIndex(v => String(v) === String(optionValue))
        if (idx >= 0) {
            current.splice(idx, 1)
        } else {
            current.push(optionValue)
        }
        updateField(name, current)
    } else {
        updateField(name, optionValue)
        openDropdowns.value[name] = false
    }
}

function removeSelectOption(name: string, optionValue: number | string, event: Event): void {
    event.stopPropagation()
    const current = (form.value[name] || []).filter((v: any) => String(v) !== String(optionValue))
    updateField(name, current)
}

function getOptionLabel(options: Array<{ value: number | string; label: string }> | undefined, val: any, fieldName?: string): string {
    const list: Array<{ value: number | string; label: string }> = (options && options.length > 0)
        ? options
        : (fieldName === 'roles' ? (props.configuration?.roles || []) : [])
    if (!list || list.length === 0) return String(val)
    const found = list.find((o: { value: number | string; label: string }) => String(o.value) === String(val))
    return found ? found.label : String(val)
}

function getFilteredOptions(field: SerializedField): Array<{ value: number | string; label: string }> {
    const opts: Array<{ value: number | string; label: string }> = (field.options && field.options.length > 0)
        ? field.options
        : (field.name === 'roles' ? (props.configuration?.roles || []) : [])
    const q = (searchQueries.value[field.name] || '').toLowerCase().trim()
    if (!q) return opts
    return opts.filter((o: { value: number | string; label: string }) => o.label.toLowerCase().includes(q))
}

// Dynamic grid & column span helpers
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
</script>

<template>
    <div class="fi-js-dynamic-form" :class="{ 'is-fullscreen': isFullscreen }" @click="closeDropdowns">
        <!-- Render schema elements -->
        <div v-for="(item, index) in props.configuration?.schema || []" :key="index"
            :style="getColumnSpanStyle(item.columnSpan)">
            
            <!-- MODERN GLASS SECTION / CONTAINER -->
            <div v-if="item.type === 'section' || item.type === 'fieldset' || item.type === 'group'" class="fi-modern-card">
                
                <!-- Section Header with Glowing Icon & Controls -->
                <div v-if="item.heading" class="fi-modern-header">
                    <div class="fi-header-left">
                        <div class="fi-header-badge-icon">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="fi-modern-title">{{ item.heading }}</h3>
                            <p v-if="item.description" class="fi-modern-desc">{{ item.description }}</p>
                        </div>
                    </div>

                    <!-- Fullscreen & action controls -->
                    <div class="fi-header-right">
                        <button type="button" class="fi-modern-pill-btn" :title="isFullscreen ? 'Pəncərə rejiminə qayıt' : 'Tam ekran rejimi'"
                            @click.stop="isFullscreen = !isFullscreen">
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

                <!-- Modern Grid Area -->
                <div :style="getGridStyle(item.columns)">
                    <template v-for="(child, childIdx) in item.schema || []" :key="childIdx">
                        <!-- Nested Field -->
                        <div v-if="child.type === 'field'" class="fi-modern-field" :style="getColumnSpanStyle(child.columnSpan)">
                            
                            <!-- Field Label with optional Required Dot -->
                            <div class="fi-modern-label-row">
                                <label v-if="child.label" class="fi-modern-label">
                                    {{ child.label }}
                                </label>
                                <span v-if="child.required" class="fi-modern-required-dot" title="Vacib xana">•</span>
                            </div>

                            <!-- TEXT INPUT -->
                            <div v-if="child.fieldType === 'text'" class="fi-modern-input-wrp">
                                <span v-if="child.prefix" class="fi-modern-affix">{{ child.prefix }}</span>
                                <input :type="child.inputType === 'password' && revealedPasswords[child.name] ? 'text' : (child.inputType || 'text')"
                                    :value="form[child.name] ?? ''" :placeholder="child.placeholder || ''"
                                    :required="child.required" :disabled="child.disabled" :readonly="child.readOnly"
                                    :maxlength="child.maxLength || undefined" class="fi-modern-input"
                                    @input="updateField(child.name, ($event.target as HTMLInputElement).value)" />
                                
                                <!-- Password eye reveal button -->
                                <button v-if="child.inputType === 'password'" type="button" class="fi-modern-eye-btn"
                                    tabindex="-1" @click="togglePassword(child.name)">
                                    <svg v-if="revealedPasswords[child.name]" style="width: 1.125rem; height: 1.125rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                    </svg>
                                    <svg v-else style="width: 1.125rem; height: 1.125rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <span v-if="child.suffix" class="fi-modern-affix">{{ child.suffix }}</span>
                            </div>

                            <!-- SELECT INPUT (Pill & Glass dropdown) -->
                            <div v-else-if="child.fieldType === 'select'" class="fi-modern-select-box">
                                <div class="fi-modern-input-wrp fi-modern-select-trigger" @click="toggleDropdown(child.name, $event)">
                                    <div class="fi-modern-select-chips">
                                        <template v-if="child.multiple && Array.isArray(form[child.name]) && form[child.name].length > 0">
                                            <span v-for="val in form[child.name]" :key="val" class="fi-modern-chip">
                                                {{ getOptionLabel(child.options, val, child.name) }}
                                                <button type="button" class="fi-modern-chip-remove" @click="removeSelectOption(child.name, val, $event)">&times;</button>
                                            </span>
                                        </template>
                                        <template v-else-if="!child.multiple && form[child.name] !== undefined && form[child.name] !== null && form[child.name] !== ''">
                                            <span class="fi-modern-selected-text">{{ getOptionLabel(child.options, form[child.name], child.name) }}</span>
                                        </template>
                                        <span v-else class="fi-modern-placeholder">{{ child.placeholder || 'Seçin...' }}</span>
                                    </div>
                                    <div class="fi-modern-arrow-icon" :class="{ 'is-flipped': openDropdowns[child.name] }">
                                        <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Glass Dropdown Menu -->
                                <div v-if="openDropdowns[child.name]" class="fi-modern-dropdown-menu" @click.stop>
                                    <div v-if="child.searchable" class="fi-modern-search-header">
                                        <svg style="width: 0.875rem; height: 0.875rem; color: #71717a;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        <input v-model="searchQueries[child.name]" type="text" placeholder="Axtarış..." class="fi-modern-search-input" />
                                    </div>
                                    <div class="fi-modern-options-scroll">
                                        <div v-for="opt in getFilteredOptions(child)" :key="opt.value"
                                            class="fi-modern-option-row"
                                            :class="{ 'is-active': child.multiple ? (Array.isArray(form[child.name]) && form[child.name].some((v: any) => String(v) === String(opt.value))) : String(form[child.name]) === String(opt.value) }"
                                            @click="toggleSelectOption(child.name, opt.value, child.multiple)">
                                            <div v-if="child.multiple" class="fi-modern-check-box"
                                                :class="{ checked: Array.isArray(form[child.name]) && form[child.name].some((v: any) => String(v) === String(opt.value)) }">
                                                <svg v-if="Array.isArray(form[child.name]) && form[child.name].some((v: any) => String(v) === String(opt.value))"
                                                    style="width: 0.75rem; height: 0.75rem;" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <span class="fi-modern-opt-text">{{ opt.label }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TOGGLE BUTTONS (Segmented Switch Capsule) -->
                            <div v-else-if="child.fieldType === 'toggle-buttons'" class="fi-modern-segmented-switch">
                                <button v-for="opt in child.options || []" :key="opt.value" type="button"
                                    class="fi-modern-switch-btn"
                                    :class="{
                                        'is-active-primary': String(form[child.name]) === String(opt.value) && String(opt.value) !== '1' && String(opt.value) !== '0',
                                        'is-active-success': String(form[child.name]) === String(opt.value) && String(opt.value) === '1',
                                        'is-active-danger': String(form[child.name]) === String(opt.value) && String(opt.value) === '0',
                                    }"
                                    @click="updateField(child.name, opt.value)">
                                    <span class="fi-switch-dot"></span>
                                    <span>{{ opt.label }}</span>
                                </button>
                            </div>

                            <!-- TEXTAREA -->
                            <div v-else-if="child.fieldType === 'textarea'" class="fi-modern-input-wrp fi-modern-textarea-wrp">
                                <textarea :value="form[child.name] ?? ''" :placeholder="child.placeholder || ''"
                                    :rows="child.rows || 4" :required="child.required" :disabled="child.disabled"
                                    class="fi-modern-textarea"
                                    @input="updateField(child.name, ($event.target as HTMLTextAreaElement).value)"></textarea>
                            </div>

                            <!-- DATE TIME PICKER -->
                            <div v-else-if="child.fieldType === 'date-time-picker'" class="fi-modern-input-wrp">
                                <input type="datetime-local" :value="form[child.name] ?? ''" :required="child.required"
                                    :disabled="child.disabled" class="fi-modern-input"
                                    @input="updateField(child.name, ($event.target as HTMLInputElement).value)" />
                            </div>

                            <!-- DATE PICKER -->
                            <div v-else-if="child.fieldType === 'date-picker'" class="fi-modern-input-wrp">
                                <input type="date" :value="form[child.name] ?? ''" :required="child.required"
                                    :disabled="child.disabled" class="fi-modern-input"
                                    @input="updateField(child.name, ($event.target as HTMLInputElement).value)" />
                            </div>

                            <p v-if="child.helperText" class="fi-modern-helper-text">{{ child.helperText }}</p>
                        </div>
                    </template>
                </div>
            </div>

            <!-- STANDALONE FIELD (Root Level) -->
            <div v-else-if="item.type === 'field'" class="fi-modern-field" :style="getColumnSpanStyle(item.columnSpan)">
                <div class="fi-modern-label-row">
                    <label v-if="item.label" class="fi-modern-label">
                        {{ item.label }}
                    </label>
                    <span v-if="item.required" class="fi-modern-required-dot">•</span>
                </div>
                <div v-if="item.fieldType === 'text'" class="fi-modern-input-wrp">
                    <input :type="item.inputType || 'text'" :value="form[item.name] ?? ''" :placeholder="item.placeholder || ''"
                        :required="item.required" :disabled="item.disabled" class="fi-modern-input"
                        @input="updateField(item.name, ($event.target as HTMLInputElement).value)" />
                </div>
            </div>
        </div>
    </div>
</template>
