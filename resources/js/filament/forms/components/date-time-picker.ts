import { createApp, h, shallowRef } from 'vue'
import DateTimePicker from './DateTimePicker.vue'
import { normalizeProps, type JsRendererContext, type JsRendererInstance, type DateTimePickerProps } from './types'

export default function mountDateTimePicker({ host, props: initialProps }: JsRendererContext): JsRendererInstance {
    const props = shallowRef<DateTimePickerProps>(normalizeProps<DateTimePickerProps>(initialProps))

    const application = createApp({
        setup: () => () => h(DateTimePicker, props.value),
    })

    application.mount(host)

    return {
        update(nextProps): void {
            props.value = normalizeProps<DateTimePickerProps>(nextProps)
        },
        destroy: (): void => application.unmount(),
    }
}
