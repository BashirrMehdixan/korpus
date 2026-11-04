<script setup lang="ts">
import type { TextareaProps } from './types'

defineOptions({ inheritAttrs: false })

const props = defineProps<TextareaProps>()
</script>

<template>
    <div
        class="fi-custom-field-wrp"
        :class="{ 'is-invalid': props.isInvalid, 'is-disabled': props.isDisabled }"
        style="height: auto; align-items: stretch;"
    >
        <textarea
            :id="props.id"
            :value="String(props.value ?? props.default ?? '')"
            :disabled="props.isDisabled"
            :readonly="props.isReadOnly"
            :required="props.isRequired"
            :aria-invalid="props.isInvalid"
            :aria-describedby="props.ariaDescribedBy ?? undefined"
            :rows="props.rows ?? 3"
            :placeholder="props.placeholder ?? ''"
            :maxlength="props.maxLength ?? undefined"
            class="fi-custom-textarea"
            @input="props.onChange(($event.target as HTMLTextAreaElement).value)"
            @blur="props.onBlur()"
        />
    </div>
</template>
