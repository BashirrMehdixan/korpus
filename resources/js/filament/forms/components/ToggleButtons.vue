<script setup lang="ts">
import { computed, onMounted } from 'vue'
import type { ToggleButtonsProps, ToggleOption } from './types'

defineOptions({ inheritAttrs: false })

const props = defineProps<ToggleButtonsProps>()

const normalizedOptions = computed((): ToggleOption[] => {
    if (props.isBoolean) {
        return [
            { value: true, label: 'Aktiv' },
            { value: false, label: 'Deaktiv' },
        ]
    }
    const opts = props.options ?? {}
    if (Array.isArray(opts)) return opts as ToggleOption[]
    return Object.entries(opts as Record<string | number, string>).map(([value, label]) => ({
        value: !isNaN(Number(value)) && String(Number(value)) === String(value) ? Number(value) : value,
        label: String(label),
    }))
})

function isSelected(val: unknown): boolean {
    const rawVal = (props.value !== undefined && props.value !== null)
        ? props.value
        : (props.default ?? null)

    if (props.isBoolean) {
        const boolVal = rawVal === true || rawVal === '1' || rawVal === 1
        const targetBool = val === true || val === '1' || val === 1
        return boolVal === targetBool
    }
    if (props.isMultiple) {
        const current = Array.isArray(rawVal) ? rawVal as unknown[] : []
        return current.some(v => String(v) === String(val))
    }
    return String(rawVal) === String(val)
}

function handleClick(val: unknown): void {
    if (props.isDisabled || props.isReadOnly) return

    if (props.isMultiple) {
        const current = Array.isArray(props.value) ? [...(props.value as unknown[])] : []
        const idx = current.findIndex(v => String(v) === String(val))
        if (idx >= 0) {
            current.splice(idx, 1)
        } else {
            current.push(val)
        }
        props.onChange(current)
    } else {
        props.onChange(val)
    }
    props.onBlur()
}

onMounted(() => {
    if ((props.value === undefined || props.value === null) && props.default !== undefined && props.default !== null) {
        props.onChange(props.default)
    }
})
</script>

<template>
    <div
        :id="props.id"
        :aria-invalid="props.isInvalid"
        :aria-describedby="props.ariaDescribedBy ?? undefined"
        class="fi-toggle-group"
        :style="props.isInline ? 'display: inline-flex; flex-direction: row;' : 'display: inline-flex; flex-direction: column;'"
        role="group"
    >
        <button
            v-for="(opt, index) in normalizedOptions"
            :key="String(opt.value)"
            type="button"
            :disabled="props.isDisabled || props.isReadOnly"
            class="fi-toggle-btn"
            :class="{
                'is-active': isSelected(opt.value),
                'is-active-success': isSelected(opt.value) && (opt.value === true || opt.value === 1),
                'is-active-danger': isSelected(opt.value) && (opt.value === false || opt.value === 0),
                'is-first': index === 0,
                'is-last': index === normalizedOptions.length - 1
            }"
            @click="handleClick(opt.value)"
        >
            {{ opt.label }}
        </button>
    </div>
</template>
