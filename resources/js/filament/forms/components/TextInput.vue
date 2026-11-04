<script setup lang="ts">
import { ref, computed } from 'vue'
import type { TextInputProps } from './types'

defineOptions({ inheritAttrs: false })

const props = defineProps<TextInputProps>()

const isPasswordRevealed = ref(false)

const computedType = computed(() => {
    if (props.type === 'password') {
        return isPasswordRevealed.value ? 'text' : 'password'
    }
    return props.type ?? 'text'
})

function handleInput(event: Event): void {
    let val: string | number | null = (event.target as HTMLInputElement).value
    if (props.type === 'number') {
        val = val === '' ? null : Number(val)
    }
    props.onChange(val)
}

function togglePassword(): void {
    isPasswordRevealed.value = !isPasswordRevealed.value
}
</script>

<template>
    <div class="fi-custom-field-wrp" :class="{ 'is-invalid': props.isInvalid, 'is-disabled': props.isDisabled }">
        <span v-if="props.prefix" class="fi-custom-affix fi-custom-prefix">
            {{ props.prefix }}
        </span>

        <input :id="props.id" :type="computedType" :value="props.value ?? props.default ?? ''"
            :disabled="props.isDisabled" :readonly="props.isReadOnly" :required="props.isRequired"
            :aria-invalid="props.isInvalid" :aria-describedby="props.ariaDescribedBy ?? undefined"
            :placeholder="props.placeholder ?? ''" :maxlength="props.maxLength ?? undefined"
            :min="props.minValue ?? undefined" :step="props.step ?? undefined" class="fi-custom-input"
            @input="handleInput" @blur="props.onBlur()" />

        <!-- Password Reveal Button -->
        <button v-if="props.type === 'password'" type="button" class="fi-custom-icon-btn" tabindex="-1"
            :title="isPasswordRevealed ? 'Şifrəni gizlət' : 'Şifrəni göstər'" @click="togglePassword">
            <!-- Eye slash (gizlət) -->
            <svg v-if="isPasswordRevealed" style="width: 1.125rem; height: 1.125rem;" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
            </svg>
            <!-- Eye (göstər) -->
            <svg v-else style="width: 1.125rem; height: 1.125rem;" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </button>

        <span v-if="props.suffix" class="fi-custom-affix fi-custom-suffix">
            {{ props.suffix }}
        </span>
    </div>
</template>
