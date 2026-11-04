import { createApp, h, shallowRef } from 'vue'
import Checkbox from './Checkbox.vue'
import { ensureFilamentStyles } from './styles'
import { normalizeProps, type CheckboxProps, type JsRendererContext, type JsRendererInstance } from './types'

export default function mountCheckbox({ host, props: initialProps }: JsRendererContext): JsRendererInstance {
    ensureFilamentStyles()

    const props = shallowRef<CheckboxProps>(normalizeProps<CheckboxProps>(initialProps))

    const application = createApp({
        setup: () => () => h(Checkbox, props.value),
    })

    application.mount(host)

    return {
        update(nextProps): void {
            props.value = normalizeProps<CheckboxProps>(nextProps)
        },
        destroy: (): void => application.unmount(),
    }
}

