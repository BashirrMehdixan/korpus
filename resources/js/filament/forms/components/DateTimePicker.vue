<script setup lang="ts">
import type { DateTimePickerProps } from './types'

defineOptions({ inheritAttrs: false })

const props = defineProps<DateTimePickerProps>()

function toInputValue(val: unknown): string {
    if (!val) return ''
    return String(val).replace(' ', 'T').substring(0, 16)
}

function handleChange(event: Event): void {
    const val = (event.target as HTMLInputElement).value
    if (!val) {
        props.onChange(null)
        return
    }
    props.onChange(val.replace('T', ' ') + ':00')
}
</script>

<template>
    <div class="custom-datetime-wrapper" :class="{ 'is-invalid': props.isInvalid, 'is-disabled': props.isDisabled }">
        <input :id="props.id" type="datetime-local" :value="toInputValue(props.value)" :disabled="props.isDisabled"
            :readonly="props.isReadOnly" :required="props.isRequired" :aria-invalid="props.isInvalid"
            :aria-describedby="props.ariaDescribedBy" :min="props.minDate ?? undefined"
            :max="props.maxDate ?? undefined" class="custom-datetime-input" @change="handleChange"
            @blur="props.onBlur()" />
    </div>
</template>

<style scoped>
.custom-datetime-wrapper {
    display: flex;
    align-items: center;
    width: 100%;
    min-height: 2.375rem;
    border-radius: 0.5rem;
    border: 1px solid rgba(255, 255, 255, 0.15);
    background-color: rgba(255, 255, 255, 0.05);
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    transition: border-color 0.15s, box-shadow 0.15s;
    overflow: hidden;
}

:root:not(.dark) .custom-datetime-wrapper {
    border: 1px solid #d1d5db;
    background-color: #ffffff;
}

.custom-datetime-wrapper:focus-within {
    border-color: #f59e0b;
    box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.25);
}

.custom-datetime-wrapper.is-invalid {
    border-color: #ef4444;
}

.custom-datetime-wrapper.is-disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.custom-datetime-input {
    flex: 1;
    width: 100%;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.25rem;
    color: #ffffff;
    background: transparent;
    border: none;
    outline: none;
    color-scheme: dark;
}

:root:not(.dark) .custom-datetime-input {
    color: #111827;
    color-scheme: light;
}

.custom-datetime-input:disabled {
    cursor: not-allowed;
}
</style>
