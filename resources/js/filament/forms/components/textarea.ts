import { createApp, h, shallowRef } from 'vue'
import Textarea from './Textarea.vue'
import { normalizeProps, type JsRendererContext, type JsRendererInstance, type TextareaProps } from './types'

export default function mountTextarea({ host, props: initialProps }: JsRendererContext): JsRendererInstance {
    const props = shallowRef<TextareaProps>(normalizeProps<TextareaProps>(initialProps))

    const application = createApp({
        setup: () => () => h(Textarea, props.value),
    })

    application.mount(host)

    return {
        update(nextProps): void {
            props.value = normalizeProps<TextareaProps>(nextProps)
        },
        destroy: (): void => application.unmount(),
    }
}
