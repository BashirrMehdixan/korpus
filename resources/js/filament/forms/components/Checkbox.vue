<script setup lang="ts">
import type { CheckboxProps } from './types'

defineOptions({ inheritAttrs: false })

const props = defineProps<CheckboxProps>()

function handleChange(event: Event): void {
    const isChecked = (event.target as HTMLInputElement).checked
    props.onChange(isChecked)
}
</script>

<template>
    <div class="fi-modern-checkbox-wrapper" :class="{ 'is-disabled': props.isDisabled }">
        <label :for="props.id" class="fi-modern-checkbox-label">
            <input
                :id="props.id"
                type="checkbox"
                :checked="Boolean(props.value ?? props.default)"
                :disabled="props.isDisabled"
                :aria-invalid="props.isInvalid"
                :aria-describedby="props.ariaDescribedBy ?? undefined"
                class="fi-modern-checkbox-native"
                @change="handleChange"
                @blur="props.onBlur()"
            />
            <span class="fi-modern-checkbox-custom">
                <svg class="fi-modern-checkbox-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </span>
            <span v-if="props.label" class="fi-modern-checkbox-text">{{ props.label }}</span>
        </label>
    </div>
</template>

<style scoped>
.fi-modern-checkbox-wrapper {
    display: inline-flex;
    align-items: center;
}

.fi-modern-checkbox-wrapper.is-disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.fi-modern-checkbox-label {
    display: inline-flex;
    align-items: center;
    gap: 0.625rem;
    cursor: pointer;
    user-select: none;
}

.fi-modern-checkbox-native {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
    pointer-events: none;
}

.fi-modern-checkbox-custom {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.25rem;
    height: 1.25rem;
    border-radius: 0.375rem;
    border: 1.5px solid rgba(255, 255, 255, 0.25);
    background: rgba(255, 255, 255, 0.05);
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

:root:not(.dark) .fi-modern-checkbox-custom {
    border: 1.5px solid #d4d4d8;
    background: #ffffff;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.fi-modern-checkbox-icon {
    width: 0.8125rem;
    height: 0.8125rem;
    color: #ffffff;
    stroke-dasharray: 24;
    stroke-dashoffset: 24;
    transition: stroke-dashoffset 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.fi-modern-checkbox-native:checked + .fi-modern-checkbox-custom {
    background: #f59e0b;
    border-color: #f59e0b;
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.35);
}

.fi-modern-checkbox-native:checked + .fi-modern-checkbox-custom .fi-modern-checkbox-icon {
    stroke-dashoffset: 0;
}

.fi-modern-checkbox-native:focus-visible + .fi-modern-checkbox-custom {
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.25);
}

.fi-modern-checkbox-text {
    font-size: 0.875rem;
    font-weight: 500;
    color: #e4e4e7;
}

:root:not(.dark) .fi-modern-checkbox-text {
    color: #27272a;
}
</style>
