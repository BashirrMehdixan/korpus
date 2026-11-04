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
    <div
        class="fi-custom-field-wrp"
        :class="{ 'is-invalid': props.isInvalid, 'is-disabled': props.isDisabled }"
    >
        <input
            :id="props.id"
            type="datetime-local"
            :value="toInputValue(props.value || props.default)"
            :disabled="props.isDisabled"
            :readonly="props.isReadOnly"
            :required="props.isRequired"
            :aria-invalid="props.isInvalid"
            :aria-describedby="props.ariaDescribedBy ?? undefined"
            :min="props.minDate ?? undefined"
            :max="props.maxDate ?? undefined"
            class="fi-custom-input"
            @change="handleChange"
            @blur="props.onBlur()"
        />
    </div>
</template>
