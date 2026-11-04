import { createApp, h, shallowRef } from 'vue'
import DatePicker from './DatePicker.vue'
import { ensureFilamentStyles } from './styles'
import { normalizeProps, type JsRendererContext, type JsRendererInstance, type DatePickerProps } from './types'

export default function mountDatePicker({ host, props: initialProps }: JsRendererContext): JsRendererInstance {
    ensureFilamentStyles()

    const props = shallowRef<DatePickerProps>(normalizeProps<DatePickerProps>(initialProps))

    const application = createApp({
        setup: () => () => h(DatePicker, props.value),
    })

    application.mount(host)

    return {
        update(nextProps): void {
            props.value = normalizeProps<DatePickerProps>(nextProps)
        },
        destroy: (): void => application.unmount(),
    }
}
