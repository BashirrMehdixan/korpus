// Filament JS Renderer — shared types

export interface JsRendererHost extends HTMLElement { }

export interface FieldProps {
    value: unknown
    id: string
    isDisabled: boolean
    isReadOnly: boolean
    isRequired: boolean
    isInvalid: boolean
    ariaDescribedBy: string | null
    configuration?: Record<string, unknown>
    onChange: (value: unknown) => void
    onBlur: () => void
    [key: string]: unknown
}

export interface JsRendererContext {
    host: JsRendererHost
    props: FieldProps
}

export interface JsRendererInstance {
    update(nextProps: FieldProps): void
    destroy(): void
}

export function normalizeProps<T extends FieldProps>(props: FieldProps): T {
    const config = (props?.configuration ?? {}) as Record<string, unknown>
    return {
        ...props,
        ...config,
    } as T
}

// TextInput extras
export interface TextInputProps extends FieldProps {
    type?: string
    prefix?: string | null
    suffix?: string | null
    maxLength?: number | null
    minValue?: number | null
    step?: string | null
    placeholder?: string | null
}

// Textarea extras
export interface TextareaProps extends FieldProps {
    rows?: number
    maxLength?: number | null
    placeholder?: string | null
}

// Select extras
export type SelectOption = { value: string | number; label: string }
export type SelectOptions = SelectOption[] | Record<string, string>

export interface SelectProps extends FieldProps {
    options?: SelectOptions
    isMultiple?: boolean
    isSearchable?: boolean
    placeholder?: string | null
}

// DatePicker extras
export interface DatePickerProps extends FieldProps {
    minDate?: string | null
    maxDate?: string | null
    placeholder?: string | null
}

// DateTimePicker extras
export interface DateTimePickerProps extends FieldProps {
    minDate?: string | null
    maxDate?: string | null
}

// ToggleButtons extras
export interface ToggleOption {
    value: string | number | boolean
    label: string
}

export interface ToggleButtonsProps extends FieldProps {
    options?: Record<string | number, string> | ToggleOption[]
    isInline?: boolean
    isGrouped?: boolean
    isBoolean?: boolean
    isMultiple?: boolean
}
