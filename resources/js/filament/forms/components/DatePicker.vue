<script setup lang="ts">
import type { DatePickerProps } from './types'

defineOptions({ inheritAttrs: false })

const props = defineProps<DatePickerProps>()

function handleChange(event: Event): void {
    props.onChange((event.target as HTMLInputElement).value || null)
}
</script>

<template>
    <div
        class="fi-custom-field-wrp"
        :class="{ 'is-invalid': props.isInvalid, 'is-disabled': props.isDisabled }"
    >
        <input
            :id="props.id"
            type="date"
            :value="props.value || props.default || ''"
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
