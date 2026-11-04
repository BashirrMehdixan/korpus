import { createApp, h, shallowRef } from 'vue'
import ToggleButtons from './ToggleButtons.vue'
import { ensureFilamentStyles } from './styles'
import { normalizeProps, type JsRendererContext, type JsRendererInstance, type ToggleButtonsProps } from './types'

export default function mountToggleButtons({ host, props: initialProps }: JsRendererContext): JsRendererInstance {
    ensureFilamentStyles()

    const props = shallowRef<ToggleButtonsProps>(normalizeProps<ToggleButtonsProps>(initialProps))

    const application = createApp({
        setup: () => () => h(ToggleButtons, props.value),
    })

    application.mount(host)

    return {
        update(nextProps): void {
            props.value = normalizeProps<ToggleButtonsProps>(nextProps)
        },
        destroy: (): void => application.unmount(),
    }
}
