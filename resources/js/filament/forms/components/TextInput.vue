<script setup lang="ts">
import type { TextInputProps } from './types'

defineOptions({ inheritAttrs: false })

const props = defineProps<TextInputProps>()

function handleInput(event: Event): void {
    let val: string | number | null = (event.target as HTMLInputElement).value
    if (props.type === 'number') {
        val = val === '' ? null : Number(val)
    }
    props.onChange(val)
}
</script>

<template>
    <div
        class="custom-field-wrapper"
        :class="{ 'is-invalid': props.isInvalid, 'is-disabled': props.isDisabled }"
    >
        <span v-if="props.prefix" class="field-affix field-prefix">{{ props.prefix }}</span>
        <input
            :id="props.id"
            :type="props.type ?? 'text'"
            :value="props.value ?? ''"
            :disabled="props.isDisabled"
            :readonly="props.isReadOnly"
            :required="props.isRequired"
            :aria-invalid="props.isInvalid"
            :aria-describedby="props.ariaDescribedBy"
            :placeholder="props.placeholder ?? ''"
            :maxlength="props.maxLength ?? undefined"
            :min="props.minValue ?? undefined"
            :step="props.step ?? undefined"
            class="custom-field-input"
            @input="handleInput"
            @blur="props.onBlur()"
        />
        <span v-if="props.suffix" class="field-affix field-suffix">{{ props.suffix }}</span>
    </div>
</template>

<style scoped>
.custom-field-wrapper {
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
:root:not(.dark) .custom-field-wrapper {
    border: 1px solid #d1d5db;
    background-color: #ffffff;
}
.custom-field-wrapper:focus-within {
    border-color: #f59e0b;
    box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.25);
}
.custom-field-wrapper.is-invalid {
    border-color: #ef4444;
}
.custom-field-wrapper.is-disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
.field-affix {
    padding: 0 0.75rem;
    font-size: 0.875rem;
    color: #9ca3af;
    background-color: rgba(255, 255, 255, 0.05);
    display: flex;
    align-items: center;
    user-select: none;
}
.field-prefix {
    border-right: 1px solid rgba(255, 255, 255, 0.1);
}
.field-suffix {
    border-left: 1px solid rgba(255, 255, 255, 0.1);
}
.custom-field-input {
    flex: 1;
    width: 100%;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.25rem;
    color: #ffffff;
    background: transparent;
    border: none;
    outline: none;
}
:root:not(.dark) .custom-field-input {
    color: #111827;
}
.custom-field-input::placeholder {
    color: #6b7280;
}
.custom-field-input:disabled {
    cursor: not-allowed;
}
</style>
