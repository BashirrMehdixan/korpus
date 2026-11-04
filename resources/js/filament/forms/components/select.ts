import { createApp, h, shallowRef } from 'vue'
import Select from './Select.vue'
import { ensureFilamentStyles } from './styles'
import { normalizeProps, type JsRendererContext, type JsRendererInstance, type SelectProps } from './types'

export default function mountSelect({ host, props: initialProps }: JsRendererContext): JsRendererInstance {
    ensureFilamentStyles()

    const props = shallowRef<SelectProps>(normalizeProps<SelectProps>(initialProps))

    const application = createApp({
        setup: () => () => h(Select, props.value),
    })

    application.mount(host)

    return {
        update(nextProps): void {
            props.value = normalizeProps<SelectProps>(nextProps)
        },
        destroy: (): void => application.unmount(),
    }
}
