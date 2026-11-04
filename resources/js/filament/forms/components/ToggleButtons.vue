<script setup lang="ts">
import { computed } from 'vue'
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
        value: isNaN(Number(value)) ? value : Number(value),
        label: String(label),
    }))
})

function isSelected(val: unknown): boolean {
    if (props.isBoolean) {
        const boolVal = props.value === true || props.value === '1' || props.value === 1
        const targetBool = val === true || val === '1' || val === 1
        return boolVal === targetBool
    }
    if (props.isMultiple) {
        const current = Array.isArray(props.value) ? props.value as unknown[] : []
        return current.some(v => String(v) === String(val))
    }
    return String(props.value) === String(val)
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
</script>

<template>
    <div
        :id="props.id"
        :aria-invalid="props.isInvalid"
        :aria-describedby="props.ariaDescribedBy"
        class="toggle-buttons-group"
        :class="{ 'is-inline': props.isInline, 'is-vertical': !props.isInline }"
        role="group"
    >
        <button
            v-for="(opt, index) in normalizedOptions"
            :key="String(opt.value)"
            type="button"
            :disabled="props.isDisabled || props.isReadOnly"
            class="toggle-btn"
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

<style scoped>
.toggle-buttons-group {
    display: inline-flex;
    border-radius: 0.5rem;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}
.toggle-buttons-group.is-inline {
    flex-direction: row;
}
.toggle-buttons-group.is-vertical {
    flex-direction: column;
}
.toggle-btn {
    padding: 0.375rem 0.875rem;
    font-size: 0.875rem;
    font-weight: 500;
    line-height: 1.25rem;
    border: 1px solid rgba(255, 255, 255, 0.15);
    background-color: rgba(255, 255, 255, 0.05);
    color: #9ca3af;
    cursor: pointer;
    transition: all 0.15s;
    user-select: none;
}
:root:not(.dark) .toggle-btn {
    border: 1px solid #d1d5db;
    background-color: #ffffff;
    color: #4b5563;
}
.toggle-btn:not(:first-child) {
    margin-left: -1px;
}
.toggle-buttons-group.is-inline .toggle-btn.is-first {
    border-top-left-radius: 0.5rem;
    border-bottom-left-radius: 0.5rem;
}
.toggle-buttons-group.is-inline .toggle-btn.is-last {
    border-top-right-radius: 0.5rem;
    border-bottom-right-radius: 0.5rem;
}
.toggle-buttons-group.is-vertical .toggle-btn.is-first {
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
}
.toggle-buttons-group.is-vertical .toggle-btn.is-last {
    border-bottom-left-radius: 0.5rem;
    border-bottom-right-radius: 0.5rem;
}
.toggle-btn:hover:not(:disabled) {
    background-color: rgba(255, 255, 255, 0.1);
    color: #ffffff;
}
:root:not(.dark) .toggle-btn:hover:not(:disabled) {
    background-color: #f3f4f6;
    color: #111827;
}
.toggle-btn.is-active {
    background-color: #f59e0b;
    border-color: #f59e0b;
    color: #ffffff;
    z-index: 10;
}
.toggle-btn.is-active-success {
    background-color: #10b981;
    border-color: #10b981;
    color: #ffffff;
    z-index: 10;
}
.toggle-btn.is-active-danger {
    background-color: #ef4444;
    border-color: #ef4444;
    color: #ffffff;
    z-index: 10;
}
.toggle-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>
