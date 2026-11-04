import { createApp, h, shallowRef } from 'vue'
import TextInput from './TextInput.vue'
import { ensureFilamentStyles } from './styles'
import { normalizeProps, type JsRendererContext, type JsRendererInstance, type TextInputProps } from './types'

export default function mountTextInput({ host, props: initialProps }: JsRendererContext): JsRendererInstance {
    ensureFilamentStyles()

    const props = shallowRef<TextInputProps>(normalizeProps<TextInputProps>(initialProps))

    const application = createApp({
        setup: () => () => h(TextInput, props.value),
    })

    application.mount(host)

    return {
        update(nextProps): void {
            props.value = normalizeProps<TextInputProps>(nextProps)
        },
        destroy: (): void => application.unmount(),
    }
}
